<?php

namespace App;

use Cache;
use DateTime;
use Carbon\Carbon;
use App\Traits\Votable;
use App\Services\FFMPEG;
use App\Services\Tinify;
use App\Jobs\EncodeVideo;
use App\Services\Gstreamer;
use App\Traits\ContentMutators;
use App\Traits\ContentAccessors;
use App\Jobs\TinifyExternalImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\CreateThumbnailFromVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Waavi\Translation\Traits\Translatable;
use App\Services\Zencoder as ZencoderService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Content extends Model
{
    use
    ContentAccessors,
    ContentMutators,
    Votable,
    SoftDeletes,
    DispatchesJobs;

    protected $fillable = [
        'user_id',
        'title',
        'title_translated',
        'slug',
        'slug_translated',
        'filename',
        'filename2',
        'original_filename',
        'embed',
        'mobile',
        'movie_width',
        'movie_height',
        'description',
        'description_translated',
        'length',
        'ip',
        'approved',
        'enabled',
        'offence_date',
        'offence_time',
        'country_code',
        'region_code',
        'city_name',
        'camera',
        'agreement',
        'latitude',
        'longitude',
        'disable_comments',
        'disable_map',
        'private',
        'type',
        'start_in_seconds',
        'embed_id',
        'embed_type',
        'created_at',
        'updated_at'
    ];

    protected $appends = [];

    protected $dates = ['offence_date'];

    //protected $translatableAttributes = ['title', 'description'];

    protected $casts = [
        'title_translated' => 'json',
        'description_translated' => 'json'
    ];   

    public static function boot()
    {
        parent::boot();

        $instance = new static;

        static::created(function ($content) use($instance) {
            if ($content->type == 'video' && is_null($content->embed_type)) {
                $instance->dispatch((new EncodeVideo($content))->onQueue('comroads'));
            }

            if ($content->embed_id && $content->embed_type) {
                $instance->dispatch((new TinifyExternalImage($content))->onQueue('comroads'));
            }
        });

        static::updated(function ($content) use($instance) {
            if ($content->embed_id && $content->embed_type) {
                $instance->dispatch((new TinifyExternalImage($content))->onQueue('comroads'));
            }
        });

    }

    public function encode($encoder = null, $reencode = false)
    {
        Log::info('Encoding #'.$this->id);

        if ($this->type == 'video' && !empty($this->original_filename)) {
            $encoder = $encoder ?: config('app.encoder'); 
            if ($encoder == 'zencoder') {
                $zencoder = new ZencoderService;
                $job = $zencoder->encode($this->original_filename);
                $content_id = $this->id;

                foreach (config('services.zencoder.labels') as $key => $label) {
                    Zencoder::create([
                        'id' => $job->outputs[$key]->id, 
                        'content_id' => $content_id
                    ]);
                }

                return;
            }

            if ($encoder == 'ffmpeg') {
                $encoder = new FFMPEG($this);
                $encoder->encode(null, null, $reencode);                

                Log::info('Encoding Success (ffmpeg): #'.$this->id);
                return;
            }

            if ($encoder == 'gstreamer') {
                $encoder = new Gstreamer($this->original_filename);
                $info = $encoder->encode();
                $this->createThumbnail();
                
                Log::info('Encoding Success (gstreamer): #'.$this->id);
                return;
            }
        }

        Log::info('Nothing to encode');
    }

    public function createThumbnail()
    {
        $encoder = new FFMPEG($this->original_filename);

        if (! $encoder->createThumbnail()) {
            //$this->dispatch((new CreateThumbnailFromVideo($this))->delay(10));
            sleep(10);
            return $this->createThumbnail();
        }

        $info = $encoder->videoInfo();

        $this->length = ceil($info['playtime_seconds']);
        $this->movie_width = $info['video']['resolution_x'];
        $this->movie_height = $info['video']['resolution_y'];
        $this->encoded_date = Carbon::now();
        $this->save();

    }

    public function gstreamerEncode()
    {
        $this->dispatch((new EncodeVideo($this, 'gstreamer')));
    }

    public function tinifyExternalImage()
    {
        if ($this->embed_id && $this->embed_type) {
            $tinify = new Tinify;
            $tinify->processExternalImage($this->embed_id, $this->embed_type);
        }
    }

    public static function data(array $filters, $sorting)
    {
        $content = new static;

        $items = $content->viewable()->filter($filters);

        if (!is_null($filters['created_at'])) {
            $items->latest('created_at');
        }

        if (!is_null($filters['category_id'])) {
            $items->whereHas('categories', function ($query) use ($filters) {
                $query->where('niche_id', $filters['category_id']);
            });
        }

        $items = $items->latest($sorting)->take($filters['limit'])->get()->load(['images', 'categories.category']);
//dd(count($items));
        $items = count($items) >= $filters['limit'] ? $items : $items->merge($content->defaultData($filters, $sorting));

        return $items->take($filters['limit'])->unique();
    }

    public function defaultData(array $filters, $sorting)
    {
        array_forget($filters, 'country_code');
        array_forget($filters, 'created_at');

        $items = $this->viewable()->filter($filters);        

        $items = $items->latest($sorting)->take($filters['limit'])->get()->load(['images', 'categories.category']);

        return $items;
    }

    public static function map(array $filters)
    {
        $content = new static;

        return $content->viewable()->withLatLng()->filter($filters)->get()->load(['images', 'categories.category', 'country', 'region']);
    }

    public static function mostPopularVideos(array $filters = [])
    {
        $content = new static;

        $items = $content::viewable()->filter($filters);        

        $items = $items->take(24)->latest('total_views')->get()->load(['images']);

        return count($items) >= 24 ? $items : $items->merge($content->overallMostPopularVideos($filters));
    }

    public static function trendingVideos()
    {
        $from   = (new DateTime('1 week ago'))->format('Y-m-d H:i:s'); 
        $to     = (new DateTime)->format('Y-m-d H:i:s');
        $content = new static;
        $contents = UserWatched::whereHas('content', function ($query) {
                $query->whereType('video');
            })
            ->whereBetween('created_at', [$from, $to])
            ->select('content_id', DB::raw('COUNT(content_id) as count'))
            ->groupBy('content_id')
            ->orderBy('count', 'DESC')
            //->lists('content_id')
            ->take(24)
            ->latest()
            ->get()
            ->load(['content.images']);
        
        return $contents;
        //dd($contents);
        //$items = $content::viewable()->whereIn('id', $content_ids)->whereType('video');
        //$items = $items->take(24)->get()->load(['images']);

        //return count($items) >= 24 ? $items : $items->merge($content->mostPopularVideos());
    }

    public function overallMostPopularVideos(array $filters)
    {
        array_forget($filters, 'country_code');
        array_forget($filters, 'created_at');

        return $this->viewable()->filter($filters)->take(24)->latest('total_views')->get()->load(['images']);
    }

    public function scopeViewable($query)
    {
        return $query->whereApproved(1)->whereEnabled(1)->wherePrivate(0);
    }

    public function scopeWithLatLng($query)
    {
        return $query->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->where('latitude', '!=', 0)
                    ->where('longitude', '!=', 0);
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereType($type);
    }

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $filter) {
            if (!empty($filter['value'])) {
                $query->where($key, $filter['operator'], $filter['value']);                
            }
        }

        return $query;
    }

    public function scopeCountry($query, $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    public function scopeUploadedSince($query, $key)
    {
        $since = created_at_filter($key);

        if ($since) {
            $query->where('created_at', '>=', $since['value']);
        }
    }

    public function scopeWhereCategories($query, array $categories)
    {
        return $query->whereHas('categories', function ($query) use ($categories) {
            return $query->whereIn('niche_id', $categories);
        });
    }

    public function zencoder()
    {
        return $this->hasMany(\App\Zencoder::class, 'content_id');
    }

    public function country()
    {
        return $this->belongsTo(\App\Country::class, 'country_code', 'code');
    }

    public function region()
    {
        return $this->belongsTo(\App\Region::class, 'region_code', 'code')->whereCountryCode($this->country_code);
    }

    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(\App\ContentNiche::class, 'content_id');
    }

    public function comments()
    {
        return $this->morphMany(\App\Comment::class, 'commentable');
    }

    public function images()
    {
        return $this->hasMany(\App\ContentImage::class, 'content_id');
    }

    public function plates()
    {
        return $this->hasMany(\App\ContentLicensePlate::class, 'content_id');
    }

    public function inactiveEmbed()
    {
        return $this->hasOne(ContentInactiveEmbed::class, 'content_id');
    }

    public function addInactiveYoutube()
    {
        $response = json_decode(@file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$this->embed_id.'&key='.config('services.google.server_api_key').'&part=snippet'), true);

        if ((count($response['items']) == 0 || is_null($response)) && is_null($this->inactiveEmbed)) {
            $this->inactiveEmbed()->save(new ContentInactiveEmbed);
        }
    }

    public function addInactiveVidme()
    {
        $response = json_decode(@file_get_contents('https://api.vid.me/videoByUrl/'.$this->embed_id), true);

        if (is_null($response) && is_null($this->inactiveEmbed)) {
            $this->inactiveEmbed()->save(new ContentInactiveEmbed);
        }
    }

    public function deleteInactiveEmbed()
    {
        if ($this->has('inactiveEmbed')) {
            $this->inactiveEmbed()->delete();
        }
    }

    public function addComment(Comment $comment)
    {
        return $this->comments()->save($comment);
    }

    public function addCategory(array $category)
    {
        return $this->categories()->save(new ContentNiche($category));
    }

    public function deleteCategories()
    {
        return $this->categories()->delete();
    }

    public function addPlate(array $plate)
    {
        return $this->plates()->save(new ContentLicensePlate($plate));
    }

    public function deletePlates()
    {
        return $this->plates()->delete();
    }

    public function addImage(array $attributes)
    {
        return $this->images()->save(new ContentImage($attributes));
    }

    public function addImages(array $images)
    {
        $objects = [];

        foreach ($images as $key => $image) {
            $objects[$key] = new ContentImage(['filename' => $image]);
        }

        $this->images()->saveMany($objects);

        return $this;
    }

    public function publish()
    {
        $this->approved = 1;
        return $this->save();
    }

    public function setAsPending()
    {
        $this->approved = 0;
        return $this->save();
    }

    public function incrementTotalViews()
    {
        $content = Content::findOrFail($this->id);

        $content->total_views = $content->total_views + 1;
        $content->save();
    }

    public function related($limit = 3)
    {
        $categories = $this->categories;
        $category_ids = count($categories) ? $categories->pluck('niche_id')->toArray() : [8];        

        $content_ids = array_unique(ContentNiche::whereIn('niche_id', $category_ids)->where('content_id', '!=', $this->id)
                    ->get()->pluck('content_id')->toArray());

        return Content::viewable()->whereIn('id', $content_ids)
                ->ofType($this->type)
                ->whereCountryCode($this->country_code)
                ->latest()
                ->take($limit)
                ->get()->load(['images']);
    }

    public function updateTranslations(array $attributes)
    {  
        if (isset($attributes['titles']['en'])) {
            $this->title = $attributes['titles']['en'];
        }

        if (isset($attributes['descriptions']['en'])) {
            $this->description = $attributes['descriptions']['en'];
        }

        $titles = array_except($attributes['titles'], ['en']);

        if (isset($attributes['descriptions'])) {
            $descriptions = array_except($attributes['descriptions'], ['en']);
            if (count($descriptions)) {
                $this->description_translated = is_array($this->description_translated) ? array_merge($this->description_translated, $descriptions) : $descriptions;
            }
        }
        
        if (count($titles)) {
            $this->title_translated = is_array($this->title_translated) ? array_merge($this->title_translated, $titles) : $titles;
        }        

        return $this->save();
    }

    public function translate($attribute, $locale)
    {
        if ($locale == 'en') {
            return $this->$attribute;
        }

        $translated = $attribute.'_translated';
        $translated = $this->$translated;

        return isset($translated[$locale]) ? $translated[$locale] : null;
    }

    public function isWatched($ip)
    {
        $from   = (new DateTime)->format('Y-m-d 00:00:00'); 
        $to     = (new DateTime)->format('Y-m-d 23:59:59');
        return $this->hasMany(\App\UserWatched::class, 'content_id')
            ->whereIp($ip)
            ->whereBetween('created_at', [$from, $to])
            ->first();
    }

    public function addWatched($ip = null)
    {
        if (!is_null($ip)) {
            $userWatched['ip'] = $ip;
            return $this->hasMany(\App\UserWatched::class, 'content_id')->save(new UserWatched($userWatched));
        }
    }

    public function isVoted(User $user, $type)
    {
        return $this->hasMany(Voter::class, 'votable_id')->where('user_id', $user->id)->where('type', $type)->first();
    }

    public function approve()
    {
        $this->approved = 1;
        $this->enabled = 1;
        $this->save();

        return $this;
    }

    public function changeVideo($filename)
    {
        if ($filename) {
            $this->forceDeleteLocalFiles();
            $this->deleteRemoteFiles();

            $this->original_filename = $filename;
            $this->encoded_date = null;
            $this->embed_type = null;
            $this->embed_id = null;
            $this->save();

            $this->dispatch((new EncodeVideo($this)));

            return $this;
        }
    }

    public function deleteAllFiles()
    {
        $originalFile = $this->original_filename;
        $filename = pathinfo($originalFile, PATHINFO_FILENAME);
        $original = config('app.video_upload_path') . $originalFile;
        $subDir = sub_dir($originalFile);
        $videosPath = public_path(config('app.video_path') . $subDir);
        $thumbsPath = public_path(config('app.video_thumb_path') . $subDir . $originalFile);
        $encoded = [
            $videosPath . $filename . '.mp4',
            $videosPath . 'pc_720_' . $filename . '.mp4',
            $videosPath . 'pc_480_' . $filename . '.mp4',
            $videosPath . '480p_' . $filename . '.mp4',
            $videosPath . '720p_' . $filename . '.mp4',
            $videosPath . '1080p_' . $filename . '.mp4',
            $videosPath . $filename . '.smil',
        ];

        if ($this->type == 'video' && is_null($this->embed_type)) {
            if (file_exists($original)) {
                unlink($original);
            }            

            foreach ($encoded as $key => $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            if (file_exists($thumbsPath)) {
                array_map('unlink', glob("$thumbsPath/*.*"));
                rmdir($thumbsPath);
            }
        }
    }

    public function deleteEncodedFiles()
    {
        $originalFile = $this->original_filename;
        $filename = pathinfo($originalFile, PATHINFO_FILENAME);
        $subDir = sub_dir($originalFile);
        $videosPath = public_path(config('app.video_path') . $subDir);
        $thumbsPath = public_path(config('app.video_thumb_path') . $subDir . $originalFile);
        $encoded = [
            $videosPath . $filename . '.mp4',
            $videosPath . 'pc_720_' . $filename . '.mp4',
            $videosPath . 'pc_480_' . $filename . '.mp4',
            $videosPath . '480p_' . $filename . '.mp4',
            $videosPath . '720p_' . $filename . '.mp4',
            $videosPath . '1080p_' . $filename . '.mp4',
            $videosPath . $filename . '.smil',
        ];

        if ($this->type == 'video' && is_null($this->embed_type)) {
            foreach ($encoded as $key => $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            if (file_exists($thumbsPath)) {
                array_map('unlink', glob("$thumbsPath/*.*"));
                rmdir($thumbsPath);
            }
        }
    }

    public function deleteLocalFiles()
    {
        foreach ($this->files as $file) {
            
            // only delete local file if it already exists in remote server
            // and of course if it exists in local files 
            if (! is_null($file['remote']) && ! is_null($file['local'])) {
                unlink($file['local']);
            }
        }
    }

    public function forceDeleteLocalFiles()
    {
        foreach ($this->files as $file) {
            
            // only delete local file if it exists
            if (! is_null($file['local'])) {
                unlink($file['local']);
            }
        }
    }

    public function deleteRemoteFiles()
    {
        //$sftp = sftp();

        foreach ($this->files as $file) {

            // only delete if it exists in remote server
            if (! is_null($file['remote'])) {
                //ssh2_sftp_unlink($sftp, $file['remote']);                
                Storage::disk('s3')->delete($file['remote']);
            }
        }        
    }

    public function getVideoByResolution($resolution = '480p')
    {
        $video = $this->path . $resolution . '_' .$this->filename . '.mp4';

        if (file_exists($video)) {
            return $video;
        }
    }
}

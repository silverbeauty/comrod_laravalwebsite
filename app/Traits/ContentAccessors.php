<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

trait ContentAccessors
{
    public function getThankYouUrlAttribute()
    {
        return route('upload::getThankYou', ['id' => $this->id]);
    }

    public function getUrlAttribute()
    {
        if ($this->type == 'photo') {
            return route('getContentPhotoProfile', slugify($this->getOriginal('title')).'-'.$this->id);
        }

        $time = $this->start_in_seconds ? '?t=' . $this->start_in_seconds : null;  

        return route('getContentVideoProfile', slugify($this->getOriginal('title')).'-'.$this->id . $time);
    }

    public function getEditUrlAttribute()
    {
        return url($this->type . '/' . slugify($this->getOriginal('title')) . '-' . $this->id . '/edit');
    }

    public function getDeleteUrlAttribute()
    {
        return $this->type == 'video' ? route('api::postDeleteVideo') : route('api::postDeletePhoto');
    }

    public function getSlugAttribute($value)
    {
        return $value ?: str_slug($this->title);
    }

    public function getLikeUrlAttribute()
    {
        return route('api::postLikeContent');
    }

    public function getDislikeUrlAttribute()
    {
        return route('api::postDislikeContent');
    }

    public function getFacebookShareUrlAttribute()
    {
        return "http://www.facebook.com/sharer/sharer.php?u=".$this->url."&title=".$this->title;
    }

    public function getTwitterShareUrlAttribute()
    {
        return "http://twitter.com/intent/tweet?status=".$this->title."+".$this->url;
    }

    public function getTumblrShareUrlAttribute()
    {
        return "http://www.tumblr.com/share?v=3&u=".$this->url."&t=".$this->title;
    }

    public function getGooglePlusShareUrlAttribute()
    {
        return "https://plus.google.com/share?url=".$this->url;
    }

    public function getYoutubeUrlAttribute()
    {
        return $this->embed_type == 'youtube' ? 'https://www.youtube.com/watch?v='.$this->embed_id : null;
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        $start = $this->start_in_seconds ? 'start='.$this->start_in_seconds.'&' : '';

        return 'https://www.youtube.com/embed/' . $this->embed_id . '?' . $start .'autoplay=1&rel=0&modestbranding=1';
    }

    public function getVidmeUrlAttribute()
    {
        return $this->embed_type == 'vidme' ? 'https://vid.me/'.$this->embed_id : null;
    }

    public function getVidmeEmbedUrlAttribute()
    {
        return 'https://vid.me/e/'.$this->embed_id.'?autoplay=1#'.$this->start_in_seconds.'s';
    }

    public function getThumbnailUrlAttribute()
    {
        $filename = $this->original_filename;

        if ($this->type == 'video') {
            if (empty($this->embed_type)) {
                $filename = $this->thumbnail ?: $this->original_filename . '-0.jpg';               
                return config('app.video_thumbnail_base_url') . $this->sub_dir . $this->original_filename . '/' . $filename;
            } else {
                return $this->embeded_image_url;
            }
        }

        if ($this->type == 'photo') {
            $image = $this->images->first();
            if ($image) {
                return $image->url($this->original_filename, 300);
            }
        }
    }

    public function getEmbededImageUrlAttribute()
    {
        $cacheTags = Cache::tags(['contents', 'thumbnails']);
        $filename = $this->thumbnail ?: $this->embed_type.'-'.$this->embed_id.'.jpg';
        $path = config('app.video_remote_embed_thumb_path') . $filename;

        if (is_null($fileExists = $cacheTags->get('embedded_thumbnail_' . $this->id))) {
            $fileExists = remote_file_exists(sftp(), $path);
            $cacheTags->forever('embedded_thumbnail_' . $this->id, $fileExists);
        }

        if (! $fileExists) {
            if ($this->embed_type == 'youtube') {
                return 'https://img.youtube.com/vi/'.$this->embed_id.'/0.jpg';
            } elseif ($this->embed_type == 'vidme') {
                $info = vidme_info('https://vid.me/'.$this->embed_id);

                if ($info) {
                    return $info['video']['thumbnail_url'];
                }
            }
        }

        return config('app.video_thumbnail_base_url') . 'embedded/' . $filename;
    }

    public function getVideoPosterUrlAttribute()
    {
       return $this->thumbnail_url;
    }

    public function getVideoDefaultUrlAttribute()
    {
        $filename = 'pc_480_'.$this->filename.'.mp4';

        if (remote_file_exists(sftp(), $this->remote_smil)) {
            $filename = '480p_' . $this->filename . '.mp4';
        }       

        return config('app.video_base_url') . $this->sub_dir . $filename . '#t=' . $this->start_in_seconds; 
    }

    public function getSmilUrlAttribute()
    {
        return config('app.video_smil_base_url') . $this->sub_dir . 'smil:' . $this->filename . '.smil' . '/playlist.m3u8';
    }

    public function getVideoFilesAttribute()
    {
        $playerCache = Cache::tags(['contents', 'players']);
        $smils = Cache::tags(['contents', 'smils']);

        $resolutions_available = $playerCache->get('player_resolutions_' . $this->id);

        if (is_null($files = $playerCache->get('player_sources_' . $this->id)) || count($resolutions_available) == 0) {
            $sftp = sftp();
            $filename = $this->filename;
            $subDir = $this->sub_dir;
            $smil = $filename . '.smil';
            $video = $filename . '.mp4';        
            $baseUrl = config('app.video_base_url') . $subDir;         
            $path = config('app.video_remote_path') . $subDir;
            $files = [];
            $resolutions_available = [];           

            if (is_null($smilExists = $smils->get('smil_exists_' . $this->id))) {
                $smilExists = remote_file_exists($sftp, $this->remote_smil);
                $smils->forever('smil_exists_' . $this->id, $smilExists);
            }

            $resolutions = [
                'original' => 'Original',
                'pc_480_' => '480p',
                'pc_720_' => '720p',            
            ];     

            if ($smilExists) {
                // $files[] = [
                //     'type' => 'application/x-mpegurl',
                //     'src' => $this->smil_url,
                //     'label' => 'Auto'
                // ];

                $resolutions = [
                    '720p_' => '720p',                    
                    '480p_' => '480p',
                    '1080p_' => '1080p'
                ];            
            }

            $type = 'video/mp4';
            $time = $this->start_in_seconds ? '#t=' . $this->start_in_seconds : null;

            foreach ($resolutions as $key => $res) {
                if ($key == 'original' && remote_file_exists($sftp, $path . $video)) {
                    $files[] = [
                        'type' => $type,
                        'src' => $baseUrl . $video . $time,
                        'label' => $res,
                    ];
                }

                elseif (remote_file_exists($sftp, $path . $key . $video)) {
                    $files[] = [
                        'type' => $type,
                        'src' => $baseUrl . $key . $video . $time,
                        'label' => $res,
                    ];                

                    $resolutions_available[] = $res;
                }
            }

            $playerCache->forever('player_sources_' . $this->id, $files);
            $playerCache->forever('player_resolutions_' . $this->id, $resolutions_available);            
        }

        return [
            'files' => $files,
            'resolutions' => $resolutions_available
        ];
    }

    public function getJwplayerFilesAttribute()
    {
        $files = [];

        foreach ($this->video_files['files'] as $key => $file) {
            $files[$key]['file'] = $file['src'];
            $files[$key]['label'] = $file['label'];
        }

        return $files;
    }

    public function getFlowplayerSettingsAttribute()
    {
        if ($this->type == 'video' && is_null($this->embed_type)) {
            $video = $this->video_files;

            return [
                'key' => '$108835620266723',
                'defaultAudioCodec' => 'mp4a.40.2',
                'clip' => [
                    'title' => $this->title,
                    'qualities' => $video['resolutions'],
                    'defaultQuality' => '720p',
                    'sources' => $video['files'],
                ],
                //'rtmp' => "rtmp://rtmp.flowplayer.org/cfx/st",
                'ratio' => 0.5625,
                'autoplay' => true,
                'poster' => $this->video_poster_url,
                'embed' => [
                    'iframe' => $this->embed_url,
                    'width' => 864,
                    'height' => 363
                ]
            ];
        }

        return;
    }

    public function getFlowplayerHolaSettingsAttribute()
    {
        if ($this->type == 'video' && is_null($this->embed_type)) {
            $video = $this->video_files;

            return [
                'key' => '$108835620266723',
                'swf' => asset('flowplayerhls_h65.swf'),
                'swfHls' => asset('flowplayerhls_h65.swf'),
                'defaultAudioCodec' => 'mp4a.40.2',
                'clip' => [
                    'title' => $this->title,
                    'qualities' => $video['resolutions'],
                    'defaultQuality' => '480p',
                    'sources' => $video['files'],
                ],
                //'rtmp' => "rtmp://rtmp.flowplayer.org/cfx/st",
                'ratio' => 0.5625,
                'autoplay' => true,
                'poster' => $this->video_poster_url,
                'embed' => [
                    'iframe' => $this->embed_url,
                    'width' => 864,
                    'height' => 363
                ]
            ];
        }

        return;
    }

    public function getVideoHdUrlAttribute()
    {
        $filename = $this->filename;

        return config('app.video_base_url') . sub_dir($filename) . $filename; 
    }

    public function getPhotoUrlAttribute()
    {
        $image = $this->images()->first();

        return $image ? image_url(remove_extension($this->original_filename ?: $image->filename).'/'.$image->filename, 'xlarge') : null;
    }

    public function getCountryNameAttribute()
    {
        $country = $this->country;

        return $country ? $country->name : null;
    }

    public function getStateNameAttribute()
    {
        $region = $this->region;

        return $region ? $region->name : null;
    }

    public function getAddressAttribute()
    {
        $show_state = ['AU', 'CA', 'US'];
        $state_name = null;
        $city_name = null;
        $state = $this->state_name;

        if (in_array($this->country_code, $show_state) && $state) {
            $state_name = $state.', ';
        }

        if (!empty($this->city_name)) {
            $city_name = $this->city_name.', ';
        }

        return "{$city_name}{$state_name}{$this->country_name}";
    }

    public function getOffenceDateTimeAttribute()
    {
        return strtotime($this->offence_date) > 0 ? Carbon::createFromFormat('Y-m-d H:i:s', $this->offence_date)->format('d. m. Y / h:ia') : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)
                    ->format('d. m. Y / h:ia');
    }

    public function getCalculatedTypeAttribute()
    {
        if (str_contains($this->filename, '.mp4') || !empty($this->embed)) {
            return 'video';
        }

        return 'photo';
    }

    public function getFirstCategoryIconUrlAttribute()
    {
        foreach ($this->categories as $category) {
            $category = $category->category;

            if ($category) {
                return asset_cdn('images/categories/'.$category->icon);
            }
        }

        return default_map_icon();       
    }

    public function getFirstCategoryHoverIconUrlAttribute()
    {
        foreach ($this->categories as $category) {
            $category = $category->category;

            if ($category) {
                return asset_cdn('images/categories/hover/'.$category->icon);
            }
        }

        return asset_cdn('images/categories/hover/icon_8.png');       
    }

    public function getFirstCategoryIconAttribute()
    {
        $category = $this->categories->first();

        if ($category) {
            return $category->niche_id;
        }

        return 8;
    }

    public function getFormattedTotalViewsAttribute()
    {
        return number_format($this->total_views);
    }

    public function getTotalRatingAttribute()
    {
        return $this->total_likes - $this->total_dislikes;
    }

    public function getIsPendingAttribute()
    {
        return $this->approved == 0 && !$this->trashed() ? true : false;
    }

    public function getIsPublishedAttribute()
    {
        return $this->approved == 1 && !$this->trashed() ? true : false;
    }

    public function getTitleAttribute()
    {
        $lang = subdomain();
        if ($lang != 'en') {
            $translations = is_array($this->title_translated) ? $this->title_translated : json_decode($this->title_translated, true);

            if (isset($translations[$lang]) && $translations[$lang]) {
                return $translations[$lang];
            }
        }
        return $this->attributes['title'];
    }

    public function getDescriptionAttribute()
    {
        $lang = subdomain();
        if ($lang != 'en') {
            $translations = is_array($this->description_translated) ? $this->description_translated : json_decode($this->description_translated, true);
            if (isset($translations[$lang]) && $translations[$lang]) {
                return $translations[$lang];
            }
        }
        return $this->attributes['description'];
    }

    public function getVersionsAttribute()
    {
        return config('app.encoded_videos');
    }

    public function getFilesAttribute()
    {
        $files = [];

        if (empty($this->original_filename)) {
            return $files;
        }

        $sftp = sftp();
        $subDir = $this->sub_dir;
        $counter = 1;

        $fileNames = [
            ['name' => $this->filename . '.mp4', 'type' => 'encoded'],
            ['name' => 'pc_480_' . $this->filename . '.mp4', 'type' => 'encoded'],
            ['name' => 'pc_720_' . $this->filename . '.mp4', 'type' => 'encoded'],
            ['name' => '480p_' . $this->filename . '.mp4', 'type' => 'encoded'],
            ['name' => '720p_' . $this->filename . '.mp4', 'type' => 'encoded'],
            ['name' => '1080p_' . $this->filename . '.mp4', 'type' => 'encoded'],
            ['name' => $this->filename . '.smil', 'type' => 'smil'],
            ['name' => $this->original_filename . '-0.jpg', 'type' => 'thumbnail']
        ];        

        $originalLocalFile = public_path(config('app.video_upload_path') . $this->original_filename);
        $originalRemoteFile = config('app.video_remote_temp_path') . $this->original_filename;
        $files[0]['local'] = null;
        $files[0]['remote'] = null;

        if (file_exists($originalLocalFile)) {
            $files[0]['local'] = $originalLocalFile;
        }

        if (remote_file_exists($sftp, $originalRemoteFile)) {
            $files[0]['remote'] = $originalRemoteFile;
        }

        foreach ($this->versions as $version) {
            foreach ($fileNames as $key => $file) {
                $files[$counter]['local'] = null;
                $files[$counter]['remote'] = null;

                if ($file['type'] == 'encoded' || $file['type'] == 'smil') {
                    $localEncodedFile = public_path($version['path'] . $subDir . $file['name']);
                    $remoteEncodedFile = $version['remote_path'] . $subDir . $file['name'];
                    
                    if (file_exists($localEncodedFile)) {
                        $files[$counter]['local'] = $localEncodedFile;
                    }

                    if (remote_file_exists($sftp, $remoteEncodedFile)) {
                        $files[$counter]['remote'] = $remoteEncodedFile;
                    }
                }                

                if ($file['type'] == 'thumbnail') {
                    $localThumbnail = public_path($version['thumb_path'] . $subDir . $this->original_filename . '/' . $file['name']);
                    $remoteThumbnail = $version['remote_thumb_path'] . $subDir . $this->original_filename . '/' . $file['name'];

                    if (file_exists($localThumbnail)) {
                        $files[$counter]['local'] = $localThumbnail;
                    }

                    if (remote_file_exists($sftp, $remoteThumbnail)) {
                        $files[$counter]['remote'] = $remoteThumbnail;
                    }
                }

                $counter++;
            }
        }

        return $files;
    }

    public function getFilenameAttribute()
    {
        return $this->original_filename ? pathinfo($this->original_filename, PATHINFO_FILENAME) : null;
    }

    public function getPathAttribute()
    {
        if ($this->filename) {
            return public_path(config('app.video_path') . $this->sub_dir);
        }
    }

    public function getOldPathAttribute()
    {
        if ($this->filename) {
            return public_path(config('app.old_video_path') . $this->sub_dir);
        }
    }

    public function getSubDirAttribute()
    {
        if ($this->filename) {
            return sub_dir($this->filename);
        }
    }

    public function getLocalOriginalVideoAttribute()
    {
        if ($this->original_filename) {
            return public_path(config('app.video_upload_path') . $this->original_filename);
        }
    }

    public function getLocalThumbAttribute()
    {
        if ($this->original_filename) {
            return public_path(config('app.video_path') . $this->sub_dir . $this->original_filename);
        }
    }

    public function getLocalVideosAttribute()
    {
        if ($this->original_filename) {            
            $basePath = public_path(config('app.video_path') . $this->sub_dir);

            return [
                $basePath . '480p_' . $this->filename . '.mp4',
                $basePath . '720p_' . $this->filename . '.mp4',
                $basePath . '1080p_' . $this->filename . '.mp4',
            ];
        }
    }

    public function getLocalSmilAttribute()
    {
        if ($this->original_filename) {
            return config('app.video_path') . $this->sub_dir . $this->filename . '.smil';
        }
    }

    public function getRemoteVideosAttribute()
    {
        if ($this->original_filename) {            
            $basePath = config('app.video_remote_path') . $this->sub_dir;

            return [
                $basePath . '480p_' . $this->filename . '.mp4',
                $basePath . '720p_' . $this->filename . '.mp4',
                $basePath . '1080p_' . $this->filename . '.mp4',
            ];
        }
    }

    public function getRemoteSmilAttribute()
    {
        if ($this->original_filename) {
            return config('app.video_remote_path') . $this->sub_dir . $this->filename . '.smil';
        }
    }

    public function getRemoteThumbAttribute()
    {
        if ($this->original_filename) {
            return config('app.video_remote_thumb_path') . $this->sub_dir . $this->original_filename;
        }
    }

    public function getRemoteOriginalVideoAttribute()
    {
        if ($this->original_filename) {
            return config('app.video_remote_temp_path') . $this->original_filename;
        }
    }

    public function getDurationAttribute()
    {
        return gmdate('i:s', $this->length);
    }
}
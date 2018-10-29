<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateVideoCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videocache:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate video cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $videos = Content::ofType('video')->viewable()->latest()->get();
        $smils = Cache::tags(['contents', 'smils']);
        $embeddedThumbnail = Cache::tags(['contents', 'thumbnails']);
        $sftp = sftp();

        foreach ($videos as $key => $video) {
            $smilsCacheKey = 'smil_exists_' . $video->id;
            $embeddedThumbnailCacheKey = 'embedded_thumbnail_' . $video->id;

            if (is_null($video->embed_type) && ! $smils->has($smilsCacheKey)) {
                $this->info('Generating cache for '. $video->id);
                $smilExists = remote_file_exists($sftp, $video->remote_smil);

                if (! $smilExists) {
                    $this->info('no smil file');
                }

                $smils->forever($smilsCacheKey, $smilExists);

                $this->info($smils->get($smilsCacheKey));
            }

            if ($video->embed_type && ! $embeddedThumbnail->has($embeddedThumbnailCacheKey)) {
                $this->info('Generating embeded thumbnail cache for '. $video->id);
                $filename = $video->thumbnail ?: $video->embed_type.'-'.$video->embed_id.'.jpg';
                $path = config('app.video_remote_embed_thumb_path') . $filename;

                $embeddedThumbnail->forever($embeddedThumbnailCacheKey, remote_file_exists($sftp, $path));
            }
        }
    }
}

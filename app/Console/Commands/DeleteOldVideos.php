<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class DeleteOldVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old videos';

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
        $videos = Content::whereType('video')
                    ->where('original_filename', '!=', '')
                    ->get();

        $totalFilesDeleted = 0;
        $totalUndeletedFiles = 0;

        foreach ($videos as $key => $video) {
            $p480 = $video->getVideoByResolution('480p');
            $original = $video->filename . '.mp4';                

            $resolutions = [
                $original,
                'pc_720_' . $original,
                'pc_480_' . $original,
                'mobile_' . $original,
            ];

            if ($p480) {
                foreach ($resolutions as $key => $res) {
                    $newFile = $video->path . $res;
                    $oldFile = $video->old_path . $res;
                    if (file_exists($newFile)) {
                        unlink($newFile);
                        $this->info($newFile);
                        $totalFilesDeleted++;
                    }

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                        $this->info($oldFile);
                        $totalFilesDeleted++;
                    }
                }
            } else {
                foreach ($resolutions as $key => $res) {
                    if (file_exists($video->path . $res)) {
                        $totalUndeletedFiles++;
                    }

                    if (file_exists($video->old_path . $res)) {
                        $totalUndeletedFiles++;
                    }
                }
            }            
        }

        $this->info('Total Files Deleted: '.$totalFilesDeleted);
        $this->info('Total Files Remaining: '.$totalUndeletedFiles);
    }
}

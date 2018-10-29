<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class UpdateSmilFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smil:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a .smil file';

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
                    ->whereNull('embed_type')
                    ->where('original_filename', '!=', '')
                    ->whereEnabled(1)
                    ->whereApproved(1)
                    ->get();


        foreach ($videos as $key => $video) {            
            $filename = pathinfo($video->original_filename, PATHINFO_FILENAME);
            $path = public_path(config('app.video_path') . sub_dir($filename));

            if (file_exists($path . '480p_'.$filename.'.mp4')) {
                $smilFile = $path . $filename . '.smil';
                
                $resolutions = [
                    '480p_'.$filename.'.mp4' => [
                        'bitrate' => 2000000,
                        'height' => 480,
                        'width' => 854
                    ],
                    '720p_'.$filename.'.mp4' => [
                        'bitrate' => 3500000,
                        'height' => 720,
                        'width' => 1280
                    ],
                    '1080p_'.$filename.'.mp4' => [
                        'bitrate' => 6000000,
                        'height' => 1080,
                        'width' => 1920
                    ],
                ];

                $text = '<?xml version="1.0" encoding="UTF-8"?><smil title=""><body><switch>';        

                foreach ($resolutions as $key => $video) {$this->info($path . $key);
                    if (file_exists($path . $key)) {
                        $text .= '<video height="' . $video['height'] . '" src="' . $key . '" system-bitrate="' . $video['bitrate'] . '" systemLanguage="eng" width="' . $video['width'] . '"></video>';
                    }
                }
                                    
                $text .= '</switch></body></smil>';
                
                $file = fopen($smilFile, 'w+') or die('Unable to open file');
                fwrite($file, $text);
                fclose($file);
            }
        }

        $this->info('Done updating...');
    }
}

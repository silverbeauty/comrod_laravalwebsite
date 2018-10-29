<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CompressThumbnail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compress:thumbnail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compressing videos thumbnails.';

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
        $videos = Content::whereType('video')->where('id', 3582)->get();
        $api_key = env('TINYPNG_API_KEY', null);
        if (is_null($api_key)) {
            $this->error( 'Enter your api key in .env file with TINYPNG_API_KEY key name.' ); die;
        }
        \Tinify\setKey($api_key);
        $bar = $this->output->createProgressBar($videos->count());
        foreach ($videos as $key => $video) {
            $filename = $video->original_filename;
            if($video->embed_id && $video->embed_type == 'youtube') {
                $dir = public_path().'/media/thumbs/embedded';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path = $dir.'/'.$video->embed_id.'-0.jpg';
            } elseif (empty($video->embed)) {
                $dir = public_path().'/media/thumbs/' . sub_dir($filename) . $filename;
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path = $dir.'/'.$filename.'-0.jpg';
            } else {
                $dir = public_path().'/media/thumbs/embedded';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path = $dir.'/'.$video->id.'.jpg';
            }
            
            if (!file_exists($path)) {
                $source = \Tinify\fromFile($video->thumbnail_url);
                $source->toFile($path);
            }
            $bar->advance();
        }
        $this->line("");
    }
}

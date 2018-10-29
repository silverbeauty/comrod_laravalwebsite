<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class YoutubeDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:duration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get youtube video duration';

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
        $videos = Content::whereEmbedType('youtube')->whereLength(0)->get();
        $apiKey = config('services.google.server_api_key');

        foreach ($videos as $video) {
            $url = "https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$video->embed_id&key=$apiKey";
            $this->info($url);
            $info = file_get_contents($url);
            $info =json_decode($info, true);

            if (isset($info['items'][0])) {
                $video->length = ISO8601ToSeconds($info['items'][0]['contentDetails']['duration']);
                $video->save();
            }
        }
    }
}

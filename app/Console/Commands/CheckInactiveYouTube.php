<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class CheckInactiveYouTube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check inactive YouTube video';

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
        $videos = Content::whereEmbedType('youtube')->get();

        foreach ($videos as $key => $video) {
            $video->addInactiveYoutube();            
        }
    }
}

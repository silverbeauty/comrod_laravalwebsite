<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Gstreamer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gstreamer:encode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encode video using Gstreamer';

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
        $videos = Content::whereType('video')->whereNull('embed_type')->get();

        foreach ($videos as $key => $video) {
            $video->encode();
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DownloadLiveFeedXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:livefeedxml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download live feed xml';

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
        file_put_contents(public_path('jamcams-camera-list.xml'), file_get_contents('http://www.tfl.gov.uk/tfl/livetravelnews/trafficcams/cctv/jamcams-camera-list.xml'));
    }
}

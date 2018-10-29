<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class CheckInactiveVidme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vidme:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check inactive vidme video';

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
        $videos = Content::whereEmbedType('vidme')->get();

        foreach ($videos as $key => $video) {
            $video->addInactiveVidme();            
        }
    }
}

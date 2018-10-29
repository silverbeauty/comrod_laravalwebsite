<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class DeleteSyncedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:synced';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete synced files';

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
                    ->whereNotNull('encoded_date')
                    ->where('original_filename', '!=', '')
                    ->latest()
                    ->get();

        foreach ($videos as $key => $video) {
            $video->deleteLocalFiles();

            $this->info('Deleting ' . $video->filename . '.mp4');
        }        
    }
}

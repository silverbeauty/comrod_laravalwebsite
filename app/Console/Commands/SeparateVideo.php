<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class SeparateVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:separate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $videos = Content::viewable()
                    ->ofType('video')
                    ->whereNull('embed_type')
                    ->where('country_code', '!=', 'IL')
                    ->where('original_filename', '!=', '')
                    ->get();

        $sftp = sftp();
        $connection = ssh2_connect(config('app.storage_server_ip'));
        ssh2_auth_password($connection, 'root', config('app.storage_server_password'));

        foreach ($videos as $key => $video) {
            $file = $video->original_filename;

            if (remote_file_exists($sftp, '/home/comroads/' . $file) && ! remote_file_exists($sftp, '/home/nonisrael/' . $file)) {
                $this->info($file);
                ssh2_exec($connection, 'mv /home/comroads/' . $file . ' /home/nonisrael/');
            }
        }
    }
}

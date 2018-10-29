<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EncodeVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:encode {encode_command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encode video';

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
        //dd($this->argument('encode_command'));
        shell_exec($this->argument('encode_command'));
        //$this->info($this->argument('encode_command'));
        //return $this->argument('encode_command');     
    }
}

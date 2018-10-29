<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class GenerateMapContentJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mapcontentjson:generate {locale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate json file for map content';

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
        $locale = $this->argument('locale');

        $_SERVER['HTTP_HOST'] = $locale . '.comroads.com';

        $contents = Content::with(['images', 'categories.category', 'country', 'region'])
                        ->viewable()
                        //->withLatLng()
                        //->take(1)
                        ->get();
        
        $file = public_path($locale . '-map.json');

        file_put_contents($file, collect(map_info($contents, $locale))->toJson());

    }
}

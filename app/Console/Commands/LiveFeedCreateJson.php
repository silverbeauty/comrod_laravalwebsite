<?php

namespace App\Console\Commands;

use App\LiveFeed;
use Illuminate\Console\Command;
use Nathanmac\Utilities\Parser\Parser;

class LiveFeedCreateJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livefeed:createjson {locale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate JSON file from url';

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
        $subdomain = $this->argument('locale');

        $parser = new Parser();
        $parsed = $parser->xml(file_get_contents(public_path('jamcams-camera-list.xml')));
        $iconUrl = asset('images/categories/icon_44.png');
        $iconHoverUrl = asset('images/categories/hover/icon_44.png');

        $xmlFeeds = collect($parsed['cameraList']['camera'])->transform(function ($item, $key) use ($subdomain, $iconUrl, $iconHoverUrl) {
            //dd($item);
            if ($item['@attributes']['available']) {
                $slug = str_slug($item['location'] . '-' . $item['@attributes']['id']);

                $items['id'] = str_slug($item['@attributes']['id']);
                $items['lat'] = (double)$item['lat'];
                $items['lng'] = (double)$item['lng'];
                $items['icon'] = 44;
                $items['title'] = $item['location'];    
                $items['url'] = base_url() . 'live-feed/' . $slug;

                if (!is_null($subdomain) && $subdomain != 'en') {
                    $items['url'] = base_url($subdomain) . 'live-feed/' . $slug;
                }

                $items['cc'] = 'GB';
                $items['tu'] = 'https://s3-eu-west-1.amazonaws.com/jamcams.tfl.gov.uk/' . $item['file'] . '?' . strtotime("now");
                $items['source'] = 'jamcams-camera-list.xml';
                $items['refresh'] = true;
                $items['refresh_seconds'] = 10;
                $items['type'] = 'live-feed';

                return $items;
            }
        });

        $dbFeeds = LiveFeed::all()->transform(function ($item, $key) use ($iconUrl, $iconHoverUrl, $subdomain) {
            $slug = str_slug($item->title . '-' . $item->id);

            $items['id'] = $item->id;
            $items['title'] = $item->title;
            $items['lat'] = $item->latitude;
            $items['lng'] = $item->longitude;
            $items['icon'] = 44;
            $items['url'] = base_url() . 'live-feed/' . $slug;

            if (!is_null($subdomain) && $subdomain != 'en') {
                $items['url'] = base_url($subdomain) . 'live-feed/' . $slug;
            }

            $items['cc'] = $item->country_code;
            $items['tu'] = explode('?', $item->thumb_url)[0] . '?' . strtotime("now");
            $items['source'] = 'db';
            $items['refresh'] = true;
            $items['refresh_seconds'] = $item->refresh_in_seconds;
            $items['type'] = 'live-feed';

            return $items;
        });

        $feeds = $xmlFeeds->merge($dbFeeds)->toJson();

        $file = public_path($subdomain . '-map-live-feed.json');

        file_put_contents($file, $feeds);
    }
}

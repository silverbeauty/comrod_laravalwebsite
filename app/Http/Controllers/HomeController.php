<?php

namespace App\Http\Controllers;

use Cache;
use JavaScript;
use App\Content;
use App\LiveFeed;
use App\WatchLog;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Nathanmac\Utilities\Parser\Parser;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->merge([
            'content_type' => 'any'
        ]);

        return $this->homeContents($request);
    }

    public function v3(Request $request)
    {
        session()->put('layout', 'v3');

        $request->merge([
            'content_type' => 'any'
        ]);

        return $this->homeContents($request);
    }

    public function photos(Request $request)
    {   
        $request->merge([
            'content_type' => 'photo'
        ]);

        return $this->homeContents($request);
    }

    public function videos(Request $request)
    {   
        $request->merge([
            'content_type' => 'video'
        ]);

        return $this->homeContents($request);
    }

    private function homeContents(Request $request)
    {
        $user = $request->user();
        $ip = user_ip();
        $domain = config('app.domain');
        $subdomain = get_subdomain();
        $layout = session('layout') ?: config('app.layout');
        $cacheTime = config('app.cache_time');
        $user_geo = user_geo($ip);

        $data['content_type'] = $request->content_type;
        $data['limit'] = $layout == 'v2' || $layout == 'v3' ? 16 : 9;        
        $data['disable_map'] = $layout == 'v3' ? true : false;        
        $data['sort_key'] = $request->sort_by ?: 'most_recent_uploaded';
        $data['show_from_filter_key'] = $request->filter_by ?: 'all_time';
        $data['category_filters'] = [];
        $data['hide_watched'] = false;
        $data['country_code'] = $request->geo ? strtoupper($request->geo) : $user_geo['country_code'];
        $data['country_name'] = $request->geo ? country_name_by_code($request->geo) : $user_geo['country_name'];
        $data['ne_lat'] = null;
        $data['ne_lng'] = null;
        $data['sw_lat'] = null;
        $data['sw_lng'] = null;

        if ($layout == 'v3') {
            $data['country_code'] = 'worldwide';
            $data['country_name'] = trans('app.worldwide');
        }

        $data['settings'] = isset($_COOKIE['settings']) ? (array) json_decode($_COOKIE['settings']) : null;
        
        if (!is_null($data['settings'])) {
            $data['sort_key'] = isset($data['settings']['sort_type']) ? $data['settings']['sort_type'] : $data['sort_key'];
            $data['show_from_filter_key'] = isset($data['settings']['show_from']) ? $data['settings']['show_from'] : $data['show_from_filter_key'];
            $data['category_filters'] = isset($data['settings']['categories']) ? $data['settings']['categories'] : [];
            $data['hide_watched'] = isset($data['settings']['hide_watched']) ? $data['settings']['hide_watched'] : false;
            $data['country_code'] = isset($data['settings']['country_code']) ? $data['settings']['country_code'] : $data['country_code'];
            $data['country_name'] = isset($data['settings']['country_name']) ? $data['settings']['country_name'] : $data['country_name'];
            $data['ne_lat'] = isset($data['settings']['ne_lat']) ? $data['settings']['ne_lat'] : $data['ne_lat'];
            $data['ne_lng'] = isset($data['settings']['ne_lng']) ? $data['settings']['ne_lng'] : $data['ne_lng'];
            $data['sw_lat'] = isset($data['settings']['sw_lat']) ? $data['settings']['sw_lat'] : $data['sw_lat'];
            $data['sw_lng'] = isset($data['settings']['sw_lng']) ? $data['settings']['sw_lng'] : $data['sw_lng'];
        }  

        $cacheKey = md5(json_encode([
                    $data['sort_key'],
                    $data['show_from_filter_key'],
                    $data['category_filters'],
                    $data['country_code'],
                    $data['ne_lat'],
                    $data['ne_lng'],
                    $data['sw_lat'],
                    $data['sw_lng'],
                ]));        
        
        if ($layout == 'v1') {
            $trendingCache = Cache::tags(['contents', 'trending_contents']);
            $trendingCacheKey = $subdomain.'_trending_'.$cacheKey;

            $data['popular'] = $trendingCache->remember($trendingCacheKey, $cacheTime, function () {
                return Content::trendingVideos();
            });
        }

        $mainContentsCache = Cache::tags(['contents', 'main_contents']);
        $mainContentsCacheKey = $subdomain.'_main_contents_'.$cacheKey;

        $data['main_contents'] = $mainContentsCache->remember($mainContentsCacheKey, $cacheTime, function () use ($data) { 
            $contents = Content::with(['images', 'categories.category', 'country', 'region'])
                        ->viewable()
                        ->uploadedSince($data['show_from_filter_key']);

            if ($data['country_code'] != 'worldwide' && is_null($data['ne_lat'])) {
                $contents->country($data['country_code']);
            }

            if (count($data['category_filters'])) {
                $contents->whereCategories($data['category_filters']);
            }

            if ($data['content_type'] != 'any') {
                $contents->where('type', $data['content_type']);
            }

            if ($data['ne_lat'] && $data['ne_lng'] && $data['sw_lat'] && $data['sw_lng']) {
                $neLat = (double)$data['ne_lat'];
                $neLng = (double)$data['ne_lng'];
                $swLat = (double)$data['sw_lat'];
                $swLng = (double)$data['sw_lng'];

                if ($neLat < 1 && $swLat < 1) {
                    $neLng = abs($neLng);
                    $swLng = abs($swLng);
                }

                $contents->where('latitude', '>', $swLat)
                         ->where('latitude', '<', $neLat)
                         ->where('longitude', '>', $swLng)
                         ->where('longitude', '<', $neLng);               
            }
            
            $results = $contents->latest(sorting($data['sort_key']))->paginate($data['limit']);
            
            if ($results->total() < $data['limit'] && is_null($data['ne_lat'])) {
                $results = Content::with(['images', 'categories.category', 'country', 'region'])
                        ->viewable()
                        ->uploadedSince($data['show_from_filter_key'])
                        ->whereCategories($data['category_filters'])
                        ->latest(sorting($data['sort_key']))->paginate($data['limit']);
            }            

            return [
                'total' => $results->total(),
                'items' => map_info(collect($results->all()))
            ];
        });

        $data['filter_menu'] = filter_menu($request->all());
        $data['watched'] = !is_null($user) ? $user->watched->pluck('content_id') : session('watched', []);
        $data['banner_ad'] = ad(1);
        $data['content_type'] = $request->content_type;
        $data['total_contents'] = $data['main_contents']['total'];

        JavaScript::put([
            'no_marker_message' => trans('app.no_marker_message'),
            'settings' => [
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => false,
                'total_slots' => $data['limit'],
                'multiple_markers' => true,
                'map_element_id' => 'map',
                'disable_map' => $data['disable_map'],
                'map_icon' => null,
                'use_prev_map' => true,
                'lat' => $user_geo['latitude'],
                'lng' => $user_geo['longitude'],
                'address' => $data['country_name'],
                'zoom' => map_zoom_by_country_code($data['country_code']),
                'sort_type' => $data['sort_key'],
                'show_from' => $data['show_from_filter_key'],
                'content_id' => null,
                'categories' => [],
                'hide_watched' => false,
                'main_carousel_item' => 0,
                'country_code' => $data['country_code'],
                'country_name' => $data['country_name'],
                'map_content_type' => $request->content_type,
                'map_loading' => true,
                'use_country_name' => true,
                'logged_in' => Auth::check(),
                'watched' => $data['watched'],
                'watchedLabel' => trans('app.watched'),
                'has_json_file' => true,
                'json_file' => '../../'.get_subdomain().'-map.json',
                'layout' => $layout,
                'categories_icon_url' => 'http://jspl.comroads.com/images/categories/',
                'query_string' => null,
                'ne_lat' => null,
                'ne_lng' => null,
                'sw_lat' => null,
                'sw_lng' => null,
            ]
        ]);       
        
        if ($layout == 'v2') {
            return view('home_v2', $data);
        }

        if ($layout == 'v3') {

            if ($data['total_contents'] < $data['limit']) {
                $data['country_code'] = 'worldwide';
                $data['country_name'] = trans('app.worldwide');                
            }

            return view('home_v3', $data);
        }

        return view('home', $data);
    }

    public function switchLayout($version)
    {
        session()->put('layout', $version);

        return redirect('');
    }

    public function liveFeeds(Parser $parser)
    {
        $layout = session('layout') ?: config('app.layout');
        $data['limit'] = $layout == 'v2' ? 16 : 9;

        $parsed = $parser->xml(file_get_contents(public_path('jamcams-camera-list.xml')));

        $data['contents'] = collect($parsed['cameraList']['camera'])->take(16);

        JavaScript::put([
            'no_marker_message' => trans('app.no_marker_message'),
            'settings' => [
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => true,
                'total_slots' => $data['limit'],
                'multiple_markers' => true,
                'map_element_id' => 'map',
                'map_icon' => null,
                'use_prev_map' => true,
                'lat' => null,
                'lng' => null,
                'address' => 'London United Kingdom',
                'zoom' => map_zoom_by_country_code('GB'),
                'content_id' => null,
                'categories' => [],
                'hide_watched' => false,
                'main_carousel_item' => 0,
                'country_code' => 'GB',
                'country_name' => 'United Kingdom',
                'map_content_type' => 'any',
                'map_loading' => true,
                'use_country_name' => true,
                'logged_in' => Auth::check(),
                'map_search' => true,
                'map_search_box_placeholder' => trans('video.search_google_maps'),
                'has_json_file' => true,
                'json_file' => '../../'.get_subdomain().'-map-live-feed.json',
                'layout' => $layout,
                'traffic_layer' => true,
                'categories_icon_url' => 'http://jspl.comroads.com/images/categories/'
            ]
        ]);

        return view('live_feeds', $data);
    }

    public function liveFeed($id, Parser $parser, Request $request)
    {
        $parsed = $parser->xml(file_get_contents(public_path('jamcams-camera-list.xml')));
        $id = last(explode('-', $id));
//dd($id);
        $data['content'] = collect($parsed['cameraList']['camera'])->filter(function ($item) use ($id) {
            return $item['@attributes']['available'] && str_slug($item['@attributes']['id']) == $id;
        })->collapse()->all();

        if (count($data['content']) == 0) {
            $feed = LiveFeed::find($id);

            if (is_null($feed)) {
                return redirect()->route('liveFeeds');
            }

            $data['content']['title'] = $feed->title;
            $data['content']['url'] = $feed->url;
            $data['content']['country_code'] = strtolower($feed->country_code);
            $data['content']['country_name'] = country_name_by_code($feed->country_code);
            $data['content']['lat'] = $feed->latitude;
            $data['content']['lng'] = $feed->longitude;
            $data['content']['source'] = 'db';            
            $data['content']['type'] = $feed->type;
            $data['content']['content_url'] = $feed->content_url;
            $data['content']['image_url'] = $feed->type == 'photo' ? $feed->content_url : $feed->thumb_url;
            $data['content']['refresh_seconds'] = $feed->refresh_in_seconds;

        } else {
            $slug = str_slug($data['content']['location'] . '-' . $data['content']['@attributes']['id']);
            $data['content']['title'] = $data['content']['location'];
            $data['content']['url'] = route('liveFeed', ['id' => $slug]);
            $data['content']['country_code'] = 'gb';
            $data['content']['country_name'] = 'United Kingdom';
            $data['content']['src'] = 'xml';
            $data['content']['image_url'] = 'https://s3-eu-west-1.amazonaws.com/jamcams.tfl.gov.uk/' . $data['content']['file'];
            $data['content']['content_url'] = 'https://s3-eu-west-1.amazonaws.com/jamcams.tfl.gov.uk/' . pathinfo($data['content']['file'], PATHINFO_FILENAME) . '.mp4';
            $data['content']['type'] = 'video';
            $data['content']['refresh_seconds'] = 10;           
        }       




        $data['is_ajax'] = $request->ajax();       
        

        if (! $data['is_ajax']) {            

            $settings = [                
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => true,
                'total_slots' => 3,
                'multiple_markers' => true,
                'map_element_id' => 'contentProfileMap',
                'map_icon' => asset('images/categories/hover/icon_44.png'),
                'lat' => (double)$data['content']['lat'],
                'lng' => (double)$data['content']['lng'],
                'address' => null,
                'zoom' => 12,
                'content_id' => $id,
                'categories' => [],
                'map_content_type' => 'any',
                'map_loading' => true,
                'default_marker' => true,
                'logged_in' => Auth::check(),
                'main_carousel_item' => 0,
                'watched' => [],
                'has_json_file' => true,
                'json_file' => '../../'.get_subdomain().'-map-live-feed.json'
            ];

            $data['js_vars'] = JavaScript::put([
                'settings' => $settings
            ]);            
        }

        if (is_rtl()) {
            return view('profiles.live_feed_content_right', $data);
        }
        
        return view('profiles.live_feed_content', $data);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Content;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subdomain = get_subdomain();

        $data['settings'] = isset($_COOKIE['settings']) ? (array) json_decode($_COOKIE['settings']) : null;
        $data['sort_key'] = $request->sort_by ?: 'most_recent_uploaded';
        $data['show_from_filter_key'] = $request->filter_by ?: 'all_time';
        $data['category_filters'] = [];
        $data['country_code'] = 'worldwide';
        $data['query_string'] = null;
        $data['ne_lat'] = null;
        $data['ne_lng'] = null;
        $data['sw_lat'] = null;
        $data['sw_lng'] = null;
        $data['limit'] = 16;
        
        if (!is_null($data['settings'])) {
            $data['sort_key'] = isset($data['settings']['sort_type']) ? $data['settings']['sort_type'] : $data['sort_key'];
            $data['show_from_filter_key'] = isset($data['settings']['show_from']) ? $data['settings']['show_from'] : $data['show_from_filter_key'];
            $data['category_filters'] = isset($data['settings']['categories']) ? $data['settings']['categories'] : [];
            $data['country_code'] = isset($data['settings']['country_code']) ? $data['settings']['country_code'] : $data['country_code'];
            $data['query_string'] = isset($data['settings']['query_string']) ? $data['settings']['query_string'] : $data['query_string'];
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
                    $data['query_string'],
                    $data['ne_lat'],
                    $data['ne_lng'],
                    $data['sw_lat'],
                    $data['sw_lng'],
                    $request->page
                ]));

        $mainContentsCache = Cache::tags(['contents', 'main_contents']);
        $mainContentsCacheKey = $subdomain.'_main_contents_'.$cacheKey;

        $contents = $mainContentsCache->remember($mainContentsCacheKey, config('app.cache_time'), function () use ($data) {
            $contents = Content::with(['images', 'categories.category', 'country', 'region'])
                        ->viewable()
                        ->uploadedSince($data['show_from_filter_key']);

            if ($data['country_code'] != 'worldwide' && is_null($data['ne_lat'])) {
                $contents->country($data['country_code']);
            }

            if (count($data['category_filters'])) {
                $contents->whereCategories($data['category_filters']);
            }

            if ($data['query_string']) {
                $contents->where('title', 'like', '%' . $data['query_string'] . '%')
                         ->orWhere('description', 'like', '%' . $data['query_string'] . '%')
                         ->orWhere('camera', 'like', '%' . $data['query_string'] . '%');
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
                         
                $results = $contents->latest(sorting($data['sort_key']))->paginate(500);
            } else {
                $results = $contents->latest(sorting($data['sort_key']))->paginate($data['limit']);
            }

            if ($results->total() < $data['limit'] && is_null($data['query_string']) && is_null($data['ne_lat'])) {
                $results = Content::with(['images', 'categories.category', 'country', 'region'])
                        ->viewable()
                        ->uploadedSince($data['show_from_filter_key'])
                        ->whereCategories($data['category_filters'])
                        ->latest(sorting($data['sort_key']))->paginate($data['limit']);                
            }            

            return [
                'next_page_url' => $results->nextPageUrl(),
                'items' => map_info(collect($results->all()))
            ];

        });
        
        return $contents;
    }    
}

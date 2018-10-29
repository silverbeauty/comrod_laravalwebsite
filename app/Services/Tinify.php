<?php

namespace App\Services;

use Tinify\Source;
use Tinify\Tinify as BaseTinify;

class Tinify
{
    public function __construct()
    {
        BaseTinify::setKey(env('TINYPNG_API_KEY', null));
    }

    public function processExternalImage($id, $type)
    {        
        $url = $this->imageUrl($id, $type);

        $headers = @get_headers($url);

        if ($headers[0] != 'HTTP/1.1 200 OK') {
            return;
        }

        $dir = public_path().'/media/thumbs/embedded';

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $path = $dir.'/'.$type.'-'.$id.'.jpg';

        if (!file_exists($path) && $url) {
            $source = Source::fromFile($url);
            $source->toFile($path);
        }
    }

    private function imageUrl($id, $type)
    {
        if ($type == 'youtube') {
            return 'https://img.youtube.com/vi/'.$id.'/0.jpg';
        }

        if ($type == 'vidme') {
            $info = vidme_info('https://vid.me/'.$id);

            if ($info) {
                return $info['video']['thumbnail_url'];
            }
        }
    }    
}
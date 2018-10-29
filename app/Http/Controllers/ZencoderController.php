<?php

namespace App\Http\Controllers;

use App\Zencoder;
use App\Http\Requests;
use App\Services\FFMPEG;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Zencoder as ZencoderService;

class ZencoderController extends Controller
{
    public function getEncode()
    {
        //$zencoder = new ZencoderService;

        //dd($zencoder->encode('aa975198d110f86880536cb33136790c216a8cf6.mp4'));

        $ffmpeg = new FFMPEG('4f7ef9683ea0df7eb4d07b4a415cbe94595e49c5.mp4');
        //$ffmpeg->encode();

        dd($ffmpeg->createThumbnail());
    }

    public function postNotifications()
    {
        $zencoder = new ZencoderService;        

        $notifications = $zencoder->notifications();
        $video_path = public_path(config('app.video_path'));

        if (count($notifications)) {
            foreach ($notifications as $key => $notification) { 
                $item = Zencoder::find($notification['id']);
                
                if ($item) {
                    $content = $item->content;
                    $extract_original_filename = explode('.', $content->original_filename);
                    $new_filename = $notification['label'].'_'.$extract_original_filename[0].'.mp4';
                    $sub_path = sub_dir($content->original_filename);
                    $full_video_path = str_replace('//', '/', $video_path . $sub_path);                    

                    if (!file_exists($full_video_path) && !mkdir($full_video_path, 0777, true)) {                        
                        Log::error('Zencoder unable to create directory: ', [
                            'Full video path: ' => $full_video_path,
                            'Zencoder output url: ' => $notification['url']
                        ]);
                        dd('Zencoder unable to create directory: '.$full_video_path);
                    } else { 
                        exec(config('app.wget_path') . ' --no-check-certificate "' . $notification['url'] . '" -O "'.$full_video_path.'/'.$new_filename.'"', $output);

                        dd(config('app.wget_path') . ' --no-check-certificate "' . $notification['url'] . '" -O "'.$full_video_path.'/'.$new_filename.'"');                        
                    }                    
                }
            }

            return ['message' => 'done'];
        }

        return ['message' => 'No notification'];
    }
}

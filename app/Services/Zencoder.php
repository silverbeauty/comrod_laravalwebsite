<?php

namespace App\Services;

use App\Content;

class Zencoder 
{
    protected $zencoder;

    protected $getID3;

    protected $basePath;

    protected $baseUrl;

    protected $videoPath;

    public function __construct()
    {
        $this->zencoder = new \Services_Zencoder(config('services.zencoder.key'));
        $this->getID3 = new \getID3;
        $this->basePath = public_path(config('app.video_upload_path'));
        $this->videoPath = public_path(config('app.video_path'));
        $this->baseUrl = asset(config('app.video_upload_path'));
    }

    public function encode($filename)
    {
        return $this->zencoder->jobs->create([
            "test" => config('services.zencoder.test_mode'),
            "input" => "$this->baseUrl/$filename",
            "private" => false,
            "outputs" => $this->formats($this->getWidth($filename))                
        ]);
    }

    protected function getWidth($filename)
    {
        $info = $this->getID3->analyze($this->basePath . $filename);

        return $info['video']['resolution_x'];
    }

    private function formats($width)
    {
        $notifications = [
            'url' => route('zencoder::postNotifications'),
            'format' => 'json'
        ];

        $watermark_url = zencoder_watermark_url();
        $watermark_margin_left = config('services.zencoder.watermark.margin_left');
        $watermark_margin_top = config('services.zencoder.watermark.margin_top');
        $watermark_width_default = config('services.zencoder.watermark.width');
        $watermark_height_default = config('services.zencoder.watermark.height');
        $keyframe_rate = config('services.zencoder.keyframe_rate');

        $watermark_settings_default = [
            "url" => $watermark_url,
            "x" => $watermark_margin_top / 5,
            "y" => $watermark_margin_left / 5,
            "width" => $watermark_width_default / 5,
            "height" => $watermark_height_default / 5
        ];

        $watermark_settings = $watermark_settings_default;

        if($width > 720){
            $watermark_settings = [
                "url" => $watermark_url,
                "x" => $watermark_margin_top / 2,
                "y" => $watermark_margin_left / 2,
                "width" => $watermark_width_default / 2,
                "height" => $watermark_height_default / 2
            ];
        }

        $formats[] = [
            "label" => "mobile",
            "audio_bitrate" => 128,
            "audio_sample_rate" => 44100,
            "width" => 720,
            "max_frame_rate" => 30,
            "video_bitrate" => 1500,
            "h264_level" => 3,
            "watermarks" => $watermark_settings_default,
            "notifications" => $notifications
        ];
        
        $formats[] = [
            "label" => "pc_720",
            "width" => $width,
            "keyframe_rate" => $keyframe_rate,
            "watermarks" => $watermark_settings,
            "notifications" => $notifications
        ];
        
        $formats[] = [
            "label" => "pc_480",
            "width" => 720,
            "video_bitrate" => 2500,
            "keyframe_rate" => $keyframe_rate,
            "watermarks" => $watermark_settings_default,
            "notifications" => $notifications
        ];

        return $formats;
    }    

    public function notifications()
    {
        $notifications = [];

        try {
            $zencoder_notifications = $this->zencoder->notifications->parseIncoming();

            foreach (config('services.zencoder.labels') as $key => $label) {
                if (isset($zencoder_notifications->job->outputs[$key]) && $zencoder_notifications->job->outputs[$key]->state == 'finished') {
                    $notifications[$key]['id'] = $zencoder_notifications->job->outputs[$key]->id;
                    $notifications[$key]['url'] = $zencoder_notifications->job->outputs[$key]->url;
                    $notifications[$key]['label'] = $key;
                    $notifications[$key]['make_thumbs'] = $label['make_thumbs'];
                }
            }           

        } catch (\Services_Zencoder_Exception $e) {
            
        }

        return $notifications;        
    }
}
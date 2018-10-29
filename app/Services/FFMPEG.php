<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class FFMPEG extends Encoder
{
    public function encode($processId = null, $pending = [], $reencode = false)
    {
        if ($processId) {
            sleep(10);

            if ($this->processIsRunning($processId)) {
                return $this->encode($processId, $pending);
            }            

            if (count($pending)) {
                foreach ($pending as $key => $command) {
                    unset($pending[$key]);
                    $processId = shell_exec($command);
                    return $this->encode($processId, $pending);
                }
            } else {
                $this->createSmilFile();
                $this->transferFiles();
                $this->updateVideoInfo();

                return;
            }       
        }

        $this->calculateVideoThumbsize();

        $videoHeight = $this->videoHeight();
        $processId = null;
        $pending = [];

        foreach (config('app.encoded_videos') as $key => $video) {
            $videoPath = public_path($video['path'] . $this->subdir);
            $thumbPath = public_path($video['thumb_path'] . $this->subdir . $this->originalFilename . '/');
            $watermarksPath = public_path($video['watermarks_path']);

            $outputFile1080p = $videoPath . '1080p_' . $this->filename . '.mp4';
            $outputFile720p = $videoPath . '720p_' . $this->filename . '.mp4';
            $outputFile480p = $videoPath . '480p_' . $this->filename . '.mp4';        
            $target_image = $thumbPath . $this->originalFilename . '-0.jpg';
            $watermark480p = $watermarksPath . '60.png';
            $watermark = $this->watermark($watermarksPath);

            if ($this->countryNotExempted($video['exempted_countries']) && (!file_exists($outputFile480p) || $reencode)) {

                make_dir($videoPath);
                make_dir($thumbPath);                    

                $command1080p = $this->ffmpegPath . "ffmpeg -y -i ".$this->originalVideo." -g 60 -force_key_frames \"expr:gte(t,n_forced*2)\" -b:v 6000k -vf \"movie=".$watermark." [watermark]; [in][watermark] overlay=15:15, scale=trunc(oh*a/2)*2:1080 [out]\" ".$outputFile1080p . " >/dev/null 2>&1 & echo $!";
                $command720p = $this->ffmpegPath . "ffmpeg -y -i ".$this->originalVideo." -g 60 -force_key_frames \"expr:gte(t,n_forced*2)\" -b:v 3500k -vf \"movie=".$watermark." [watermark]; [in][watermark] overlay=15:15, scale=trunc(oh*a/2)*2:720 [out]\" ".$outputFile720p . " >/dev/null 2>&1 & echo $!";
                $command480p = $this->ffmpegPath . "ffmpeg -y -i ".$this->originalVideo." -g 60 -force_key_frames \"expr:gte(t,n_forced*2)\" -b:v 2000k -vf \"movie=".$watermark." [watermark]; [in][watermark] overlay=15:15, scale=trunc(oh*a/2)*2:480 [out]\" ".$outputFile480p . " >/dev/null 2>&1 & echo $!";            

                Log::info($command480p);

                if ($videoHeight >= 1080) {
                    if (is_null($processId)) {
                        $processId = shell_exec($command1080p);
                    } else {
                       $pending[] = $command1080p; 
                    }

                    $pending[] = $command720p;
                    $pending[] = $command480p;                
                }

                if ($videoHeight >= 720 && $videoHeight < 1080) {
                    if (is_null($processId)) {
                        $processId = shell_exec($command720p);
                    } else {
                        $pending[] = $command720p;
                    }

                    $pending[] = $command480p;                
                }

                if ($videoHeight < 720) {
                    if (is_null($processId)) {
                        $processId = shell_exec($command480p);
                    } else {
                        $pending[] = $command480p;
                    }                          
                }

                $commandCreateThumbnail = $this->ffmpegPath . "ffmpeg -ss 1 -y -i \"".$this->originalVideo."\" -vcodec mjpeg -vframes 1 -an -f rawvideo -s ".$this->thumbWidth."x".$this->thumbHeight." \"$target_image\"";
                $mogrify = "mogrify -modulate 110,102,100 -sharpen 1x1 -enhance " . $target_image;
                $composite = "composite -gravity northwest -geometry +10+10 -dissolve 100% " . $watermark480p . " " . $target_image . " " . $target_image;

                shell_exec($commandCreateThumbnail);

                shell_exec($mogrify);

                shell_exec($composite);
            }
        }

        if ($processId) {
            return $this->encode($processId, $pending);
        }
    }
}
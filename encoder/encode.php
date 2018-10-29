<?php

// ob_start();
// phpinfo();
// $info = ob_get_contents();
// ob_end_clean();
// $file = fopen('phpinfo.txt', 'w+') or die('Unable to open file');
// fwrite($file, $info);
// fclose($file);
// ffprobe -show_streams -select_streams v -show_entries stream=width -hide_banner /home/comroads/99d2c84d4629484c7de2e616f2f21e8a9c76cf04.MOV 2>/dev/null | grep width=
$siteName = 'comroads';
$paths['input'] = '/home/'.$siteName.'/';
$paths['videos_output'] = '/home/encoded/'.$siteName.'/videos/';
$paths['thumbs_output'] = '/home/encoded/'.$siteName.'/thumbs/';
$paths['watermarks'] = '/home/encoder/watermarks/'.$siteName.'/';
$paths['ffmpeg'] = '/home/ffmpeg/';

//$videos = ['09a40f4b7bac59d90299b2b99be8e26d6925b0e0.mp4'];
$videos = array_diff(scandir($paths['input']), ['..', '.']);

//exec("ps 14323", $processState);
//var_dump($processState);

ffmpeg_encode($videos, $paths);

function ffmpeg_encode($videos, $paths, $video = null, $processes = [], $pending = [])
{
    if (count($processes)) {
        sleep(10);
        echo 'encoding '. $video . ' - Time: '. time();
        echo "\r\n";

        foreach ($processes as $key => $id) {
            if (is_running($id)) {
                return ffmpeg_encode($videos, $paths, $video, $processes, $pending);
            }
        }

        if (count($pending)) {
            foreach ($pending as $key => $command) {
                unset($pending[$key]);
                $processes[] = shell_exec($command);
                return ffmpeg_encode($videos, $paths, $video, $processes, $pending);
            }
        } else {
            $filename = pathinfo($video, PATHINFO_FILENAME);
            $subDir = sub_dir($filename);
            $smil = $paths['videos_output'] . $subDir . $filename . '.smil';

            create_smil_file($smil, $filename . '.mp4', $paths['videos_output'] . $subDir);
        }       
    }    

    foreach ($videos as $key => $video) {        
        $filename = pathinfo($video, PATHINFO_FILENAME);
        $subDir = sub_dir($filename);       
        $videoOutputPath = $paths['videos_output'] . $subDir;
        $thumbOutputPath = $paths['thumbs_output'] . $subDir . $video . '/';
        $outputFile1080p = $videoOutputPath . '1080p_' . $filename . '.mp4';
        $outputFile720p = $videoOutputPath . '720p_' . $filename . '.mp4';
        $outputFile480p = $videoOutputPath . '480p_' . $filename . '.mp4';
        $inputFile = $paths['input'] . $video;
        $target_image = $thumbOutputPath . $video . '-0.jpg';
            
        make_dir($videoOutputPath);
        make_dir($thumbOutputPath);

        if (!file_exists($outputFile480p)) {
            $height = shell_exec($paths['ffmpeg'] . "ffprobe -show_streams -select_streams v -show_entries stream=height -hide_banner ".$inputFile." 2>/dev/null | grep height=");
            $width = shell_exec($paths['ffmpeg'] . "ffprobe -show_streams -select_streams v -show_entries stream=width -hide_banner ".$inputFile." 2>/dev/null | grep width=");

            echo 'Height: ' . $height . "\r\n";
            echo 'Width: ' . $width . "\r\n";            

            $widthPeices = explode('=', $width);
            $width = $widthPeices[1];
            $heightPeices = explode('=', $height);
            $height = $heightPeices[1];

            $thumbWidth = 500;
            $thumbHeight = 200;
            $ratio = $width / $height;

            if ($ratio < 1) {
                $thumbWidth = floor($thumbHeight * $ratio);
            } else {
                $thumbHeight = floor($thumbWidth / $ratio);
            }

            $processes = [];
            $pending = [];

            $watermark480p = $paths['watermarks'] . '60.png';
            $watermark = $paths['watermarks'] . '60.png';

            if ($height >= 1080) {
                $watermark = $paths['watermarks'] . '110.png';
            }

            if ($height >= 720 && $height < 1080) {
                $watermark = $paths['watermarks'] . '90.png';
            }

            $command1080p = $paths['ffmpeg'] . "ffmpeg -i ".$inputFile." -g 60 -force_key_frames \"expr:gte(t,n_forced*2)\" -b:v 6000k -vf \"movie=".$watermark." [watermark]; [in][watermark] overlay=1065:15, scale=trunc(oh*a/2)*2:1080 [out]\" ".$outputFile1080p . " >/dev/null 2>&1 & echo $!";
            $command720p = $paths['ffmpeg'] . "ffmpeg -i ".$inputFile." -g 60 -force_key_frames \"expr:gte(t,n_forced*2)\" -b:v 3500k -vf \"movie=".$watermark." [watermark]; [in][watermark] overlay=705:15, scale=trunc(oh*a/2)*2:720 [out]\" ".$outputFile720p . " >/dev/null 2>&1 & echo $!";
            $command480p = $paths['ffmpeg'] . "ffmpeg -i ".$inputFile." -g 60 -force_key_frames \"expr:gte(t,n_forced*2)\" -b:v 2000k -vf \"movie=".$watermark." [watermark]; [in][watermark] overlay=465:15, scale=trunc(oh*a/2)*2:480 [out]\" ".$outputFile480p . " >/dev/null 2>&1 & echo $!";            

            if ($height >= 1080) {
                $processes[] = shell_exec($command1080p);
                $pending[] = $command720p;
                $pending[] = $command480p;
                echo $command1080p . "\r\n";
                echo $command720p . "\r\n";
                echo $command480p . "\r\n";
            }

            if ($height >= 720 && $height < 1080) {
                $processes[] = shell_exec($command720p);
                $pending[] = $command480p;
                echo $command720p . "\r\n";
                echo $command480p . "\r\n";
            }

            if ($height < 720) {
                $processes[] = shell_exec($command480p);
                echo $command480p . "\r\n";
            }

            $commandCreateThumbnail = $paths['ffmpeg'] . "ffmpeg -ss 1 -y -i \"".$inputFile."\" -vcodec mjpeg -vframes 1 -an -f rawvideo -s ".$thumbWidth."x".$thumbHeight." \"$target_image\"";        

            shell_exec($commandCreateThumbnail);

            shell_exec("mogrify -modulate 110,102,100 -sharpen 1x1 -enhance " . $target_image);

            shell_exec("composite -gravity northwest -geometry +10+10 -dissolve 100% " . $watermark480p . " " . $target_image . " " . $target_image);

            var_dump($processes);

            return ffmpeg_encode($videos, $paths, $video, $processes, $pending);
        }   
    }

    echo 'Finish encoding';
    echo "\r\n";
    return;
}

//gstreamer_encode($videos, $inputPath, $outputPath, $watermarksPath, null, null);

function gstreamer_encode($videos, $inputPath, $outputPath, $watermarksPath, $video, $smil)
{
    if ((!is_null($smil) && !file_exists($smil)) || (file_exists($smil) && filesize($smil) == 0)) {
        sleep(10);
        echo 'encoding '. $video . ' - Time: '. time();
        echo "\r\n";        
        return gstreamer_encode($videos, $inputPath, $outputPath, $watermarksPath, $video, $smil);
    }

    foreach ($videos as $key => $video) {
        $newOutputPath = str_replace('//', '/', $outputPath . sub_dir($video));        
        $filename = pathinfo($video, PATHINFO_FILENAME);
        $command = "prepare " . $watermarksPath . " " . $inputPath . $video . " ". $newOutputPath ." ". $filename . " >/dev/null 2>&1 &";
        $smil = $newOutputPath . '/' . $filename . '.smil';        

        if (!file_exists($smil)) {            
            shell_exec($command);
            return gstreamer_encode($videos, $inputPath, $outputPath, $watermarksPath, $video, $smil);
        }    
    }

    echo 'Finish encoding';
    echo "\r\n";
    return;
}

function sub_dir($filename)
{
    $dir = null;

    for ($i=0; $i < 5; $i++) { 
        $dir .= substr($filename, $i, 1) . '/';
    }

    return $dir;
}

function is_running($pid) {
    exec("ps $pid", $processState);

    return count($processState) >= 2;
}

function make_dir($path)
{
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
        chmod($path, 0777);
    }
}

function create_smil_file($smilFile, $filename, $videoPath)
{
    if (file_exists($videoPath . '480p_'.$filename)) {
        $resolutions = [
            '480p_'.$filename => [
                'bitrate' => 2000000,
                'height' => 480,
                'width' => 854
            ],
            '720p_'.$filename => [
                'bitrate' => 3500000,
                'height' => 720,
                'width' => 1280
            ],
            '1080p_'.$filename => [
                'bitrate' => 6000000,
                'height' => 1080,
                'width' => 1920
            ],
        ];

        $text = '<?xml version="1.0" encoding="UTF-8"?><smil title=""><body><switch>';        

        foreach ($resolutions as $key => $video) {
            if (file_exists($videoPath . $key)) {
                $text .= '<video height="' . $video['height'] . '" src="' . $key . '" system-bitrate="' . $video['bitrate'] . '" systemLanguage="eng" width="' . $video['width'] . '"></video>';                
            }
        }
                            
        $text .= '</switch></body></smil>';
        
        
        $file = fopen($smilFile, 'w+') or die('Unable to open file');
        fwrite($file, $text);
        fclose($file);

        return true;
    }

    return false;
}
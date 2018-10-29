<?php

$siteName = 'comroads';
$paths['input'] = '/home/'.$siteName.'/';
$paths['smil_base_path'] = '/home/encoded/videos/';

$videos = array_diff(scandir($paths['input']), ['..', '.']);
$totalUpdated = 0;

foreach ($videos as $key => $video) {
    $filename = pathinfo($video, PATHINFO_FILENAME);
    $subDir = sub_dir($filename);
    $path = $paths['smil_base_path'] . $subDir;
    $smil = $path . $filename . '.smil';
    $url = 'http://296155671.r.cdnsun.net/videos/' . $subDir;

    if (create_smil_file($smil, $filename . '.mp4', $path, $url)) {
        echo 'Updated: ' . $smil . "\r\n";
        $totalUpdated++;
    }

}

echo 'Total Updated: ' . $totalUpdated . "\r\n";

function sub_dir($filename)
{
    $dir = null;

    for ($i=0; $i < 5; $i++) { 
        $dir .= substr($filename, $i, 1) . '/';
    }

    return $dir;
}

function create_smil_file($smilFile, $filename, $videoPath, $url)
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
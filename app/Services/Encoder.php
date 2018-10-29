<?php

namespace App\Services;

use App\Content;
use Carbon\Carbon;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;

abstract class Encoder
{
    protected $video;
    protected $getID3;
    protected $videoTempPath;
    protected $videoFinalPath;
    protected $filename;
    protected $originalFilename;
    protected $videoNewFilename;
    protected $videoThumbPath;
    protected $thumbWidth;
    protected $thumbHeight;
    protected $watermarksPath;
    protected $ffmpegPath;
    protected $subdir;
    protected $originalVideo;
    protected $videoInfo = [];    

    public function __construct(Content $video)
    {
        $this->video = $video;
        $this->originalFilename = $video->original_filename;
        $this->filename = pathinfo($this->originalFilename, PATHINFO_FILENAME);
        $this->videoNewFilename = $this->filename . '.mp4';
        $this->subdir = sub_dir($this->filename);
        $this->getID3 = new \getID3;
        $this->videoThumbPath = public_path(config('app.video_thumb_path') . $this->subdir . $this->originalFilename . '/');
        $this->videoRemoteThumbPath = config('app.video_remote_thumb_path') . $this->subdir . $this->originalFilename . '/';
        $this->videoTempPath = public_path(config('app.video_upload_path'));
        $this->videoFinalPath = public_path(config('app.video_path') . $this->subdir);
        $this->videoRemotePath =  config('app.video_remote_path') . $this->subdir;
        $this->videoInfo = $this->getID3->analyze($this->videoTempPath . $this->originalFilename);
        $this->watermarksPath = public_path(config('app.watermarks_path'));
        $this->ffmpegPath = config('app.ffmpeg_path');
        //$this->ffmpegPath = '';
        
        $this->thumbWidth = config('app.thumb_width');
        $this->thumbHeight = config('app.thumb_height');

        $this->originalVideo = $this->videoTempPath . $this->originalFilename;        

        //make_dir($this->videoFinalPath);
        //make_dir($this->videoThumbPath);
    }

    public function videoInfo()
    {
        return $this->videoInfo;
    }

    public function videoWidth()
    {
        if (isset($this->videoInfo['video']['resolution_x'])) {
            return $this->videoInfo['video']['resolution_x'];
        }

        return 720;
    }

    public function videoHeight()
    {
        if (isset($this->videoInfo['video']['resolution_y'])) {
            return $this->videoInfo['video']['resolution_y'];
        }

        return 480;
    }

    public function watermark($path)
    {
        $videoHeight = $this->videoHeight();

        if ($videoHeight >= 1080) {
            return $path . '110.png';
        }

        if ($videoHeight >= 720 && $videoHeight < 1080) {
            return $path . '90.png';
        }

        return $path . '60.png';
    }

    public function calculateVideoThumbSize()
    {
        $ratio = $this->videoWidth() / $this->videoHeight();

        if ($ratio < 1) {
            $this->thumbWidth = floor($this->thumbHeight * $ratio);
        } else {
            $this->thumbHeight = floor($this->thumbWidth / $ratio);
        }        
    }

    public function videoLength()
    {
        return (int) round($this->videoInfo['playtime_seconds']);
    }
    
    public function createThumbnail()
    {
        $ffmpegFile = $this->videoFinalPath . "/". $this->videoNewFilename;
        $gstreamerFile = $this->videoFinalPath . "/480p_".$this->videoNewFilename; 

        if (! file_exists($ffmpegFile) && ! file_exists($gstreamerFile)) {
            Log::info('Video not available yet');
            Log::info('ffmpeg: '.$ffmpegFile);
            Log::info('gstreamer: '.$gstreamerFile);
            return false;
        }

        $this->calculateVideoThumbSize();

        $target_image = $this->videoThumbPath . '/' . $this->originalFilename . '-0.jpg';
        $command = "ffmpeg -ss 1 -y -i \"".$this->videoTempPath . $this->originalFilename."\" -vcodec mjpeg -vframes 1 -an -f rawvideo -s ".$this->thumbWidth."x".$this->thumbHeight." \"$target_image\"";        

        shell_exec($command);

        if(file_exists("/usr/local/bin/mogrify")) {
            shell_exec("/usr/local/bin/mogrify " . config('app.imagick_command') . $target_image); 
        } else {
            shell_exec("/usr/bin/mogrify " . config('app.imagick_command') . $target_image); 
        }

        $watermark = public_path('images/watermarks/60.png');

        shell_exec("composite -gravity northwest -geometry +10+10 -dissolve 100% " . $watermark . " " . $target_image . " ".$target_image);

        Log::info($command);

        return true;
    }

    public function createSmilFile()
    {
        foreach (config('app.encoded_videos') as $key => $video) { 
            if ($this->countryNotExempted($video['exempted_countries'])) {           
                $videoPath = public_path($video['path'] . $this->subdir);
                $smilFile = $videoPath . $this->filename . '.smil';
                
                $resolutions = [
                    '480p_'.$this->videoNewFilename => [
                        'bitrate' => 2000000,
                        'height' => 480,
                        'width' => 854
                    ],
                    '720p_'.$this->videoNewFilename => [
                        'bitrate' => 3500000,
                        'height' => 720,
                        'width' => 1280
                    ],
                    '1080p_'.$this->videoNewFilename => [
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
            }
        }
    }

    public function updateVideoInfo()
    {
        $this->video->length = ceil($this->videoInfo['playtime_seconds']);
        $this->video->movie_width = $this->videoWidth();
        $this->video->movie_height = $this->videoHeight();
        $this->video->encoded_date = Carbon::now();
        $this->video->save();
    }

    public function processIsRunning($pid)
    {
        exec("ps $pid", $processState);

        return count($processState) >= 2;
    }

    public function transferFiles()
    {        
        $client = s3Client();

        s3Sync($client, $this->videoTempPath, config('app.video_remote_temp_path'));

        foreach (config('app.encoded_videos') as $key => $video) {
            if ($this->countryNotExempted($video['exempted_countries'])) {    
                $videoPath = public_path($video['path'] . $this->subdir);
                $thumbPath = public_path($video['thumb_path'] . $this->subdir . $this->originalFilename . '/');
                $remotePath = $video['remote_path'] . $this->subdir;
                $remoteThumbPath = $video['remote_thumb_path'] . $this->subdir . $this->originalFilename . '/';
                
                s3Sync($client, $videoPath, $remotePath);
                s3Sync($client, $thumbPath, $remoteThumbPath);                        
            }                      
        }

    }

    public function transferFilesOld()
    {
        $ip = config('app.storage_server_ip');
        $password = config('app.storage_server_password');       

        $transferOriginalFileCommand = "rsync -ratlz --rsh=\"/usr/bin/sshpass -p ".config('app.storage_server_password')." ssh -o StrictHostKeyChecking=no -l root\" ".$this->videoTempPath." ". $ip . ':' . config('app.video_remote_temp_path') . " >/dev/null 2>&1";
        shell_exec($transferOriginalFileCommand);

        foreach (config('app.encoded_videos') as $key => $video) {
            if ($this->countryNotExempted($video['exempted_countries'])) {    
                $videoPath = public_path($video['path'] . $this->subdir);
                $thumbPath = public_path($video['thumb_path'] . $this->subdir . $this->originalFilename . '/');
                $remotePath = $video['remote_path'] . $this->subdir;
                $remoteThumbPath = $video['remote_thumb_path'] . $this->subdir . $this->originalFilename . '/';

                $transferVideoCommand = "rsync -ratlz --rsh=\"/usr/bin/sshpass -p ".$password." ssh -o StrictHostKeyChecking=no -l root\" ".$videoPath." ". $ip . ':' . $remotePath . " >/dev/null 2>&1";
                $transferThumbnailCommand = "rsync -ratlz --rsh=\"/usr/bin/sshpass -p ".$password." ssh -o StrictHostKeyChecking=no -l root\" ".$thumbPath." ". $ip . ':' . $remoteThumbPath . " >/dev/null 2>&1";
                $makeRemoteVideoDirectoryCommand = "sshpass -p ".$password." ssh root@".$ip." mkdir -p " . $remotePath . " >/dev/null 2>&1";
                $makeRemoteThumbnailDirectoryCommand = "sshpass -p ".$password." ssh root@".$ip." mkdir -p " . $remoteThumbPath . " >/dev/null 2>&1";

                shell_exec($makeRemoteVideoDirectoryCommand);
                shell_exec($makeRemoteThumbnailDirectoryCommand);
                shell_exec($transferVideoCommand);
                shell_exec($transferThumbnailCommand);
            }                      
        }

    }

    public function countryNotExempted(array $countries)
    {
        return ! in_array($this->video->country_code, $countries);
    }

    abstract function encode();
}
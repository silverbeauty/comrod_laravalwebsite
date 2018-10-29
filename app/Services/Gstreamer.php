<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Gstreamer extends Encoder
{
    public function encode()
    {
        $command = "prepare " . $this->watermarksPath . " " . $this->videoTempPath . $this->originalFilename . " ". $this->videoFinalPath ." ". remove_extension($this->originalFilename) . " >/dev/null 2>&1 &";

        shell_exec($command);

        Log::info($command);
        
    }
}
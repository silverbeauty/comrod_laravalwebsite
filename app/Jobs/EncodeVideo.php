<?php

namespace App\Jobs;

use App\Content;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class EncodeVideo extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $video;
    protected $encoder;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Content $video, $encoder = null)
    {
        $this->video = $video;
        $this->encoder = $encoder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // if (!is_null($this->video->encoded_date)) {
        //     $this->release(10);
        // } else {
            $this->video->encode($this->encoder);
        //}
    }

    public function getVideo()
    {
        return $this->video;
    }
}

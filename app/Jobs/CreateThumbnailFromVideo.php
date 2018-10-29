<?php

namespace App\Jobs;

use App\Content;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateThumbnailFromVideo extends Job implements SelfHandling
{
    protected $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Content $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->video->createThumbnail();
    }
}

<?php

namespace App\Jobs;

use App\Content;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class TinifyExternalImage extends Job implements SelfHandling
{
    protected $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->content->tinifyExternalImage();
    }
}

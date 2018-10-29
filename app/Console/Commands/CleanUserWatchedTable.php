<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\UserWatched;
use Illuminate\Console\Command;

class CleanUserWatchedTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:user_watched_table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean user_watched table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $aWeekAgo = Carbon::now()->subWeek()->toDateTimeString();

        UserWatched::where('created_at', '<', $aWeekAgo)->delete();
    }
}

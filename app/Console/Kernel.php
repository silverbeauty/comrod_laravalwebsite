<?php

namespace App\Console;

use App\Console\Commands\EncodeVideo;
use App\Console\Commands\SeparateVideo;
use App\Console\Commands\UpdateSmilFile;
use App\Console\Commands\DeleteOldVideos;
use App\Console\Commands\YoutubeDuration;
use App\Console\Commands\CompressThumbnail;
use App\Console\Commands\DeleteSyncedFiles;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CheckInactiveVidme;
use App\Console\Commands\GenerateVideoCache;
use App\Console\Commands\LiveFeedCreateJson;
use App\Console\Commands\DownloadLiveFeedXml;
use App\Console\Commands\CheckInactiveYouTube;
use App\Console\Commands\CleanUserWatchedTable;
use App\Console\Commands\GenerateMapContentJson;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'compress:thumbnail' => CompressThumbnail::class,
        'youtube:check' => CheckInactiveYouTube::class,
        'vidme:check' => CheckInactiveVidme::class,
        'video:encode' => EncodeVideo::class,
        'smil:update' => UpdateSmilFile::class,
        'video:delete-old' => DeleteOldVideos::class,
        'delete:synced' => DeleteSyncedFiles::class,
        'clean:user_watched_table' => CleanUserWatchedTable::class,
        'mapcontentjson:generate' => GenerateMapContentJson::class,
        'videocache:generate' => GenerateVideoCache::class,
        'video:separate' => SeparateVideo::class,
        'livefeed:createjson' => LiveFeedCreateJson::class,
        'download:livefeedxml' => DownloadLiveFeedXml::class,
        'youtube:duration' => YoutubeDuration::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('youtube:check')
        ->daily()
        ->withoutOverlapping();

        $schedule->command('youtube:duration')
                 ->everyMinute()
                 ->withoutOverlapping();

        $schedule->command('vidme:check')
        ->daily()
        ->withoutOverlapping();

        $schedule->command('delete:synced')
        ->daily()
        ->withoutOverlapping();

        $schedule->command('clean:user_watched_table')
        ->weekly()
        ->withoutOverlapping();

        // $schedule->command('mapcontentjson:generate www')
        // ->everyTenMinutes()
        // ->withoutOverlapping();

        // $schedule->command('mapcontentjson:generate en')
        // ->everyTenMinutes()
        // ->withoutOverlapping();

        // $schedule->command('mapcontentjson:generate il')
        // ->everyTenMinutes()
        // ->withoutOverlapping();

        // $schedule->command('mapcontentjson:generate ar')
        // ->everyTenMinutes()
        // ->withoutOverlapping();

        // $schedule->command('mapcontentjson:generate ro')
        // ->everyTenMinutes()
        // ->withoutOverlapping();

        // $schedule->command('mapcontentjson:generate ru')
        // ->everyTenMinutes()
        // ->withoutOverlapping();

        $schedule->command('videocache:generate')
        ->everyTenMinutes()
        ->withoutOverlapping();

        // $schedule->command('download:livefeedxml')
        // ->everyMinute()
        // ->withoutOverlapping();

        // $schedule->command('livefeed:createjson en')
        // ->everyMinute()
        // ->withoutOverlapping();

        // $schedule->command('livefeed:createjson il')
        // ->everyMinute()
        // ->withoutOverlapping();

        // $schedule->command('livefeed:createjson ar')
        // ->everyMinute()
        // ->withoutOverlapping();

        // $schedule->command('livefeed:createjson ro')
        // ->everyMinute()
        // ->withoutOverlapping();

        // $schedule->command('livefeed:createjson ru')
        // ->everyMinute()
        // ->withoutOverlapping();

        // $schedule->command('livefeed:createjson www')
        // ->everyMinute()
        // ->withoutOverlapping();
    }
}
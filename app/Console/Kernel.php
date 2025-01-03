<?php

namespace App\Console;

use App\Console\Commands\LoadAdvEvents;
use App\Console\Commands\LoadMoersEvents;
use App\Console\Commands\SendEmailUserHasUnreadConversations;
use App\Console\Commands\UpdateResources;
use App\Console\Commands\UpdateRubbishScheduleItems;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmailUserHasUnreadConversations::class,
        LoadMoersEvents::class,
        UpdateResources::class,
        UpdateRubbishScheduleItems::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // Load events from the moers site every four hours
        $schedule
            ->command('events:load-moers-events')
            ->cron('0 */4 * * *');
            
        $schedule
            ->command('radio-broadcasts:load')
            ->cron('0 */4 * * *');

        $schedule
            ->command('parking-area:update')
            ->everyMinute();

//        $schedule
//            ->command('resources:update')
//            ->everyMinute();

//        $schedule->command('emails:send-unread')
//                 ->cron('0 */4 * * *');

        $schedule
            ->command('telescope:prune')
            ->daily();

        $schedule
            ->command('personal-data-export:clean')
            ->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use App\Console\Commands\CreateDailyQuestionLogger;
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
        // Commands\DailyQuestionCron::class,
        Commands\DemoCron::class,
        // Commands\DailyActivityCron::class,
        Commands\CreateDailyActivityLogger::class,
        Commands\CreateDailyQuestionLogger::class,




    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->everyMinute();
        // $schedule->command('dailyQuestion:cron')->everyMinute();
        // $schedule->command('dailyActivity:cron')->everyTwoMinutes();

        // $schedule->command('demo:cropn')->everyTwoMinutes();
        $schedule->command('CreateDailyActivityLogger:cron')->everyMinute();
        $schedule->command('CreateDailyQuestionLogger:cron')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

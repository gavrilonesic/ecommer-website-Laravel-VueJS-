<?php

namespace App\Console;

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
        //
        Commands\CategoryImport::class,
        Commands\ProductImport::class,
        Commands\SendEmails::class,
        Commands\GenerateSitemap::class,
        Commands\GenerateFeed::class,
        Commands\SendResetEmailToBigUsers::class,
        Commands\GenerateAllSitemap::class,
        Commands\DeleteFailOrder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:run --only-db')->dailyAt('00:10');
        $schedule->command('backup:clean')->dailyAt('00:00');
        
        $schedule->command('categories:import')->everyMinute()->withoutOverlapping();
        $schedule->command('products:import')->everyMinute()->withoutOverlapping();
        $schedule->command('emails:send')->everyMinute()->withoutOverlapping();
        $schedule->command('sitemap:generate')->daily();
        // $schedule->command('order:fail')->daily()->withoutOverlapping();
        // $schedule->command('emails:sendreset')->everyFiveMinutes()->withoutOverlapping();
        // $schedule->command('fme:feed')
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // $this->load(__DIR__.'/Commands');

        // require base_path('routes/console.php');
    }
}

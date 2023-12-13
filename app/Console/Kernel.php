<?php

namespace App\Console;

use App\Models\Grafikinternet;
use App\Models\Mointernet;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('App\Http\Controllers\SchedulerController@runMointernetScheduler')->everyMinute();
        $schedule->command('app:whatsapp-acserver')->everyMinute();
        $schedule->command('app:whatsapp-cctv')->everyMinute();
        $schedule->command('app:whatsapp-csdatabase')->everyMinute();
        $schedule->command('app:whatsapp-fujixerox')->everyMinute();
        $schedule->command('app:whatsapp-gacsirt')->everyMinute();
        $schedule->command('app:whatsapp-sanswitch')->everyMinute();
        $schedule->command('app:whatsapp-physical')->everyMinute();
        $schedule->command('app:whatsapp-tapedrive')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    // protected $commands = [
    //     \App\Console\Commands\SendWhatsAppMessage::class,
    // ];

}

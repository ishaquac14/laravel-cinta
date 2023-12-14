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
        $schedule->call('App\Http\Controllers\SchedulerController@runMointernetScheduler')->daily();
        $schedule->command('app:whatsapp-acserver')->dailyAt('08:00');
        $schedule->command('app:whatsapp-cctv')->dailyAt('08:00');
        $schedule->command('app:whatsapp-csdatabase')->dailyAt('08:00');
        $schedule->command('app:whatsapp-fujixerox')->dailyAt('08:00');
        $schedule->command('app:whatsapp-gacsirt')->dailyAt('08:00');
        $schedule->command('app:whatsapp-sanswitch')->dailyAt('08:00');
        $schedule->command('app:whatsapp-physical')->dailyAt('08:00');
        $schedule->command('app:whatsapp-tapedrive')->dailyAt('08:00');
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

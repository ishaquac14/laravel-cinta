<?php

namespace App\Console;

use App\Models\Grafikinternet;
use App\Models\Mointernet;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        $schedule->call('App\Http\Controllers\SchedulerController@runMointernetScheduler')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-acserver')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-cctv')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-csdatabase')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-fujixerox')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-gacsirt')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-sanswitch')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-physical')
            ->weekdays()
            ->at('08:00');

        $schedule->command('app:whatsapp-tapedrive')
            ->weekdays()
            ->at('08:00');
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}

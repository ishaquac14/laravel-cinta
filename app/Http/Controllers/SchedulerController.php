<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MointernetController;
use Illuminate\Support\Facades\Artisan;

class SchedulerController extends Controller
{
    public function runMointernetScheduler()
    {
        app(MointernetController::class)->grafik_internet();
    }

    public function runScheduler()
    {
        Artisan::call('schedule:run');
        return response()->json(['message' => 'Scheduler run successfully']);
    }
}


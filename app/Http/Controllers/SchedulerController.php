<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MointernetController;

class SchedulerController extends Controller
{
    public function runMointernetScheduler()
    {
        // Panggil method grafik_internet dari MointernetController
        app(MointernetController::class)->grafik_internet();
    }
}


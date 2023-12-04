<?php

namespace App\Console\Commands;

use App\Models\Grafikinternet;
use App\Models\Mointernet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GrafikInternetCommand extends Command
{
    protected $signature = 'grafik_internet';
    protected $description = 'Access a specific URL';

    public function handle()
    {
        $response = Http::get('http://127.0.0.1:8000/mointernet/persen_grafik_monitoring_internet');

        // Lakukan apa pun dengan respons jika diperlukan
        // Misalnya, log respons atau melakukan tindakan tertentu berdasarkan respons
        $this->info('URL accessed successfully.');
    }
}


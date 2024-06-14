<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MointernetController;
use Illuminate\Support\Facades\Artisan;
use App\Models\Acserver;
use App\Models\Cctv;
use App\Models\Csdatabase;
use App\Models\CServerElectric;
use App\Models\Fujixerox;
use App\Models\Gacsirt;
use App\Models\Grafikinternet;
use App\Models\Mointernet;
use App\Models\Physical;
use App\Models\Sanswitch;
use Carbon\Carbon;

class SchedulerController extends Controller
{
    public function runMointernetScheduler()
    {
        app(MointernetController::class)->grafik_internet();
    }

    public function runScheduler()
    {
        $now = Carbon::now();
        // $day = $now->day;
        // dd($formattedDate);
        $yesterday = $now->subDay();
        $formattedDate = $yesterday->locale('id')->translatedFormat('d F Y');
        $yesterday = Carbon::yesterday()->toDateString();

        $yesterday_acservers = Acserver::whereDate('created_at', $yesterday)->count();
        $yesterday_cctvs = Cctv::whereDate('created_at', $yesterday)->count();
        $yesterday_csdatabases = Csdatabase::whereDate('created_at', $yesterday)->count();
        $yesterday_cserverelectrics = CServerElectric::whereDate('created_at', $yesterday)->count();
        $yesterday_fujixeroxs = Fujixerox::whereDate('created_at', $yesterday)->count();
        $yesterday_gacsirts = Gacsirt::whereDate('created_at', $yesterday)->count();
        $yesterday_physicals = Physical::whereDate('created_at', $yesterday)->count();
        $yesterday_sanswitchs = Sanswitch::whereDate('created_at', $yesterday)->count();
        $yesterday_tapedrives = Sanswitch::whereDate('created_at', $yesterday)->count();
        // dd($yesterday_cctvs);

        $messages = [];

        if ($yesterday_acservers == 0) {
            $messages[] = "Checksheet AC SERVER tidak diisi!";
        }

        if ($yesterday_cctvs == 0) {
            $messages[] = "Checksheet CCTV tidak diisi!";
        }

        if ($yesterday_csdatabases == 0) {
            $messages[] = "Checksheet Database tidak diisi!";
        }

        if ($yesterday_cserverelectrics == 0) {
            $messages[] = "Checksheet Server Electric tidak diisi!";
        }

        if ($yesterday_fujixeroxs == 0) {
            $messages[] = "Checksheet Printer Fujixerox tidak diisi!";
        }

        if ($yesterday_gacsirts == 0) {
            $messages[] = "Checksheet GA-CSIRT tidak diisi!";
        }

        if ($yesterday_physicals == 0) {
            $messages[] = "Checksheet Physical tidak diisi!";
        }

        if ($yesterday_sanswitchs == 0) {
            $messages[] = "Checksheet Sanswitch tidak diisi!";
        }

        if ($yesterday_tapedrives == 0) {
            $messages[] = "Checksheet Tape Drive tidak diisi!";
        }

        if (!empty($messages)) {
            $nomors = ['081223506433', '082260050066', '085282716716', '082111707754', '082125008160'];
            $isi = "WARNING !!!\nTanggal : ". $formattedDate . "\n\n" . implode("\n", $messages);

            foreach ($nomors as $nomor) {
                $token = "v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1";
                $message = sprintf("------------CINTA------------%c$isi%c-------------------------------- ", 10, 10);

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $nomor . '&message=' . $message,
                ));
                $response = curl_exec($curl);
                curl_close($curl);
            }
        }
    }

    public function Alertapproval()
    {
        
    }
}

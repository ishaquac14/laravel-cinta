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
use App\Models\Tapedrive;
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
        $yesterday_tapedrives = Tapedrive::whereDate('created_at', $yesterday)->count();
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
            $isi = "WARNING !!!\nTanggal : " . $formattedDate . "\n\n" . implode("\n", $messages);

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
        $now = Carbon::now();
        $lastMonth = $now->subMonth();
        $formattedDate = $lastMonth->locale('id')->translatedFormat('F Y');

        // Mengambil jumlah data yang belum di-approve untuk bulan lalu
        $unapprovedAcservers = Acserver::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedCctvs = Cctv::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedCsdatabases = Csdatabase::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedCserverelectrics = CServerElectric::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedFujixeroxs = Fujixerox::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedGacsirts = Gacsirt::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedPhysicals = Physical::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedSanswitchs = Sanswitch::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedTapedrives = Tapedrive::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedMointernet = Mointernet::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $messages = [];

        $checksheets = [
            'AC Server' => $unapprovedAcservers,
            'CCTV' => $unapprovedCctvs,
            'Database' => $unapprovedCsdatabases,
            'Server Electric' => $unapprovedCserverelectrics,
            'Printer Fujixerox' => $unapprovedFujixeroxs,
            'GA-CSIRT' => $unapprovedGacsirts,
            'Physical Server' => $unapprovedPhysicals,
            'Sanswitch' => $unapprovedSanswitchs,
            'Tape Drive' => $unapprovedTapedrives,
            'Internet' => $unapprovedMointernet
        ];

        $messages = [];
        $i = 1;  // Start counting from 1 for numbering

        foreach ($checksheets as $name => $count) {
            if ($count > 0) {
                $messages[] = "{$i}. Checksheet {$name}";
                $i++;  // Increment the counter for each item
            }
        }

        if (!empty($messages)) {
            $nomors = ['081223506433'];
            $isi = "REMINDER !!!\n\nDear pak Ferry,\nMohon untuk segera approve form checksheet bulan " . $formattedDate . ".\nGuna memastikan form checksheet selalu dilakukan pengecekan\nsesuai dengan standard.\n" . "\nBerikut form yang belum diapprove :\n" . implode("\n", $messages) . "\n\nTerimakasih.";

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

    public function Alertapproval_ldr()
    {
        $now = Carbon::now();
        $lastMonth = $now->subMonth();
        $formattedDate = $lastMonth->locale('id')->translatedFormat('F Y');

        $unapprovedAcservers = Acserver::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedCctvs = Cctv::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedCsdatabases = Csdatabase::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedCserverelectrics = CServerElectric::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedFujixeroxs = Fujixerox::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedGacsirts = Gacsirt::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedPhysicals = Physical::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedSanswitchs = Sanswitch::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedTapedrives = Tapedrive::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $unapprovedMointernet = Mointernet::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('is_approved', 0)
            ->count();

        $messages = [];

        $checksheets = [
            'AC Server' => $unapprovedAcservers,
            'CCTV' => $unapprovedCctvs,
            'Database' => $unapprovedCsdatabases,
            'Server Electric' => $unapprovedCserverelectrics,
            'Printer Fujixerox' => $unapprovedFujixeroxs,
            'GA-CSIRT' => $unapprovedGacsirts,
            'Physical Server' => $unapprovedPhysicals,
            'Sanswitch' => $unapprovedSanswitchs,
            'Tape Drive' => $unapprovedTapedrives,
            'Internet' => $unapprovedMointernet
        ];

        $messages = [];
        $i = 1;  

        foreach ($checksheets as $name => $count) {
            if ($count > 0) {
                $messages[] = "{$i}. Checksheet {$name}";
                $i++; 
            }
        }

        if (!empty($messages)) {
            $nomors = ['081223506433'];
            $isi = "REMINDER !!!\n\nDear pak Alliq,\nTest " . $formattedDate . ".\nGuna memastikan form checksheet selalu dilakukan pengecekan\nsesuai dengan standard.\n" . "\nBerikut form yang belum diapprove :\n" . implode("\n", $messages) . "\n\nTerimakasih.";

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
}

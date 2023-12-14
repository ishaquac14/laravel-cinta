<?php

namespace App\Console\Commands;

use App\Policies\GacsirtPolicy;
use Illuminate\Console\Command;
use App\Models\Gacsirt;

class WhatsappGacsirt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:whatsapp-gacsirt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!Gacsirt::whereDate('created_at', today())->exists()) {
            $nomor = ['081223506433']; 
            $isi = "WARNING !!!\n\n"; 
            $isi .= "Hari ini Checksheet GA CSIRT tidak diisi !";

            $token = "v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1";
            $message = sprintf("-------------------------%c$isi%c------------------------- ", 10, 10);

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
                CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $nomor[0] . '&message=' . $message,
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }
    }
}

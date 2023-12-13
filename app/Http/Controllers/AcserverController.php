<?php

namespace App\Http\Controllers;

use App\Models\Acserver;
use App\Models\Mointernet;
use App\Models\Grafikinternet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class AcserverController extends Controller
{
    /**
     * Display a listierror of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Acserver::orderBy('id', 'DESC');

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $acservers = $query->paginate(5);

        // Mengirimkan data ke tampilan
        return view('pages.acserver.index', compact('acservers'));
    }


    /**
     * Show the form for creatierror a new resource.
     */
    public function create()
    {
        return view('pages.acserver.create');
    }

    public function store(Request $request)
    {
        // Validasi form input
        $request->validate([
            'kondisi_ac-01' => 'string|required',
            'kondisi_ac-02' => 'string|required',
            'kondisi_ac-03' => 'string|required',
            'kondisi_ac-04' => 'string|required',
            'ac-01_suhu' => 'string|nullable',
            'ac-02_suhu' => 'string|nullable',
            'ac-03_suhu' => 'string|nullable',
            'ac-04_suhu' => 'string|nullable',
            'suhu_ruangan' => 'string|required',
            'note' => 'string|nullable',
            'follow_up' => 'string|nullable',
            'status' => 'required'
        ]);


        // Mendapatkan data dari permintaan
        $data = $request->only([
            'kondisi_ac-01', 'kondisi_ac-02', 'kondisi_ac-03', 'kondisi_ac-04',
            'ac-01_suhu', 'ac-02_suhu', 'ac-03_suhu', 'ac-04_suhu', 'suhu_ruangan', 'note', 'follow_up', 'status'
        ]);
        // Menyimpan data ke dalam acserver
        // dd($data);auth()->user()->name
        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Acserver::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('acserver.index')->with('success', 'Data berhasil disimpan');
    }

    private function calculateDuration($startTime, $endTime)
    {
        if ($startTime && $endTime) {
            $start = Carbon::parse($startTime);
            $end = Carbon::parse($endTime);

            return $end->diffInMinutes($start);
        }

        return 0;
    }

    private function updatePercentage()
    {
        $startDate = Carbon::now()->subMonth(); // Ambil tanggal satu bulan yang lalu dari sekarang
        $totalEntries = Mointernet::where('created_at', '>=', $startDate)->count();
        $percentage = ($totalEntries > 0) ? $totalEntries / max(1, Mointernet::count()) * 100 : 0;

        // Perbarui kolom persentase pada data yang baru saja dibuat
        Mointernet::latest()->first()->update(['percentage' => $percentage]);
    }

    public function getChartData()
    {
        $startDate = now()->subMonth();
        $data = Mointernet::where('created_at', '>=', $startDate)->get();

        $labels = $data->pluck('created_at')->map(function ($date) {
            return Carbon::parse($date)->format('M Y');
        });

        $percentages = $data->pluck('percentage');

        return response()->json(['labels' => $labels, 'percentages' => $percentages]);
    }

    public function grafik_internet()
    {
        $now = Carbon::now()->format("Y-m-d");

        $mointernets = Mointernet::where('date', $now)->get();
        // dd($mointernets);
        if (count($mointernets) > 0) {
            $total_durasi = 0;
            foreach ($mointernets as $mo) {
                $total_durasi = $total_durasi + $mo->duration;
            }
            $persen = $total_durasi / (24 * 60) * 100;
            $persen = 100 - $persen;
            $grafikinternets = Grafikinternet::create([
                'date' => $now,
                'persen' => $persen,
            ]);
        } else {
            $grafikinternets = Grafikinternet::create([
                'date' => $now,
                'persen' => "100",
            ]);
        };
    }

    public function show($id)
    {
        $acserver = Acserver::findOrFail($id);
        return view('pages.acserver.show', compact('acserver'));
    }

    public function edit($id)
    {
        $acserver = AcServer::findOrFail($id);

        return view('pages.acserver.edit', compact('acserver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $acserver = Acserver::findOrFail($id);

        $request->validate([
            'kondisi_ac-01' => 'string|required',
            'kondisi_ac-02' => 'string|required',
            'kondisi_ac-03' => 'string|required',
            'kondisi_ac-04' => 'string|required',
            'ac-01_suhu' => 'string|nullable',
            'ac-02_suhu' => 'string|nullable',
            'ac-03_suhu' => 'string|nullable',
            'ac-04_suhu' => 'string|nullable',
            'suhu_ruangan' => 'string|required',
            'note' => 'string|nullable',
            'follow_up' => 'string|nullable',
            'status' => 'required|in:ok,warning,not good',
        ]);

        // Ambil data dari formulir yang diubah oleh pengguna
        $data = $request->only([
            'kondisi_ac-01', 'kondisi_ac-02', 'kondisi_ac-03', 'kondisi_ac-04',
            'ac-01_suhu', 'ac-02_suhu', 'ac-03_suhu', 'ac-04_suhu',
            'suhu_ruangan', 'note', 'follow_up', 'status'
        ]);

        // Update atribut model berdasarkan input formulir
        $acserver->update($data);

        return redirect()->route('acserver.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $acserver = Acserver::findOrFail($id);
        $acserver->delete();

        return redirect()->route('acserver.index')->with('success', 'Data berhasil dihapus');
    }

    // public function test(Request $request)
    // {
    //     $nomorUser = $request->nomor_user;

    //     $result = Acserver::create([
    //         'nomor_user' => $nomorUser,
    //     ]);

    //     if ($result) {
    //         $nomor = ['081223506433', $nomorUser];
    //         $isi = 'Tidk isi';

    //         $token = "v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1";
    //         $message = sprintf("-------------------------%c$isi%c------------------------- ", 10, 10);
    //         $curl = curl_init();
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $nomor[0] . '&message=' . $message,
    //         ));
    //         $response = curl_exec($curl);
    //         curl_close($curl);
    //     } else {
    //     }
    // }

    // public function alert()
    // {
    //     Artisan::call('whatsapp:acserver');
    // }
}

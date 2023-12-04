<?php

namespace App\Http\Controllers;

use App\Models\Mointernet;
use App\Models\Grafikinternet;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MointernetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Mointernet::orderBy('id', 'DESC');

        $currentDate = now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;
        $daysInMonth = $currentDate->daysInMonth;

        // Mengambil data dari database
        $dataFromDatabase = Grafikinternet::whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get();

        // Membuat array data dengan nilai null untuk setiap tanggal
        $data = array_fill(0, $daysInMonth, null);

        // Mengisi data dengan nilai persen dari database
        foreach ($dataFromDatabase as $item) {
            $day = (int)Carbon::parse($item->date)->format('d') - 1; // -1 karena index array dimulai dari 0
            $data[$day] = (float)$item->persen;
        }

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('note', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Menggunakan paginate(5) untuk mendapatkan data paginasi
        $mointernets = $query->paginate(5);

        // Menghitung total durasi dalam sebulan
        $totalDuration = $mointernets->sum('duration');
        // Menghitung rata-rata persentase
        $averagePercentage = ($mointernets->count() > 0) ? $mointernets->avg('percentage') : 0;
        // Mengirimkan data ke tampilan
        return view('pages.mointernet.index', compact('mointernets', 'averagePercentage', 'totalDuration', 'data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.mointernet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'root_cause' => 'nullable',
        ]);

        $data = $request->only(['date', 'start_time', 'end_time', 'root_cause']);
        $data['author'] = auth()->user()->name;
        $data['user_id'] = auth()->user()->id;

        // Hitung durasi dalam menit
        $data['duration'] = $this->calculateDuration($request->input('start_time'), $request->input('end_time'));

        // Simpan data menggunakan metode create
        Mointernet::create($data);

        // Hitung persentase dan simpan pada data yang baru saja dibuat
        $this->updatePercentage();

        return redirect()->route('mointernet.index')->with('success', 'Data berhasil disimpan');
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


    public function show($id)
    {
        $mointernet = Mointernet::findOrFail($id);
        return view('pages.mointernet.show', compact('mointernet'));
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

            $grafikinternets = Grafikinternet::create([
                'date' => $now,
                'persen' => $persen,
            ]);
        } else {
            $grafikinternets = Grafikinternet::create([
                'date' => $now,
                'persen' => "100%",
            ]);
        };
    }
}

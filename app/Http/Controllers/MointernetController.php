<?php

namespace App\Http\Controllers;

use App\Models\Mointernet;
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
        return view('pages.mointernet.index', compact('mointernets', 'averagePercentage', 'totalDuration'));
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
    $totalEntries = Mointernet::count();
    $percentage = ($totalEntries > 0) ? ($totalEntries - 1) / $totalEntries * 100 : 100;

    // Perbarui kolom persentase pada data yang baru saja dibuat
    Mointernet::latest()->first()->update(['percentage' => $percentage]);
}



    public function show($id)
    {
        $mointernet = Mointernet::findOrFail($id);
        return view('pages.mointernet.show', compact('mointernet'));
    }

    /**
     * Display the specified resource.
     */
    // public function show(Mointernet $mointernet)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Mointernet $mointernet)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateMointernetRequest $request, Mointernet $mointernet)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Mointernet $mointernet)
    // {
    //     //
    // }
}

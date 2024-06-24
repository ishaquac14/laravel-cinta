<?php

namespace App\Http\Controllers;

use App\Models\Acserver;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AcserverController extends Controller
{
    /**
     * Display a listierror of the resource.
     */
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Acserver::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Acserver::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $acservers = $query->paginate(10);

        $acservers->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

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

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Acserver::create($data);

        return redirect()->route('acserver.index')->with('success', 'Data berhasil disimpan !');
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

        return redirect()->route('acserver.index')->with('success', 'Data berhasil diperbaharui !');
    }

    public function destroy($id)
    {
        $acserver = Acserver::findOrFail($id);
        $acserver->delete();

        return redirect()->route('acserver.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_acserver(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();
        $current_month = $now->format('m');

        $count_acservers = Acserver::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_acservers > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya !');
        };

        $acservers = Acserver::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($acservers->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove !');
        }

        foreach ($acservers as $acserver) {
            $acserver->is_approved = 1;
            $acserver->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "acservers",
        ]);

        return redirect()->back()->with('success', 'Data berhasil diapprove !');
    }


    public function log_approved(Request $request)
    {
        $request->validate([
            'selected_month' => 'string|required'
        ]);

        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $request->input('selected_month'),
        ]);

        return redirect()->back()->with('success', 'Data bulan berhasil disimpan !');
    }
}

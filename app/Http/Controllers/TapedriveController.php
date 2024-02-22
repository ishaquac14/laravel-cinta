<?php

namespace App\Http\Controllers;

use App\Models\Tapedrive;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class TapedriveController extends Controller
{
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Tapedrive::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Tapedrive::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $tapedrives = $query->paginate(10);

        $tapedrives->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

        return view('pages.tapedrive.index', compact('tapedrives'));
    }

    public function create()
    {
        return view('pages.tapedrive.create');
    }

    public function store(Request $request)
    {
        // Validasi form input
        $request->validate([
            'plan_media' => 'string|required',
            'actual_media' => 'string|required',
            'tape_id' => 'string|required',
            'status' => 'string|required',
            'note' => 'string|nullable',
            'follow_up' => 'string|nullable',
        ]);
        

        // Mendapatkan data dari permintaan
        $data = $request->only(['plan_media', 'actual_media', 'tape_id', 'status', 'note', 'follow_up']);
        // Menyimpan data ke dalam tapedrive
        // dd($data);auth()->user()->name
        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Tapedrive::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('tapedrive.index')->with('success', 'Data berhasil disimpan !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tapedrive = Tapedrive::findOrFail($id);
        return view('pages.tapedrive.show', compact('tapedrive'));
    }

    public function edit($id)
    {
        $tapedrive = Tapedrive::findOrFail($id);

        return view('pages.tapedrive.edit', compact('tapedrive'));
    }

    public function update(Request $request, $id)
    {
        $tapedrive = Tapedrive::findOrFail($id);

        $request->validate([
            'plan_media' => 'string|required',
            'actual_media' => 'string|required',
            'tape_id' => 'string|required',
            'status' => 'string|required',
            'note' => 'string|nullable',
            'follow_up' => 'string|nullable',
        ]);

        // Ambil data dari formulir yang diubah oleh pengguna
        $tapedrive->update($request->only('plan_media', 'actual_media', 'tape_id', 'status', 'note', 'follow_up'));

        return redirect()->route('tapedrive.index')->with('success', 'Data berhasil diperbaharui !');
    }

    public function destroy($id)
    {
        $tapedrive = Tapedrive::findOrFail($id);
        $tapedrive->delete();

        return redirect()->route('tapedrive.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_tapedrive(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();
        $current_month = $now->format('m');

        $count_tapedrives = Tapedrive::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_tapedrives > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya !');
        };

        $tapedrives = Tapedrive::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($tapedrives->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove !');
        }

        foreach ($tapedrives as $tapedrive) {
            $tapedrive->is_approved = 1;
            $tapedrive->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "tapedrives",
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

        return redirect()->back()->with('success', 'Data berhasil disimpan !');
    }

}

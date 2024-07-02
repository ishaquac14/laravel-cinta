<?php

namespace App\Http\Controllers;

use App\Models\Tapedrive;
use App\Models\MTapedrive;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class TapedriveController extends Controller
{
    /// MASTER ///
    public function master_list()
    {
        $m_tapedrives = MTapedrive::all();

        return view('pages.tapedrive.master_list', compact('m_tapedrives'));
    }

    public function master_create()
    {
        return view('pages.tapedrive.master_create');
    }

    public function master_store(Request $request)
    {
        $m_tapedrives = MTapedrive::create([
            'name' => $request->name,
            'tape_id' => $request->tape_id,
        ]);

        return redirect()->route('tapedrive.master_list')->with('success', 'Data berhasil disimpan !');
    }

    public function master_edit($uuid)
    {
        $m_tapedrive = MTapedrive::where('uuid', $uuid)->first();
        // Temukan data berdasarkan ID
        // $m_tapedrives = MTapedrive::findOrFail($uuid_m_tapedrive->id);

        // Load view untuk halaman edit dan lewatkan data item yang akan diedit
        return view('pages.tapedrive.master_edit', compact('m_tapedrive'));
    }

    public function master_update(Request $request, $uuid)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'name' => 'required',
            'tape_id' => 'required',
        ]);

        // Temukan data berdasarkan ID
        // $m_tapedrives = MTapedrive::findOrFail($id);
        $m_tapedrives = MTapedrive::where('uuid', $uuid)->first();

        // Update data
        $m_tapedrives->name = $request->name;
        $m_tapedrives->tape_id = $request->tape_id;
        $m_tapedrives->save();

        // Redirect ke halaman master_list dengan pesan sukses
        return redirect()->route('tapedrive.master_list')->with('success', 'Data berhasil diperbarui !');
    }

    public function master_delete($uuid)
    {
        $m_tapedrives = MTapedrive::where('uuid', $uuid)->first();
        $m_tapedrives->delete();

        return redirect()->route('tapedrive.master_list')->with('danger', 'Data berhasil dihapus !');
    }

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
        $m_tapedrives = MTapedrive::orderBy('name', 'ASC')->get();

        return view('pages.tapedrive.create', compact('m_tapedrives'));
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

        // Cek apakah ada data yang sudah diapprove di bulan yang dipilih
        $count_tapedrives = Tapedrive::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_tapedrives > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya!');
        }

        // Cari data yang belum diapprove di bulan yang dipilih
        $tapedrives = Tapedrive::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($tapedrives->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove!');
        }

        foreach ($tapedrives as $tapedrive) {
            $tapedrive->is_approved = 1;
            $tapedrive->approved_at = $now; // Menyimpan waktu approval
            $tapedrive->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "tapedrives",
        ]);

        return redirect()->back()->with('success', 'Data berhasil diapprove!');
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

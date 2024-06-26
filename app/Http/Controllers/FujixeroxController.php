<?php

namespace App\Http\Controllers;

use App\Models\Fujixerox;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FujixeroxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Fujixerox::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Fujixerox::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $fujixeroxs = $query->paginate(10);

        $fujixeroxs->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

        return view('pages.fujixerox.index', compact('fujixeroxs'));
    }


    public function create()
    {
        return view('pages.fujixerox.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'timedown' => 'required',
            'timeon' => 'required',
            'follow_up' => 'nullable',
            'status' => 'required',
        ]);

        $data = $request->only([
            'date', 'timedown', 'timeon', 'status', 'follow_up'
        ]);

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Fujixerox::create($data);

        return redirect()->route('fujixerox.index')->with('success', 'Data berhasil disimpan !');
    }


    public function show($id)
    {
        $fujixerox = Fujixerox::findOrFail($id);
        return view('pages.fujixerox.show', compact('fujixerox'));
    }

    public function edit($id)
    {
        $fujixerox = Fujixerox::findOrFail($id);

        return view('pages.fujixerox.edit', compact('fujixerox'));
    }

    public function update(Request $request, $id)
    {
        $fujixerox = Fujixerox::findOrFail($id);

        $request->validate([
            'date' => 'required',
            'timedown' => 'required',
            'timeon' => 'required',
            'status' => 'required',
            'follow_up' => 'nullable',
        ]);

        $fujixerox->update($request->only(
            'date',
            'timedown',
            'timeon',
            'follow_up',
            'status'
        ));

        return redirect()->route('fujixerox.index')->with('success', 'Data berhasil diperbaharui !');
    }

    public function destroy($id)
    {
        $fujixerox = Fujixerox::findOrFail($id);
        $fujixerox->delete();

        return redirect()->route('fujixerox.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_fujixerox(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();

        // Cek apakah ada data yang sudah diapprove di bulan yang dipilih
        $count_fujixeroxs = Fujixerox::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_fujixeroxs > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya!');
        }

        // Cari data yang belum diapprove di bulan yang dipilih
        $fujixeroxs = Fujixerox::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($fujixeroxs->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove!');
        }

        foreach ($fujixeroxs as $fujixerox) {
            $fujixerox->is_approved = 1;
            $fujixerox->approved_at = $now; // Menyimpan waktu approval
            $fujixerox->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "fujixeroxs",
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

        return redirect()->back()->with('success', 'Data bulan berhasil disimpan');
    }
}

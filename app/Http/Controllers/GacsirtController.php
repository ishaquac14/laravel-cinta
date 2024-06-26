<?php

namespace App\Http\Controllers;

use App\Models\Gacsirt;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class GacsirtController extends Controller
{
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Gacsirt::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Gacsirt::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $gacsirts = $query->paginate(10);

        $gacsirts->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

        return view('pages.gacsirt.index', compact('gacsirts'));
    }

    public function create()
    {
        return view('pages.gacsirt.create');
    }

    public function store(Request $request)
    {
        // Validasi form input
        $request->validate([
            'date' => 'string|nullable',
            'tincoming' => 'string|nullable',
            'incoming' => 'string|nullable',
            'tcompleted' => 'string|nullable',
            'completed' => 'string|nullable',
            'status' => 'string|required',
            'follow_up' => 'string|nullable',
        ]);

        $data = $request->only([
            'date', 'tincoming', 'incoming', 'tcompleted', 'completed', 'status', 'follow_up'
        ]);

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Gacsirt::create($data);

        return redirect()->route('gacsirt.index')->with('success', 'Data berhasil disimpan !');
    }

    public function show($id)
    {
        $gacsirt = Gacsirt::findOrFail($id);
        return view('pages.gacsirt.show', compact('gacsirt'));
    }

    public function edit($id)
    {
        $gacsirt = Gacsirt::findOrFail($id);

        return view('pages.gacsirt.edit', compact('gacsirt'));
    }
    
    public function update(Request $request, $id)
    {
        $gacsirt = Gacsirt::findOrFail($id);

        $request->validate([
            'date' => 'string|nullable',
            'tincoming' => 'string|nullable',
            'incoming' => 'string|nullable',
            'tcompleted' => 'string|nullable',
            'completed' => 'string|nullable',
            'status' => 'string|required',
            'follow_up' => 'nullable'
        ]);

        $gacsirt->update($request->only(
            'date',
            'tincoming',
            'incoming',
            'tcompleted',
            'completed',
            'status',
            'follow_up'
        ));

        return redirect()->route('gacsirt.index')->with('success', 'Data berhasil diperbaharui !');
    }

    public function destroy($id)
    {
        $gacsirt = Gacsirt::findOrFail($id);
        $gacsirt->delete();

        return redirect()->route('gacsirt.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_gacsirt(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();

        // Cek apakah ada data yang sudah diapprove di bulan yang dipilih
        $count_gacsirts = Gacsirt::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_gacsirts > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya!');
        }

        // Cari data yang belum diapprove di bulan yang dipilih
        $gacsirts = Gacsirt::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($gacsirts->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove!');
        }

        foreach ($gacsirts as $gacsirt) {
            $gacsirt->is_approved = 1;
            $gacsirt->approved_at = $now; // Menyimpan waktu approval
            $gacsirt->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "gacsirts",
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

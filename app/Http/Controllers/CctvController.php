<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\CctvMonitoring;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;

class CctvController extends Controller
{
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Cctv::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Cctv::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $cctvs = $query->paginate(10);

        $cctvs->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

        return view('pages.cctv.index', compact('cctvs'));
    }

    public function create()
    {
        $response = Http::withOptions(['verify' => false])->get('https://devita-dev.aiia.co.id/api_data_cctv');

        $cctvs = $response->json()['cctvs'];

        return view('pages.cctv.create', ['cctvs' => $cctvs]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        $cctvs = Cctv::create([
            "user_id" => auth()->id(),
            "note" => $request->note,
            "follow_up" => $request->follow_up
        ]);

        foreach ($request->input('status') as $id_cctv => $status) {
            $condition = $request->input("condition.$id_cctv");
            $lokasi_name = $request->input("lokasi_name.$id_cctv");
            $posisi_name = $request->input("posisi_name.$id_cctv");

            $cctv = new CctvMonitoring;
            $cctv->cctv_id = $cctvs->id;
            $cctv->id_cctv = $id_cctv;
            $cctv->building_name = $request->input("building_name.$id_cctv");
            $cctv->lokasi_name = $lokasi_name;
            $cctv->posisi_name = $posisi_name;
            $cctv->status = $status;
            $cctv->condition = $condition;
            $cctv->save();
        }

        // dd($request);

        return redirect()->route('cctv.index')->with('success', 'Data berhasil disimpan !');
    }


    public function show($id)
    {

        $cctv = Cctv::findOrFail($id);

        $cctv_monitoring = CctvMonitoring::where('cctv_id', $id)->orderBy('id_cctv', 'asc')->get();

        return view('pages.cctv.show', compact('cctv', 'cctv_monitoring'));
    }

    public function edit($id)
    {
        $cctv = Cctv::findOrFail($id);
        $cctv_monitoring = CctvMonitoring::where('cctv_id', $id)->orderBy('id_cctv', 'asc')->get();

        // dd($cctv, $cctv_monitoring);

        return view('pages.cctv.edit', compact('cctv', 'cctv_monitoring'));
    }

    public function update(Request $request, $id)
    {
        $cctv = Cctv::findOrFail($id);

        $rules = [
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ];

        // Check if cctv_monitoring is not null
        if ($cctv->cctv_monitoring) {
            foreach ($cctv->cctv_monitoring as $index => $monitoring) {
                $rules["status.{$monitoring->id_cctv}"] = 'required|in:OK,NG';
                $rules["condition.{$monitoring->id_cctv}"] = 'nullable|in:Bersih,Kotor';
            }
        }

        $request->validate($rules);

        if ($cctv->cctv_monitoring) {
            foreach ($cctv->cctv_monitoring as $index => $monitoring) {
                $status = $request->input("status.{$monitoring->id_cctv}");
                $condition = $request->input("condition.{$monitoring->id_cctv}");

                $monitoring->status = $status;
                $monitoring->condition = $condition;
                $monitoring->save();
            }
        }

        $data = $request->only([
            'note', 'follow_up'
        ]);

        $cctv->update($data);

        return redirect()->route('cctv.index')->with('success', 'Data berhasil diperbaharui !');
    }



    public function destroy($id)
    {
        $cctv = Cctv::findOrFail($id);
        $cctv->delete();

        return redirect()->route('cctv.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_cctv(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();

        // Cek apakah ada data yang sudah diapprove di bulan yang dipilih
        $count_cctvs = Cctv::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_cctvs > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya!');
        }

        // Cari data yang belum diapprove di bulan yang dipilih
        $cctvs = Cctv::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($cctvs->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove!');
        }

        foreach ($cctvs as $cctv) {
            $cctv->is_approved = 1;
            $cctv->approved_at = $now; // Menyimpan waktu approval
            $cctv->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "cctvs",
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

        return redirect()->back()->with('success', 'Data bulan berhasil disimpan !');
    }

    public function cctv_sama()
    {
        $now = Carbon::now();
        $day = $now->day;
        $yesterday = Carbon::yesterday()->toDateString();

        $yesterday_cctvs = CctvMonitoring::whereDate('created_at', $yesterday)->get();

        $cctvs = Cctv::create([
            'user_id' => auth()->id(),
            // 'note' => $request->note,
        ]);
        // dd($yesterday_cctvs[0]);

        foreach ($yesterday_cctvs as $yesterday_cctv) {
            $cctv = new CctvMonitoring;
            $cctv->cctv_id = $cctvs->id;
            $cctv->id_cctv = $yesterday_cctv->id_cctv;
            $cctv->status = $yesterday_cctv->status;
            $cctv->lokasi_name = $yesterday_cctv->lokasi_name;
            $cctv->posisi_name = $yesterday_cctv->posisi_name;
            $cctv->condition = $yesterday_cctv->condition;
            $cctv->save();
        }

        return redirect()->route('cctv.index')->with('success', 'Data berhasil disimpan !');
    }
}

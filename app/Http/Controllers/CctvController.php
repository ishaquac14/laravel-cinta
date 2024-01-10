<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\CctvMonitoring;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Http;

class CctvController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Cctv::orderBy('id', 'DESC');

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('note', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $cctvs = $query->paginate(5);

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
        ]);

        $cctvs = Cctv::create([
            "user_id" => auth()->id(),
            "note" => $request->note,
        ]);

        foreach ($request->input('status') as $id_cctv => $status) {
            $condition = $request->input("condition.$id_cctv");

            $cctv = new CctvMonitoring;
            $cctv->cctv_id = $cctvs->id;
            $cctv->id_cctv = $id_cctv;
            $cctv->building_name = $request->input("building_name.$id_cctv");
            $cctv->lokasi_name = $request->input("lokasi_name.$id_cctv");
            $cctv->status = $status;
            $cctv->condition = $condition;
            $cctv->save();
        }

        return redirect()->route('cctv.index')->with('success', 'Data berhasil disimpan');
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

        $data = [
            'note' => $request->input('note'),
            'follow_up' => $request->input('follow_up'),
        ];

        // Check if cctv_monitoring is not null
        if ($cctv->cctv_monitoring) {
            foreach ($cctv->cctv_monitoring as $index => $monitoring) {
                $data["cam{$monitoring->id_cctv}"] = $request->input("status.{$monitoring->id_cctv}");
                $data["kondisi_cam{$monitoring->id_cctv}"] = $request->input("condition.{$monitoring->id_cctv}");
            }
        }

        $cctv->update($data);

        return redirect()->route('cctv.index')->with('success', 'Data berhasil diperbarui');
    }



    public function destroy($id)
    {
        $cctv = Cctv::findOrFail($id);
        $cctv->delete();

        return redirect()->route('cctv.index')->with('success', 'Data berhasil dihapus');
    }

    public function approval_cctv(Request $request)
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $before_month = $month - 1;
        $cctvs = Cctv::whereYear('created_at', $year)->whereMonth('created_at', $before_month)->get();

        foreach ($cctvs as $cctv) {
            $cctv->is_approved = 1;
            $cctv->save();
        }

        return redirect()->back()->with('success', 'Approved success');
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
            $cctv->condition = $yesterday_cctv->condition;
            $cctv->save();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\CctvMonitoring;
use Illuminate\Http\Request;

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

        return redirect()->route('cctv.index')->with('success', 'Formulir berhasil dikirim');
    }


    public function show($id)
    {
<<<<<<< HEAD
        $cctv = Cctv::findOrFail($id);
        $cctv_monitoring = CctvMonitoring::where('cctv_id', $id)->orderBy('id_cctv', 'asc')->get();

        return view('pages.cctv.show', compact('cctv', 'cctv_monitoring'));
=======
        // $response = Http::withOptions(['verify' => false])->get('https://devita-dev.aiia.co.id/api_data_cctv');
        // $cctvs = $response->json()['cctvs'];
    
        $cctvs = CctvMonitoring::where('cctv_id', $id)->first();

        return view('pages.cctv.show', compact('cctvs'));
>>>>>>> d3340eb6c01bdb3d36173b0d6e8aa70070900a1f
    }

    public function edit($id)
    {
        $cctv = Cctv::findOrFail($id);

        return view('pages.cctv.edit', compact('cctv'));
    }

    public function update(Request $request, $id)
    {
        $cctv = Cctv::findOrFail($id);
    
        $rules = [
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ];
    
        for ($i = 1; $i <= 117; $i++) {
            $rules["cam{$i}"] = 'required|in:Ok,Ng';
            $rules["kondisi_cam{$i}"] = 'nullable|in:Kotor,Normal,Rusak';
        }
    
        $request->validate($rules);
    
        $data = [
            'note' => $request->input('note'),
            'follow_up' => $request->input('follow_up')
        ];
    
        for ($i = 1; $i <= 117; $i++) {
            $data["cam{$i}"] = $request->input("cam{$i}");
            $data["kondisi_cam{$i}"] = $request->input("kondisi_cam{$i}");
        }
    
        $cctv->update($data);
    
        $cctv->save();
    
        return redirect()->route('cctv.index')->with('success', 'Data berhasil diperbarui');
    }
    

    public function destroy($id)
    {
        $cctv = Cctv::findOrFail($id);
        $cctv->delete();

        return redirect()->route('cctv.index')->with('success', 'Data berhasil dihapus');
    }
}

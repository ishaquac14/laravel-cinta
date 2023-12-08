<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use Illuminate\Http\Request;

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
    
        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $cctvs = $query->paginate(5);
    
        // Mengirimkan data ke tampilan
        return view('pages.cctv.index', compact('cctvs'));
    }

    public function create()
    {
        return view('pages.cctv.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ];

        for ($i = 1; $i <= 117; $i++) {
            $rules["cam{$i}"] = 'required|in:Ok,Ng';
        }

        for ($i = 1; $i <= 117; $i++) {
            $rules["kondisi_cam{$i}"] = 'nullable|in:Kotor,Normal';
        }

        $request->validate($rules);

        $data = [
            'note' => $request->input('note'),
            'follow_up' => $request->input('follow_up')
        ];
        
        
        for ($i = 1; $i <= 117; $i++) {
            $data["cam{$i}"] = $request->input("cam{$i}");
        }

        for ($i = 1; $i <= 117; $i++) {
            $data["kondisi_cam{$i}"] = $request->input("kondisi_cam{$i}");
        }

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Cctv::create($data);
        

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('cctv.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cctv = Cctv::findOrFail($id);
        return view('pages.cctv.show', compact('cctv'));
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
        }

        for ($i = 1; $i <= 117; $i++) {
            $rules["kondisi_cam{$i}"] = 'nullable|in:Kotor,Normal';
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
        $cctv->note = $request->input('note', 'follow_up');
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

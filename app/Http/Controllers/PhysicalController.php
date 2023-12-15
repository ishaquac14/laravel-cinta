<?php

namespace App\Http\Controllers;

use App\Models\Physical;
use Illuminate\Http\Request;

class PhysicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Physical::orderBy('id', 'DESC');

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('note', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $physicals = $query->paginate(5);

        // Mengirimkan data ke tampilan
        return view('pages.physical.index', compact('physicals'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.physical.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // Validasi form input
        $request->validate ([
            'host3' => 'required|in:OK,NG',
            'storage3' => 'required|in:OK,NG',
            'host4' => 'required|in:OK,NG',
            'storage4' => 'required|in:OK,NG',
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        // // Validasi untuk 'hdd1' hingga 'hdd19' di storage3
        // for ($i = 1; $i <= 19; $i++) {
        //     $rules["hdd{$i}"] = 'required|in:OK,NG';
        // }

        // // Validasi untuk 'hdd1' hingga 'hdd10' di storage4
        // for ($i = 1; $i <= 10; $i++) {
        //     $rules["hdd_{$i}"] = 'required|in:OK,NG';
        // }

        // $request->validate($rules);

        // Simpan data ke database
        $data = [
            'host3' => $request->input('host3'),
            'storage3' => $request->input('storage3'),
            'host4' => $request->input('host4'),
            'storage4' => $request->input('storage4'),
            'note' => $request->input('note'),
            'follow_up' => $request->input('follow_up')
        ];

        // Tambahkan 'hdd1' hingga 'hdd19' ke dalam data untuk storage3
        for ($i = 1; $i <= 19; $i++) {
            $data["hdd{$i}"] = $request->input("hdd" . $i);
        }

        // Tambahkan 'hdd1' hingga 'hdd10' ke dalam data untuk storage4
        for ($i = 1; $i <= 10; $i++) {
            $data["hdd_{$i}"] = $request->input("hdd_" . $i);
        }
        // dd($data);

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Physical::create($data);


        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('physical.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $physical = Physical::findOrFail($id);
        return view('pages.physical.show', compact('physical'));
    }

    public function edit($id)
    {
        $physical = Physical::findOrFail($id);

        return view('pages.physical.edit', compact('physical'));
    }
    
    public function update(Request $request, $id)
    {
        $physical = Physical::findOrFail($id);
    
        $request->validate([
            'host3' => 'required|in:OK,NG',
            'storage3' => 'required|in:OK,NG',
            'host4' => 'required|in:OK,NG',
            'storage4' => 'required|in:OK,NG',
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);
    
        $data = $request->only([
            'host3', 'storage3', 'host4', 'storage4', 'note', 'follow_up'
        ]);
    
        for ($i = 1; $i <= 19; $i++) {
            $data["hdd{$i}"] = $request->input("hdd" . $i);
        }
    
        for ($i = 1; $i <= 10; $i++) {
            $data["hdd_{$i}"] = $request->input("hdd_" . $i);
        }
    
        $physical->update($data);
    
        return redirect()->route('physical.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $physical = Physical::findOrFail($id);
        $physical->delete();

        return redirect()->route('physical.index')->with('success', 'Data berhasil dihapus');
    }
}

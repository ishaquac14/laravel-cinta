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
        ];

        for ($i = 1; $i <= 117; $i++) {
            $rules["cam{$i}"] = 'required|in:Ok,Ng';
        }

        $request->validate($rules);

        $data = [
            'note' => $request->input('note')
        ];
        
        // Tambahkan 'hdd1' hingga 'hdd19' ke dalam data untuk storage3
        for ($i = 1; $i <= 117; $i++) {
            $data["cam{$i}"] = $request->input("cam{$i}");
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
}

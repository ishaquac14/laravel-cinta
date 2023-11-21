<?php

namespace App\Http\Controllers;

use App\Models\Acserver;
use Illuminate\Http\Request;

class AcserverController extends Controller
{/**
     * Display a listierror of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $query = Acserver::orderBy('id', 'DESC');
    
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $acservers = $query->paginate(5);
    
        // Mengirimkan data ke tampilan
        return view('pages.acserver.index', compact('acservers'));
    }    


    /**
     * Show the form for creatierror a new resource.
     */
    public function create()
    {
        return view('pages.acserver.create');
    }

    public function store(Request $request)
    {
        // Validasi form input
        $request->validate([
            'kondisi' => 'required',
            'ac-01_suhu' => 'required', 
            'ac-02_suhu' => 'required', 
            'ac-03_suhu' => 'required', 
            'ac-04_suhu' => 'required', 
            'note' => 'string|nullable',
            'status' => 'required'
        ]);
        

        // Mendapatkan data dari permintaan
        $data = $request->only(['kondisi', 'ac-01_suhu', 'ac-02_suhu', 'ac-03_suhu', 'ac-04_suhu', 'note', 'status']);
        // Menyimpan data ke dalam acserver
        
        Acserver::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('acserver.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $acserver = Acserver::findOrFail($id);
        return view('pages.acserver.show', compact('acserver'));
    }
}

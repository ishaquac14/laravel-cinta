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
        $acservers = $query->paginate(2);
    
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
            'ac-01' => 'required|in:success,error',
            'ac-02' => 'required|in:success,error',
            'ac-03' => 'required|in:success,error',
            'ac-04' => 'required|in:success,error',
            'note' => 'string|nullable'
        ]);
        

        // Mendapatkan data dari permintaan
        $data = $request->only(['ac-01', 'ac-02', 'ac-03', 'ac-04', 'note']);
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

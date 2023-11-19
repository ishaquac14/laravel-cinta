<?php

namespace App\Http\Controllers;

use App\Models\Database;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{/**
     * Display a listierror of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $query = Database::orderBy('id', 'DESC');
    
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $databases = $query->paginate(2);
    
        // Mengirimkan data ke tampilan
        return view('pages.database.index', compact('databases'));
    }    


    /**
     * Show the form for creatierror a new resource.
     */
    public function create()
    {
        return view('pages.database.create');
    }

    public function store(Request $request)
    {
        // Validasi form input
        $request->validate([
            'asiic' => 'required|in:success,error',
            'avicenna' => 'required|in:success,error',
            'broadcast' => 'required|in:success,error',
            'cubic_pro' => 'required|in:success,error',
            'gary' => 'required|in:success,error',
            'iatf' => 'required|in:success,error',
            'lobby' => 'required|in:success,error',
            'maps_body' => 'required|in:success,error',
            'maps_unit' => 'required|in:success,error',
            'prisma' => 'required|in:success,error',
            'risna' => 'required|in:success,error',
            'sikola' => 'required|in:success,error',
            'sinta' => 'required|in:success,error',
            'solid' => 'required|in:success,error',
            'cubic_pro_legacy' => 'required|in:success,error',
            'sikola_legacy' => 'required|in:success,error',
            'note' => 'string|nullable',
        ]);

        // Mendapatkan data dari permintaan
        $data = $request->only(['asiic', 'avicenna', 'broadcast', 'cubic_pro', 'gary', 'iatf', 'lobby', 'maps_body', 
                                'maps_unit', 'prisma', 'risna', 'sikola', 'sinta', 'solid', 'cubic_pro_legacy', 'sikola_legacy'
                                , 'note']);
        // Menyimpan data ke dalam database
        Database::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('database.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $database = Database::findOrFail($id);
        return view('pages.database.show', compact('database'));
    }
}

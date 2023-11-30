<?php

namespace App\Http\Controllers;

use App\Models\Tapedrive;
use Illuminate\Http\Request;

class TapedriveController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $query = Tapedrive::orderBy('id', 'DESC');
    
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('note', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $tapedrives = $query->paginate(5);
    
        // Mengirimkan data ke tampilan
        return view('pages.tapedrive.index', compact('tapedrives'));
    }

    public function create()
    {
        return view('pages.tapedrive.create');
    }

    public function store(Request $request)
    {
        // Validasi form input
        $request->validate([
            'plan_media' => 'string|required',
            'actual_media' => 'string|required',
            'tape_id' => 'string|required',
            'status' => 'string|required',
            'note' => 'string|nullable',
        ]);
        

        // Mendapatkan data dari permintaan
        $data = $request->only(['plan_media', 'actual_media', 'tape_id', 'status', 'note']);
        // Menyimpan data ke dalam tapedrive
        // dd($data);auth()->user()->name
        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Tapedrive::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('tapedrive.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tapedrive = Tapedrive::findOrFail($id);
        return view('pages.tapedrive.show', compact('tapedrive'));
    }

}
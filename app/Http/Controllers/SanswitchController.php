<?php

namespace App\Http\Controllers;

use App\Models\Sanswitch;
use Illuminate\Http\Request;

class SanswitchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $query = Sanswitch::orderBy('id', 'DESC');
    
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $sanswitchs = $query->paginate(2);
    
        // Mengirimkan data ke tampilan    
    
        return view('pages.sanswitch.index', compact('sanswitchs'));
    }
  

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sanswitch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi form input
        $rules = [
            'powerstatus' => 'required|in:OK,NG',
            'notif_' => 'required|in:OK,NG',
            'powerstatus_' => 'required|in:OK,NG',
            'notif' => 'required|in:OK,NG',
            'note' => 'nullable|string',
        ];

        for ($i = 0; $i <= 3; $i++) {
            $rules["port{$i}"] = 'required|in:OK,NG';
        }

        for ($i = 0; $i <= 4; $i++) {
            $rules["port_{$i}"] = 'required|in:OK,NG';
        }

        $request->validate($rules);

        // Simpan data ke database
        $data = [
            'powerstatus' => $request->input('powerstatus'),
            'notif' => $request->input('notif'),
            'powerstatus_' => $request->input('powerstatus_'),
            'notif_' => $request->input('notif_'),
            'note' => $request->input('note')
        ];
        
        // Tambahkan 'hdd1' hingga 'hdd19' ke dalam data untuk storage3
        for ($i = 0; $i <= 3; $i++) {
            $data["port{$i}"] = $request->input("port{$i}");
        }
        
        // Tambahkan 'hdd1' hingga 'hdd10' ke dalam data untuk storage4
        for ($i = 0; $i <= 4; $i++) {
            $data["port_{$i}"] = $request->input("port_{$i}");
        }
        
        Sanswitch::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('sanswitch.index')->with('success', 'Data berhasil disimpan');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sanswitch = Sanswitch::findOrFail($id);
        return view('pages.sanswitch.show', compact('sanswitch'));
    }
        
}

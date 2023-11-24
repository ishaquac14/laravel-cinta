<?php

namespace App\Http\Controllers;

use App\Models\Mointernet;
use Illuminate\Http\Request;

class MointernetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $query = Mointernet::orderBy('id', 'DESC');
    
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('note', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $mointernets = $query->paginate(5);
    
        // Mengirimkan data ke tampilan
        return view('pages.mointernet.index', compact('mointernets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.mointernet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'required',
            'note' => 'nullable',
            ]);

        $data = $request->only(['date', 'start_time', 'end_time', 'duration', 'note'
                                ]);

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Mointernet::create($data);

        return redirect()->route('mointernet.index')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $mointernet = Mointernet::findOrFail($id);
        return view('pages.mointernet.show', compact('mointernet'));
    }

    /**
     * Display the specified resource.
     */
    // public function show(Mointernet $mointernet)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Mointernet $mointernet)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateMointernetRequest $request, Mointernet $mointernet)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Mointernet $mointernet)
    // {
    //     //
    // }
}

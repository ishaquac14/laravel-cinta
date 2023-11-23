<?php

namespace App\Http\Controllers;

use App\Models\Fujixerox;
use App\Http\Requests\StoreFujixeroxRequest;
use App\Http\Requests\UpdateFujixeroxRequest;

class FujixeroxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $query = Fujixerox::orderBy('id', 'DESC');
    
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('note', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $fujixeroxs = $query->paginate(5);
    
        // Mengirimkan data ke tampilan
        return view('pages.fujixerox.index', compact('fujixeroxs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFujixeroxRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fujixerox $fujixerox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fujixerox $fujixerox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFujixeroxRequest $request, Fujixerox $fujixerox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fujixerox $fujixerox)
    {
        //
    }
}

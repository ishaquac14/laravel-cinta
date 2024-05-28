<?php

namespace App\Http\Controllers;

use App\Models\Cctvaiia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CctvaiiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Cctvaiia::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Cctvaiia::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $cctvaiias = $query->paginate(10);
        
        $cctvaiias->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

        return view('pages.cctvaiia.index', compact('cctvaiias'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cctvaiia $cctvaiia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cctvaiia $cctvaiia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cctvaiia $cctvaiia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cctvaiia $cctvaiia)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Gacsirt;
use Illuminate\Http\Request;

class GacsirtController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Gacsirt::orderBy('id', 'DESC');

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $gacsirts = $query->paginate(5);

        // Mengirimkan data ke tampilan
        return view('pages.gacsirt.index', compact('gacsirts'));
    }

    public function create()
    {
        return view('pages.gacsirt.create');
    }

    public function store(Request $request)
    {
        // Validasi form input
        $request->validate([
            'date' => 'string|nullable',
            'tincoming' => 'string|nullable',
            'incoming' => 'string|nullable',
            'tcompleted' => 'string|nullable',
            'completed' => 'string|nullable',
            'status' => 'string|required',
            'follow_up' => 'string|nullable',
        ]);

        $data = $request->only([
            'date', 'tincoming', 'incoming', 'tcompleted', 'completed', 'status', 'follow_up'
        ]);

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Gacsirt::create($data);

        return redirect()->route('gacsirt.index')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $gacsirt = Gacsirt::findOrFail($id);
        return view('pages.gacsirt.show', compact('gacsirt'));
    }

    public function edit($id)
    {
        $gacsirt = Gacsirt::findOrFail($id);

        return view('pages.gacsirt.edit', compact('gacsirt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gacsirt = Gacsirt::findOrFail($id);

        $request->validate([
            'date' => 'string|nullable',
            'tincoming' => 'string|nullable',
            'incoming' => 'string|nullable',
            'tcompleted' => 'string|nullable',
            'completed' => 'string|nullable',
            'status' => 'string|required',
            'follow_up' => 'nullable'
        ]);

        $gacsirt->update($request->only(
            'date',
            'tincoming',
            'incoming',
            'tcompleted',
            'completed',
            'status',
            'follow_up'
        ));

        return redirect()->route('gacsirt.index')->with('success', 'GA Csirt berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gacsirt = Gacsirt::findOrFail($id);
        $gacsirt->delete();

        return redirect()->route('gacsirt.index')->with('success', 'GA Csirt berhasil dihapus.');
    }
}

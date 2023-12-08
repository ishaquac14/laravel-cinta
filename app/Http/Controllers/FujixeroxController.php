<?php

namespace App\Http\Controllers;

use App\Models\Fujixerox;
use Illuminate\Http\Request;

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


    public function create()
    {
        return view('pages.fujixerox.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'timedown' => 'required',
            'timeon' => 'required',
            'follow_up' => 'nullable',
            'status' => 'required',
        ]);

        $data = $request->only([
            'date', 'timedown', 'timeon', 'status', 'follow_up'
        ]);

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Fujixerox::create($data);

        return redirect()->route('fujixerox.index')->with('success', 'Data berhasil disimpan');
    }


    public function show($id)
    {
        $fujixerox = Fujixerox::findOrFail($id);
        return view('pages.fujixerox.show', compact('fujixerox'));
    }

    public function edit($id)
    {
        $fujixerox = Fujixerox::findOrFail($id);

        return view('pages.fujixerox.edit', compact('fujixerox'));
    }

    public function update(Request $request, $id)
    {
        $fujixerox = Fujixerox::findOrFail($id);

        $request->validate([
            'date' => 'required',
            'timedown' => 'required',
            'timeon' => 'required',
            'status' => 'required',
            'follow_up' => 'nullable',
        ]);

        $fujixerox->update($request->only(
            'date',
            'timedown',
            'timeon',
            'follow_up',
            'status'
        ));

        return redirect()->route('fujixerox.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $fujixerox = Fujixerox::findOrFail($id);
        $fujixerox->delete();

        return redirect()->route('fujixerox.index')->with('success', 'Data berhasil dihapus.');
    }
}

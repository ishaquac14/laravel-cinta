<?php

namespace App\Http\Controllers;

use App\Models\Csdatabase;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CsdatabaseController extends Controller
{
    /**
     * Display a listierror of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Csdatabase::orderBy('id', 'DESC');

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('created_at', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('author', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Menggunakan paginate(10) untuk mendapatkan data paginasi
        $csdatabases = $query->paginate(5);

        // dd($csdatabases);
        // Mengirimkan data ke tampilan
        return view('pages.csdatabase.index', compact('csdatabases'));
    }


    /**
     * Show the form for creatierror a new resource.
     */
    public function create()
    {
        return view('pages.csdatabase.create');
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
        $data = $request->only([
            'asiic', 'avicenna', 'broadcast', 'cubic_pro', 'gary', 'iatf', 'lobby', 'maps_body',
            'maps_unit', 'prisma', 'risna', 'sikola', 'sinta', 'solid', 'cubic_pro_legacy', 'sikola_legacy', 'note'
        ]);
        // Menyimpan data ke dalam csdatabase

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Csdatabase::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('csdatabase.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $csdatabase = Csdatabase::findOrFail($id);
        return view('pages.csdatabase.show', compact('csdatabase'));
    }

    public function edit($id)
    {
        $csdatabase = Csdatabase::findOrFail($id);

        return view('pages.csdatabase.edit', compact('csdatabase'));
    }

    public function update(Request $request, $id)
    {
        $csdatabase = Csdatabase::findOrFail($id);

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
            'follow_up' => 'string|nullable'
        ]);

        $csdatabase->update($request->only(
            'asiic',
            'avicenna',
            'broadcast',
            'cubic_pro',
            'gary',
            'iatf',
            'lobby',
            'maps_body',
            'maps_unit',
            'prisma',
            'risna',
            'sikola',
            'sinta',
            'solid',
            'cubic_pro_legacy',
            'sikola_legacy',
            'note',
            'follow_up'
        ));

        return redirect()->route('csdatabase.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $csdatabase = Csdatabase::findOrFail($id);
        $csdatabase->delete();

        return redirect()->route('csdatabase.index')->with('success', 'Data berhasil dihapus');
    }

    public function approval_csdatabase (Request $request)
    {   
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $before_month = $month - 1;
        $csdatabase = Csdatabase::whereYear('created_at', $year)->whereMonth('created_at', $before_month)->get();

        foreach($csdatabase as $csdatabase)
        {
            $csdatabase->is_approved = 1;
            $csdatabase->save();
        }

        return redirect()->back()->with('success', 'Approved success');
    }
}

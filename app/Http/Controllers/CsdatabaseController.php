<?php

namespace App\Http\Controllers;

use App\Models\Csdatabase;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CsdatabaseController extends Controller
{
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Csdatabase::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Csdatabase::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $csdatabases = $query->paginate(10);

        $csdatabases->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

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
            'devita' => 'required|in:success,error',
            'cinta' => 'required|in:success,error',
            'note' => 'string|nullable',
        ]);

        // Mendapatkan data dari permintaan
        $data = $request->only([
            'asiic', 'avicenna', 'broadcast', 'cubic_pro', 'gary', 'iatf', 'lobby', 'maps_body',
            'maps_unit', 'prisma', 'risna', 'sikola', 'sinta', 'solid', 'cubic_pro_legacy', 'sikola_legacy','devita', 'note', 'cinta'
        ]);
        // Menyimpan data ke dalam csdatabase

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Csdatabase::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('csdatabase.index')->with('success', 'Data berhasil disimpan !');
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
            'devita' => 'required|in:success,error',
            'cinta' => 'required|in:success,error',
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
            'devita',
            'cinta',
            'note',
            'follow_up'
        ));

        return redirect()->route('csdatabase.index')->with('success', 'Data berhasil diperbaharui !');
    }

    public function destroy($id)
    {
        $csdatabase = Csdatabase::findOrFail($id);
        $csdatabase->delete();

        return redirect()->route('csdatabase.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_csdatabase(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();
        $current_month = $now->format('m');

        $count_csdatabases = Csdatabase::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_csdatabases > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya !');
        };

        $csdatabases = Csdatabase::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($csdatabases->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove !');
        }

        foreach ($csdatabases as $csdatabase) {
            $csdatabase->is_approved = 1;
            $csdatabase->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "csdatabases",
        ]);

        return redirect()->back()->with('success', 'Data berhasil diapprove !');
    }


    public function log_approved(Request $request)
    {
        $request->validate([
            'selected_month' => 'string|required'
        ]);

        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $request->input('selected_month'),
        ]);

        return redirect()->back()->with('success', 'Data bulan berhasil disimpan');
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Physical;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PhysicalController extends Controller
{
   
    public function index(Request $request)
    {
        $sortTerm = $request->input('sort_bulan');
        $tahunTerm = $request->input('sort_tahun');

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $query = Physical::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Physical::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $physicals = $query->paginate(10);

        $physicals->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

        return view('pages.physical.index', compact('physicals'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.physical.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // Validasi form input
        $request->validate ([
            'host3' => 'required|in:OK,NG',
            'storage3' => 'required|in:OK,NG',
            'host4' => 'required|in:OK,NG',
            'storage4' => 'required|in:OK,NG',
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        $data = [
            'host3' => $request->input('host3'),
            'storage3' => $request->input('storage3'),
            'host4' => $request->input('host4'),
            'storage4' => $request->input('storage4'),
            'note' => $request->input('note'),
            'follow_up' => $request->input('follow_up')
        ];

        // Tambahkan 'hdd1' hingga 'hdd19' ke dalam data untuk storage3
        for ($i = 1; $i <= 19; $i++) {
            $data["hdd{$i}"] = $request->input("hdd" . $i);
        }

        // Tambahkan 'hdd1' hingga 'hdd10' ke dalam data untuk storage4
        for ($i = 1; $i <= 10; $i++) {
            $data["hdd_{$i}"] = $request->input("hdd_" . $i);
        }
        // dd($data);

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;

        Physical::create($data);


        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('physical.index')->with('success', 'Data berhasil disimpan !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $physical = Physical::findOrFail($id);
        return view('pages.physical.show', compact('physical'));
    }

    public function edit($id)
    {
        $physical = Physical::findOrFail($id);

        return view('pages.physical.edit', compact('physical'));
    }
    
    public function update(Request $request, $id)
    {
        $physical = Physical::findOrFail($id);
    
        $request->validate([
            'host3' => 'required|in:OK,NG',
            'storage3' => 'required|in:OK,NG',
            'host4' => 'required|in:OK,NG',
            'storage4' => 'required|in:OK,NG',
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);
    
        $data = $request->only([
            'host3', 'storage3', 'host4', 'storage4', 'note', 'follow_up'
        ]);
    
        for ($i = 1; $i <= 19; $i++) {
            $data["hdd{$i}"] = $request->input("hdd" . $i);
        }
    
        for ($i = 1; $i <= 10; $i++) {
            $data["hdd_{$i}"] = $request->input("hdd_" . $i);
        }
    
        $physical->update($data);
    
        return redirect()->route('physical.index')->with('success', 'Data berhasil diperbaharui !');
    }

    public function destroy($id)
    {
        $physical = Physical::findOrFail($id);
        $physical->delete();

        return redirect()->route('physical.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_physical(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();
        $current_month = $now->format('m');

        $count_physicals = Physical::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_physicals > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya !');
        };

        $physicals = Physical::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($physicals->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove !');
        }

        foreach ($physicals as $physical) {
            $physical->is_approved = 1;
            $physical->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "physicals",
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

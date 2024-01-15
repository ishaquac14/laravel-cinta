<?php

namespace App\Http\Controllers;

use App\Models\Sanswitch;
use App\Models\Logapproved;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SanswitchController extends Controller
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
        $query = Sanswitch::whereMonth('created_at', $current_month)->whereYear('created_at', $current_year)->orderBy('id', 'DESC');

        if ($sortTerm) {
            $query = Sanswitch::orderBy('id', 'DESC');
            $query->where(function ($q) use ($sortTerm, $tahunTerm) {
                $q->whereMonth('created_at', $sortTerm)
                    ->whereYear('created_at', $tahunTerm);
            });
        }

        $sanswitchs = $query->paginate(5);

        $sanswitchs->appends([
            'sort_bulan' => $sortTerm,
            'sort_tahun' => $tahunTerm,
        ]);

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
            'follow_up' => 'nullable|string',
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
            'note' => $request->input('note'),
            'follow_up' => $request->input('note')
        ];
        
        // Tambahkan 'hdd1' hingga 'hdd19' ke dalam data untuk storage3
        for ($i = 0; $i <= 3; $i++) {
            $data["port{$i}"] = $request->input("port{$i}");
        }
        
        // Tambahkan 'hdd1' hingga 'hdd10' ke dalam data untuk storage4
        for ($i = 0; $i <= 4; $i++) {
            $data["port_{$i}"] = $request->input("port_{$i}");
        }

        $data['author'] = auth()->user()->name;

        $data['user_id'] = auth()->user()->id;
        
        Sanswitch::create($data);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('sanswitch.index')->with('success', 'Data berhasil disimpan !');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sanswitch = Sanswitch::findOrFail($id);
        return view('pages.sanswitch.show', compact('sanswitch'));
    }

    public function edit($id)
    {
        $sanswitch = Sanswitch::findOrFail($id);

        return view('pages.sanswitch.edit', compact('sanswitch'));
    }
    
    public function update(Request $request, $id)
    {
        $sanswitch = Sanswitch::findOrFail($id);
        
        $rules = [
            'powerstatus' => 'required|in:OK,NG',
            'notif_' => 'required|in:OK,NG',
            'powerstatus_' => 'required|in:OK,NG',
            'notif' => 'required|in:OK,NG',
            'note' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ];

        for ($i = 0; $i <= 3; $i++) {
            $rules["port{$i}"] = 'required|in:OK,NG';
        }

        for ($i = 0; $i <= 4; $i++) {
            $rules["port_{$i}"] = 'required|in:OK,NG';
        }

        $request->validate($rules);

        $data = [
            'powerstatus' => $request->input('powerstatus'),
            'notif' => $request->input('notif'),
            'powerstatus_' => $request->input('powerstatus_'),
            'notif_' => $request->input('notif_'),
            'note' => $request->input('note'),
            'follow_up' => $request->input('follow_up')
        ];

        for ($i = 0; $i <= 4; $i++) {
            $data["port{$i}"] = $request->input("port{$i}");
            $data["port_{$i}"] = $request->input("port_{$i}");
        }

        // Simpan data ke model
        $sanswitch->update($data);

        return redirect()->route('sanswitch.index')->with('success', 'Data berhasil diperbaharui !');
    }

    public function destroy($id)
    {
        $sanswitch = Sanswitch::findOrFail($id);
        $sanswitch->delete();

        return redirect()->route('sanswitch.index')->with('success', 'Data berhasil dihapus !');
    }

    public function approval_sanswitch(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();
        $current_month = $now->format('m');

        $count_sanswitchs = Sanswitch::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_sanswitchs > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya !');
        };

        $sanswitchs = Sanswitch::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($sanswitchs->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove !');
        }

        foreach ($sanswitchs as $sanswitch) {
            $sanswitch->is_approved = 1;
            $sanswitch->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "sanswitchs",
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

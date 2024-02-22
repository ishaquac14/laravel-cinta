<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CServerElectric;
use App\Models\CServerElectricItem;
use App\Models\Logapproved;
use App\Models\MServerElectric;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ServerElectricController extends Controller
{
    /// MASTER ///
    public function master_list()
    {
        $m_server_electrics = MServerElectric::all();

        return view('pages.server_electric.master_list', compact('m_server_electrics'));
    }

    public function master_create()
    {
        return view('pages.server_electric.master_create');
    }

    public function master_store(Request $request)
    {
        $m_server_electrics = MServerElectric::create([
            'type' => $request->type,
            'item' => $request->item,
        ]);

        return redirect()->route('server_electric.master_list')->with('success', 'Data berhasil disimpan !');
    }

    public function master_edit($id)
    {
    }

    public function master_update(Request $request, $id)
    {
    }

    public function master_delete(Request $request, $id)
    {
    }

    /// CHECKSHHET ///
    public function checksheet_list()
    {
        $c_server_electrics = CServerElectric::all();

        return view('pages.server_electric.checksheet_list', compact('c_server_electrics'));
    }

    public function checksheet_detail($id)
    {
        $c_server_electrics = CServerElectric::findOrFail($id);

        $c_server_electric_items = CServerElectricItem::where('server_electric_id', $id)->get();

        return view('pages.server_electric.checksheet_detail', compact('c_server_electrics', 'c_server_electric_items'));
    }

    public function checksheet_create()
    {
        $m_server_electrics = MServerElectric::all();

        return view('pages.server_electric.checksheet_create', compact('m_server_electrics'));
    }

    public function checksheet_store(Request $request)
    {
        // dd($request);
        $types = $request->input('type');
        $items = $request->input('item');
        $statuses = $request->input('status');

        $c_server_electrics = CServerElectric::create([
            'user_id' => Auth::user()->id,
            'suhu' => $request->suhu,
            'note' => $request->note,
        ]);

        // Menyimpan setiap baris data
        foreach ($types as $key => $type) {
            if (isset($items[$key], $statuses[$key])) {
                $serverElectric = new CServerElectricItem();
                // dd($serverElectric);
                $serverElectric->server_electric_id = $c_server_electrics->id;
                $serverElectric->type = $type;
                $serverElectric->item = $items[$key];
                $serverElectric->status = $statuses[$key];
                $serverElectric->save();
            }
        }

        return redirect()->route('server_electric.checksheet_list')->with('success', 'Data berhasil disimpan !');
    }

    public function checksheet_edit($id)
    {
        $c_server_electric_items = CServerElectricItem::all();
        $c_server_electric = CServerElectric::findOrFail($id);
        $c_server_electrics = CServerElectric::findOrFail($id);
        return view('pages.server_electric.checksheet_edit', compact('c_server_electrics', 'c_server_electric_items', 'c_server_electric'));
    }

    public function checksheet_update(Request $request, $id)
    {
        $c_server_electric = CServerElectric::findOrFail($id);
        $c_server_electric->suhu = $request->suhu;
        $c_server_electric->note = $request->note;
        $c_server_electric->save();
    
        // Menghapus semua item yang terkait dengan server electric
        CServerElectricItem::where('server_electric_id', $id)->delete();
    
        // Menyimpan setiap baris data yang diperbarui
        $types = $request->input('type');
        $items = $request->input('item');
        $statuses = $request->input('status');
    
        foreach ($types as $key => $type) {
            if (isset($items[$key], $statuses[$key])) {
                $serverElectricItem = new CServerElectricItem();
                $serverElectricItem->server_electric_id = $c_server_electric->id;
                $serverElectricItem->type = $type;
                $serverElectricItem->item = $items[$key];
                $serverElectricItem->status = $statuses[$key];
                $serverElectricItem->save();
            }
        }
    
        return redirect()->route('server_electric.checksheet_list')->with('success', 'Data berhasil diperbarui!');
    }
    

    public function checksheet_destroy($id)
    {
        
        CServerElectricItem::where('server_electric_id', $id)->delete();

        $c_server_electric = CServerElectric::findOrFail($id);
        $c_server_electric->delete();

        return redirect()->route('server_electric.checksheet_list')->with('danger', 'Data berhasil dihapus !');
    }

    public function approval_c_server_electric(Request $request)
    {
        $selectedMonth = $request->input('selected_month');
        $now = Carbon::now();
        $current_month = $now->format('m');

        $count_c_server_electrics = cServerElectric::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 1)
            ->count();

        if ($count_c_server_electrics > 0) {
            return redirect()->back()->with('warning', 'Data sudah diapprove sebelumnya !');
        };

        $c_server_electrics = cServerElectric::whereMonth('created_at', $selectedMonth)
            ->where('is_approved', 0)
            ->get();

        if ($c_server_electrics->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak ditemukan untuk diapprove !');
        }

        foreach ($c_server_electrics as $c_server_electric) {
            $c_server_electric->is_approved = 1;
            $c_server_electric->save();
        }

        $user_id = Auth::id();
        // Simpan data bulan yang di-approve ke dalam tabel Logapproved
        $logApproved = Logapproved::create([
            'month' => $selectedMonth,
            'user_id' => $user_id,
            'checksheet_name' => "c_server_electrics",
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CServerElectric;
use App\Models\CServerElectricItem;
use App\Models\MServerElectric;

use Auth;

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

    public function master_delete(Request $request,$id)
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
        $c_server_electrics = CServerElectric::findOrFail($id);
    }

    public function checksheet_update(Request $request, $id)
    {

    }

    public function checksheet_delete(Request $request,$id)
    {

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Acserver;
use App\Models\Csdatabase;
use App\Models\Tapedrive;
use App\Models\Gacsirt;
use App\Models\Mointernet;
use App\Models\Physical;
use App\Models\Sanswitch;
use App\Models\Fujixerox;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function ApproveAcserver($id)
    {
        $acserver = Acserver::findOrFail($id);
        $acserver->is_approved = true;
        $acserver->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }
    
    public function ApproveCsdatabase($id)
    {
        $csdatabase = Csdatabase::findOrFail($id);
        $csdatabase->is_approved = true;
        $csdatabase->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }  

    public function ApproveTapedrive($id)
    {
        $tapedrive = Tapedrive::findOrFail($id);
        $tapedrive->is_approved = true;
        $tapedrive->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }

    public function ApproveGacsirt($id)
    {
        $gacsirt = Gacsirt::findOrFail($id);
        $gacsirt->is_approved = true;
        $gacsirt->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }  

    public function ApproveMointernet($id)
    {
        $mointernet = Mointernet::findOrFail($id);
        $mointernet->is_approved = true;
        $mointernet->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }  

    public function ApprovePhysical($id)
    {
        $physical = Physical::findOrFail($id);
        $physical->is_approved = true;
        $physical->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }  

    public function ApproveFujixerox($id)
    {
        $fujixerox = Fujixerox::findOrFail($id);
        $fujixerox->is_approved = true;
        $fujixerox->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }  

    public function ApproveSanswitch($id)
    {
        $sanswitch = Sanswitch::findOrFail($id);
        $sanswitch->is_approved = true;
        $sanswitch->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }  
}

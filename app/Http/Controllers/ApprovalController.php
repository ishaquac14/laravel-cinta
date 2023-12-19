<?php

namespace App\Http\Controllers;

use App\Models\Acserver;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function approve($id)
    {
        $acserver = Acserver::findOrFail($id);
        $acserver->is_approved = true;
        $acserver->save();
    
        return redirect()->back()->with('success', 'Approved success');
    }  
}

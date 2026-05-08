<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterFileController extends Controller
{
    // Redirect main groups to default first items
    public function terkendali()
    {
        return redirect()->route('admin.gmd.index');
    }

    public function referensi()
    {
        return redirect()->route('admin.place.index');
    }

    public function peralatan()
    {
        return redirect()->route('admin.master.placeholder', ['type' => 'peralatan', 'current' => 'ruang_pengunjung']);
    }

    // Placeholder view for unimplemented master files
    public function placeholder($type, $current)
    {
        return view('admin.master.placeholder', compact('type', 'current'));
    }
}

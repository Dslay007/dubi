<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarcController extends Controller
{
    public function index()
    {
        return view('admin.marc.index');
    }

    public function import(Request $request)
    {
        // Stub for MARC import
        return back()->with('success', 'MARC Import Not Implemented Yet');
    }

    public function export()
    {
        // Stub for MARC export
        return back()->with('success', 'MARC Export Not Implemented Yet');
    }
}

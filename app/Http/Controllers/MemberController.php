<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function dashboard()
    {
        $member = Auth::guard('member')->user();
        
        // Eager load loans with item and biblio info
        $loans = $member->loans()
            ->where('is_return', 0) // Only active loans
            ->with(['item.biblio'])
            ->orderBy('due_date', 'asc')
            ->get();
            
        // Get active reservations
        $reservations = $member->reservations()
            ->with(['item.biblio'])
            ->orderBy('reserve_date', 'desc')
            ->get();

        return view('member.dashboard', compact('member', 'loans', 'reservations'));
    }
}

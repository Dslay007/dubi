<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $member = $request->user();

        // Mengambil daftar pinjaman buku yang masih aktif beserta detail bukunya
        $activeLoans = $member->loans()->with(['item.biblio'])->get();

        // Mengambil riwayat reservasi
        $reservations = $member->reservations()->with(['biblio'])->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'member_info' => [
                    'member_id' => $member->member_id,
                    'member_name' => $member->member_name,
                    'member_type_id' => $member->member_type_id,
                    'member_image' => $member->member_image ? asset('images/persons/' . $member->member_image) : null,
                ],
                'summary' => [
                    'total_active_loans' => $activeLoans->count(),
                    'total_reservations' => $reservations->count(),
                ],
                'active_loans' => $activeLoans,
                'reservations' => $reservations,
            ]
        ]);
    }
}

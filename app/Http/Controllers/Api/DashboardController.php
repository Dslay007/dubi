<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $member = $request->user();

        // Mengambil daftar pinjaman buku yang masih aktif beserta detail bukunya (is_return = 0)
        $activeLoans = $member->loans()->where('is_return', 0)->with(['item.biblio'])->get();

        // Mengambil reservasi aktif (status null, pending, atau approved)
        $reservations = $member->reservations()
                               ->where(function($q) {
                                   $q->whereNull('status')
                                     ->orWhereNotIn('status', ['completed', 'rejected']);
                               })
                               ->with(['biblio'])->get();

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
                    'total_visits' => \App\Models\VisitorCount::where('member_id', $member->member_id)->count(),
                ],
                'active_loans' => $activeLoans,
                'reservations' => $reservations,
            ]
        ]);
    }

    public function history(Request $request)
    {
        $member = $request->user();

        // Riwayat Peminjaman (is_return = 1)
        $loanHistory = $member->loans()->where('is_return', 1)->with(['item.biblio'])->orderBy('loan_date', 'desc')->get();

        // Riwayat Reservasi (status completed atau rejected)
        $reservationHistory = $member->reservations()
                                     ->whereNotNull('status')
                                     ->whereIn('status', ['completed', 'rejected'])
                                     ->with(['biblio'])
                                     ->orderBy('reserve_date', 'desc')
                                     ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'loan_history' => $loanHistory,
                'reservation_history' => $reservationHistory,
            ]
        ]);
    }
}

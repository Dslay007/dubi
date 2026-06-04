<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biblio;
use App\Models\Item;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // Mengambil daftar buku untuk dicari di aplikasi mobile
    public function books(Request $request)
    {
        $query = Biblio::with(['author', 'publisher']);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $books = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    // Melakukan reservasi buku
    public function store(Request $request)
    {
        $request->validate([
            'item_code' => 'required|exists:item,item_code',
        ]);

        $member = $request->user();

        // Cek apakah item sedang dipinjam (biasanya reservasi hanya bisa jika buku sedang dipinjam)
        // Atau cek apakah member sudah mereservasi item ini
        $existingReservation = Reservation::where('member_id', $member->member_id)
                                        ->where('item_code', $request->item_code)
                                        ->first();

        if ($existingReservation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah mereservasi buku ini.'
            ], 400);
        }

        $reservation = Reservation::create([
            'member_id' => $member->member_id,
            'item_code' => $request->item_code,
            'reserve_date' => now()->format('Y-m-d'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil dibuat.',
            'data' => $reservation
        ], 201);
    }
}

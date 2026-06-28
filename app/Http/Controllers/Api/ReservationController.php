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
        $query = Biblio::with(['authors', 'publisher']);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $books = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    // Mengambil detail buku beserta ketersediaan eksemplar (item)
    public function show($id)
    {
        $book = Biblio::with(['authors', 'publisher', 'items'])->find($id);

        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        // Hitung ketersediaan
        $totalItems = $book->items->count();
        
        $itemCodes = $book->items->pluck('item_code')->toArray();
        $borrowedItemCodes = \DB::table('loan')
                                ->whereIn('item_code', $itemCodes)
                                ->where('is_return', 0)
                                ->pluck('item_code')
                                ->toArray();
                                
        $availableItems = $book->items->filter(function($item) use ($borrowedItemCodes) {
            return !in_array($item->item_code, $borrowedItemCodes);
        });

        $book->total_items = $totalItems;
        $book->available_items_count = $availableItems->count();

        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    // Melakukan reservasi buku berdasarkan biblio_id
    public function store(Request $request)
    {
        $request->validate([
            'biblio_id' => 'required|exists:biblio,biblio_id',
        ]);

        $member = $request->user();

        // Cek Loan Limit (Batas Peminjaman)
        $memberModel = \App\Models\Member::with('memberType')->find($member->member_id);
        $loanLimit = $memberModel->memberType->loan_limit ?? 3;
        $activeLoansCount = \App\Models\Loan::where('member_id', $member->member_id)->where('is_return', 0)->count();

        if ($activeLoansCount >= $loanLimit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maksimal peminjaman tercapai. Anda sudah meminjam ' . $activeLoansCount . ' dari batas maksimal ' . $loanLimit . ' buku. Kembalikan buku terlebih dahulu untuk melakukan reservasi.'
            ], 400);
        }

        // Cek Reservation Limit (Batas Reservasi)
        $max_reservations = \Illuminate\Support\Facades\DB::table('setting')
            ->where('setting_name', 'max_reservations')
            ->value('setting_value') ?? 2;

        $activeReservationsCount = \App\Models\Reservation::where('member_id', $member->member_id)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeReservationsCount >= $max_reservations) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda telah mencapai batas maksimal reservasi (' . $max_reservations . ' buku).'
            ], 400);
        }

        // Cari item yang tersedia dari biblio ini
        $biblio = Biblio::with('items')->find($request->biblio_id);
        $itemCodes = $biblio->items->pluck('item_code')->toArray();
        $borrowedItemCodes = \DB::table('loan')
                                ->whereIn('item_code', $itemCodes)
                                ->where('is_return', 0)
                                ->pluck('item_code')
                                ->toArray();
        
        $reservedItemCodes = \DB::table('reservation')
                                ->whereIn('item_code', $itemCodes)
                                ->whereIn('status', ['pending', 'approved'])
                                ->pluck('item_code')
                                ->toArray();
                                
        $availableItem = $biblio->items->filter(function($item) use ($borrowedItemCodes, $reservedItemCodes) {
            $isNoLoan = optional($item->status)->no_loan;
            return !in_array($item->item_code, $borrowedItemCodes) && !in_array($item->item_code, $reservedItemCodes) && !$isNoLoan;
        })->first();

        if (!$availableItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf, buku ini tidak tersedia untuk direservasi.'
            ], 400);
        }

        // Cek apakah member sudah mereservasi judul ini (biblio_id)
        $existingReservation = Reservation::where('member_id', $member->member_id)
                                        ->where('biblio_id', $request->biblio_id)
                                        ->first();

        if ($existingReservation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah mereservasi buku ini.'
            ], 400);
        }

        $reservation = Reservation::create([
            'member_id' => $member->member_id,
            'biblio_id' => $request->biblio_id,
            'item_code' => $availableItem->item_code,
            'reserve_date' => now()->format('Y-m-d'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil dibuat.',
            'data' => $reservation
        ], 201);
    }
}

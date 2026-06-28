<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biblio;

class OpacController extends Controller
{
    public function index(Request $request)
    {
        $query = Biblio::query();

        if ($request->has('keywords')) {
            $query->where('title', 'like', '%' . $request->keywords . '%');
        }

        if ($request->has('type') && $request->type == 'fisik') {
            $query->where(function($q) {
                $q->whereNull('file_att')->orWhere('file_att', '');
            });
        } elseif ($request->has('type') && $request->type == 'digital') {
            $query->whereNotNull('file_att')->where('file_att', '!=', '');
        }

        // Filter out hidden opac items
        $query->where('opac_hide', 0);

        $biblios = $query->with(['publisher', 'authors'])
            ->orderBy('last_update', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('opac.index', compact('biblios'));
    }

    public function show($id)
    {
        $biblio = Biblio::with(['publisher', 'authors', 'topics', 'items.status'])
            ->findOrFail($id);

        return view('opac.show', compact('biblio'));
    }

    public function downloadDigital($id)
    {
        if (!\Illuminate\Support\Facades\Auth::guard('member')->check()) {
            return redirect()->route('member.login')->withErrors(['member_id' => 'Anda harus login sebagai member untuk mengunduh file digital.']);
        }

        $biblio = Biblio::findOrFail($id);

        if (!$biblio->file_att) {
            abort(404, 'File digital tidak ditemukan.');
        }

        // If it's a URL, redirect to it
        if (\str_starts_with($biblio->file_att, 'http')) {
            return redirect($biblio->file_att);
        }

        // Otherwise serve the file from storage
        $path = 'books/' . $biblio->file_att;
        if (!\Illuminate\Support\Facades\Storage::exists($path)) {
            abort(404, 'File digital tidak ditemukan di server.');
        }

        return \Illuminate\Support\Facades\Storage::download($path);
    }

    public function reserve(Request $request, $biblio_id)
    {
        $biblio = Biblio::findOrFail($biblio_id);
        
        if (!$biblio->is_reservable) {
            return back()->withErrors(['Buku ini tidak tersedia untuk reservasi.']);
        }

        $availableItem = null;
        foreach ($biblio->items as $item) {
            $isOnLoan = \App\Models\Loan::where('item_code', $item->item_code)
                                        ->where('is_return', 0)
                                        ->exists();
            $isReserved = \App\Models\Reservation::where('item_code', $item->item_code)
                                        ->whereIn('status', ['pending', 'approved'])
                                        ->exists();
            $isNoLoan = optional($item->status)->no_loan;
            
            if (!$isOnLoan && !$isReserved && !$isNoLoan) {
                $availableItem = $item;
                break;
            }
        }

        if (!$availableItem) {
            return back()->withErrors(['Mohon maaf, semua eksemplar buku ini sedang dipinjam atau sudah direservasi orang lain.']);
        }

        $existing = \App\Models\Reservation::where('member_id', \Illuminate\Support\Facades\Auth::guard('member')->id())
                        ->where('biblio_id', $biblio_id)
                        ->whereIn('status', ['pending', 'approved'])
                        ->first();
        if ($existing) {
             return back()->withErrors(['Anda sudah melakukan reservasi untuk buku ini.']);
        }

        $memberId = \Illuminate\Support\Facades\Auth::guard('member')->id();
        $member = \App\Models\Member::with('memberType')->find($memberId);
        $loanLimit = $member->memberType->loan_limit ?? 3;
        $activeLoansCount = \App\Models\Loan::where('member_id', $memberId)->where('is_return', 0)->count();

        if ($activeLoansCount >= $loanLimit) {
            return back()->withErrors(['Maksimal peminjaman tercapai. Anda sudah meminjam ' . $activeLoansCount . ' dari batas maksimal ' . $loanLimit . ' buku. Kembalikan buku terlebih dahulu untuk melakukan reservasi.']);
        }

        $max_reservations = \Illuminate\Support\Facades\DB::table('setting')
            ->where('setting_name', 'max_reservations')
            ->value('setting_value') ?? 2;

        $activeCount = \App\Models\Reservation::where('member_id', \Illuminate\Support\Facades\Auth::guard('member')->id())
                        ->whereIn('status', ['pending', 'approved'])
                        ->count();

        if ($activeCount >= $max_reservations) {
             return back()->withErrors(['Anda telah mencapai batas maksimal reservasi (' . $max_reservations . ' buku).']);
        }

        $reservation = new \App\Models\Reservation();
        $reservation->member_id = \Illuminate\Support\Facades\Auth::guard('member')->id();
        $reservation->biblio_id = $biblio_id;
        $reservation->item_code = $availableItem->item_code;
        $reservation->reserve_date = now();
        $reservation->status = 'pending';
        $reservation->save();

        return back()->with('success', 'Reservasi berhasil dibuat. Silakan tunggu persetujuan admin.');
    }
}

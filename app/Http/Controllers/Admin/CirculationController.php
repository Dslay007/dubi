<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Item;
use App\Models\Loan;
use Carbon\Carbon;
use App\Helpers\SystemLog;

class CirculationController extends Controller
{
    public function index()
    {
        return view('admin.circulation.index');
    }

    public function start(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:member,member_id'
        ]);

        return redirect()->route('admin.circulation.transaction', $request->member_id);
    }

    public function searchMember(Request $request)
    {
        $q = $request->q;
        if (!$q) return response()->json([]);

        $members = Member::where('member_name', 'like', "%{$q}%")
            ->orWhere('member_id', 'like', "%{$q}%")
            ->limit(10)
            ->get(['member_id', 'member_name']);

        return response()->json($members);
    }

    public function transaction($member_id)
    {
        $member = Member::findOrFail($member_id);
        
        // Active loans for this member
        $loans = Loan::where('member_id', $member_id)
            ->where('is_return', 0)
            ->with(['item.biblio'])
            ->get();

        return view('admin.circulation.transaction', compact('member', 'loans'));
    }

    public function storeLoan(Request $request, $member_id)
    {
        $request->validate([
            'item_code' => 'required|exists:item,item_code'
        ]);

        $member = Member::with('memberType')->findOrFail($member_id);
        if (empty($member->member_email) || empty($member->member_phone)) {
            return back()->withErrors(['item_code' => 'Peminjaman Gagal: Nomor telepon dan email anggota harus diisi terlebih dahulu. Silakan lengkapi data anggota.']);
        }

        // Cek Batas Pinjaman (Loan Limit)
        $loanLimit = $member->memberType->loan_limit ?? 2;
        $activeLoansCount = Loan::where('member_id', $member_id)->where('is_return', 0)->count();

        if ($activeLoansCount >= $loanLimit) {
            return back()->withErrors(['item_code' => 'Peminjaman Gagal: Anggota telah mencapai batas maksimal peminjaman (' . $loanLimit . ' eksemplar).']);
        }

        $item = Item::where('item_code', $request->item_code)->first();

        // Check availability
        $activeLoan = Loan::where('item_code', $request->item_code)->where('is_return', 0)->first();
        if ($activeLoan) {
            return back()->withErrors(['item_code' => 'Item is currently on loan to ' . $activeLoan->member_id]);
        }

        // Dapatkan Lama Pinjaman (Loan Tenure)
        $loanTenure = $member->memberType->loan_tenure ?? 7;

        // Create Loan
        $loan = new Loan();
        $loan->item_code = $request->item_code;
        $loan->member_id = $member_id;
        $loan->loan_date = now()->toDateString();
        $loan->due_date = Carbon::now()->addDays($loanTenure)->toDateString();
        $loan->is_return = 0;
        $loan->input_date = now();
        $loan->last_update = now();
        $loan->save();

        SystemLog::write('insert', 'Peminjaman Eksemplar: ' . $request->item_code . ' oleh ' . $member_id, 'Circulation', 'Loan');

        return back()->with('success', 'Item loaned successfully.');
    }

    public function returnLoan($loan_id)
    {
        $loan = Loan::findOrFail($loan_id);
        $loan->is_return = 1;
        $loan->return_date = now()->toDateString();
        $loan->last_update = now();
        $loan->save();

        SystemLog::write('update', 'Pengembalian Eksemplar: ' . $loan->item_code . ' oleh ' . $loan->member_id, 'Circulation', 'Return');

        return back()->with('success', 'Item returned successfully.');
    }

    public function extendLoan($loan_id)
    {
        $loan = Loan::findOrFail($loan_id);
        
        // Cannot extend if already returned
        if ($loan->is_return) {
            return back()->withErrors(['extend' => 'Cannot extend an item that is already returned.']);
        }

        // Extend by 7 days from the CURRENT due_date (or from now if past due)
        $currentDueDate = \Carbon\Carbon::parse($loan->due_date);
        if ($currentDueDate->isPast()) {
            $loan->due_date = now()->addDays(7)->toDateString();
        } else {
            $loan->due_date = $currentDueDate->addDays(7)->toDateString();
        }
        
        $loan->last_update = now();
        $loan->save();

        SystemLog::write('update', 'Perpanjangan Eksemplar: ' . $loan->item_code . ' oleh ' . $loan->member_id, 'Circulation', 'Extend');

        return back()->with('success', 'Loan extended for 7 days successfully.');
    }

    public function quickReturn()
    {
        // View for Quick Return (Pop up / Scan form)
        return view('admin.circulation.quick_return');
    }

    public function history(Request $request)
    {
        $query = Loan::with(['member', 'item.biblio', 'loanHistory']);

        if ($request->has('q') && $request->q != '') {
            $q = $request->q;
            $query->whereHas('member', function($sub) use ($q) {
                $sub->where('member_name', 'like', "%{$q}%")
                    ->orWhere('member_id', 'like', "%{$q}%");
            })->orWhereHas('item.biblio', function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%");
            })->orWhere('item_code', 'like', "%{$q}%");
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'returned') {
                $query->where('is_return', 1);
            } elseif ($request->status == 'active') {
                $query->where('is_return', 0);
            }
        }

        if ($request->has('date_start') && $request->date_start != '') {
            $query->whereDate('loan_date', '>=', $request->date_start);
        }

        if ($request->has('date_end') && $request->date_end != '') {
            $query->whereDate('loan_date', '<=', $request->date_end);
        }

        $loans = $query->orderBy('loan_date', 'desc')->paginate(20)->withQueryString();
            
        return view('admin.circulation.history', compact('loans'));
    }

    public function exportHistory(Request $request)
    {
        $query = Loan::with(['member', 'item.biblio']);

        if ($request->has('q') && $request->q != '') {
            $q = $request->q;
            $query->whereHas('member', function($sub) use ($q) {
                $sub->where('member_name', 'like', "%{$q}%")
                    ->orWhere('member_id', 'like', "%{$q}%");
            })->orWhereHas('item.biblio', function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%");
            })->orWhere('item_code', 'like', "%{$q}%");
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'returned') {
                $query->where('is_return', 1);
            } elseif ($request->status == 'active') {
                $query->where('is_return', 0);
            }
        }

        if ($request->has('date_start') && $request->date_start != '') {
            $query->whereDate('loan_date', '>=', $request->date_start);
        }

        if ($request->has('date_end') && $request->date_end != '') {
            $query->whereDate('loan_date', '<=', $request->date_end);
        }

        $loans = $query->orderBy('loan_date', 'desc')->get();

        $filename = "sejarah_peminjaman_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($loans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Transaksi', 'ID Member', 'Nama Member', 'Kode Eksemplar', 'Judul Buku', 'Tgl Pinjam', 'Tgl Kembali', 'Batas Kembali', 'Status']);

            foreach ($loans as $loan) {
                $status = $loan->is_return ? 'Sudah Kembali' : 'Sedang Dipinjam';
                fputcsv($file, [
                    $loan->loan_id,
                    $loan->member_id,
                    $loan->member->member_name ?? '-',
                    $loan->item_code,
                    $loan->item->biblio->title ?? '-',
                    $loan->loan_date,
                    $loan->return_date ?? '-',
                    $loan->due_date,
                    $status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function overdue(Request $request)
    {
        // Peringatan jatuh tempo / Daftar Keterlambatan
        $query = Loan::with(['member.memberType', 'item.biblio'])
            ->where('is_return', 0)
            ->where('due_date', '<', now()->toDateString());

        // Filter by Member Name or ID
        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->whereHas('member', function($sub) use ($q) {
                $sub->where('member_name', 'like', "%{$q}%")
                    ->orWhere('member_id', 'like', "%{$q}%");
            });
        }

        $loans = $query->orderBy('due_date', 'asc')->paginate(20);

        return view('admin.circulation.overdue', compact('loans'));
    }

    public function notifyOverdue($loan_id)
    {
        $loan = Loan::with(['member.memberType', 'item.biblio'])->findOrFail($loan_id);
        
        if (empty($loan->member->member_email)) {
            return back()->with('error', 'Gagal: Anggota tidak memiliki alamat email.');
        }

        $daysOverdue = max(0, \Carbon\Carbon::parse($loan->due_date)->diffInDays(now(), false));
        $finePerDay = $loan->member->memberType->fine_each_day ?? 1000;
        $fines = $daysOverdue * $finePerDay;
        $formattedFines = "Rp " . number_format($fines, 0, ',', '.');
        $title = $loan->item->biblio->title ?? 'Buku Tidak Diketahui';
        $memberName = $loan->member->member_name;

        $messageText = "Halo {$memberName},\n\n" .
            "Kami dari Dudukbaca ingin mengingatkan bahwa Anda memiliki keterlambatan pengembalian buku:\n\n" .
            "Judul: {$title}\n" .
            "Terlambat: {$daysOverdue} Hari\n" .
            "Estimasi Denda: {$formattedFines}\n\n" .
            "Mohon segera mengembalikan buku tersebut untuk menghindari bertambahnya denda. Terima kasih.";

        try {
            \Illuminate\Support\Facades\Mail::raw($messageText, function($message) use ($loan) {
                $message->to($loan->member->member_email)
                        ->subject('Peringatan Keterlambatan Pengembalian Buku');
            });
            return back()->with('success', 'Email Peringatan berhasil dikirim ke ' . $loan->member->member_email);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email! Pastikan SMTP Gmail di file .env sudah diatur. (Detail: ' . $e->getMessage() . ')');
        }
    }
    
    public function reservations()
    {
        $pending = \App\Models\Reservation::with(['member', 'item.biblio'])
            ->where('status', 'pending')
            ->orderBy('reserve_date', 'desc')
            ->get();

        $approved = \App\Models\Reservation::with(['member', 'item.biblio'])
            ->where('status', 'approved')
            ->orderBy('reserve_date', 'desc')
            ->get();

        $history = \App\Models\Reservation::with(['member', 'item.biblio'])
            ->orderBy('reserve_date', 'desc')
            ->paginate(15);

        return view('admin.circulation.reservations', compact('pending', 'approved', 'history'));
    }

    public function approveReservation($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        
        // Cek apakah item sudah dipinjam
        $activeLoan = Loan::where('item_code', $reservation->item_code)->where('is_return', 0)->first();
        if ($activeLoan) {
            return back()->withErrors(['Item ini sedang dipinjam oleh member lain.']);
        }

        $reservation->status = 'approved';
        $reservation->save();

        SystemLog::write('update', 'Menyetujui Reservasi: ' . $reservation->item_code . ' oleh ' . $reservation->member_id, 'Circulation', 'Reservation');

        return back()->with('success', 'Reservasi berhasil disetujui (Buku Siap Diambil).');
    }

    public function handoverReservation($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        
        // Cek kembali apakah item sudah dipinjam
        $activeLoan = Loan::where('item_code', $reservation->item_code)->where('is_return', 0)->first();
        if ($activeLoan) {
            return back()->withErrors(['Item ini sedang dipinjam oleh member lain.']);
        }

        // Buat data peminjaman (Transaksi)
        $loan = new Loan();
        $loan->item_code = $reservation->item_code;
        $loan->member_id = $reservation->member_id;
        $loan->loan_date = now()->toDateString();
        $loan->due_date = \Carbon\Carbon::now()->addDays(7)->toDateString(); // Default 7 hari
        $loan->is_return = 0;
        $loan->input_date = now();
        $loan->last_update = now();
        $loan->save();

        // Update status reservasi menjadi completed
        $reservation->status = 'completed';
        $reservation->save();

        SystemLog::write('update', 'Penyerahan Buku Reservasi: ' . $reservation->item_code . ' ke ' . $reservation->member_id, 'Circulation', 'Reservation');

        return back()->with('success', 'Buku telah diserahkan dan transaksi peminjaman berhasil dibuat.');
    }
        
    public function rejectReservation(Request $request, $id)
    {
        $request->validate(['notes' => 'required|string']);
        
        $reservation = \App\Models\Reservation::findOrFail($id);
        $reservation->status = 'rejected';
        $reservation->notes = $request->notes;
        $reservation->save();

        SystemLog::write('update', 'Menolak Reservasi: ' . $reservation->item_code . ' oleh ' . $reservation->member_id, 'Circulation', 'Reservation');

        return back()->with('success', 'Reservasi ditolak dengan keterangan.');
    }

    public function cancelReservation(Request $request, $id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        
        // Status can only be cancelled if it's currently approved or pending
        if (!in_array($reservation->status, ['pending', 'approved'])) {
            return back()->withErrors(['Hanya reservasi aktif yang dapat dibatalkan.']);
        }

        $reservation->status = 'cancelled';
        if ($request->has('notes') && !empty($request->notes)) {
            $reservation->notes = $request->notes;
        } else {
            $reservation->notes = 'Dibatalkan admin.';
        }
        $reservation->save();

        SystemLog::write('update', 'Membatalkan Reservasi: ' . $reservation->item_code . ' oleh ' . $reservation->member_id, 'Circulation', 'Reservation');

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function searchBiblio(Request $request)
    {
        $q = $request->q;
        if (!$q) return response()->json([]);

        $biblios = \App\Models\Biblio::where('is_reservable', 1)
            ->where(function($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('isbn_issn', 'like', "%{$q}%");
            })
            ->with('items')
            ->limit(10)
            ->get();

        $results = [];
        foreach ($biblios as $biblio) {
            $totalCopies = $biblio->items->count();
            $availableCopies = 0;

            foreach ($biblio->items as $item) {
                $isOnLoan = \App\Models\Loan::where('item_code', $item->item_code)
                                            ->where('is_return', 0)
                                            ->exists();
                $isReserved = \App\Models\Reservation::where('item_code', $item->item_code)
                                            ->whereIn('status', ['pending', 'approved'])
                                            ->exists();
                if (!$isOnLoan && !$isReserved) {
                    $availableCopies++;
                }
            }

            // Skip books where all copies are on loan or reserved
            if ($availableCopies <= 0) continue;

            $results[] = [
                'biblio_id' => $biblio->biblio_id,
                'title' => $biblio->title,
                'isbn_issn' => $biblio->isbn_issn,
                'available' => $availableCopies,
                'total' => $totalCopies,
            ];
        }

        return response()->json($results);
    }

    public function storeReservation(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:member,member_id',
            'biblio_ids' => 'required|array|min:1',
            'biblio_ids.*' => 'exists:biblio,biblio_id'
        ]);

        $memberModel = \App\Models\Member::with('memberType')->find($request->member_id);
        $max_reservations = $memberModel->memberType->reservation_limit ?? 2;

        $activeCount = \App\Models\Reservation::where('member_id', $request->member_id)
                        ->whereIn('status', ['pending', 'approved'])
                        ->count();

        $requestedCount = count($request->biblio_ids);

        if (($activeCount + $requestedCount) > $max_reservations) {
             return back()->withErrors(['Batas maksimal reservasi member ini akan terlampaui. (Sisa kuota: ' . max(0, $max_reservations - $activeCount) . ')']);
        }

        $successCount = 0;
        $failedCount = 0;
        foreach ($request->biblio_ids as $biblio_id) {
            $biblio = \App\Models\Biblio::find($biblio_id);
            
            $availableItem = null;
            foreach ($biblio->items as $item) {
                $isOnLoan = \App\Models\Loan::where('item_code', $item->item_code)
                                            ->where('is_return', 0)
                                            ->exists();
                $isReserved = \App\Models\Reservation::where('item_code', $item->item_code)
                                            ->whereIn('status', ['pending', 'approved'])
                                            ->exists();
                if (!$isOnLoan && !$isReserved) {
                    $availableItem = $item;
                    break;
                }
            }
            
            if (!$availableItem) {
                $failedCount++;
                continue;
            }

            $existing = \App\Models\Reservation::where('member_id', $request->member_id)
                            ->where('biblio_id', $biblio_id)
                            ->whereIn('status', ['pending', 'approved'])
                            ->first();
            
            if ($existing) continue;

            $reservation = new \App\Models\Reservation();
            $reservation->member_id = $request->member_id;
            $reservation->biblio_id = $biblio_id;
            $reservation->item_code = $availableItem->item_code;
            $reservation->reserve_date = now();
            $reservation->status = 'approved'; // Otomatis disetujui karena admin yang input
            $reservation->save();
            $successCount++;
        }

        if ($failedCount > 0) {
            SystemLog::write('insert', "Menambah $successCount Reservasi Buku untuk member $request->member_id ($failedCount gagal)", 'Circulation', 'Reservation');
            return back()->with('success', "Berhasil menambahkan $successCount reservasi. $failedCount buku gagal direservasi karena sedang dipinjam atau sudah direservasi orang lain.");
        }

        SystemLog::write('insert', "Menambah $successCount Reservasi Buku untuk member $request->member_id", 'Circulation', 'Reservation');
        return back()->with('success', "Berhasil menambahkan $successCount reservasi untuk member {$request->member_id}.");
    }

    public function getLoanDetails(Request $request) 
    {
        $request->validate(['item_code' => 'required']);
        
        $loan = Loan::with(['member', 'item.biblio'])
            ->where('item_code', $request->item_code)
            ->where('is_return', 0)
            ->first();

        if (!$loan) {
            return response()->json(['success' => false, 'message' => 'Item not found in active loans.']);
        }

        $dueDate = Carbon::parse($loan->due_date);
        $daysOverdue = max(0, (int) $dueDate->startOfDay()->diffInDays(now()->startOfDay(), false));
        // Calculate fines (assuming 1000 per day or fetching from member type rule)
        // For simple start: 1000 per day
        $fines = $daysOverdue * 1000;

        return response()->json([
            'success' => true,
            'loan' => [
                'loan_id' => $loan->loan_id,
                'item_code' => $loan->item_code,
                'title' => $loan->item->biblio->title ?? 'Unknown Title',
                'member_id' => $loan->member_id,
                'member_name' => $loan->member->member_name ?? 'Unknown',
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'overdue_days' => $daysOverdue,
                'fines' => $fines
            ]
        ]);
    }
    
    public function searchLoan(Request $request)
    {
        $q = $request->q;
        if (!$q) return response()->json([]);

        $loans = Loan::with(['item.biblio'])->where('is_return', 0)
            ->whereHas('item', function($query) use ($q) {
                $query->where('item_code', 'like', "%{$q}%")
                      ->orWhereHas('biblio', function($q2) use ($q) {
                          $q2->where('title', 'like', "%{$q}%");
                      });
            })
            ->limit(10)
            ->get();

        $results = [];
        foreach($loans as $loan) {
            $results[] = [
                'item_code' => $loan->item_code,
                'title' => $loan->item->biblio->title ?? 'Unknown',
                'member_name' => $loan->member->member_name ?? 'Unknown',
            ];
        }

        return response()->json($results);
    }

    public function searchItem(Request $request)
    {
        $q = $request->q;
        if (!$q) return response()->json([]);

        $items = Item::with('biblio')
            ->where('item_code', 'like', "%{$q}%")
            ->orWhereHas('biblio', function($query) use ($q) {
                $query->where('title', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get();

        $results = [];
        foreach($items as $item) {
            $isOnLoan = Loan::where('item_code', $item->item_code)->where('is_return', 0)->exists();
            $results[] = [
                'item_code' => $item->item_code,
                'title' => $item->biblio->title ?? 'Unknown Title',
                'is_available' => !$isOnLoan
            ];
        }

        return response()->json($results);
    }

    public function getItemDetails(Request $request)
    {
        $request->validate(['item_code' => 'required']);

        $item = Item::with('biblio')->where('item_code', $request->item_code)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.']);
        }

        // Check if item is already loaned
        $activeLoan = Loan::where('item_code', $request->item_code)->where('is_return', 0)->first();
        if ($activeLoan) {
            return response()->json(['success' => false, 'message' => 'Item sudah dipinjam oleh member ID: ' . $activeLoan->member_id]);
        }

        return response()->json([
            'success' => true,
            'item' => [
                'item_code' => $item->item_code,
                'title' => $item->biblio->title ?? 'Unknown Title',
            ]
        ]);
    }
    
    // Existing rules method...
    public function rules()
    {
        $memberTypes = \App\Models\MemberType::latest('last_update')->get();
        return view('admin.circulation.rules', compact('memberTypes'));
    }
}

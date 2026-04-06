<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Item;
use App\Models\Loan;
use Carbon\Carbon;

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

        $item = Item::where('item_code', $request->item_code)->first();

        // Check availability
        $activeLoan = Loan::where('item_code', $request->item_code)->where('is_return', 0)->first();
        if ($activeLoan) {
            return back()->withErrors(['item_code' => 'Item is currently on loan to ' . $activeLoan->member_id]);
        }

        // Create Loan
        $loan = new Loan();
        $loan->item_code = $request->item_code;
        $loan->member_id = $member_id;
        $loan->loan_date = now()->toDateString();
        // Default 7 days loan
        $loan->due_date = Carbon::now()->addDays(7)->toDateString();
        $loan->is_return = 0;
        $loan->input_date = now();
        $loan->last_update = now();
        $loan->save();

        return back()->with('success', 'Item loaned successfully.');
    }

    public function returnLoan($loan_id)
    {
        $loan = Loan::findOrFail($loan_id);
        $loan->is_return = 1;
        $loan->return_date = now()->toDateString();
        $loan->last_update = now();
        $loan->save();

        return back()->with('success', 'Item returned successfully.');
    }

    public function quickReturn()
    {
        // View for Quick Return (Pop up / Scan form)
        return view('admin.circulation.quick_return');
    }

    public function history()
    {
        // Sejarah Peminjaman: Detail with Member, Book, Code, Status
        $loans = Loan::with(['member', 'item.biblio'])
            ->orderBy('loan_date', 'desc')
            ->paginate(20);
            
        return view('admin.circulation.history', compact('loans'));
    }

    public function overdue(Request $request)
    {
        // Peringatan jatuh tempo / Daftar Keterlambatan
        $query = Loan::with(['member', 'item.biblio'])
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
        $loan = Loan::with('member')->findOrFail($loan_id);
        
        // TODO: Implement actual Email logic here using Mail::to()...
        // For now simulate success
        
        return back()->with('success', 'Notification email sent to ' . $loan->member->member_email);
    }
    
    public function reservations()
    {
        // Tabel khusus Reservasi
        $reservations = \App\Models\Reservation::with(['member', 'item.biblio'])
            ->where('is_active', true)
            ->latest('reservation_date')
            ->paginate(10);

        return view('admin.circulation.reservations', compact('reservations'));
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
        $daysOverdue = MAX(0, $dueDate->diffInDays(now(), false));
        // Calculate fines (assuming 1000 per day or fetching from member type rule)
        // For simple start: 1000 per day
        $fines = $daysOverdue * 1000;

        return response()->json([
            'success' => true,
            'loan' => [
                'loan_id' => $loan->loan_id,
                'item_code' => $loan->item_code,
                'title' => $loan->item->biblio->title ?? 'Unknown',
                'member_id' => $loan->member_id,
                'member_name' => $loan->member->member_name,
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'overdue_days' => $daysOverdue,
                'fines' => number_format($fines, 0, ',', '.')
            ]
        ]);
    }
    
    // Existing rules method...
    public function rules()
    {
        // Aturan Peminjaman is effectively Member Type Management
        return redirect()->route('admin.member_type.index');
    }
}

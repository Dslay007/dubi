<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biblio;
use App\Models\Member;
use App\Models\Loan;
use App\Models\VisitorCount;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        
        // 1. Basic Stats
        $totalBiblio = Biblio::count();
        $totalMember = Member::count();
        $activeLoans = Loan::where('is_return', 0)->count();
        $overdueLoans = Loan::where('is_return', 0)->where('due_date', '<', Carbon::today())->count();
        
        // Pengunjung hari ini
        $today = Carbon::today()->toDateString();
        $guestVisitsToday = VisitorCount::whereDate('checkin_date', $today)->count();
        $loanVisitsToday = Loan::whereDate('loan_date', $today)->distinct('member_id')->count('member_id');
        $visitorToday = $guestVisitsToday + $loanVisitsToday; 

        // 2. Chart Data: 7 Hari Terakhir
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }

        $loanChartData = [];
        $visitorChartData = [];

        foreach ($dates as $date) {
            $loanCount = Loan::whereDate('loan_date', $date)->count();
            $loanChartData[] = $loanCount;

            $vCount = VisitorCount::whereDate('checkin_date', $date)->count();
            $lCount = Loan::whereDate('loan_date', $date)->distinct('member_id')->count('member_id');
            $visitorChartData[] = $vCount + $lCount;
        }
        
        $chartLabels = $dates->map(function($date) {
            return Carbon::parse($date)->isoFormat('D MMM');
        })->toArray();

        // 3. 5 Peminjaman Terbaru
        $recentLoans = Loan::with(['member', 'item.biblio'])
            ->orderBy('loan_date', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'user', 'totalBiblio', 'totalMember', 'activeLoans', 'overdueLoans', 'visitorToday',
            'chartLabels', 'loanChartData', 'visitorChartData', 'recentLoans'
        ));
    }
}

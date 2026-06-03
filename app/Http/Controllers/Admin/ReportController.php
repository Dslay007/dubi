<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Laporan Ketua (Executive Summary)
     */
    public function laporanKetua()
    {
        // 1. Data Koleksi
        $totalBiblio = DB::table('biblio')->count();
        $totalItem = DB::table('item')->count();
        
        // 2. Data Anggota
        $totalMember = DB::table('member')->count();
        $activeMember = DB::table('member')->where('is_pending', 0)->count();
        
        // 3. Data Kunjungan
        $totalVisitor = DB::table('visitor_count')->count();
        $visitorBulanIni = DB::table('visitor_count')
            ->whereYear('checkin_date', Carbon::now()->year)
            ->whereMonth('checkin_date', Carbon::now()->month)
            ->count();
            
        // 4. Data Transaksi Peminjaman
        $totalLoan = DB::table('loan')->count();
        $loanBulanIni = DB::table('loan')
            ->whereYear('loan_date', Carbon::now()->year)
            ->whereMonth('loan_date', Carbon::now()->month)
            ->count();
            
        $activeLoan = DB::table('loan')->where('is_return', 0)->count();
            
        // 5. Data Keuangan / Denda
        $totalDenda = DB::table('fines')->sum('debet') ?? 0;
        $totalBayar = DB::table('fines')->sum('credit') ?? 0;
        $totalTunggakan = $totalDenda - $totalBayar;

        // 6. Koleksi Paling Sering Dipinjam
        $topBooks = DB::table('loan')
            ->join('item', 'loan.item_code', '=', 'item.item_code')
            ->join('biblio', 'item.biblio_id', '=', 'biblio.biblio_id')
            ->select('biblio.title', DB::raw('COUNT(*) as total'))
            ->groupBy('biblio.title')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 7. Tren 12 Bulan Terakhir (Kunjungan vs Peminjaman)
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $yearMonth = $month->format('Y-m');
            $label = $month->translatedFormat('M Y');
            
            $visitorCount = DB::table('visitor_count')
                ->where(DB::raw("DATE_FORMAT(checkin_date, '%Y-%m')"), $yearMonth)
                ->count();
                
            $loanCount = DB::table('loan')
                ->where(DB::raw("DATE_FORMAT(loan_date, '%Y-%m')"), $yearMonth)
                ->count();
                
            $chartData[] = [
                'label' => $label,
                'visitor' => $visitorCount,
                'loan' => $loanCount
            ];
        }

        return view('admin.pelaporan.laporan_ketua', compact(
            'totalBiblio', 'totalItem', 'totalMember', 'activeMember',
            'totalVisitor', 'visitorBulanIni', 'totalLoan', 'loanBulanIni',
            'activeLoan', 'totalTunggakan', 'topBooks', 'chartData'
        ));
    }

    /**
     * Statistik Koleksi
     */
    public function statistikKoleksi()
    {
        $totalBiblio = DB::table('biblio')->count();
        $totalItem = DB::table('item')->count();

        $perGmd = DB::table('biblio')
            ->leftJoin('mst_gmd', 'biblio.gmd_id', '=', 'mst_gmd.gmd_id')
            ->select('mst_gmd.gmd_name', DB::raw('COUNT(*) as total'))
            ->groupBy('mst_gmd.gmd_name')
            ->orderByDesc('total')
            ->get();

        $perCollType = DB::table('item')
            ->leftJoin('mst_coll_type', 'item.coll_type_id', '=', 'mst_coll_type.coll_type_id')
            ->select('mst_coll_type.coll_type_name', DB::raw('COUNT(*) as total'))
            ->groupBy('mst_coll_type.coll_type_name')
            ->orderByDesc('total')
            ->get();

        $perYear = DB::table('biblio')
            ->select('publish_year', DB::raw('COUNT(*) as total'))
            ->whereNotNull('publish_year')
            ->where('publish_year', '!=', '')
            ->groupBy('publish_year')
            ->orderByDesc('publish_year')
            ->limit(15)
            ->get();

        $recentBiblio = DB::table('biblio')
            ->orderByDesc('input_date')
            ->limit(10)
            ->get();

        return view('admin.pelaporan.statistik_koleksi', compact(
            'totalBiblio', 'totalItem', 'perGmd', 'perCollType', 'perYear', 'recentBiblio'
        ));
    }

    /**
     * Laporan Peminjaman
     */
    public function laporanPeminjaman(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->subMonths(6)->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));

        $totalLoan = DB::table('loan')->count();
        $totalActive = DB::table('loan')->where('is_lent', 1)->where('is_return', 0)->count();
        $totalReturned = DB::table('loan')->where('is_return', 1)->count();
        $totalOverdue = DB::table('loan')
            ->where('is_lent', 1)->where('is_return', 0)
            ->where('due_date', '<', Carbon::now())
            ->count();

        $perMonth = DB::table('loan')
            ->select(DB::raw("DATE_FORMAT(loan_date, '%Y-%m') as bulan"), DB::raw('COUNT(*) as total'))
            ->where('loan_date', '>=', $dateFrom)
            ->where('loan_date', '<=', $dateTo)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $topBooks = DB::table('loan')
            ->join('item', 'loan.item_code', '=', 'item.item_code')
            ->join('biblio', 'item.biblio_id', '=', 'biblio.biblio_id')
            ->select('biblio.title', DB::raw('COUNT(*) as total'))
            ->groupBy('biblio.title')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $recentLoans = DB::table('loan')
            ->leftJoin('member', 'loan.member_id', '=', 'member.member_id')
            ->leftJoin('item', 'loan.item_code', '=', 'item.item_code')
            ->leftJoin('biblio', 'item.biblio_id', '=', 'biblio.biblio_id')
            ->select('loan.*', 'member.member_name', 'biblio.title')
            ->orderByDesc('loan.loan_date')
            ->limit(20)
            ->get();

        return view('admin.pelaporan.laporan_peminjaman', compact(
            'totalLoan', 'totalActive', 'totalReturned', 'totalOverdue',
            'perMonth', 'topBooks', 'recentLoans', 'dateFrom', 'dateTo'
        ));
    }

    /**
     * Laporan Anggota
     */
    public function laporanAnggota(Request $request)
    {
        $totalMember = DB::table('member')->count();
        $totalActive = DB::table('member')->where('expire_date', '>=', Carbon::now())->count();
        $totalExpired = DB::table('member')->where('expire_date', '<', Carbon::now())->count();
        $totalNew = DB::table('member')
            ->where('register_date', '>=', Carbon::now()->subDays(30))
            ->count();

        $perType = DB::table('member')
            ->leftJoin('mst_member_type', 'member.member_type_id', '=', 'mst_member_type.member_type_id')
            ->select('mst_member_type.member_type_name', DB::raw('COUNT(*) as total'))
            ->groupBy('mst_member_type.member_type_name')
            ->orderByDesc('total')
            ->get();

        $regPerMonth = DB::table('member')
            ->select(DB::raw("DATE_FORMAT(register_date, '%Y-%m') as bulan"), DB::raw('COUNT(*) as total'))
            ->where('register_date', '>=', Carbon::now()->subMonths(12))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $genderStats = DB::table('member')
            ->select('gender', DB::raw('COUNT(*) as total'))
            ->groupBy('gender')
            ->get();

        $recentMembers = DB::table('member')
            ->leftJoin('mst_member_type', 'member.member_type_id', '=', 'mst_member_type.member_type_id')
            ->select('member.*', 'mst_member_type.member_type_name')
            ->orderByDesc('register_date')
            ->limit(15)
            ->get();

        return view('admin.pelaporan.laporan_anggota', compact(
            'totalMember', 'totalActive', 'totalExpired', 'totalNew',
            'perType', 'regPerMonth', 'genderStats', 'recentMembers'
        ));
    }

    /**
     * Koleksi Perpustakaan
     */
    public function koleksiPerpustakaan(Request $request)
    {
        $search = $request->input('search');
        $gmd = $request->input('gmd');

        $query = DB::table('biblio')
            ->leftJoin('mst_gmd', 'biblio.gmd_id', '=', 'mst_gmd.gmd_id')
            ->leftJoin('mst_publisher', 'biblio.publisher_id', '=', 'mst_publisher.publisher_id')
            ->select(
                'biblio.biblio_id', 'biblio.title', 'biblio.isbn_issn',
                'biblio.publish_year', 'biblio.call_number', 'biblio.classification',
                'mst_gmd.gmd_name', 'mst_publisher.publisher_name',
                DB::raw('(SELECT COUNT(*) FROM item WHERE item.biblio_id = biblio.biblio_id) as total_items')
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('biblio.title', 'like', "%{$search}%")
                  ->orWhere('biblio.isbn_issn', 'like', "%{$search}%")
                  ->orWhere('biblio.call_number', 'like', "%{$search}%");
            });
        }
        if ($gmd) {
            $query->where('biblio.gmd_id', $gmd);
        }

        $koleksi = $query->orderByDesc('biblio.input_date')->paginate(20);
        $gmdList = DB::table('mst_gmd')->orderBy('gmd_name')->get();

        return view('admin.pelaporan.koleksi_perpustakaan', compact('koleksi', 'search', 'gmd', 'gmdList'));
    }

    /**
     * Data Klasifikasi
     */
    public function dataKlasifikasi(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('biblio')
            ->select('classification', DB::raw('COUNT(*) as total'))
            ->whereNotNull('classification')
            ->where('classification', '!=', '');

        if ($search) {
            $query->where('classification', 'like', "%{$search}%");
        }

        $classifications = $query->groupBy('classification')
            ->orderBy('classification')
            ->paginate(25);

        $topClassifications = DB::table('biblio')
            ->select('classification', DB::raw('COUNT(*) as total'))
            ->whereNotNull('classification')
            ->where('classification', '!=', '')
            ->groupBy('classification')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        return view('admin.pelaporan.data_klasifikasi', compact('classifications', 'topClassifications', 'search'));
    }

    /**
     * Laporan Pengunjung
     */
    public function laporanPengunjung(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->subMonths(3)->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));

        $totalVisitor = DB::table('visitor_count')->count();
        $todayVisitor = DB::table('visitor_count')->whereDate('checkin_date', Carbon::today())->count();
        $thisMonthVisitor = DB::table('visitor_count')
            ->whereMonth('checkin_date', Carbon::now()->month)
            ->whereYear('checkin_date', Carbon::now()->year)
            ->count();

        $perDay = DB::table('visitor_count')
            ->select(DB::raw("DATE(checkin_date) as tgl"), DB::raw('COUNT(*) as total'))
            ->where('checkin_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('tgl')->orderBy('tgl')->get();

        $perMonth = DB::table('visitor_count')
            ->select(DB::raw("DATE_FORMAT(checkin_date, '%Y-%m') as bulan"), DB::raw('COUNT(*) as total'))
            ->where('checkin_date', '>=', $dateFrom)
            ->where('checkin_date', '<=', $dateTo . ' 23:59:59')
            ->groupBy('bulan')->orderBy('bulan')->get();

        $perInstitution = DB::table('visitor_count')
            ->select('institution', DB::raw('COUNT(*) as total'))
            ->whereNotNull('institution')->where('institution', '!=', '')
            ->groupBy('institution')->orderByDesc('total')->limit(10)->get();

        $recentVisitors = DB::table('visitor_count')->orderByDesc('checkin_date')->limit(20)->get();

        return view('admin.pelaporan.laporan_pengunjung', compact(
            'totalVisitor', 'todayVisitor', 'thisMonthVisitor',
            'perDay', 'perMonth', 'perInstitution', 'recentVisitors', 'dateFrom', 'dateTo'
        ));
    }

    /**
     * Laporan Denda
     */
    public function laporanDenda(Request $request)
    {
        $search = $request->input('search');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $totalDebet = DB::table('fines')->sum('debet');
        $totalCredit = DB::table('fines')->sum('credit');
        $totalOutstanding = $totalDebet - $totalCredit;

        $query = DB::table('fines')
            ->leftJoin('member', 'fines.member_id', '=', 'member.member_id')
            ->select('fines.*', 'member.member_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('member.member_name', 'like', "%{$search}%")
                  ->orWhere('fines.member_id', 'like', "%{$search}%");
            });
        }
        if ($dateFrom) $query->where('fines.fines_date', '>=', $dateFrom);
        if ($dateTo) $query->where('fines.fines_date', '<=', $dateTo);

        $fines = $query->orderByDesc('fines.fines_date')->paginate(20);

        $dendaPerMonth = DB::table('fines')
            ->select(
                DB::raw("DATE_FORMAT(fines_date, '%Y-%m') as bulan"),
                DB::raw('SUM(debet) as total_debet'),
                DB::raw('SUM(credit) as total_credit')
            )
            ->where('fines_date', '>=', Carbon::now()->subMonths(12))
            ->groupBy('bulan')->orderBy('bulan')->get();

        return view('admin.pelaporan.laporan_denda', compact(
            'totalDebet', 'totalCredit', 'totalOutstanding',
            'fines', 'dendaPerMonth', 'search', 'dateFrom', 'dateTo'
        ));
    }
}

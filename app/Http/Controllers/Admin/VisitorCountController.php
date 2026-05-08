<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitorCount;

class VisitorCountController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitorCount::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('member_name', 'like', "%{$search}%")
                  ->orWhere('member_id', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
        }
        $visitors = $query->orderBy('checkin_date', 'desc')->paginate(15)->appends($request->all());
        return view('admin.visitor.index', compact('visitors'));
    }

    public function destroy($id)
    {
        VisitorCount::destroy($id);
        return back()->with('success', 'Data pengunjung berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'visitor_log_export_' . date('Y-m-d_H-i') . '.csv';
        $items = VisitorCount::orderBy('checkin_date', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Member ID', 'Member Name', 'Institution', 'Check-in Date'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['ID']  = $item->visitor_id;
                $row['Member ID']    = $item->member_id;
                $row['Member Name']    = $item->member_name;
                $row['Institution']    = $item->institution;
                $row['Check-in Date']    = $item->checkin_date;

                fputcsv($file, array($row['ID'], $row['Member ID'], $row['Member Name'], $row['Institution'], $row['Check-in Date']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemStatus;

class ItemStatusController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemStatus::query();

        if ($request->has('search')) {
            $query->where('item_status_name', 'like', "%{$request->search}%")
                  ->orWhere('item_status_id', 'like', "%{$request->search}%");
        }

        $statuses = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.item_status.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.item_status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_status_id' => 'required|string|max:3|unique:mst_item_status,item_status_id',
            'item_status_name' => 'required|string|max:30',
        ]);

        $status = new ItemStatus();
        $status->item_status_id = $request->item_status_id;
        $status->item_status_name = $request->item_status_name;
        $status->no_loan = 0; // Default allow loan? SLiMS specific logic might differ. 1 = no loan.
        $status->skip_stock_take = 0;
        $status->input_date = now();
        $status->last_update = now();
        $status->save();

        return redirect()->route('admin.item_status.index')->with('success', 'Item Status added successfully.');
    }

    public function edit($id)
    {
        $status = ItemStatus::findOrFail($id);
        return view('admin.item_status.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_status_id' => 'required|string|max:3|unique:mst_item_status,item_status_id,'.$id.',item_status_id',
            'item_status_name' => 'required|string|max:30',
        ]);

        $status = ItemStatus::findOrFail($id);
        $status->item_status_id = $request->item_status_id;
        $status->item_status_name = $request->item_status_name;
        $status->last_update = now();
        $status->save();

        return redirect()->route('admin.item_status.index')->with('success', 'Item Status updated successfully.');
    }

    public function destroy($id)
    {
        $status = ItemStatus::findOrFail($id);
        $status->delete();
        return redirect()->route('admin.item_status.index')->with('success', 'Item Status deleted successfully.');
    }

    public function import()
    {
        return view('admin.item_status.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $csvData = file_get_contents($file);
        
        $separator = strpos($csvData, ';') !== false ? ';' : ',';
        $rows = array_map(function($v) use ($separator) { return str_getcsv($v, $separator); }, explode("\n", $csvData));
        $header = array_shift($rows);

        $successCount = 0;
        foreach ($rows as $row) {
            if (count($row) < 2 || empty(trim($row[0])) || empty(trim($row[1]))) continue;

            $id = substr(trim($row[0]), 0, 3);
            $name = trim($row[1]);
            $no_loan = isset($row[2]) ? (int)trim($row[2]) : 0;
            $skip_stock_take = isset($row[3]) ? (int)trim($row[3]) : 0;

            $data = [
                'item_status_name' => $name,
                'no_loan' => $no_loan,
                'skip_stock_take' => $skip_stock_take,
                'last_update' => now()->toDateString()
            ];

            $existing = ItemStatus::find($id);
            if ($existing) {
                $existing->update($data);
            } else {
                $data['item_status_id'] = $id;
                $data['input_date'] = now()->toDateString();
                ItemStatus::create($data);
            }
            $successCount++;
        }

        return redirect()->route('admin.item_status.index')->with('success', "$successCount data berhasil diimpor.");
    }

    public function export()
    {
        $fileName = 'item_status_export_' . date('Y-m-d_H-i') . '.csv';
        $items = ItemStatus::orderBy('item_status_id', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Status Name', 'No Loan', 'Skip Stock Take'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                fputcsv($file, [$item->item_status_id, $item->item_status_name, $item->no_loan, $item->skip_stock_take], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

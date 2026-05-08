<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $query = Publisher::query();

        if ($request->has('search')) {
            $query->where('publisher_name', 'like', "%{$request->search}%");
        }

        $publishers = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.publisher.index', compact('publishers'));
    }

    public function create()
    {
        return view('admin.publisher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'publisher_name' => 'required|string|max:255',
        ]);

        $publisher = new Publisher();
        $publisher->publisher_name = $request->publisher_name;
        $publisher->input_date = now();
        $publisher->last_update = now();
        $publisher->save();

        return redirect()->route('admin.publisher.index')->with('success', 'Publisher added successfully.');
    }

    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('admin.publisher.edit', compact('publisher'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'publisher_name' => 'required|string|max:255',
        ]);

        $publisher = Publisher::findOrFail($id);
        $publisher->publisher_name = $request->publisher_name;
        $publisher->last_update = now();
        $publisher->save();

        return redirect()->route('admin.publisher.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy($id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->delete();
        return redirect()->route('admin.publisher.index')->with('success', 'Publisher deleted successfully.');
    }

    public function import()
    {
        return view('admin.publisher.import');
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
            if (count($row) < 2 || empty(trim($row[1]))) continue;

            $id = isset($row[0]) && trim($row[0]) !== '' ? trim($row[0]) : null;
            $name = trim($row[1]);

            $data = [
                'publisher_name' => $name,
                'last_update' => now()->toDateString()
            ];

            if ($id) {
                $existing = Publisher::find($id);
                if ($existing) {
                    $existing->update($data);
                } else {
                    $data['publisher_id'] = $id;
                    $data['input_date'] = now()->toDateString();
                    Publisher::create($data);
                }
            } else {
                $data['input_date'] = now()->toDateString();
                Publisher::create($data);
            }
            $successCount++;
        }

        return redirect()->route('admin.publisher.index')->with('success', "$successCount data berhasil diimpor.");
    }

    public function export()
    {
        $fileName = 'publisher_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Publisher::orderBy('publisher_id', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Publisher Name'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                fputcsv($file, [$item->publisher_id, $item->publisher_name], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

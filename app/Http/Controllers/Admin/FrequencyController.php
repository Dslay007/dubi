<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frequency;

class FrequencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Frequency::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('frequency', 'like', "%{$search}%");
        }
        $frequencies = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.frequency.index', compact('frequencies'));
    }

    public function create()
    {
        return view('admin.frequency.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'frequency' => 'required|string|max:25',
            'language_prefix' => 'nullable|string|max:5',
            'time_increment' => 'nullable|integer',
            'time_unit' => 'required|in:day,week,month,year',
        ]);

        $item = new Frequency();
        $item->frequency = $validated['frequency'];
        $item->language_prefix = $validated['language_prefix'];
        $item->time_increment = $validated['time_increment'];
        $item->time_unit = $validated['time_unit'];
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.frequency.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $frequency = Frequency::findOrFail($id);
        return view('admin.frequency.edit', compact('frequency'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'frequency' => 'required|string|max:25',
            'language_prefix' => 'nullable|string|max:5',
            'time_increment' => 'nullable|integer',
            'time_unit' => 'required|in:day,week,month,year',
        ]);

        $item = Frequency::findOrFail($id);
        $item->frequency = $validated['frequency'];
        $item->language_prefix = $validated['language_prefix'];
        $item->time_increment = $validated['time_increment'];
        $item->time_unit = $validated['time_unit'];
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.frequency.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Frequency::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'frequency_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Frequency::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['frequency_id', 'frequency', 'language_prefix', 'time_increment', 'time_unit'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['frequency_id']  = $item->frequency_id;
                $row['frequency']    = $item->frequency;
                $row['language_prefix']    = $item->language_prefix;
                $row['time_increment']    = $item->time_increment;
                $row['time_unit']    = $item->time_unit;

                fputcsv($file, array($row['frequency_id'], $row['frequency'], $row['language_prefix'], $row['time_increment'], $row['time_unit']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.frequency.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->path(), 'r');
        
        $header = fgetcsv($handle, 1000, ';');
        if($header && count($header) <= 1) {
            rewind($handle);
            $header = fgetcsv($handle, 1000, ',');
            $separator = ',';
        } else {
            $separator = ';';
        }
        
        $insertedCount = 0;
        $updatedCount = 0;

        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
            $name = $data[1] ?? null;
            if (empty(trim($name))) continue;
            
            $id = $data[0] ?? null;

            if ($id) {
                $item = Frequency::find($id);
            } else {
                $item = null;
            }
            
            if ($item) {
                $item->frequency = $name;
                $item->language_prefix = $data[2] ?? null;
                $item->time_increment = $data[3] ?? null;
                $item->time_unit = $data[4] ?? 'day';
                $item->last_update = now();
                $item->save();
                $updatedCount++;
            } else {
                $item = new Frequency();
                if ($id) {
                    $item->frequency_id = $id;
                }
                $item->frequency = $name;
                $item->language_prefix = $data[2] ?? null;
                $item->time_increment = $data[3] ?? null;
                $item->time_unit = $data[4] ?? 'day';
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.frequency.index')->with('success', "Import selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}

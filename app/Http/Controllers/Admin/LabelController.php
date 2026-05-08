<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Label;

class LabelController extends Controller
{
    public function index(Request $request)
    {
        $query = Label::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('label_name', 'like', "%{$search}%");
        }
        $labels = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.label.index', compact('labels'));
    }

    public function create()
    {
        return view('admin.label.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label_name' => 'required|string|max:20',
            'label_desc' => 'nullable|string|max:50',
            'label_image' => 'nullable|string|max:200',
        ]);

        $item = new Label();
        $item->label_name = $validated['label_name'];
        $item->label_desc = $validated['label_desc'];
        $item->label_image = $validated['label_image'] ?? '';
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.label.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $label = Label::findOrFail($id);
        return view('admin.label.edit', compact('label'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'label_name' => 'required|string|max:20',
            'label_desc' => 'nullable|string|max:50',
            'label_image' => 'nullable|string|max:200',
        ]);

        $item = Label::findOrFail($id);
        $item->label_name = $validated['label_name'];
        $item->label_desc = $validated['label_desc'];
        if (isset($validated['label_image'])) {
            $item->label_image = $validated['label_image'];
        }
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.label.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Label::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'label_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Label::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['label_id', 'label_name', 'label_desc', 'label_image'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['label_id']  = $item->label_id;
                $row['label_name']    = $item->label_name;
                $row['label_desc']    = $item->label_desc;
                $row['label_image']    = $item->label_image;

                fputcsv($file, array($row['label_id'], $row['label_name'], $row['label_desc'], $row['label_image']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.label.import');
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
                $item = Label::find($id);
            } else {
                $item = null;
            }
            
            if ($item) {
                $item->label_name = $name;
                $item->label_desc = $data[2] ?? null;
                $item->label_image = $data[3] ?? '';
                $item->last_update = now();
                $item->save();
                $updatedCount++;
            } else {
                $item = new Label();
                if ($id) {
                    $item->label_id = $id;
                }
                $item->label_name = $name;
                $item->label_desc = $data[2] ?? null;
                $item->label_image = $data[3] ?? '';
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.label.index')->with('success', "Import selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}

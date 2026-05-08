<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CollType;

class CollTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = CollType::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('coll_type_name', 'like', "%{$search}%");
        }
        $collTypes = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.coll_type.index', compact('collTypes'));
    }

    public function create()
    {
        return view('admin.coll_type.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'coll_type_name' => 'required|string|max:30',
        ]);

        $item = new CollType();
        $item->coll_type_name = $validated['coll_type_name'];
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.coll_type.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $collType = CollType::findOrFail($id);
        return view('admin.coll_type.edit', compact('collType'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'coll_type_name' => 'required|string|max:30',
        ]);

        $item = CollType::findOrFail($id);
        $item->coll_type_name = $validated['coll_type_name'];
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.coll_type.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        CollType::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'coll_type_export_' . date('Y-m-d_H-i') . '.csv';
        $items = CollType::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['coll_type_id', 'coll_type_name'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['coll_type_id']  = $item->coll_type_id;
                $row['coll_type_name']    = $item->coll_type_name;

                fputcsv($file, array($row['coll_type_id'], $row['coll_type_name']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.coll_type.import');
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
                $item = CollType::find($id);
            } else {
                $item = null;
            }
            
            if ($item) {
                $item->coll_type_name = $name;
                $item->last_update = now();
                $item->save();
                $updatedCount++;
            } else {
                $item = new CollType();
                if ($id) {
                    $item->coll_type_id = $id;
                }
                $item->coll_type_name = $name;
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.coll_type.index')->with('success', "Import selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}

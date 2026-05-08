<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('location_name', 'like', "%{$search}%")
                  ->orWhere('location_id', 'like', "%{$search}%");
        }
        $locations = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.location.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.location.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_id' => 'required|string|max:3|unique:mst_location,location_id',
            'location_name' => 'required|string|max:100',
        ]);

        $item = new Location();
        $item->location_id = $validated['location_id'];
        $item->location_name = $validated['location_name'];
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.location.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:100',
        ]);

        $item = Location::findOrFail($id);
        $item->location_name = $validated['location_name'];
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.location.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Location::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'location_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Location::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['location_id', 'location_name'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['location_id']  = $item->location_id;
                $row['location_name']    = $item->location_name;

                fputcsv($file, array($row['location_id'], $row['location_name']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.location.import');
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
            $id = $data[0] ?? null;
            $name = $data[1] ?? null;
            if (empty(trim($id)) || empty(trim($name))) continue;
            
            $item = Location::find($id);
            
            if ($item) {
                $item->location_name = $name;
                $item->last_update = now();
                $item->save();
                $updatedCount++;
            } else {
                $item = new Location();
                $item->location_id = $id;
                $item->location_name = $name;
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.location.index')->with('success', "Import selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}

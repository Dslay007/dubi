<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Place::query();

        if ($request->has('search')) {
            $query->where('place_name', 'like', "%{$request->search}%");
        }

        $places = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.place.index', compact('places'));
    }

    public function create()
    {
        return view('admin.place.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'place_name' => 'required|string|max:30',
        ]);

        $place = new Place();
        $place->place_name = $request->place_name;
        $place->input_date = now();
        $place->last_update = now();
        $place->save();

        return redirect()->route('admin.place.index')->with('success', 'Place added successfully.');
    }

    public function edit($id)
    {
        $place = Place::findOrFail($id);
        return view('admin.place.edit', compact('place'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'place_name' => 'required|string|max:30',
        ]);

        $place = Place::findOrFail($id);
        $place->place_name = $request->place_name;
        $place->last_update = now();
        $place->save();

        return redirect()->route('admin.place.index')->with('success', 'Place updated successfully.');
    }

    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();
        return redirect()->route('admin.place.index')->with('success', 'Place deleted successfully.');
    }

    public function import()
    {
        return view('admin.place.import');
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
                'place_name' => $name,
                'last_update' => now()->toDateString()
            ];

            if ($id) {
                $existing = Place::find($id);
                if ($existing) {
                    $existing->update($data);
                } else {
                    $data['place_id'] = $id;
                    $data['input_date'] = now()->toDateString();
                    Place::create($data);
                }
            } else {
                $data['input_date'] = now()->toDateString();
                Place::create($data);
            }
            $successCount++;
        }

        return redirect()->route('admin.place.index')->with('success', "$successCount data berhasil diimpor.");
    }

    public function export()
    {
        $fileName = 'place_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Place::orderBy('place_id', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Place Name'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                fputcsv($file, [$item->place_id, $item->place_name], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

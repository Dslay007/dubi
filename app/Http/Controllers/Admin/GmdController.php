<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gmd;

class GmdController extends Controller
{
    public function index(Request $request)
    {
        $query = Gmd::query();

        if ($request->has('search')) {
            $query->where('gmd_name', 'like', "%{$request->search}%")
                  ->orWhere('gmd_code', 'like', "%{$request->search}%");
        }

        $gmds = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.gmd.index', compact('gmds'));
    }

    public function create()
    {
        return view('admin.gmd.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gmd_code' => 'required|string|max:15|unique:mst_gmd,gmd_code',
            'gmd_name' => 'required|string|max:30',
        ]);

        $gmd = new Gmd();
        $gmd->gmd_code = $request->gmd_code;
        $gmd->gmd_name = $request->gmd_name;
        // input_date and last_update handled by model/seeder logic usually, 
        // but explicit assignment doesn't hurt if timestamps disabled
        $gmd->input_date = now();
        $gmd->last_update = now();
        $gmd->save();

        return redirect()->route('admin.gmd.index')->with('success', 'GMD added successfully.');
    }

    public function edit($id)
    {
        $gmd = Gmd::findOrFail($id);
        return view('admin.gmd.edit', compact('gmd'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gmd_code' => 'required|string|max:15|unique:mst_gmd,gmd_code,'.$id.',gmd_id',
            'gmd_name' => 'required|string|max:30',
        ]);

        $gmd = Gmd::findOrFail($id);
        $gmd->gmd_code = $request->gmd_code;
        $gmd->gmd_name = $request->gmd_name;
        $gmd->last_update = now();
        $gmd->save();

        return redirect()->route('admin.gmd.index')->with('success', 'GMD updated successfully.');
    }

    public function destroy($id)
    {
        $gmd = Gmd::findOrFail($id);
        $gmd->delete();
        return redirect()->route('admin.gmd.index')->with('success', 'GMD deleted successfully.');
    }

    public function import()
    {
        return view('admin.gmd.import');
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
            if (count($row) < 3 || empty(trim($row[2]))) continue;

            $id = isset($row[0]) && trim($row[0]) !== '' ? trim($row[0]) : null;
            $code = isset($row[1]) ? trim($row[1]) : '';
            $name = trim($row[2]);
            $icon = isset($row[3]) ? trim($row[3]) : '';

            $data = [
                'gmd_code' => $code,
                'gmd_name' => $name,
                'icon_image' => $icon,
                'last_update' => now()->toDateString()
            ];

            if ($id) {
                $existing = Gmd::find($id);
                if ($existing) {
                    $existing->update($data);
                } else {
                    $data['gmd_id'] = $id;
                    $data['input_date'] = now()->toDateString();
                    Gmd::create($data);
                }
            } else {
                $data['input_date'] = now()->toDateString();
                Gmd::create($data);
            }
            $successCount++;
        }

        return redirect()->route('admin.gmd.index')->with('success', "$successCount data berhasil diimpor.");
    }

    public function export()
    {
        $fileName = 'gmd_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Gmd::orderBy('gmd_id', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'GMD Code', 'GMD Name', 'Icon Image'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                fputcsv($file, [$item->gmd_id, $item->gmd_code, $item->gmd_name, $item->icon_image], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

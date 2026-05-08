<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $query = Language::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('language_name', 'like', "%{$search}%")
                  ->orWhere('language_id', 'like', "%{$search}%");
        }
        $languages = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.language.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.language.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'language_id' => 'required|string|max:5|unique:mst_language,language_id',
            'language_name' => 'required|string|max:20',
        ]);

        $item = new Language();
        $item->language_id = $validated['language_id'];
        $item->language_name = $validated['language_name'];
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.language.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.language.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'language_name' => 'required|string|max:20',
        ]);

        $item = Language::findOrFail($id);
        $item->language_name = $validated['language_name'];
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.language.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Language::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'language_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Language::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['language_id', 'language_name'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['language_id']  = $item->language_id;
                $row['language_name']    = $item->language_name;

                fputcsv($file, array($row['language_id'], $row['language_name']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.language.import');
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
            
            $item = Language::find($id);
            
            if ($item) {
                $item->language_name = $name;
                $item->last_update = now();
                $item->save();
                $updatedCount++;
            } else {
                $item = new Language();
                $item->language_id = $id;
                $item->language_name = $name;
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.language.index')->with('success', "Import selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}

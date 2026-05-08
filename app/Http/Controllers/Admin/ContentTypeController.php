<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContentType;

class ContentTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = ContentType::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('content_type', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }
        $contentTypes = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.content_type.index', compact('contentTypes'));
    }

    public function create()
    {
        return view('admin.content_type.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_type' => 'required|string|max:100',
            'code' => 'nullable|string|max:20',
        ]);

        $item = new ContentType();
        $item->content_type = $validated['content_type'];
        $item->code = $validated['code'];
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.content_type.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $contentType = ContentType::findOrFail($id);
        return view('admin.content_type.edit', compact('contentType'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content_type' => 'required|string|max:100',
            'code' => 'nullable|string|max:20',
        ]);

        $item = ContentType::findOrFail($id);
        $item->content_type = $validated['content_type'];
        $item->code = $validated['code'];
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.content_type.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        ContentType::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'content_type_export_' . date('Y-m-d_H-i') . '.csv';
        $items = ContentType::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['id', 'content_type', 'code'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['id']  = $item->id;
                $row['content_type']    = $item->content_type;
                $row['code']  = $item->code;

                fputcsv($file, array($row['id'], $row['content_type'], $row['code']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.content_type.import');
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
            $code = $data[2] ?? null;

            if ($id) {
                $item = ContentType::find($id);
            } else {
                $item = null;
            }
            
            if ($item) {
                $item->content_type = $name;
                $item->code = $code;
                $item->last_update = now();
                $item->save();
                $updatedCount++;
            } else {
                $item = new ContentType();
                if ($id) {
                    $item->id = $id;
                }
                $item->content_type = $name;
                $item->code = $code;
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.content_type.index')->with('success', "Import selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}

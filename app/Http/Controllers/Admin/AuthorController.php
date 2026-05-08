<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::query();

        if ($request->has('search')) {
            $query->where('author_name', 'like', "%{$request->search}%");
        }

        $authors = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.author.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.author.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_year' => 'nullable|string|max:20',
        ]);

        $author = new Author();
        $author->author_name = $request->author_name;
        $author->author_year = $request->author_year;
        $author->input_date = now();
        $author->last_update = now();
        $author->save();

        return redirect()->route('admin.author.index')->with('success', 'Author added successfully.');
    }

    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return view('admin.author.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_year' => 'nullable|string|max:20',
        ]);

        $author = Author::findOrFail($id);
        $author->author_name = $request->author_name;
        $author->author_year = $request->author_year;
        $author->last_update = now();
        $author->save();

        return redirect()->route('admin.author.index')->with('success', 'Author updated successfully.');
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return redirect()->route('admin.author.index')->with('success', 'Author deleted successfully.');
    }

    public function import()
    {
        return view('admin.author.import');
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
            $year = isset($row[2]) ? trim($row[2]) : '';

            $data = [
                'author_name' => $name,
                'author_year' => $year,
                'last_update' => now()->toDateString()
            ];

            if ($id) {
                $existing = Author::find($id);
                if ($existing) {
                    $existing->update($data);
                } else {
                    $data['author_id'] = $id;
                    $data['input_date'] = now()->toDateString();
                    Author::create($data);
                }
            } else {
                $data['input_date'] = now()->toDateString();
                Author::create($data);
            }
            $successCount++;
        }

        return redirect()->route('admin.author.index')->with('success', "$successCount data berhasil diimpor.");
    }

    public function export()
    {
        $fileName = 'author_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Author::orderBy('author_id', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Author Name', 'Author Year'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                fputcsv($file, [$item->author_id, $item->author_name, $item->author_year], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

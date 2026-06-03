<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biblio;
use App\Helpers\SystemLog;

class BiblioController extends Controller
{
    public function index(Request $request)
    {
        $query = Biblio::with(['publisher', 'authors']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('isbn_issn', 'like', "%{$search}%");
        }

        $biblios = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.biblio.index', compact('biblios'));
    }

    public function create()
    {
        return view('admin.biblio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'isbn_issn' => 'nullable',
            'publisher_id' => 'nullable|exists:mst_publisher,publisher_id',
            'publish_year' => 'nullable|numeric',
            'gmd_id' => 'nullable|exists:mst_gmd,gmd_id',
            'authors' => 'nullable|array',
            'authors.*.id' => 'required|exists:mst_author,author_id',
            'authors.*.level' => 'nullable|integer',
            'edition' => 'nullable|string|max:50',
            'call_number' => 'nullable|string|max:50',
            'classification' => 'nullable|string|max:50',
            'series_title' => 'nullable|string',
            'publish_place_id' => 'nullable|exists:mst_place,place_id',
            'language' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'sor' => 'nullable|string',
            'collation' => 'nullable|string',
            'spec_detail_info' => 'nullable|string',
            'topic_id' => 'nullable|array',
            'topic_id.*' => 'exists:mst_topic,topic_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
            'file_att_upload' => 'nullable|file|mimes:pdf,epub|max:51200', // max 50MB
            'file_att_link' => 'nullable|url',
        ]);

        $biblio = new Biblio();
        $biblio->title = $validated['title'];
        $biblio->isbn_issn = $validated['isbn_issn'];
        $biblio->publisher_id = $validated['publisher_id'];
        $biblio->publish_year = $validated['publish_year'];
        $biblio->gmd_id = $validated['gmd_id'];
        
        $biblio->edition = $validated['edition'] ?? null;
        $biblio->call_number = $validated['call_number'] ?? null;
        $biblio->classification = $validated['classification'] ?? null;
        $biblio->series_title = $validated['series_title'] ?? null;
        $biblio->publish_place_id = $validated['publish_place_id'] ?? null;
        $biblio->language = $validated['language'] ?? null;
        $biblio->notes = $validated['notes'] ?? null;
        $biblio->sor = $validated['sor'] ?? null;
        $biblio->collation = $validated['collation'] ?? null;
        $biblio->spec_detail_info = $validated['spec_detail_info'] ?? null;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $biblio->image = $imageName;
        } elseif ($request->filled('image_url')) {
            $biblio->image = $request->image_url;
        }

        if ($request->hasFile('file_att_upload')) {
            $fileName = time().'_'.str_replace(' ', '_', $request->file_att_upload->getClientOriginalName());  
            $request->file_att_upload->storeAs('books', $fileName); // saves in storage/app/books
            $biblio->file_att = $fileName;
        } elseif ($request->filled('file_att_link')) {
            $biblio->file_att = $request->file('file_att_link') ? null : $request->file_att_link;
        }

        $biblio->input_date = now();
        $biblio->last_update = now();
        $biblio->save();

        if ($request->has('authors') && is_array($request->authors)) {
            $syncData = [];
            foreach ($request->authors as $author) {
                if (isset($author['id'])) {
                    $syncData[$author['id']] = ['level' => $author['level'] ?? 1];
                }
            }
            $biblio->authors()->sync($syncData);
        }
        
        if (isset($validated['topic_id'])) {
            $biblio->topics()->attach($validated['topic_id']);
        }

        // Catat log aktifitas
        SystemLog::write('insert', 'Menambah Bibliografi Baru: ' . $biblio->title, 'Bibliography', 'Biblio');

        return redirect()->route('admin.biblio.index')->with('success', 'Book added successfully!');
    }

    public function edit($id)
    {
        $biblio = Biblio::with('authors')->findOrFail($id);
        return view('admin.biblio.edit', compact('biblio'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'isbn_issn' => 'nullable',
            'publisher_id' => 'nullable|exists:mst_publisher,publisher_id',
            'publish_year' => 'nullable|numeric',
            'gmd_id' => 'nullable|exists:mst_gmd,gmd_id',
            'authors' => 'nullable|array',
            'authors.*.id' => 'required|exists:mst_author,author_id',
            'authors.*.level' => 'nullable|integer',
            'edition' => 'nullable|string|max:50',
            'call_number' => 'nullable|string|max:50',
            'classification' => 'nullable|string|max:50',
            'series_title' => 'nullable|string',
            'publish_place_id' => 'nullable|exists:mst_place,place_id',
            'language' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'sor' => 'nullable|string',
            'collation' => 'nullable|string',
            'spec_detail_info' => 'nullable|string',
            'topic_id' => 'nullable|array',
            'topic_id.*' => 'exists:mst_topic,topic_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
            'file_att_upload' => 'nullable|file|mimes:pdf,epub|max:51200',
            'file_att_link' => 'nullable|url',
        ]);

        $biblio = Biblio::findOrFail($id);
        $biblio->title = $validated['title'];
        $biblio->isbn_issn = $validated['isbn_issn'];
        $biblio->publisher_id = $validated['publisher_id'];
        $biblio->publish_year = $validated['publish_year'];
        $biblio->gmd_id = $validated['gmd_id'];

        $biblio->edition = $validated['edition'] ?? null;
        $biblio->call_number = $validated['call_number'] ?? null;
        $biblio->classification = $validated['classification'] ?? null;
        $biblio->series_title = $validated['series_title'] ?? null;
        $biblio->publish_place_id = $validated['publish_place_id'] ?? null;
        $biblio->language = $validated['language'] ?? null;
        $biblio->notes = $validated['notes'] ?? null;
        $biblio->sor = $validated['sor'] ?? null;
        $biblio->collation = $validated['collation'] ?? null;
        $biblio->spec_detail_info = $validated['spec_detail_info'] ?? null;
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($biblio->image && file_exists(public_path('images/' . $biblio->image)) && !\str_starts_with($biblio->image, 'http')) {
                unlink(public_path('images/' . $biblio->image));
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $biblio->image = $imageName;
        } elseif ($request->filled('image_url')) {
            // Delete old image if it was a file
            if ($biblio->image && file_exists(public_path('images/' . $biblio->image)) && !\str_starts_with($biblio->image, 'http')) {
                unlink(public_path('images/' . $biblio->image));
            }
            $biblio->image = $request->image_url;
        }

        if ($request->hasFile('file_att_upload')) {
            // Delete old file if exists
            if ($biblio->file_att && !\str_starts_with($biblio->file_att, 'http')) {
                \Illuminate\Support\Facades\Storage::delete('books/' . $biblio->file_att);
            }
            $fileName = time().'_'.str_replace(' ', '_', $request->file_att_upload->getClientOriginalName());  
            $request->file_att_upload->storeAs('books', $fileName);
            $biblio->file_att = $fileName;
        } elseif ($request->filled('file_att_link')) {
            if ($biblio->file_att && !\str_starts_with($biblio->file_att, 'http')) {
                \Illuminate\Support\Facades\Storage::delete('books/' . $biblio->file_att);
            }
            $biblio->file_att = $request->file_att_link;
        }

        $biblio->last_update = now();
        $biblio->save();

        if ($request->has('authors') && is_array($request->authors)) {
            $syncData = [];
            foreach ($request->authors as $author) {
                if (isset($author['id'])) {
                    $syncData[$author['id']] = ['level' => $author['level'] ?? 1];
                }
            }
            $biblio->authors()->sync($syncData);
        } else {
            $biblio->authors()->detach();
        }

        if (isset($validated['topic_id'])) {
            $biblio->topics()->sync($validated['topic_id']);
        } else {
            $biblio->topics()->detach();
        }

        // Catat log aktifitas
        SystemLog::write('update', 'Mengubah Bibliografi: ' . $biblio->title, 'Bibliography', 'Biblio');

        return redirect()->route('admin.biblio.index')->with('success', 'Book updated successfully!');
    }

    public function destroy($id)
    {
        $biblio = Biblio::findOrFail($id);
        // Detach relations first
        $biblio->authors()->detach();
        $biblio->topics()->detach();
        
        $title = $biblio->title;
        $biblio->delete();

        // Catat log aktifitas
        SystemLog::write('delete', 'Menghapus Bibliografi: ' . $title, 'Bibliography', 'Biblio');

        return redirect()->route('admin.biblio.index')->with('success', 'Book deleted successfully!');
    }

    public function import()
    {
        return view('admin.biblio.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->path(), 'r');
        
        $header = fgetcsv($handle, 1000, ';');
        if(count($header) <= 1) {
            rewind($handle);
            $header = fgetcsv($handle, 1000, ',');
            $separator = ',';
        } else {
            $separator = ';';
        }
        
        $insertedCount = 0;

        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
            if (!isset($data[0]) || empty(trim($data[0]))) continue;
            
            $title = $data[0];
            $isbn = $data[1] ?? null;
            $gmdId = $data[2] ?? 1; // Default to Text/Buku
            $publisherId = $data[3] ?? null;
            $publishYear = $data[4] ?? null;
            $callNumber = $data[5] ?? null;

            $biblio = new Biblio();
            $biblio->title = $title;
            $biblio->isbn_issn = $isbn;
            $biblio->gmd_id = $gmdId;
            $biblio->publisher_id = $publisherId;
            $biblio->publish_year = $publishYear;
            $biblio->call_number = $callNumber;
            $biblio->input_date = now();
            $biblio->last_update = now();
            $biblio->save();
            $insertedCount++;
        }
        fclose($handle);

        return redirect()->route('admin.biblio.index')->with('success', "Import Buku berhasil. $insertedCount buku ditambahkan.");
    }

    public function export()
    {
        $fileName = 'biblio_export_' . date('Y-m-d_H-i') . '.csv';
        $biblios = Biblio::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Title', 'ISBN_ISSN', 'GMD_ID', 'Publisher_ID', 'Publish_Year', 'Call_Number'];

        $callback = function() use($biblios, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($biblios as $b) {
                fputcsv($file, array($b->title, $b->isbn_issn, $b->gmd_id, $b->publisher_id, $b->publish_year, $b->call_number), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

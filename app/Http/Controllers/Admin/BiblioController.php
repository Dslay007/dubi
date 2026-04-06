<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biblio;

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
            'author_id' => 'nullable|array',
            'author_id.*' => 'exists:mst_author,author_id',
            'edition' => 'nullable|string|max:50',
            'call_number' => 'nullable|string|max:50',
            'classification' => 'nullable|string|max:50',
            'series_title' => 'nullable|string',
            'publish_place_id' => 'nullable|exists:mst_place,place_id',
            'language' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $biblio->image = $imageName;
        }

        $biblio->input_date = now();
        $biblio->last_update = now();
        $biblio->save();

        if (isset($validated['author_id'])) {
            $biblio->authors()->attach($validated['author_id']);
        }

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
            'author_id' => 'nullable|array',
            'author_id.*' => 'exists:mst_author,author_id',
            'edition' => 'nullable|string|max:50',
            'call_number' => 'nullable|string|max:50',
            'classification' => 'nullable|string|max:50',
            'series_title' => 'nullable|string',
            'publish_place_id' => 'nullable|exists:mst_place,place_id',
            'language' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($biblio->image && file_exists(public_path('images/' . $biblio->image))) {
                unlink(public_path('images/' . $biblio->image));
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $biblio->image = $imageName;
        }

        $biblio->last_update = now();
        $biblio->save();

        if (isset($validated['author_id'])) {
            $biblio->authors()->sync($validated['author_id']);
        } else {
            $biblio->authors()->detach();
        }

        return redirect()->route('admin.biblio.index')->with('success', 'Book updated successfully!');
    }

    public function destroy($id)
    {
        $biblio = Biblio::findOrFail($id);
        // Detach relations first
        $biblio->authors()->detach();
        $biblio->topics()->detach();
        $biblio->delete();

        return redirect()->route('admin.biblio.index')->with('success', 'Book deleted successfully!');
    }

    public function import()
    {
        return view('admin.biblio.import');
    }

    public function processImport(Request $request)
    {
        // Placeholder for logic
        return redirect()->route('admin.biblio.index')->with('success', 'Import successful (stub).');
    }

    public function export()
    {
        // Placeholder for logic
        return response()->download('path-to-file.csv');
    }
}

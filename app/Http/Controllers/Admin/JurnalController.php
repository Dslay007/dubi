<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurnal::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $jurnals = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.kegiatan.jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        return view('admin.kegiatan.jurnal.form', ['jurnal' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_published' => 'boolean'
        ]);

        $data = $request->except('cover_image');
        $data['slug'] = Str::slug($request->title) . '-' . time();

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->hashName();
            $image->move(public_path('uploads/jurnal'), $imageName);
            $data['cover_image'] = $imageName;
        }

        Jurnal::create($data);

        return redirect()->route('admin.kegiatan.jurnal.index')->with('success', 'Jurnal Lapak berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        return view('admin.kegiatan.jurnal.form', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_published' => 'boolean'
        ]);

        $data = $request->except('cover_image');
        
        if ($request->title !== $jurnal->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($jurnal->cover_image && File::exists(public_path('uploads/jurnal/' . $jurnal->cover_image))) {
                File::delete(public_path('uploads/jurnal/' . $jurnal->cover_image));
            }

            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->hashName();
            $image->move(public_path('uploads/jurnal'), $imageName);
            $data['cover_image'] = $imageName;
        }

        $jurnal->update($data);

        return redirect()->route('admin.kegiatan.jurnal.index')->with('success', 'Jurnal Lapak berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);

        if ($jurnal->cover_image && File::exists(public_path('uploads/jurnal/' . $jurnal->cover_image))) {
            File::delete(public_path('uploads/jurnal/' . $jurnal->cover_image));
        }

        $jurnal->delete();

        return redirect()->route('admin.kegiatan.jurnal.index')->with('success', 'Jurnal Lapak berhasil dihapus.');
    }
}

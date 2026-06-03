<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityStructure;
use Illuminate\Support\Facades\File;

class CommunityStructureController extends Controller
{
    public function index()
    {
        $founders = CommunityStructure::where('type', 'founder')->get();
        $cores = CommunityStructure::where('type', 'core')->get();
        $divisions = CommunityStructure::where('type', 'division')->get();

        return view('admin.kegiatan.struktur.index', compact('founders', 'cores', 'divisions'));
    }

    public function updateStatic(Request $request, $id)
    {
        $structure = CommunityStructure::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['name', 'subtitle']);

        if ($request->hasFile('photo')) {
            if ($structure->photo && File::exists(public_path('uploads/struktur/' . $structure->photo))) {
                File::delete(public_path('uploads/struktur/' . $structure->photo));
            }
            
            // Create dir if not exists
            if (!File::isDirectory(public_path('uploads/struktur'))) {
                File::makeDirectory(public_path('uploads/struktur'), 0777, true, true);
            }

            $image = $request->file('photo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/struktur'), $imageName);
            $data['photo'] = $imageName;
        }

        $structure->update($data);

        return redirect()->route('admin.kegiatan.struktur.index')->with('success', 'Data struktur berhasil diperbarui.');
    }

    public function storeDivision(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'vice_name' => 'nullable|string|max:255',
            'members_list' => 'nullable|string',
        ]);

        CommunityStructure::create([
            'type' => 'division',
            'title' => $request->title,
            'name' => $request->name,
            'vice_name' => $request->vice_name,
            'members_list' => $request->members_list,
        ]);

        return redirect()->route('admin.kegiatan.struktur.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function updateDivision(Request $request, $id)
    {
        $division = CommunityStructure::where('type', 'division')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'vice_name' => 'nullable|string|max:255',
            'members_list' => 'nullable|string',
        ]);

        $division->update([
            'title' => $request->title,
            'name' => $request->name,
            'vice_name' => $request->vice_name,
            'members_list' => $request->members_list,
        ]);

        return redirect()->route('admin.kegiatan.struktur.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroyDivision($id)
    {
        $division = CommunityStructure::where('type', 'division')->findOrFail($id);
        $division->delete();

        return redirect()->route('admin.kegiatan.struktur.index')->with('success', 'Divisi berhasil dihapus.');
    }
}

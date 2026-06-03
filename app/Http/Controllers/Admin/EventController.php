<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.kegiatan.acara.index', compact('events'));
    }

    public function create()
    {
        return view('admin.kegiatan.acara.form', ['event' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'registration_link' => 'nullable|url|max:255',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048' // multiple validation
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/acara'), $filename);
                $photos[] = $filename;
            }
        }

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'registration_link' => $request->registration_link,
            'photos' => empty($photos) ? null : json_encode($photos),
            'is_active' => false // Default false, must be activated manually
        ]);

        return redirect()->route('admin.kegiatan.acara.index')->with('success', 'Acara berhasil ditambahkan. Silakan klik Tampilkan di Beranda untuk mengaktifkannya.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.kegiatan.acara.form', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'registration_link' => 'nullable|url|max:255',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $photos = $event->photos ? json_decode($event->photos, true) : [];
        
        // Handle new uploads (append to existing or replace depending on logic. Let's append for now or replace if they upload new ones. Actually, simpler to just replace if new photos are uploaded).
        if ($request->hasFile('photos')) {
            // Delete old photos
            if (!empty($photos)) {
                foreach($photos as $oldFile) {
                    if (file_exists(public_path('uploads/acara/' . $oldFile))) {
                        unlink(public_path('uploads/acara/' . $oldFile));
                    }
                }
            }
            
            $photos = [];
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/acara'), $filename);
                $photos[] = $filename;
            }
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'registration_link' => $request->registration_link,
            'photos' => empty($photos) ? null : json_encode($photos),
        ]);

        return redirect()->route('admin.kegiatan.acara.index')->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // Delete photos
        $photos = $event->photos ? json_decode($event->photos, true) : [];
        if (!empty($photos)) {
            foreach($photos as $oldFile) {
                if (file_exists(public_path('uploads/acara/' . $oldFile))) {
                    unlink(public_path('uploads/acara/' . $oldFile));
                }
            }
        }
        
        $event->delete();

        return redirect()->route('admin.kegiatan.acara.index')->with('success', 'Acara berhasil dihapus.');
    }
    
    public function toggleActive($id)
    {
        // Set all to false first
        Event::query()->update(['is_active' => false]);
        
        // Activate the selected one
        $event = Event::findOrFail($id);
        $event->update(['is_active' => true]);
        
        return redirect()->route('admin.kegiatan.acara.index')->with('success', 'Acara "'.$event->title.'" sekarang ditampilkan di halaman beranda.');
    }
}

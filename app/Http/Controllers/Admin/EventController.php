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

        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        $events = $query->orderBy('event_date', 'desc')->paginate(10);

        return view('admin.acara.berita_acara.index', compact('events'));
    }

    public function create()
    {
        return view('admin.acara.berita_acara.form', ['event' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Event::create($request->all());

        return redirect()->route('admin.acara.berita_acara.index')->with('success', 'Berita acara berhasil ditambahkan.');
    }

    public function edit(Event $beritaAcarum) // Route Model Binding uses $beritaAcarum by default because of the route name, but let's use standard $id to avoid confusion with pluralization
    {
        // Using manual find to avoid Laravel's pluralization route binding issues with non-english words
    }

    public function editById($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.acara.berita_acara.form', compact('event'));
    }

    public function updateById(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $event->update($request->all());

        return redirect()->route('admin.acara.berita_acara.index')->with('success', 'Berita acara berhasil diperbarui.');
    }

    public function destroyById($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.acara.berita_acara.index')->with('success', 'Berita acara berhasil dihapus.');
    }
}

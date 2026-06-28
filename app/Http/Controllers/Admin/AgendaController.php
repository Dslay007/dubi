<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        $agendas = $query->orderBy('event_date', 'desc')->paginate(10);

        return view('admin.kegiatan.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.kegiatan.agenda.form', ['agenda' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'documentation_link' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        Agenda::create($request->all());

        return redirect()->route('admin.kegiatan.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('admin.kegiatan.agenda.form', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'documentation_link' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $agenda->update($validated);

        return redirect()->route('admin.kegiatan.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('admin.kegiatan.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}

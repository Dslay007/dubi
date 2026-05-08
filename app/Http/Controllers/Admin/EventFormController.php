<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventForm;
use App\Models\EventFormField;
use App\Models\EventRegistrant;

class EventFormController extends Controller
{
    public function index()
    {
        $forms = EventForm::with('event')->orderBy('id', 'desc')->paginate(10);
        return view('admin.acara.pendaftaran.index', compact('forms'));
    }

    public function create()
    {
        $events = Event::orderBy('title')->get();
        return view('admin.acara.pendaftaran.form', ['form' => null, 'events' => $events]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'form_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'google_sheet_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        EventForm::create($request->all());

        return redirect()->route('admin.acara.pendaftaran.index')->with('success', 'Form pendaftaran berhasil dibuat.');
    }

    public function edit($id)
    {
        $form = EventForm::findOrFail($id);
        $events = Event::orderBy('title')->get();
        return view('admin.acara.pendaftaran.form', compact('form', 'events'));
    }

    public function update(Request $request, $id)
    {
        $form = EventForm::findOrFail($id);
        
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'form_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'google_sheet_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        $form->update($request->all());

        return redirect()->route('admin.acara.pendaftaran.index')->with('success', 'Form pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $form = EventForm::findOrFail($id);
        $form->delete();
        return redirect()->route('admin.acara.pendaftaran.index')->with('success', 'Form pendaftaran berhasil dihapus.');
    }

    // Form Builder (Atur Pertanyaan)
    public function builder($id)
    {
        $form = EventForm::with('fields')->findOrFail($id);
        return view('admin.acara.pendaftaran.builder', compact('form'));
    }

    public function storeField(Request $request, $id)
    {
        $form = EventForm::findOrFail($id);

        $request->validate([
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|string|in:text,textarea,email,select,radio,checkbox',
            'options' => 'nullable|string',
            'is_required' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $options = null;
        if (in_array($request->field_type, ['select', 'radio', 'checkbox']) && $request->filled('options')) {
            $optionsArray = array_map('trim', explode(',', $request->options));
            $options = json_encode($optionsArray);
        }

        EventFormField::create([
            'event_form_id' => $form->id,
            'field_label' => $request->field_label,
            'field_type' => $request->field_type,
            'options' => $options,
            'is_required' => $request->is_required ?? 0,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function destroyField($id)
    {
        $field = EventFormField::findOrFail($id);
        $field->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    // List Pendaftar
    public function registrants($id)
    {
        $form = EventForm::with(['fields', 'registrants.answers.field'])->findOrFail($id);
        return view('admin.acara.pendaftaran.registrants', compact('form'));
    }

    public function confirmRegistrant($id)
    {
        $registrant = EventRegistrant::findOrFail($id);
        $registrant->update(['status' => 'confirmed']);
        
        // Mockup email sending
        // \Mail::to($registrant->email)->send(new EventConfirmationMail($registrant));
        
        return back()->with('success', 'Pendaftar berhasil dikonfirmasi (Mockup Email Terkirim).');
    }
}

@extends('layouts.admin')

@section('pageTitle', $form ? 'Edit Form Pendaftaran' : 'Buat Form Pendaftaran Baru')

@section('content')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h3 style="font-weight: 700; color: #1e293b;">Form Pendaftaran</h3>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.acara.pendaftaran.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #cbd5e1;">
            <i data-lucide="list" style="width: 1rem; height: 1rem;"></i> Daftar Form
        </a>
    </div>
</div>

<form action="{{ $form ? route('admin.acara.pendaftaran.update', $form->id) : route('admin.acara.pendaftaran.store') }}" method="POST" id="pendaftaran-form" style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 2rem;">
    @csrf
    @if($form) @method('PUT') @endif

    <!-- Kolom Kiri: Editor Konten -->
    <div>
        @error('form_title') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 1rem;">
            <label style="display: block; font-weight: 700; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Judul Form*</label>
            <input type="text" name="form_title" value="{{ old('form_title', $form->form_title ?? '') }}" required placeholder="Contoh: Form Pendaftaran Seminar Nasional" 
                style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 1rem;">
        </div>

        @error('description') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 1rem;">
            <label style="display: block; font-weight: 700; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Deskripsi Form</label>
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.375rem; overflow: hidden;">
                <div id="editor-container" style="height: 300px;">{!! old('description', $form->description ?? '') !!}</div>
            </div>
            <textarea name="description" id="hidden_description" style="display: none;"></textarea>
        </div>
        
        <div style="background: #fef2f2; border: 1px solid #fca5a5; border-radius: 0.375rem; padding: 1rem;">
            <h5 style="color: #b91c1c; font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="info" style="width: 1rem; height: 1rem;"></i> Alternatif: Sambung Spreadsheet
            </h5>
            <p style="color: #7f1d1d; font-size: 0.875rem; margin-bottom: 0.75rem;">
                (MOCKUP FEATURE) Jika Anda menggunakan Google Forms atau alat pihak ketiga lainnya, masukkan link spreadsheet/form di bawah. Form internal tidak akan ditampilkan jika kolom ini diisi.
            </p>
            <input type="url" name="google_sheet_url" value="{{ old('google_sheet_url', $form->google_sheet_url ?? '') }}" placeholder="https://docs.google.com/spreadsheets/d/.../edit" 
                style="width: 100%; padding: 0.75rem; border: 1px solid #fca5a5; border-radius: 0.375rem; outline: none; font-size: 0.875rem; background: white;">
        </div>
    </div>

    <!-- Kolom Kanan: Pengaturan -->
    <div>
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; overflow: hidden;">
            <div style="padding: 1rem 1.5rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">Informasi Pendaftaran</h4>
                <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.25rem; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="save" style="width: 1rem; height: 1rem;"></i> {{ $form ? 'Perbaharui' : 'Simpan' }}
                </button>
            </div>

            <div style="padding: 1.5rem;">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Terkait Acara*</label>
                    <select name="event_id" required style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                        <option value="">-- Pilih Acara --</option>
                        @foreach($events as $e)
                            <option value="{{ $e->id }}" {{ old('event_id', $form->event_id ?? '') == $e->id ? 'selected' : '' }}>{{ $e->title }} ({{ \Carbon\Carbon::parse($e->event_date)->format('d/m/Y') }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Status Pendaftaran</label>
                    <select name="is_active" style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                        <option value="1" {{ old('is_active', $form->is_active ?? 1) == 1 ? 'selected' : '' }}>Dibuka (Menerima Pendaftar)</option>
                        <option value="0" {{ old('is_active', $form->is_active ?? 1) == 0 ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
                
                @if($form)
                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #e2e8f0;">
                    <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem;">Langkah Berikutnya:</p>
                    <a href="{{ route('admin.acara.pendaftaran.builder', $form->id) }}" class="btn" style="width: 100%; background: #4f46e5; color: white; padding: 0.6rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <i data-lucide="layout-template" style="width: 1rem; height: 1rem;"></i> Atur Pertanyaan Form
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        },
        placeholder: 'Tuliskan deskripsi/syarat pendaftaran di sini...',
        theme: 'snow'
    });

    document.getElementById('pendaftaran-form').onsubmit = function() {
        document.getElementById('hidden_description').value = quill.root.innerHTML;
    };
</script>
@endsection


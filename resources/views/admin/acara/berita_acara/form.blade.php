@extends('layouts.admin')

@section('pageTitle', $event ? 'Edit Berita Acara' : 'Tambah Berita Acara Baru')

@section('content')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h3 style="font-weight: 700; color: #1e293b;">Berita Acara</h3>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.acara.berita_acara.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #cbd5e1;">
            <i data-lucide="list" style="width: 1rem; height: 1rem;"></i> Daftar Acara
        </a>
    </div>
</div>

<form action="{{ $event ? route('admin.acara.berita_acara.update', $event->id) : route('admin.acara.berita_acara.store') }}" method="POST" id="acara-form" style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 2rem;">
    @csrf
    @if($event) @method('PUT') @endif

    <!-- Kolom Kiri: Editor Konten -->
    <div>
        @error('title') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 1rem;">
            <label style="display: block; font-weight: 700; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Judul Acara*</label>
            <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" required placeholder="Masukkan judul acara..." 
                style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 1rem;">
        </div>

        @error('description') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.375rem; overflow: hidden;">
            <div id="editor-container" style="height: 400px;">{!! old('description', $event->description ?? '') !!}</div>
        </div>
        <textarea name="description" id="hidden_description" style="display: none;"></textarea>
    </div>

    <!-- Kolom Kanan: Pengaturan -->
    <div>
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; overflow: hidden;">
            <div style="padding: 1rem 1.5rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">Informasi Acara</h4>
                <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.25rem; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="save" style="width: 1rem; height: 1rem;"></i> {{ $event ? 'Perbaharui' : 'Simpan' }}
                </button>
            </div>

            <div style="padding: 1.5rem;">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Tanggal Acara*</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $event->event_date ?? '') }}" required
                        style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Lokasi Acara</label>
                    <input type="text" name="location" value="{{ old('location', $event->location ?? '') }}" placeholder="Contoh: Aula Perpustakaan"
                        style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Status Publikasi</label>
                    <select name="is_active" style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                        <option value="1" {{ old('is_active', $event->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif / Published</option>
                        <option value="0" {{ old('is_active', $event->is_active ?? 1) == 0 ? 'selected' : '' }}>Draft / Sembunyikan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'blockquote'],
                ['clean']
            ]
        },
        placeholder: 'Tuliskan deskripsi/berita acara di sini...',
        theme: 'snow'
    });

    document.getElementById('acara-form').onsubmit = function() {
        document.getElementById('hidden_description').value = quill.root.innerHTML;
    };
</script>
@endsection


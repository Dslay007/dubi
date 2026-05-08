@extends('layouts.admin')

@section('pageTitle', $content ? 'Edit Konten' : 'Tambah Konten Baru')

@section('content')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h3 style="font-weight: 700; color: #1e293b;">Konten</h3>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.sistem.konten.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #cbd5e1;">
            <i data-lucide="list" style="width: 1rem; height: 1rem;"></i> Daftar Konten
        </a>
        <a href="{{ route('admin.sistem.konten.create') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="plus-circle" style="width: 1rem; height: 1rem;"></i> Tambahkan Data Baru
        </a>
    </div>
</div>

<form action="{{ $content ? route('admin.sistem.konten.update', $content->content_path) : route('admin.sistem.konten.store') }}" method="POST" id="konten-form" style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 2rem;">
    @csrf
    @if($content) @method('PUT') @endif

    <!-- Kolom Kiri: Editor Konten -->
    <div>
        @error('content_title') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 1rem;">
            <label style="display: block; font-weight: 700; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Judul Konten*</label>
            <input type="text" name="content_title" value="{{ old('content_title', $content->content_title ?? '') }}" required placeholder="Masukkan judul..." 
                style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 1rem;">
        </div>

        @error('content_desc') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.375rem; overflow: hidden;">
            <div id="editor-container" style="height: 500px;">{!! old('content_desc', $content->content_desc ?? '') !!}</div>
        </div>
        <textarea name="content_desc" id="hidden_content_desc" style="display: none;"></textarea>
    </div>

    <!-- Kolom Kanan: Pengaturan -->
    <div>
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; overflow: hidden;">
            <div style="padding: 1rem 1.5rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">Penyetelan Konten</h4>
                <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.25rem; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="save" style="width: 1rem; height: 1rem;"></i> {{ $content ? 'Perbaharui' : 'Simpan' }}
                </button>
            </div>

            <div style="padding: 1.5rem;">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Diterbitkan pada</label>
                    @php 
                        $pubDate = old('publish_date', $content->input_date ?? ''); 
                        if($pubDate) $pubDate = date('Y-m-d\TH:i', strtotime($pubDate));
                    @endphp
                    <input type="datetime-local" name="publish_date" value="{{ $pubDate }}"
                        style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Ini Berita*</label>
                    <select name="is_news" style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                        <option value="0" {{ old('is_news', $content->is_news ?? 0) == 0 ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ old('is_news', $content->is_news ?? 0) == 1 ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>

                @error('content_path') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Path (Harus unik)*</label>
                    <input type="text" name="content_path" value="{{ old('content_path', $content->content_path ?? '') }}" required placeholder="contoh: info-terbaru"
                        style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Konsep?*</label>
                    @php $isConcept = old('is_concept', ($content->content_ownpage ?? '1') == '2' ? 1 : 0); @endphp
                    <select name="is_concept" style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                        <option value="0" {{ $isConcept == 0 ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ $isConcept == 1 ? 'selected' : '' }}>Ya</option>
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
                ['image', 'code-block', 'link', 'blockquote'],
                ['clean']
            ]
        },
        placeholder: 'Ketik konten di sini...',
        theme: 'snow'
    });

    document.getElementById('konten-form').onsubmit = function() {
        document.getElementById('hidden_content_desc').value = quill.root.innerHTML;
    };
</script>
@endsection

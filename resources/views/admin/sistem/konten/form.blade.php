@extends('layouts.admin')

@section('pageTitle', $content ? 'Edit Konten' : 'Tambah Konten Baru')

@section('content')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<x-master-header 
    title="{{ $content ? 'Edit Konten' : 'Tambah Konten Baru' }}" 
    subtitle="Gunakan editor di bawah untuk menulis artikel atau halaman statis." 
    icon="{{ $content ? 'edit-3' : 'file-plus' }}"
>
    <a href="{{ route('admin.sistem.konten.index') }}" class="btn" style="background: white; color: #475569; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 600; font-size: 0.875rem; border: 1px solid #cbd5e1; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
    </a>
</x-master-header>

<form action="{{ $content ? route('admin.sistem.konten.update', $content->content_path) : route('admin.sistem.konten.store') }}" method="POST" id="konten-form" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    @csrf
    @if($content) @method('PUT') @endif

    <!-- Kolom Kiri: Editor Konten -->
    <div style="grid-column: span 2; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2rem;">
        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="edit" style="width: 20px; height: 20px; color: #8b5cf6;"></i>
            Isi Konten
        </h4>

        @error('content_title') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label">Judul Konten <span style="color: #ef4444;">*</span></label>
            <input type="text" name="content_title" value="{{ old('content_title', $content->content_title ?? '') }}" required placeholder="Masukkan judul..." class="form-input">
        </div>

        @error('content_desc') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 0.5rem;">
            <label class="form-label">Deskripsi Lengkap <span style="color: #ef4444;">*</span></label>
        </div>
        <div style="background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; overflow: hidden;">
            <div id="editor-container" style="height: 500px; font-size: 1rem;">{!! old('content_desc', $content->content_desc ?? '') !!}</div>
        </div>
        <textarea name="content_desc" id="hidden_content_desc" style="display: none;"></textarea>
    </div>

    <!-- Kolom Kanan: Pengaturan -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden; align-self: start;">
        <div style="padding: 1.5rem 2rem; background: #f8fafc; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="settings" style="width: 20px; height: 20px; color: #8b5cf6;"></i>
                Pengaturan
            </h4>
        </div>

        <div style="padding: 2rem;">
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Diterbitkan pada</label>
                @php 
                    $pubDate = old('publish_date', $content->input_date ?? ''); 
                    if($pubDate) $pubDate = date('Y-m-d\TH:i', strtotime($pubDate));
                @endphp
                <input type="datetime-local" name="publish_date" value="{{ $pubDate }}" class="form-input">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Ini Berita <span style="color: #ef4444;">*</span></label>
                <select name="is_news" class="form-input">
                    <option value="0" {{ old('is_news', $content->is_news ?? 0) == 0 ? 'selected' : '' }}>Tidak</option>
                    <option value="1" {{ old('is_news', $content->is_news ?? 0) == 1 ? 'selected' : '' }}>Ya</option>
                </select>
            </div>

            @error('content_path') <div style="color: #ef4444; margin-bottom: 0.5rem; font-size: 0.875rem;">{{ $message }}</div> @enderror
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Path (Harus unik) <span style="color: #ef4444;">*</span></label>
                <input type="text" name="content_path" value="{{ old('content_path', $content->content_path ?? '') }}" required placeholder="contoh: info-terbaru" class="form-input">
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.5rem;">Path digunakan sebagai URL (misal: /page/info-terbaru).</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <label class="form-label">Konsep? <span style="color: #ef4444;">*</span></label>
                @php $isConcept = old('is_concept', ($content->content_ownpage ?? '1') == '2' ? 1 : 0); @endphp
                <select name="is_concept" class="form-input">
                    <option value="0" {{ $isConcept == 0 ? 'selected' : '' }}>Tidak (Publish)</option>
                    <option value="1" {{ $isConcept == 1 ? 'selected' : '' }}>Ya (Simpan sbg Konsep)</option>
                </select>
            </div>

            <button type="submit" class="btn" style="width: 100%; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.875rem; border: none; border-radius: 99px; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.2); cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <i data-lucide="save" style="width: 18px; height: 18px;"></i> {{ $content ? 'Simpan Perubahan' : 'Terbitkan Konten' }}
            </button>
        </div>
    </div>
</form>

<style>
    /* Quill Editor adjustments for form-input style */
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #cbd5e1 !important;
        background: #f8fafc;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .ql-container.ql-snow {
        border: none !important;
    }
</style>

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
        placeholder: 'Mulai mengetik konten Anda di sini...',
        theme: 'snow'
    });

    document.getElementById('konten-form').onsubmit = function() {
        document.getElementById('hidden_content_desc').value = quill.root.innerHTML;
    };
</script>
@endsection


@extends('layouts.admin')

@section('pageTitle', $jurnal ? 'Edit Jurnal' : 'Tulis Jurnal Baru')

@section('content')
<!-- Include Quill CSS & JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<style>
    .ql-container {
        font-family: inherit;
        font-size: 1rem;
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border-color: #cbd5e1 !important;
        background: white;
    }
    .ql-toolbar {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border-color: #cbd5e1 !important;
        background: #f8fafc;
    }
    .ql-editor {
        min-height: 300px;
        line-height: 1.7;
    }
    .ql-editor.ql-blank::before {
        color: #94a3b8;
        font-style: normal;
    }
</style>

<div style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.kegiatan.jurnal.index') }}" style="width: 2.5rem; height: 2.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
            <i data-lucide="arrow-left" style="width: 1.25rem; height: 1.25rem;"></i>
        </a>
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $jurnal ? 'Edit Jurnal' : 'Tulis Jurnal Baru' }}</h1>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0; margin-top: 0.25rem;">Tulis artikel, ulasan, atau berita kegiatan lapak.</p>
        </div>
    </div>

    @if ($errors->any())
    <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem;">
        <div style="font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="alert-circle" style="width: 1.25rem; height: 1.25rem;"></i>
            Terdapat Kesalahan
        </div>
        <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05); overflow: hidden;">
        <form action="{{ $jurnal ? route('admin.kegiatan.jurnal.update', $jurnal->id) : route('admin.kegiatan.jurnal.store') }}" method="POST" enctype="multipart/form-data" id="jurnal-form">
            @csrf
            @if($jurnal)
                @method('PUT')
            @endif

            <div style="padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <!-- Judul -->
                    <div>
                        <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Judul Artikel <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $jurnal->title ?? '') }}" required placeholder="Contoh: Liputan Keseruan Lapak Baca Bulan Ini" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; font-weight: 600; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Kategori <span style="color: #ef4444;">*</span></label>
                        <select name="category" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; background: white;">
                            <option value="Berita" {{ old('category', $jurnal->category ?? '') == 'Berita' ? 'selected' : '' }}>Berita</option>
                            <option value="Wawancara" {{ old('category', $jurnal->category ?? '') == 'Wawancara' ? 'selected' : '' }}>Wawancara</option>
                            <option value="Pengumuman" {{ old('category', $jurnal->category ?? '') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="Kegiatan" {{ old('category', $jurnal->category ?? '') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Foto Sampul -->
                    <div>
                        <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Foto Sampul (Maks. 5MB)</label>
                        @if($jurnal && $jurnal->cover_image)
                            <div style="margin-bottom: 0.5rem; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0; width: fit-content;">
                                <img src="{{ asset('uploads/jurnal/' . $jurnal->cover_image) }}" style="max-height: 120px; display: block;">
                            </div>
                            <span style="font-size: 0.8rem; color: #64748b; display: block; margin-bottom: 0.5rem;">Unggah gambar baru jika ingin mengganti.</span>
                        @endif
                        <input type="file" name="cover_image" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px dashed #cbd5e1; border-radius: 0.5rem; font-size: 0.9rem; background: #f8fafc;">
                    </div>

                    <!-- Status -->
                    <div>
                        <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Status Publikasi</label>
                        <select name="is_published" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; background: white;">
                            <option value="1" {{ old('is_published', $jurnal->is_published ?? true) == true ? 'selected' : '' }}>Publikasikan (Tampil di Website)</option>
                            <option value="0" {{ old('is_published', $jurnal->is_published ?? true) == false ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                        </select>
                    </div>
                </div>

                <!-- Konten Jurnal (Quill) -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Isi Artikel <span style="color: #ef4444;">*</span></label>
                    <input type="hidden" name="content" id="hidden_content">
                    <div id="editor-container">{!! old('content', $jurnal->content ?? '') !!}</div>
                </div>

            </div>

            <!-- Footer Buttons -->
            <div style="padding: 1.5rem 2rem; background: rgba(248, 250, 252, 0.5); border-top: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.kegiatan.jurnal.index') }}" style="padding: 0.75rem 1.5rem; color: #475569; text-decoration: none; font-weight: 600; border-radius: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='transparent'">Batal</a>
                <button type="submit" style="padding: 0.75rem 2rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 99px; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.3); cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    <i data-lucide="save" style="width: 1.25rem; height: 1.25rem;"></i>
                    Simpan Jurnal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Mulai menulis cerita Anda di sini...',
        modules: {
            toolbar: [
                [{ 'header': [2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    var form = document.getElementById('jurnal-form');
    form.onsubmit = function() {
        var content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;
        // Basic validation for empty quill
        if(content.value === '<p><br></p>') {
            content.value = '';
        }
    };
});
</script>
@endsection

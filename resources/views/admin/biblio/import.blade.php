@extends('layouts.admin')

@section('pageTitle', 'Import Bibliography')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 800px; margin: 0 auto; border: 1px solid #e2e8f0;">
    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Impor Data Buku (CSV)</h3>
    
    <div style="background: #f1f5f9; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #475569;">
        <p style="margin-bottom: 0.5rem;"><strong>Format CSV yang didukung:</strong> Separator Koma (,) atau Titik Koma (;)</p>
        <p>Susunan kolom pada baris pertama (Header) dilewati. Pastikan susunan data dari kolom 1 s/d 6 seperti di bawah ini:</p>
        <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
            <li>Kolom 1: <strong>Judul / Title</strong> (Wajib)</li>
            <li>Kolom 2: <strong>ISBN / ISSN</strong></li>
            <li>Kolom 3: <strong>GMD ID</strong> (Contoh: 1 untuk Teks)</li>
            <li>Kolom 4: <strong>Publisher ID</strong></li>
            <li>Kolom 5: <strong>Tahun Terbit</strong></li>
            <li>Kolom 6: <strong>Call Number</strong></li>
        </ul>
    </div>

    <form action="{{ route('admin.biblio.process_import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Pilih File (CSV)</label>
            <input type="file" name="file" accept=".csv" required style="display: block; width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">Upload & Import</button>
            <a href="{{ route('admin.biblio.index') }}" class="btn" style="background: #cbd5e1; color: #475569; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none;">Batal</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin')

@section('pageTitle', 'Import Kala Terbit (CSV)')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 2rem; max-width: 800px;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Impor Data Kala Terbit dari CSV</h3>
    
    <div style="background: #f1f5f9; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #475569;">
        <p style="margin-bottom: 0.5rem;"><strong>Format CSV yang didukung:</strong> Separator Koma (,) atau Titik Koma (;)</p>
        <p>Susunan kolom pada baris pertama (Header) dilewati. Pastikan susunan data dari kolom 1 s/d 5 seperti di bawah ini:</p>
        <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
            <li>Kolom 1: <strong>ID</strong> (Kosongkan jika ingin ID otomatis baru)</li>
            <li>Kolom 2: <strong>Kala Terbit</strong> (Wajib)</li>
            <li>Kolom 3: <strong>Awalan Bahasa</strong></li>
            <li>Kolom 4: <strong>Jeda Waktu</strong> (Angka bulat)</li>
            <li>Kolom 5: <strong>Unit Waktu</strong> (day / week / month / year)</li>
        </ul>
    </div>

    <form action="{{ route('admin.frequency.process_import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">File CSV</label>
            <input type="file" name="file" accept=".csv" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; background: #fff;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 0.375rem;">Mulai Impor</button>
            <a href="{{ route('admin.frequency.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1.5rem; text-decoration: none; border-radius: 0.375rem;">Batal</a>
        </div>
    </form>
</div>
@endsection


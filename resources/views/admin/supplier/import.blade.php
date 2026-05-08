@extends('layouts.admin')

@section('pageTitle', 'Import Agen (CSV)')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 2rem; max-width: 800px;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Impor Data Agen dari CSV</h3>
    
    <div style="background: #f1f5f9; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #475569;">
        <p style="margin-bottom: 0.5rem;"><strong>Format CSV yang didukung:</strong> Separator Koma (,) atau Titik Koma (;)</p>
        <p>Susunan kolom pada baris pertama (Header) dilewati. Pastikan susunan data dari kolom 1 s/d 9 seperti di bawah ini:</p>
        <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
            <li>Kolom 1: <strong>Supplier ID</strong> (Kosongkan jika ingin ID otomatis baru)</li>
            <li>Kolom 2: <strong>Nama Agen</strong> (Wajib)</li>
            <li>Kolom 3: <strong>Kontak</strong></li>
            <li>Kolom 4: <strong>Telepon</strong></li>
            <li>Kolom 5: <strong>Email</strong></li>
            <li>Kolom 6: <strong>Alamat</strong></li>
            <li>Kolom 7: <strong>Kode Pos</strong></li>
            <li>Kolom 8: <strong>Fax</strong></li>
            <li>Kolom 9: <strong>Akun</strong></li>
        </ul>
    </div>

    <form action="{{ route('admin.supplier.process_import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">File CSV</label>
            <input type="file" name="file" accept=".csv" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; background: #fff;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 0.375rem;">Mulai Impor</button>
            <a href="{{ route('admin.supplier.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1.5rem; text-decoration: none; border-radius: 0.375rem;">Batal</a>
        </div>
    </form>
</div>
@endsection

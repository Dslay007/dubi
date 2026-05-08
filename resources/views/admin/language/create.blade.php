@extends('layouts.admin')

@section('pageTitle', 'Add Bahasa')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 2rem; max-width: 600px;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 1.5rem;">Tambah Bahasa Dokumen</h3>

    <form action="{{ route('admin.language.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">ID Bahasa (Maks 5 Karakter) <span style="color: #ef4444;">*</span></label>
            <input type="text" name="language_id" required maxlength="5"
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Nama Bahasa <span style="color: #ef4444;">*</span></label>
            <input type="text" name="language_name" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 0.375rem;">Simpan</button>
            <a href="{{ route('admin.language.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1.5rem; text-decoration: none; border-radius: 0.375rem;">Batal</a>
        </div>
    </form>
</div>
@endsection

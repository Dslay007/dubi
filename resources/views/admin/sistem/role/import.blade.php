@extends('layouts.admin')

@section('pageTitle', 'Import Role & Permission')

@section('content')

<x-master-header 
    title="Import Role & Permission" 
    subtitle="Import grup pengguna dan hak akses melalui file CSV." 
    icon="upload"
>
    <a href="{{ route('admin.sistem.role.index') }}" class="btn" style="background: white; color: #475569; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 600; font-size: 0.875rem; border: 1px solid #cbd5e1; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
    </a>
</x-master-header>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); max-width: 600px;">
    <form action="{{ route('admin.sistem.role.process_import') }}" method="POST" enctype="multipart/form-data" style="padding: 2rem;">
        @csrf

        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 1rem; padding: 1.25rem; margin-bottom: 2rem;">
            <p style="font-size: 0.875rem; color: #1e40af; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="info" style="width: 18px; height: 18px;"></i> Format CSV yang diterima:
            </p>
            <code style="font-size: 0.85rem; color: #334155; display: block; margin-top: 0.5rem; background: rgba(255,255,255,0.5); padding: 0.5rem; border-radius: 0.5rem;">group_id, group_name, module_id, module_name, read, write</code>
            <p style="font-size: 0.85rem; color: #1e3a8a; margin-top: 0.75rem; line-height: 1.5;">Anda bisa mendapatkan file contoh dengan menggunakan fitur <strong>Export</strong> terlebih dahulu dari daftar grup pengguna.</p>
        </div>

        @error('file') <div style="color: #ef4444; font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 2rem;">
            <label class="form-label">Pilih File CSV <span style="color: #ef4444;">*</span></label>
            <input type="file" name="file" accept=".csv,.txt" required class="form-input" style="padding: 0.5rem;">
        </div>

        <button type="submit" class="btn" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.875rem; border: none; border-radius: 99px; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2); cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <i data-lucide="upload-cloud" style="width: 18px; height: 18px;"></i> Mulai Import
        </button>
    </form>
</div>

@endsection


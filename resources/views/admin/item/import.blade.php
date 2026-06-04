@extends('layouts.admin')

@section('pageTitle', 'Import Eksemplar')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #10b981;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            Import Data Eksemplar (CSV)
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Tambahkan data fisik buku (eksemplar) secara massal.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.item.index') }}" class="btn" style="background: white; color: #475569; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: 2px solid #e2e8f0; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>
</div>

<div style="max-width: 800px; margin: 0 auto;">
    <div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2.5rem;">
        
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 1.25rem; padding: 1.5rem; margin-bottom: 2.5rem; display: flex; gap: 1rem;">
            <div style="color: #059669; flex-shrink: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div>
                <h4 style="color: #065f46; font-weight: 800; font-size: 1.05rem; margin: 0 0 0.5rem 0;">Panduan Format CSV</h4>
                <p style="color: #047857; font-size: 0.9rem; margin: 0 0 0.75rem 0;">Gunakan Separator <strong>Koma (,)</strong> atau <strong>Titik Koma (;)</strong>. Baris pertama (Header) akan dilewati oleh sistem. Pastikan susunan data dari kolom 1 s/d 4 tepat seperti ini:</p>
                
                <ul style="color: #047857; font-size: 0.9rem; margin: 0; padding-left: 1.2rem; line-height: 1.6;">
                    <li>Kolom 1: <strong>Kode Item / Barcode</strong> <span style="color: #ef4444; font-size: 0.8rem;">(Wajib)</span></li>
                    <li>Kolom 2: <strong>Bibliografi ID</strong> <span style="opacity: 0.8;">(opsional)</span></li>
                    <li>Kolom 3: <strong>Call Number</strong></li>
                    <li>Kolom 4: <strong>Status Eksemplar ID</strong></li>
                </ul>
            </div>
        </div>

        <form action="{{ route('admin.item.process_import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 2.5rem;">
                <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.75rem;">Pilih File CSV</label>
                <div style="border: 2px dashed #cbd5e1; border-radius: 1.25rem; padding: 2rem; text-align: center; background: #f8fafc; transition: 0.2s;" onmouseover="this.style.borderColor='#10b981'; this.style.background='#f0fdf4';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
                    <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #94a3b8; margin: 0 auto 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M8 13h2"/><path d="M8 17h2"/><path d="M14 13h2"/><path d="M14 17h2"/></svg>
                    </div>
                    <input type="file" name="file" accept=".csv,.txt" required class="input" style="width: 100%; max-width: 400px; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.75rem; outline: none; background: white; cursor: pointer; margin: 0 auto; display: block;">
                    <p style="color: #64748b; font-size: 0.85rem; margin-top: 1rem;">Maksimal ukuran file: 2MB.</p>
                </div>
            </div>

            <div style="display: flex; justify-content: center; gap: 1rem;">
                <a href="{{ route('admin.item.index') }}" class="btn" style="padding: 0.85rem 2rem; background: white; color: #475569; border: 2px solid #e2e8f0; border-radius: 99px; font-weight: 700; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">Batal</a>
                <button type="submit" class="btn" style="padding: 0.85rem 2.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">Mulai Import Eksemplar</button>
            </div>
        </form>
        
    </div>
</div>
@endsection


@extends('layouts.admin')

@section('pageTitle', 'Import Anggota (CSV)')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            Impor Data Anggota
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Tambahkan data anggota secara massal melalui file CSV.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.member.index') }}" class="btn" style="background: white; color: #475569; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: 2px solid #e2e8f0; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Upload File CSV
        </h3>
    </div>

    <div style="padding: 2rem;">
        <div style="background: #eff6ff; padding: 1.5rem; border-radius: 1rem; border: 1px solid #bfdbfe; margin-bottom: 2rem; color: #1e3a8a;">
            <div style="display: flex; gap: 0.75rem; align-items: flex-start; margin-bottom: 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 0.1rem; color: #3b82f6;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/></svg>
                <div>
                    <h4 style="font-weight: 800; margin: 0 0 0.5rem 0; font-size: 1rem; color: #1e3a8a;">Panduan Format CSV</h4>
                    <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem; line-height: 1.5;">Gunakan separator <strong>Koma (,)</strong> atau <strong>Titik Koma (;)</strong>. Baris pertama (Header) akan dilewati otomatis. Pastikan urutan kolom sebagai berikut:</p>
                </div>
            </div>
            
            <div style="background: white; border-radius: 0.75rem; padding: 1rem; border: 1px solid #bfdbfe;">
                <ol style="margin: 0; padding-left: 1.25rem; font-size: 0.9rem; line-height: 1.6; color: #334155;">
                    <li><strong style="color: #0f172a;">ID Anggota / Member ID</strong> <span style="color: #ef4444; font-size: 0.8rem; font-weight: 700;">(Wajib)</span></li>
                    <li><strong style="color: #0f172a;">Nama Anggota</strong></li>
                    <li><strong style="color: #0f172a;">Gender</strong> (0 = Laki-laki, 1 = Perempuan)</li>
                    <li><strong style="color: #0f172a;">Tipe Keanggotaan ID</strong> (Contoh: 1)</li>
                    <li><strong style="color: #0f172a;">Email</strong></li>
                    <li><strong style="color: #0f172a;">Nomor Telepon</strong></li>
                    <li><strong style="color: #0f172a;">Alamat</strong></li>
                </ol>
            </div>
            
            <div style="display: flex; gap: 0.5rem; align-items: center; margin-top: 1rem; color: #b91c1c; font-size: 0.85rem; font-weight: 600; background: #fef2f2; padding: 0.75rem 1rem; border-radius: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Jika ID Anggota sudah ada di database, data lama akan ditimpa (update).
            </div>
        </div>

        <form action="{{ route('admin.member.process_import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 2rem;">
                <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Pilih File CSV <span style="color: #ef4444;">*</span></label>
                
                <div style="position: relative; border: 2px dashed #cbd5e1; border-radius: 1rem; padding: 2rem; text-align: center; background: #f8fafc; transition: 0.2s;" onmouseover="this.style.borderColor='#3b82f6'; this.style.background='#eff6ff';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
                    <input type="file" name="file" accept=".csv" required style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                    <div style="pointer-events: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #94a3b8; margin-bottom: 1rem;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="18" y2="12"/><line x1="9" x2="15" y1="15" y2="15"/></svg>
                        <p style="margin: 0 0 0.5rem 0; font-weight: 700; color: #334155; font-size: 1.1rem;">Klik atau seret file CSV ke sini</p>
                        <p style="margin: 0; color: #64748b; font-size: 0.9rem;">Maksimal ukuran file: 2MB</p>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 2rem;">
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.8rem 2.5rem; border: none; border-radius: 99px; font-weight: 700; font-size: 1rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                    Mulai Impor Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


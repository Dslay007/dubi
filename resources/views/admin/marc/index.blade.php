@extends('layouts.admin')

@section('pageTitle', 'MARC Import/Export')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #0ea5e9;"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="m8 13 4 4 4-4"/><path d="M12 17V9"/></svg>
            MARC Tools
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Fasilitas pertukaran data bibliografi menggunakan standar Machine-Readable Cataloging (MARC).</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
    
    <!-- Import Section -->
    <div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2.5rem; position: relative;">
        <div style="position: absolute; top: -1rem; left: 2.5rem; background: #0ea5e9; color: white; padding: 0.25rem 1rem; border-radius: 99px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.4rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            MARC Import
        </div>

        <h3 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin-top: 1rem; margin-bottom: 0.5rem;">Import Data (.mrc)</h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 2rem;">Upload file rekaman MARC untuk ditambahkan ke dalam database bibliografi.</p>

        <form action="{{ route('admin.marc.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 2rem;">
                <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: #0ea5e9; margin-bottom: 0.75rem;">Pilih File MARC</label>
                <div style="border: 2px dashed #bae6fd; border-radius: 1.25rem; padding: 2.5rem 1.5rem; text-align: center; background: #f0f9ff; transition: 0.2s;" onmouseover="this.style.borderColor='#0ea5e9'; this.style.background='#e0f2fe';" onmouseout="this.style.borderColor='#bae6fd'; this.style.background='#f0f9ff';">
                    <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #7dd3fc; margin: 0 auto 1.5rem; box-shadow: 0 4px 6px -1px rgba(14,165,233,0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M8 13h2"/><path d="M8 17h2"/><path d="M14 13h2"/><path d="M14 17h2"/></svg>
                    </div>
                    <input type="file" name="marc_file" accept=".mrc" required class="input" style="width: 100%; max-width: 300px; padding: 0.75rem; border: 1px solid #7dd3fc; border-radius: 0.75rem; outline: none; background: white; cursor: pointer; margin: 0 auto; display: block;">
                </div>
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 0.85rem; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: white; border: none; border-radius: 0.75rem; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(14,165,233,0.2); transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                Proses Import MARC
            </button>
        </form>
    </div>

    <!-- Export Section -->
    <div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2.5rem; position: relative;">
        <div style="position: absolute; top: -1rem; left: 2.5rem; background: #10b981; color: white; padding: 0.25rem 1rem; border-radius: 99px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.4rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            MARC Export
        </div>

        <h3 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin-top: 1rem; margin-bottom: 0.5rem;">Export Data (.mrc)</h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 2rem;">Unduh seluruh data bibliografi saat ini ke dalam format standar MARC untuk backup atau migrasi.</p>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1.25rem; padding: 2.5rem 1.5rem; text-align: center; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981; margin: 0 auto 1.5rem; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            </div>
            <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Siap untuk Diunduh</div>
            <p style="color: #64748b; font-size: 0.85rem; max-width: 250px; margin: 0 auto;">Klik tombol di bawah ini untuk memulai proses ekspor MARC.</p>
        </div>

        <a href="{{ route('admin.marc.export') }}" class="btn" style="width: 100%; text-decoration: none; padding: 0.85rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 0.75rem; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.2); transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Download Export MARC
        </a>
    </div>

</div>
@endsection


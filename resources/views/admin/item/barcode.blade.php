@extends('layouts.admin')

@section('pageTitle', 'Cetak Barcode Massal')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #8b5cf6;"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
            Cetak Barcode Berdasarkan Filter
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Konfigurasi parameter untuk mencetak barcode eksemplar secara massal.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.item.index') }}" class="btn" style="background: white; color: #475569; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: 2px solid #e2e8f0; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2.5rem;">
    
    @if(session('error'))
        <div style="background: #fef2f2; color: #dc2626; padding: 1rem 1.5rem; border-radius: 1rem; margin-bottom: 2rem; border: 1px solid #fecaca; display: flex; align-items: center; gap: 0.75rem; font-weight: 600;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.item.print_barcodes_filter') }}" method="POST" target="_blank">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            
            <!-- Date Range -->
            <div style="background: #f8fafc; padding: 2rem; border-radius: 1.25rem; border: 1px solid #e2e8f0; position: relative;">
                <div style="position: absolute; top: -1rem; left: 1.5rem; background: #8b5cf6; color: white; padding: 0.25rem 1rem; border-radius: 99px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    Berdasarkan Tanggal
                </div>
                
                <div style="margin-top: 0.5rem; margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Mulai Tanggal</label>
                    <input type="date" name="date_start" class="input" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#8b5cf6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Sampai Tanggal</label>
                    <input type="date" name="date_end" class="input" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#8b5cf6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
            </div>

            <!-- Item Code Pattern -->
            <div style="background: #f8fafc; padding: 2rem; border-radius: 1.25rem; border: 1px solid #e2e8f0; position: relative;">
                <div style="position: absolute; top: -1rem; left: 1.5rem; background: #8b5cf6; color: white; padding: 0.25rem 1rem; border-radius: 99px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5v14"/><path d="M8 5v14"/><path d="M12 5v14"/><path d="M16 5v14"/><path d="M20 5v14"/></svg>
                    Berdasarkan Kode
                </div>

                <div style="margin-top: 0.5rem; margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Pola Kode (Contoh: B001)</label>
                    <input type="text" name="item_code_pattern" placeholder="Mulai dengan..." class="input" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#8b5cf6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Dari Kode</label>
                        <input type="text" name="item_code_start" class="input" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#8b5cf6';" onblur="this.style.borderColor='#e2e8f0';">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Sampai Kode</label>
                        <input type="text" name="item_code_end" class="input" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#8b5cf6';" onblur="this.style.borderColor='#e2e8f0';">
                    </div>
                </div>
            </div>

            <!-- Other Options -->
            <div style="background: #f8fafc; padding: 2rem; border-radius: 1.25rem; border: 1px solid #e2e8f0; position: relative;">
                <div style="position: absolute; top: -1rem; left: 1.5rem; background: #8b5cf6; color: white; padding: 0.25rem 1rem; border-radius: 99px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Opsi Filter Lainnya
                </div>

                <div style="margin-top: 0.5rem; margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Tipe Koleksi (GMD)</label>
                    <select name="gmd_id" class="input" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; background: white; transition: 0.2s;" onfocus="this.style.borderColor='#8b5cf6';" onblur="this.style.borderColor='#e2e8f0';">
                        <option value="">-- Semua GMD --</option>
                        @foreach($gmds as $gmd)
                            <option value="{{ $gmd->gmd_id }}">{{ $gmd->gmd_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Batasi Hasil (Maksimal)</label>
                    <input type="number" name="limit" value="50" min="1" max="500" class="input" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#8b5cf6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
            </div>

        </div>

        <div style="margin-top: 2.5rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.85rem 2.5rem; border-radius: 99px; font-weight: 700; cursor: pointer; border: none; box-shadow: 0 4px 6px -1px rgba(139,92,246,0.2); transition: 0.2s; display: inline-flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                Cetak Barcode Berdasarkan Filter
            </button>
        </div>
    </form>
</div>
@endsection

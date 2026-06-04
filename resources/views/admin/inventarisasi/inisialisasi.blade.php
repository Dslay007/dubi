@extends('layouts.admin')

@section('pageTitle', 'Inisialisasi Inventarisasi')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <i data-lucide="package-search" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
            Inisialisasi Inventarisasi
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Buat sesi inventarisasi (Stock Take) baru dan salin data eksemplar untuk disesuaikan.</p>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;">
    @if($activeStockTake)
    <div style="padding: 3rem; text-align: center; display: flex; flex-direction: column; align-items: center;">
        <div style="width: 4rem; height: 4rem; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
            <i data-lucide="alert-triangle" style="width: 2rem; height: 2rem;"></i>
        </div>
        <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; margin-bottom: 0.5rem;">Sesi Masih Aktif!</h3>
        <p style="color: #64748b; margin-bottom: 2rem; max-width: 500px;">
            Sesi inventarisasi <strong>"{{ $activeStockTake->stock_take_name }}"</strong> saat ini sedang berjalan (dimulai sejak {{ $activeStockTake->start_date }}). Anda harus menyelesaikan sesi tersebut sebelum memulai yang baru.
        </p>
        
        <form action="{{ route('admin.inventarisasi.finish', $activeStockTake->stock_take_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan sesi inventarisasi ini? Anda tidak dapat menambah rekaman lagi setelah ini.');">
            @csrf
            <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.75rem 2rem; border: none; border-radius: 99px; font-weight: 700; font-size: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i>
                Selesaikan Sesi Ini
            </button>
        </form>
    </div>
    @else
    <form action="{{ route('admin.inventarisasi.init') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem; padding: 2rem;">
            
            <!-- Kolom Kiri: Info Utama -->
            <div>
                <h4 style="font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="info" style="width: 18px; height: 18px; color: #8b5cf6;"></i>
                    Informasi Sesi
                </h4>
                
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label">Nama / Nomor Sesi Inventarisasi <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="stock_take_name" required placeholder="Contoh: Stock Take 2026 atau Inv-001" class="form-input">
                    <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.5rem;">Berikan penamaan unik agar mudah diidentifikasi di riwayat.</p>
                </div>
            </div>

            <!-- Kolom Kanan: Filter Data -->
            <div>
                <h4 style="font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="filter" style="width: 18px; height: 18px; color: #8b5cf6;"></i>
                    Filter Data Eksemplar (Opsional)
                </h4>

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">GMD</label>
                    <select name="gmd_id" class="form-input">
                        <option value="">Semua GMD</option>
                        @foreach($gmds as $gmd)
                            <option value="{{ $gmd->gmd_id }}">{{ $gmd->gmd_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">Tipe Koleksi</label>
                    <select name="coll_type_id" class="form-input">
                        <option value="">Semua Tipe Koleksi</option>
                        @foreach($collTypes as $ct)
                            <option value="{{ $ct->coll_type_id }}">{{ $ct->coll_type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">Lokasi</label>
                    <select name="location_id" class="form-input">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->location_id }}">{{ $loc->location_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div style="padding: 1.5rem 2rem; border-top: 1px solid rgba(0,0,0,0.05); background: #f8fafc; text-align: right;">
            <button type="submit" class="btn" onclick="return confirm('Proses ini akan menyalin data buku ke dalam sesi inventaris baru. Lanjutkan?');" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.875rem 2rem; border: none; border-radius: 99px; font-weight: 700; font-size: 1rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(139,92,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <i data-lucide="play-circle" style="width: 18px; height: 18px;"></i>
                Mulai Inisialisasi
            </button>
        </div>
    </form>
    @endif
</div>

@endsection


@extends('layouts.admin')

@section('pageTitle', 'Inisialisasi Inventarisasi')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 2rem;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <h3 style="font-weight: 700; color: #1e293b; font-size: 1.25rem;">Inisialisasi Inventarisasi (Stock Take)</h3>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">Buat sesi inventarisasi baru dan salin data eksemplar ke dalam sesi ini. Anda dapat menyaring eksemplar berdasarkan GMD, Tipe Koleksi, atau Lokasi.</p>
    </div>

    @if($activeStockTake)
    <div style="padding: 2rem; text-align: center;">
        <div style="background: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 1.5rem; border-radius: 0.5rem; display: inline-block; text-align: left; max-width: 600px;">
            <h4 style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1rem;">Perhatian!</h4>
            <p style="margin-bottom: 1rem; font-size: 0.95rem;">Sesi inventarisasi <strong>"{{ $activeStockTake->stock_take_name }}"</strong> saat ini sedang aktif (dimulai sejak {{ $activeStockTake->start_date }}). Anda tidak dapat memulai sesi baru sebelum sesi yang aktif diselesaikan.</p>
            <form action="{{ route('admin.inventarisasi.finish', $activeStockTake->stock_take_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan sesi inventarisasi ini?');">
                @csrf
                <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 0.375rem; font-weight: 500;">Selesaikan Sesi Ini</button>
            </form>
        </div>
    </div>
    @else
    <form action="{{ route('admin.inventarisasi.init') }}" method="POST" style="padding: 2rem;">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Kolom Kiri: Penomoran DB / Nama -->
            <div>
                <h4 style="font-weight: 600; color: #334155; margin-bottom: 1.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem;">Penomoran DB</h4>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Nama / Nomor Sesi Inventarisasi <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="stock_take_name" required placeholder="Contoh: Stock Take 2026 atau Inv-001"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 1rem;">
                    <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Masukkan nama unik atau identifier untuk sesi inventarisasi ini.</p>
                </div>
            </div>

            <!-- Kolom Kanan: Filter Inisialisasi Angka -->
            <div>
                <h4 style="font-weight: 600; color: #334155; margin-bottom: 1.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem;">Filter Data Item (Opsional)</h4>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">GMD</label>
                    <select name="gmd_id" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: #fff;">
                        <option value="">Semua GMD</option>
                        @foreach($gmds as $gmd)
                            <option value="{{ $gmd->gmd_id }}">{{ $gmd->gmd_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Tipe Koleksi</label>
                    <select name="coll_type_id" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: #fff;">
                        <option value="">Semua Tipe Koleksi</option>
                        @foreach($collTypes as $ct)
                            <option value="{{ $ct->coll_type_id }}">{{ $ct->coll_type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Lokasi</label>
                    <select name="location_id" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: #fff;">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->location_id }}">{{ $loc->location_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; text-align: right;">
            <button type="submit" class="btn" onclick="return confirm('Proses ini akan menyalin data buku ke dalam sesi inventaris baru. Lanjutkan?');" style="background: #3b82f6; color: white; padding: 0.75rem 2rem; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 1rem; cursor: pointer;">
                Mulai Inisialisasi Angka (Initialize)
            </button>
        </div>
    </form>
    @endif
</div>

@endsection

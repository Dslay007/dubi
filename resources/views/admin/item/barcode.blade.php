@extends('layouts.admin')

@section('pageTitle', 'Cetak Barcode Massal')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Cetak Barcode Berdasarkan Filter</h3>
    
    @if(session('error'))
        <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.item.print_barcodes_filter') }}" method="POST" target="_blank">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            
            <!-- Date Range -->
            <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                <h4 style="font-size: 0.9rem; font-weight: 600; margin-bottom: 1rem; color: #475569;">Berdasarkan Tanggal Diterima</h4>
                <div style="margin-bottom: 0.75rem;">
                    <label class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
                    <input type="date" name="date_start" class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" name="date_end" class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                </div>
            </div>

            <!-- Item Code Pattern -->
            <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                <h4 style="font-size: 0.9rem; font-weight: 600; margin-bottom: 1rem; color: #475569;">Berdasarkan Kode Eksemplar</h4>
                <div style="margin-bottom: 0.75rem;">
                    <label class="block text-sm font-medium text-gray-700">Pola Kode (Contoh: B001)</label>
                    <input type="text" name="item_code_pattern" placeholder="Start with..." class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                </div>
                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari Kode</label>
                        <input type="text" name="item_code_start" class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sampai Kode</label>
                        <input type="text" name="item_code_end" class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                    </div>
                </div>
            </div>

            <!-- Other Options -->
            <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                <h4 style="font-size: 0.9rem; font-weight: 600; margin-bottom: 1rem; color: #475569;">Opsi Lainnya</h4>
                <div style="margin-bottom: 0.75rem;">
                    <label class="block text-sm font-medium text-gray-700">Tipe Koleksi (GMD)</label>
                    <select name="gmd_id" class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                        <option value="">Semua GMD</option>
                        @foreach($gmds as $gmd)
                            <option value="{{ $gmd->gmd_id }}">{{ $gmd->gmd_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Batasi Hasil (Maksimal)</label>
                    <input type="number" name="limit" value="50" min="1" max="500" class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                </div>
            </div>

        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn" style="background: #0f172a; color: white; padding: 0.75rem 2rem; border-radius: 99px; font-weight: 600; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="printer"></i> Cetak Barcode
            </button>
        </div>
    </form>
</div>
@endsection

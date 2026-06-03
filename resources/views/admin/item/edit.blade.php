@extends('layouts.admin')

@section('pageTitle', 'Edit Item (Eksemplar)')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0;">Edit Data Eksemplar</h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0; margin-top: 0.25rem;">Perbarui informasi inventaris, lokasi, dan status riwayat pengadaan buku fisik.</p>
    </div>

    <form action="{{ route('admin.item.update', $item->item_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Section 1: Identitas Eksemplar -->
        <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white);">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="tag" style="color: #3b82f6;"></i> Identitas Eksemplar</h2>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Judul Buku (Bibliografi)</label>
                    <input type="text" value="{{ $item->biblio->title ?? 'Unknown Title' }}" readonly class="form-input" style="background: #f1f5f9; color: #64748b; border-color: #e2e8f0; cursor: not-allowed;">
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">Kode Eksemplar / Barcode *</label>
                        <input type="text" name="item_code" value="{{ old('item_code', $item->item_code) }}" required class="form-input" style="border-color: #3b82f6; background: #eff6ff; font-family: monospace; font-size: 1.1rem;">
                        @error('item_code') <span style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label">No. Inventaris</label>
                        <input type="text" name="inventory_code" value="{{ old('inventory_code', $item->inventory_code) }}" class="form-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div>
                         <label class="form-label">Nomor Panggil (Call Number)</label>
                        <input type="text" name="call_number" value="{{ old('call_number', $item->call_number) }}" class="form-input">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Penempatan & Status -->
        <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white);">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="map-pin" style="color: #10b981;"></i> Penempatan & Status</h2>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div>
                         <label class="form-label">Lokasi Rak / Ruang</label>
                         <select name="location_id" class="form-input">
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach(\App\Models\Location::all() as $loc)
                                <option value="{{ $loc->location_id }}" {{ $item->location_id == $loc->location_id ? 'selected' : '' }}>{{ $loc->location_name }}</option>
                            @endforeach
                         </select>
                    </div>
                    <div>
                         <label class="form-label">Site / Cabang Perpustakaan</label>
                         <input type="text" name="site" value="{{ old('site', $item->site) }}" class="form-input" placeholder="Misal: Perpus Pusat">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">Tipe Koleksi</label>
                        <select name="coll_type_id" class="form-input">
                            <option value="">-- Pilih Tipe Koleksi --</option>
                            @foreach(\App\Models\CollType::all() as $ct)
                                <option value="{{ $ct->coll_type_id }}" {{ $item->coll_type_id == $ct->coll_type_id ? 'selected' : '' }}>{{ $ct->coll_type_name }}</option>
                            @endforeach
                         </select>
                    </div>
                    <div>
                         <label class="form-label">Status Eksemplar</label>
                         <select name="item_status_id" class="form-input">
                            <option value="">-- Pilih Status --</option>
                            @foreach(\App\Models\ItemStatus::all() as $status)
                                <option value="{{ $status->item_status_id }}" {{ $item->item_status_id == $status->item_status_id ? 'selected' : '' }}>{{ $status->item_status_name }}</option>
                            @endforeach
                         </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Section 3: Data Pengadaan -->
        <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white);">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="shopping-cart" style="color: #f59e0b;"></i> Data Pengadaan (Akuisisi)</h2>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                         <label class="form-label">Sumber Pengadaan</label>
                         <select name="source" class="form-input">
                            <option value="0" {{ $item->source == 0 ? 'selected' : '' }}>Beli (Purchase)</option>
                            <option value="1" {{ $item->source == 1 ? 'selected' : '' }}>Hadiah / Hibah</option>
                            <option value="2" {{ $item->source == 2 ? 'selected' : '' }}>Lainnya</option>
                         </select>
                    </div>
                    <div>
                         <label class="form-label">Supplier / Pemasok</label>
                         <select name="supplier_id" class="form-input">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach(\App\Models\Supplier::all() as $sup)
                                <option value="{{ $sup->supplier_id }}" {{ $item->supplier_id == $sup->supplier_id ? 'selected' : '' }}>{{ $sup->supplier_name }}</option>
                            @endforeach
                         </select>
                    </div>
                    <div>
                        <label class="form-label">Tanggal Penerimaan</label>
                        <input type="date" name="received_date" value="{{ old('received_date', $item->received_date) }}" class="form-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">No. Pemesanan (Order No)</label>
                        <input type="text" name="order_no" value="{{ old('order_no', $item->order_no) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Tanggal Pemesanan</label>
                        <input type="date" name="order_date" value="{{ old('order_date', $item->order_date) }}" class="form-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">No. Faktur (Invoice)</label>
                        <input type="text" name="invoice" value="{{ old('invoice', $item->invoice) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Tanggal Faktur</label>
                        <input type="date" name="invoice_date" value="{{ old('invoice_date', $item->invoice_date) }}" class="form-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #e2e8f0;">
                    <div>
                        <label class="form-label">Harga Barang</label>
                        <input type="number" name="price" value="{{ old('price', $item->price) }}" class="form-input" style="font-weight: 700; color: #0f172a;" placeholder="0">
                    </div>
                    <div>
                         <label class="form-label">Mata Uang</label>
                        <input type="text" name="price_currency" value="{{ old('price_currency', $item->price_currency) ?? 'IDR' }}" class="form-input">
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center; justify-content: flex-end; margin-bottom: 3rem;">
            <a href="{{ route('admin.item.index') }}" style="padding: 0.75rem 2rem; background: white; border: 1px solid #cbd5e1; color: #475569; text-decoration: none; border-radius: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9'"><i data-lucide="x" style="width: 1.25rem;"></i> Batal</a>
            <button type="submit" style="padding: 0.75rem 2.5rem; background: #3b82f6; color: white; border: none; border-radius: 0.75rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'"><i data-lucide="save" style="width: 1.25rem;"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

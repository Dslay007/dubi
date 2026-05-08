@extends('layouts.admin')

@section('pageTitle', 'Edit Item (Eksemplar)')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; max-width: 800px;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 2rem;">Edit Data Eksemplar</h3>

    <form action="{{ route('admin.item.update', $item->item_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1.5rem;">
            <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Judul Buku</label>
            <input type="text" value="{{ $item->biblio->title ?? 'Unknown Title' }}" readonly class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: #f1f5f9; color: #64748b;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Kode Eksemplar *</label>
                <input type="text" name="item_code" value="{{ old('item_code', $item->item_code) }}" required class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                @error('item_code') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Nomor Panggil</label>
                <input type="text" name="call_number" value="{{ old('call_number', $item->call_number) }}" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">No. Inventaris</label>
                <input type="text" name="inventory_code" value="{{ old('inventory_code', $item->inventory_code) }}" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Lokasi</label>
                 <select name="location_id" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->location_id }}" {{ $item->location_id == $loc->location_id ? 'selected' : '' }}>{{ $loc->location_name }}</option>
                    @endforeach
                 </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Tipe Koleksi</label>
                <select name="coll_type_id" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                    <option value="">-- Pilih Tipe Koleksi --</option>
                    @foreach($collTypes as $ct)
                        <option value="{{ $ct->coll_type_id }}" {{ $item->coll_type_id == $ct->coll_type_id ? 'selected' : '' }}>{{ $ct->coll_type_name }}</option>
                    @endforeach
                 </select>
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Status Eksemplar</label>
                 <select name="item_status_id" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                    <option value="">-- Pilih Status --</option>
                    @foreach($itemStatuses as $status)
                        <option value="{{ $status->item_status_id }}" {{ $item->item_status_id == $status->item_status_id ? 'selected' : '' }}>{{ $status->item_status_name }}</option>
                    @endforeach
                 </select>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Tanggal Pengadaan</label>
                <input type="date" name="received_date" value="{{ old('received_date', $item->received_date) }}" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Sumber (Source)</label>
                 <select name="source" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                    <option value="0" {{ $item->source == 0 ? 'selected' : '' }}>Beli</option>
                    <option value="1" {{ $item->source == 1 ? 'selected' : '' }}>Hadiah/Hibah</option>
                 </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Harga</label>
                <input type="number" name="price" value="{{ old('price', $item->price) }}" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Mata Uang</label>
                <input type="text" name="price_currency" value="{{ old('price_currency', $item->price_currency) }}" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="padding: 0.75rem 2rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; font-weight: 600; cursor: pointer;">Update Eksemplar</button>
            <a href="{{ route('admin.item.index') }}" style="padding: 0.75rem 2rem; background: #e2e8f0; color: #475569; text-decoration: none; border-radius: 0.375rem; font-weight: 600;">Batal</a>
        </div>
    </form>
</div>
@endsection

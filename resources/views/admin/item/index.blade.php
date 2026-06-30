@extends('layouts.admin')

@section('pageTitle', 'Eksemplar (Items)')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            Daftar Eksemplar
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Kelola data fisik buku dan cetak barcode.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.item.import') }}" class="btn" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#fef3c7';" onmouseout="this.style.background='#fffbeb';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            Import
        </a>
        <a href="{{ route('admin.item.export') }}" class="btn" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#d1fae5';" onmouseout="this.style.background='#ecfdf5';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Export
        </a>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem;">
        <form action="{{ route('admin.item.index') }}" method="GET" style="display: flex; gap: 0.75rem; width: 100%; flex-wrap: wrap; align-items: center;">
            <div style="position: relative;">
                <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode atau Judul..." 
                    style="padding: 0.6rem 1rem 0.6rem 2.5rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; width: 280px; font-family: inherit; font-size: 0.9rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>
            
            <button type="submit" style="padding: 0.6rem 1.25rem; background: #0f172a; color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#1e293b';" onmouseout="this.style.background='#0f172a';">Filter</button>
            <a href="{{ route('admin.item.index') }}" style="padding: 0.6rem 1.25rem; background: white; color: #64748b; border: 2px solid #e2e8f0; border-radius: 99px; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">Reset</a>
        </form>
    </div>

    <form action="{{ route('admin.item.print_barcodes') }}" method="POST" target="_blank">
        @csrf
        <div style="overflow-x: auto; padding: 1rem 2rem;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); width: 40px; text-align: center;">
                            <input type="checkbox" onclick="toggleAll(this)" style="width: 1.1rem; height: 1.1rem; accent-color: #3b82f6; cursor: pointer;">
                        </th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Kode / Barcode</th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Judul</th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tipe & Lokasi</th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">No. Panggil</th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr data-href="{{ route('admin.item.edit', $item->item_id) }}" style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1.25rem 1rem; text-align: center;">
                            <input type="checkbox" name="items[]" value="{{ $item->item_id }}" class="item-checkbox" style="width: 1.1rem; height: 1.1rem; accent-color: #3b82f6; cursor: pointer;">
                        </td>
                        <td style="padding: 1.25rem 1rem;">
                            <div style="font-weight: 800; color: #1e293b; font-family: monospace; letter-spacing: 0.05em; background: #f1f5f9; padding: 0.25rem 0.75rem; border-radius: 0.5rem; display: inline-block; border: 1px solid #e2e8f0;">
                                {{ $item->item_code }}
                            </div>
                        </td>
                        <td style="padding: 1.25rem 1rem;">
                            <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ $item->biblio->title ?? 'Unknown Title' }}</div>
                            @if($item->biblio && $item->biblio->authors->isNotEmpty())
                                <div style="color: #64748b; font-size: 0.8rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle;"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ $item->biblio->authors->pluck('author_name')->join(' - ') }}
                                </div>
                            @endif
                        </td>
                        <td style="padding: 1.25rem 1rem; color: #475569;">
                            <div style="margin-bottom: 0.25rem;">
                                <span style="background: #eff6ff; color: #2563eb; padding: 0.15rem 0.5rem; border-radius: 0.25rem; font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">{{ $item->coll_type_id ?? 'Nonfiksi' }}</span>
                            </div>
                            <div style="font-size: 0.85rem; color: #64748b;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle;"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $item->location_id ?? '-' }}
                            </div>
                        </td>
                        <td style="padding: 1.25rem 1rem; color: #475569; font-weight: 500;">
                            {{ $item->call_number ?? '-' }}
                        </td>
                        <td style="padding: 1.25rem 1rem; text-align: right;">
                            <a href="{{ route('admin.item.edit', $item->item_id) }}" style="background: #f1f5f9; color: #475569; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 4rem 2rem; text-align: center;">
                            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>
                            </div>
                            <h4 style="font-weight: 800; color: #475569; font-size: 1.1rem; margin-bottom: 0.25rem;">Tidak Ada Data Eksemplar</h4>
                            <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Silakan cari atau pastikan data buku sudah memiliki eksemplar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 1.5rem 2rem; border-top: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="font-size: 0.9rem; font-weight: 600; color: #64748b;">
                Total: <span style="color: #0f172a;">{{ $items->total() }}</span> eksemplar
            </div>
            
            <div>
                <button type="submit" class="btn" style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s; display: flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                    Cetak Barcode Terpilih
                </button>
            </div>
        </div>
    </form>
    
    @if($items->hasPages())
    <div style="padding: 0 2rem 2rem 2rem;">
        {{ $items->links() }}
    </div>
    @endif
</div>

<script>
    function toggleAll(source) {
        checkboxes = document.getElementsByClassName('item-checkbox');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
@endsection


@extends('layouts.admin')

@section('pageTitle', 'Pengaturan Reservasi')

@section('content')

<style>
/* Modern Toggle Switch */
.toggle-switch {
  position: relative;
  display: inline-block;
  width: 46px;
  height: 26px;
}
.toggle-switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #e2e8f0;
  transition: .3s cubic-bezier(0.4, 0.0, 0.2, 1);
  border-radius: 34px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
}
.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .3s cubic-bezier(0.4, 0.0, 0.2, 1);
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}
input:checked + .slider {
  background-color: #8b5cf6; /* Modern purple */
}
input:checked + .slider:before {
  transform: translateX(20px);
}
</style>

<form action="{{ route('admin.circulation.reservations.settings.update') }}" method="POST" id="reservationSettingsForm" onsubmit="confirmSaveSettings(event, this)">
    @csrf
    <input type="hidden" name="bulk_action" id="bulkAction" value="">
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem; position: sticky; top: 5.5rem; z-index: 25;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
         <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
             <div>
                 <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #4f46e5;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                     Pengaturan Reservasi
                 </h3>
                 <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Konfigurasi batas maksimal dan status ketersediaan buku untuk direservasi.</p>
             </div>
             <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                 <a href="{{ route('admin.circulation.reservations') }}" class="btn" style="background: white; color: #475569; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                     Kembali
                 </a>
                 <button type="button" id="resetBtn" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.6rem 1.25rem; border-radius: 99px; font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; border: 1px solid #e2e8f0; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                     Reset Perubahan
                 </button>
                 <button type="submit" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; padding: 0.6rem 1.5rem; border: none; border-radius: 99px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 10px -2px rgba(139,92,246,0.4); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px -2px rgba(139,92,246,0.5)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 10px -2px rgba(139,92,246,0.4)';">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                     Simpan Perubahan
                 </button>
             </div>
         </div>
    </div>
</div>
    
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem;">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05);">
            <h4 style="font-weight: 800; font-size: 1.1rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Pengaturan Umum
            </h4>
        </div>
        <div style="padding: 2rem;">
            <div style="max-width: 400px;">
                <label style="display: block; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Maksimal Reservasi per Anggota</label>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <input type="number" name="max_reservations" value="{{ $max_reservations }}" min="1" required style="width: 100px; padding: 0.85rem 1rem; border: 2px solid #cbd5e1; border-radius: 0.75rem; outline: none; font-size: 1.05rem; font-weight: 700; color: #1e293b; text-align: center; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'">
                    <span style="color: #64748b; font-weight: 500;">Buku</span>
                </div>
                <p style="margin-top: 0.75rem; font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">Tentukan batas maksimal jumlah buku yang dapat direservasi oleh seorang anggota dalam waktu yang bersamaan.</p>
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h4 style="font-weight: 800; font-size: 1.1rem; color: #1e293b; margin-bottom: 0.25rem;">Daftar Buku</h4>
                <p style="color: #64748b; font-size: 0.85rem;">Pilih buku yang diizinkan untuk direservasi oleh anggota.</p>
            </div>
            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; width: 100%; max-width: 600px; justify-content: flex-end;">
                <button type="button" onclick="stageBulkAction(1)" class="btn" style="padding: 0.6rem 1rem; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; border-radius: 99px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 0.35rem; flex: 1; min-width: 140px; justify-content: center;" onmouseover="this.style.background='#d1fae5';" onmouseout="this.style.background='#ecfdf5';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Tandai Semua Buku
                </button>
                <button type="button" onclick="stageBulkAction(0)" class="btn" style="padding: 0.6rem 1rem; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 99px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 0.35rem; flex: 1; min-width: 140px; justify-content: center;" onmouseover="this.style.background='#fee2e2';" onmouseout="this.style.background='#fef2f2';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                    Hapus Tanda Semua
                </button>
                
                <div style="display: flex; gap: 0.5rem; align-items: center; background: #f8fafc; padding: 0.5rem; border-radius: 99px; border: 1px solid #e2e8f0; flex: 2; min-width: 250px;">
                    <select id="filterStatus" style="padding: 0.5rem; border: none; background: transparent; outline: none; font-size: 0.85rem; font-family: inherit; color: #475569; border-right: 1px solid #e2e8f0; cursor: pointer; min-width: 100px;">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('filter_status') === '1' ? 'selected' : '' }}>Bisa Direservasi</option>
                        <option value="0" {{ request('filter_status') === '0' ? 'selected' : '' }}>Tidak Bisa</option>
                    </select>
                    <div style="position: relative; flex: 1;">
                        <div style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </div>
                        <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari..." style="padding: 0.5rem 0.5rem 0.5rem 2rem; border: none; background: transparent; outline: none; width: 100%; font-size: 0.85rem; font-family: inherit;" onkeypress="if(event.key === 'Enter'){ event.preventDefault(); applyFilters(); }">
                    </div>
                    <button type="button" onclick="applyFilters()" class="btn" style="padding: 0.5rem 1rem; background: #3b82f6; color: white; border: none; border-radius: 99px; font-weight: 700; font-size: 0.8rem; cursor: pointer; transition: 0.2s; box-shadow: 0 2px 4px rgba(59,130,246,0.2);" onmouseover="this.style.background='#2563eb';" onmouseout="this.style.background='#3b82f6';">Cari</button>
                </div>
            </div>
        </div>
        
        <div style="overflow-x: auto; padding: 1rem 2rem;">
            @php
                function sortUrl($column) {
                    $currentSort = request('sort_by', 'title');
                    $currentOrder = request('order', 'asc');
                    $order = ($currentSort == $column && $currentOrder == 'asc') ? 'desc' : 'asc';
                    return request()->fullUrlWithQuery(['sort_by' => $column, 'order' => $order]);
                }
                function sortIcon($column) {
                    $currentSort = request('sort_by', 'title');
                    $currentOrder = request('order', 'asc');
                    if ($currentSort != $column) return '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>';
                    return $currentOrder == 'asc' ? '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5" style="opacity: 0.3"/></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5" style="opacity: 0.3"/><path d="m7 9 5-5 5 5"/></svg>';
                }
            @endphp
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">
                            <a href="{!! sortUrl('title') !!}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.25rem;">
                                Judul Buku {!! sortIcon('title') !!}
                            </a>
                        </th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">
                            <a href="{!! sortUrl('isbn_issn') !!}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.25rem;">
                                ISBN/ISSN {!! sortIcon('isbn_issn') !!}
                            </a>
                        </th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Eksemplar</th>
                        <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: center;">Bisa Direservasi?</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($biblios as $biblio)
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1.25rem 1rem; color: #1e293b; font-weight: 700;">{{ $biblio->title }}</td>
                        <td style="padding: 1.25rem 1rem; color: #64748b; font-weight: 500;">
                            <span style="background: #f1f5f9; padding: 0.25rem 0.75rem; border-radius: 99px;">{{ $biblio->isbn_issn ?? '-' }}</span>
                        </td>
                        <td style="padding: 1.25rem 1rem; color: #64748b; font-weight: 500;">
                            @if($biblio->items && $biblio->items->count() > 0)
                                <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                                    @foreach($biblio->items->take(5) as $item)
                                        <span style="background: #e0e7ff; color: #3730a3; padding: 0.15rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700;">{{ $item->item_code }}</span>
                                    @endforeach
                                    @if($biblio->items->count() > 5)
                                        <span style="color: #94a3b8; font-size: 0.75rem; padding: 0.15rem 0.5rem; font-weight: 600;">+{{ $biblio->items->count() - 5 }} lainnya</span>
                                    @endif
                                </div>
                            @else
                                <span style="color: #94a3b8; font-style: italic; font-size: 0.8rem;">Belum ada eksemplar</span>
                            @endif
                        </td>
                        <td style="padding: 1.25rem 1rem; text-align: center;">
                            <input type="hidden" name="reservable_status[{{ $biblio->biblio_id }}]" value="0">
                            <label class="toggle-switch">
                                <input type="checkbox" class="reservable-checkbox" name="reservable_status[{{ $biblio->biblio_id }}]" value="1" {{ $biblio->is_reservable ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 3rem 2rem; text-align: center;">
                            <div style="width: 48px; height: 48px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 0.75rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            </div>
                            <p style="color: #64748b; font-weight: 500;">Tidak ada data buku yang sesuai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="padding: 1.5rem 2rem; border-top: 1px solid rgba(0,0,0,0.05); background: #f8fafc;">
            {{ $biblios->links() }}
        </div>
    </div>
</form>

<script>
    let hasUnsavedChanges = false;
    let formIsSubmitting = false;

    document.addEventListener('DOMContentLoaded', () => {
        // Deteksi perubahan form
        document.querySelectorAll('input, select').forEach(el => {
            if (el.id !== 'searchInput' && el.id !== 'filterStatus') {
                el.addEventListener('change', () => { hasUnsavedChanges = true; });
            }
        });
        
        // Reset perubahan
        document.getElementById('resetBtn').addEventListener('click', () => {
            document.getElementById('reservationSettingsForm').reset();
            document.getElementById('bulkAction').value = '';
            hasUnsavedChanges = false;
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Perubahan telah di-reset ke kondisi awal',
                showConfirmButton: false,
                timer: 3000
            });
        });

        // Intercept link clicks if there are unsaved changes
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                // Abaikan jika href kosong, anchor link, js, atau buka tab baru
                if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank') return;
                
                if (hasUnsavedChanges && !formIsSubmitting) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Keluar dari halaman ini?',
                        text: 'Ada perubahan yang belum disimpan. Jika Anda pergi sekarang, perubahan tersebut akan hilang.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Tinggalkan',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl border-0',
                            title: 'font-bold text-slate-800',
                            confirmButton: 'rounded-full font-bold px-6',
                            cancelButton: 'rounded-full font-bold px-6'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hasUnsavedChanges = false;
                            window.location.href = href;
                        }
                    });
                }
            });
        });
    });

    // Perlindungan asli browser (saat reload/close tab)
    window.addEventListener('beforeunload', (e) => {
        if (hasUnsavedChanges && !formIsSubmitting) {
            e.preventDefault();
            e.returnValue = 'Ada perubahan yang belum disimpan.';
        }
    });

    function stageBulkAction(status) {
        document.getElementById('bulkAction').value = status === 1 ? 'enable_all' : 'disable_all';
        
        // Ubah visual checkbox di halaman ini
        const checkboxes = document.querySelectorAll('.reservable-checkbox');
        checkboxes.forEach(cb => { cb.checked = (status === 1); });
        
        hasUnsavedChanges = true;
        
        Swal.fire({
            title: 'Telah Ditandai!',
            text: status === 1 
                ? 'Seluruh buku di database ditandai untuk DIBUKA aksesnya. Jangan lupa klik "Simpan Perubahan" agar benar-benar tersimpan.' 
                : 'Seluruh buku di database ditandai untuk DITUTUP aksesnya. Jangan lupa klik "Simpan Perubahan" agar benar-benar tersimpan.',
            icon: 'info',
            confirmButtonColor: '#10b981',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border-0',
                title: 'font-bold text-slate-800',
                confirmButton: 'rounded-full font-bold px-6'
            }
        });
    }

    function applyFilters() {
        const search = document.getElementById('searchInput').value;
        const filter = document.getElementById('filterStatus').value;
        
        if (hasUnsavedChanges && !confirm("Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin memfilter dan kehilangan perubahan tersebut?")) {
            return;
        }
        
        let url = new URL(window.location.href);
        url.searchParams.set('search', search);
        
        if (filter !== '') {
            url.searchParams.set('filter_status', filter);
        } else {
            url.searchParams.delete('filter_status');
        }
        
        url.searchParams.delete('page'); // Kembali ke halaman 1 saat pencarian baru
        window.location.href = url.toString();
    }


    function confirmSaveSettings(event, form) {
        event.preventDefault();
        
        let confirmText = "Pastikan batas maksimal reservasi dan status buku sudah benar.";
        let bulk = document.getElementById('bulkAction').value;
        
        if (bulk === 'enable_all') {
            confirmText = "PERINGATAN: Anda akan MEMBUKA akses reservasi untuk SELURUH BUKU di database.";
        } else if (bulk === 'disable_all') {
            confirmText = "PERINGATAN: Anda akan MENUTUP akses reservasi untuk SELURUH BUKU di database.";
        }

        Swal.fire({
            title: 'Simpan Pengaturan?',
            text: confirmText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl shadow-2xl border-0',
                title: 'font-bold text-slate-800',
                confirmButton: 'rounded-full font-bold px-6',
                cancelButton: 'rounded-full font-bold px-6'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                formIsSubmitting = true;
                form.submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection


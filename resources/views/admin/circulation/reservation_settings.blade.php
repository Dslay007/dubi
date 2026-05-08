@extends('layouts.admin')

@section('pageTitle', 'Pengaturan Reservasi')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700; font-size: 1.5rem; color: #1e293b;">Pengaturan Buku yang Bisa Direservasi</h2>
    <a href="{{ route('admin.circulation.reservations') }}" style="color: #64748b; text-decoration: none; font-weight: 600;">&larr; Kembali ke Reservasi</a>
</div>

<form action="{{ route('admin.circulation.reservations.settings.update') }}" method="POST">
    @csrf
    
    <div class="card" style="margin-bottom: 2rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
            <h3 style="font-weight: 700; font-size: 1.125rem; color: #1e293b;">Pengaturan Umum</h3>
        </div>
        <div style="padding: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem; font-weight: 600;">Maksimal Reservasi per Anggota</label>
            <input type="number" name="max_reservations" value="{{ $max_reservations }}" min="1" required style="width: 100%; max-width: 200px; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <p style="margin-top: 0.5rem; font-size: 0.8rem; color: #64748b;">Jumlah buku maksimal yang boleh direservasi oleh seorang member pada waktu bersamaan.</p>
        </div>
    </div>

    <div class="card">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <p style="color: #64748b; font-size: 0.875rem;">Centang buku yang diperbolehkan untuk direservasi oleh member.</p>
            <div style="display: flex; gap: 0.5rem;">
                <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari Judul atau ISBN..." style="padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                <button type="button" onclick="window.location.href='?search=' + document.getElementById('searchInput').value" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Cari</button>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 0.75rem;">
                        <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Judul Buku</th>
                        <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">ISBN/ISSN</th>
                        <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; text-align: center;">Bisa Direservasi?</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($biblios as $biblio)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 1rem 1.5rem; color: #1e293b; font-weight: 600;">{{ $biblio->title }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $biblio->isbn_issn ?? '-' }}</td>
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <input type="hidden" name="reservable_status[{{ $biblio->biblio_id }}]" value="0">
                            <input type="checkbox" name="reservable_status[{{ $biblio->biblio_id }}]" value="1" {{ $biblio->is_reservable ? 'checked' : '' }} style="width: 1.25rem; height: 1.25rem; cursor: pointer;">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 2.5rem; text-align: center; color: #64748b;">Tidak ada data buku.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="padding: 1.5rem; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
            <div>
                {{ $biblios->links() }}
            </div>
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.75rem 2rem; border: none; border-radius: 0.375rem; font-weight: 600; cursor: pointer;">Simpan Pengaturan</button>
        </div>
    </div>
</form>
@endsection

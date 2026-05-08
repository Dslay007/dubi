@extends('layouts.admin')

@section('pageTitle', 'Koleksi Perpustakaan')

@section('content')
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Koleksi Perpustakaan</h3>
    </div>

    <!-- Search + Filter -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form method="GET" style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul, ISBN, atau Call Number..."
                style="flex: 1; min-width: 250px; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            <select name="gmd" style="padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem; background: white;">
                <option value="">-- Semua GMD --</option>
                @foreach($gmdList as $g)
                    <option value="{{ $g->gmd_id }}" {{ $gmd == $g->gmd_id ? 'selected' : '' }}>{{ $g->gmd_name }}</option>
                @endforeach
            </select>
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;">Cari</button>
            <a href="{{ route('admin.pelaporan.koleksi_perpustakaan') }}" style="background: #64748b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none;">Reset</a>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.7rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Judul</th>
                    <th style="padding: 0.75rem 1.5rem;">GMD</th>
                    <th style="padding: 0.75rem 1.5rem;">ISBN</th>
                    <th style="padding: 0.75rem 1.5rem;">Penerbit</th>
                    <th style="padding: 0.75rem 1.5rem;">Tahun</th>
                    <th style="padding: 0.75rem 1.5rem;">Call Number</th>
                    <th style="padding: 0.75rem 1.5rem;">Klasifikasi</th>
                    <th style="padding: 0.75rem 1.5rem;">Eksemplar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($koleksi as $k)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.75rem 1.5rem; color: #1e293b; font-weight: 500; max-width: 300px;">{{ Str::limit($k->title, 55) }}</td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center;">
                        <span style="background: #eff6ff; color: #1d4ed8; padding: 0.15rem 0.5rem; border-radius: 1rem; font-size: 0.7rem;">{{ $k->gmd_name ?? '-' }}</span>
                    </td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center; font-family: monospace; font-size: 0.8rem;">{{ $k->isbn_issn ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $k->publisher_name ?? '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $k->publish_year ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center; font-family: monospace;">{{ $k->call_number ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $k->classification ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center;">
                        <span style="background: {{ $k->total_items > 0 ? '#dcfce7' : '#fee2e2' }}; color: {{ $k->total_items > 0 ? '#166534' : '#991b1b' }}; padding: 0.2rem 0.6rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">{{ $k->total_items }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="padding: 2rem; text-align: center; color: #94a3b8;">Tidak ada data ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($koleksi->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $koleksi->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

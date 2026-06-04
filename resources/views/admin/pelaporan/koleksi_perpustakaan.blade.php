@extends('layouts.admin')

@section('pageTitle', 'Koleksi Perpustakaan')

@section('content')

<x-master-header 
    title="Data Koleksi Perpustakaan" 
    subtitle="Laporan menyeluruh mengenai daftar bibliografi dan ketersediaan eksemplar." 
    icon="library"
>
</x-master-header>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="book-open" style="width: 20px; height: 20px; color: #3b82f6;"></i>
            Daftar Koleksi
        </h4>
    </div>

    <!-- Search + Filter -->
    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: white;">
        <form method="GET" style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px; position: relative;">
                <i data-lucide="search" style="width: 16px; height: 16px; color: #94a3b8; position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul, ISBN, atau Call Number..." class="form-input" style="padding-left: 2.5rem; border-radius: 99px;">
            </div>
            
            <div style="position: relative; min-width: 200px;">
                <select name="gmd" class="form-input" style="border-radius: 99px; appearance: none; padding-right: 2.5rem; cursor: pointer;">
                    <option value="">Semua Format GMD</option>
                    @foreach($gmdList as $g)
                        <option value="{{ $g->gmd_id }}" {{ $gmd == $g->gmd_id ? 'selected' : '' }}>{{ $g->gmd_name }}</option>
                    @endforeach
                </select>
                <i data-lucide="chevron-down" style="width: 16px; height: 16px; color: #64748b; position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
            </div>

            <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.6rem 1.25rem; border: none; border-radius: 99px; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <i data-lucide="filter" style="width: 16px; height: 16px;"></i> Terapkan
            </button>
            <a href="{{ route('admin.pelaporan.koleksi_perpustakaan') }}" class="btn" style="background: white; color: #475569; padding: 0.6rem 1.25rem; border: 1px solid #cbd5e1; border-radius: 99px; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
                Reset
            </a>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.05);">Judul Koleksi</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05);">GMD</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05);">ISBN / ISSN</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05);">Penerbit</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05);">Tahun</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05);">Klasifikasi</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05);">Ketersediaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($koleksi as $k)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 1.5rem;">
                        <p style="font-weight: 700; color: #0f172a; margin: 0; line-height: 1.4;">{{ Str::limit($k->title, 60) }}</p>
                        @if($k->call_number)
                            <span style="font-size: 0.75rem; color: #64748b; font-family: monospace; display: inline-block; margin-top: 0.25rem;">Call No: {{ $k->call_number }}</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <span style="background: #eff6ff; color: #2563eb; padding: 0.2rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bfdbfe; white-space: nowrap;">
                            {{ $k->gmd_name ?? 'Tidak Ada' }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #475569; text-align: center; font-family: monospace; font-size: 0.8rem; font-weight: 600;">
                        {{ $k->isbn_issn ?: '-' }}
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; text-align: center;">
                        {{ $k->publisher_name ?? '-' }}
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <span style="background: #f1f5f9; color: #475569; padding: 0.2rem 0.6rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700;">
                            {{ $k->publish_year ?: '-' }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; text-align: center; font-weight: 500;">
                        {{ $k->classification ?: '-' }}
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        @if($k->total_items > 0)
                            <div style="display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; background: #dcfce7; color: #166534; border-radius: 50%; font-weight: 800; font-size: 0.85rem; border: 2px solid #bbf7d0;" title="{{ $k->total_items }} Eksemplar">
                                {{ $k->total_items }}
                            </div>
                        @else
                            <div style="display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; background: #fee2e2; color: #991b1b; border-radius: 50%; font-weight: 800; font-size: 0.85rem; border: 2px solid #fecaca;" title="Tidak ada eksemplar">
                                0
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 4rem 1rem; text-align: center; color: #94a3b8;">
                        <i data-lucide="search-x" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p style="font-weight: 500; color: #475569;">Tidak ada koleksi ditemukan.</p>
                        <p style="font-size: 0.8rem; margin-top: 0.25rem;">Coba gunakan kata kunci pencarian yang lain.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($koleksi->hasPages())
    <div style="padding: 1.5rem 2rem; border-top: 1px solid rgba(0,0,0,0.05); background: white;">
        {{ $koleksi->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection


@extends('layouts.admin')

@section('pageTitle', 'Berita Acara')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Berita Acara</h3>
        <a href="{{ route('admin.acara.berita_acara.create') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="plus-circle" style="width: 1rem; height: 1rem;"></i> Tambah Acara Baru
        </a>
    </div>

    <!-- Filter Form -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.acara.berita_acara.index') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama acara..."
                style="flex: 1; min-width: 250px; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            <input type="date" name="date_from" value="{{ request('date_from') }}" style="padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            <span style="color: #64748b;">-</span>
            <input type="date" name="date_to" value="{{ request('date_to') }}" style="padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            
            <button type="submit" class="btn" style="padding: 0.5rem 1rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-weight: 500; font-size: 0.875rem;">
                <i data-lucide="search" style="width: 1rem; height: 1rem;"></i> Filter
            </button>
            <a href="{{ route('admin.acara.berita_acara.index') }}" class="btn" style="padding: 0.5rem 1rem; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; font-weight: 500;">Reset</a>
        </form>
    </div>

    <!-- Table Data -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; width: 50px;">Sunting</th>
                    <th style="padding: 1rem 1.5rem;">Judul Acara</th>
                    <th style="padding: 1rem 1.5rem;">Tanggal</th>
                    <th style="padding: 1rem 1.5rem;">Lokasi</th>
                    <th style="padding: 1rem 1.5rem;">Status</th>
                    <th style="padding: 1rem 1.5rem; width: 50px;">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <a href="{{ route('admin.acara.berita_acara.edit', $event->id) }}" style="color: #3b82f6; text-decoration: none;" title="Edit">
                            <i data-lucide="edit" style="width: 1.1rem; height: 1.1rem;"></i>
                        </a>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #1e293b; font-weight: 600;">{{ $event->title }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $event->location ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($event->is_active)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Aktif</span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Draft</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <form action="{{ route('admin.acara.berita_acara.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus acara ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;" title="Hapus">
                                <i data-lucide="trash-2" style="width: 1.1rem; height: 1.1rem;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 2rem; text-align: center; color: #94a3b8;">Belum ada data berita acara.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($events->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $events->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

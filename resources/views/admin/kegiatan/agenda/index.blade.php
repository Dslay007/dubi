@extends('layouts.admin')

@section('pageTitle', 'Data Agenda Komunitas')

@section('content')
<x-master-header 
    title="Data Agenda" 
    subtitle="Kelola rutinitas kegiatan lapak baca dan acara komunitas lainnya." 
    icon="calendar-days"
    createRoute="admin.kegiatan.agenda.create"
    createLabel="Tambah Agenda"
>
</x-master-header>

<div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05); overflow: hidden;">
    <!-- Filter Section -->
    <div style="padding: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: rgba(248, 250, 252, 0.5);">
        <form method="GET" action="{{ route('admin.kegiatan.agenda.index') }}" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Cari Judul</label>
                <div style="position: relative;">
                    <i data-lucide="search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; width: 1.2rem; height: 1.2rem;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik judul kegiatan..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit;">
                </div>
            </div>
            <div>
                <button type="submit" class="btn" style="padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    Filter
                </button>
            </div>
            @if(request()->anyFilled(['search', 'date_from', 'date_to']))
            <div>
                <a href="{{ route('admin.kegiatan.agenda.index') }}" style="display: inline-flex; padding: 0.75rem 1.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; color: #64748b; text-decoration: none; font-weight: 500;">
                    Reset
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Table Section -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: rgba(241, 245, 249, 0.5); border-bottom: 2px solid rgba(0,0,0,0.05);">
                    <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Judul Kegiatan</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Tanggal & Lokasi</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Tautan Dokumentasi</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: right; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Aksi</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.95rem;">
                @forelse($agendas as $agenda)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(248, 250, 252, 0.8)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 0.25rem;">{{ $agenda->title }}</div>
                        <div style="font-size: 0.85rem; color: #64748b;">{{ Str::limit(strip_tags($agenda->description), 50) }}</div>
                    </td>
                    <td style="padding: 1.25rem 1.5rem; color: #475569;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <div style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; padding: 0.25rem; border-radius: 0.375rem; display: flex;">
                                <i data-lucide="calendar" style="width: 1rem; height: 1rem;"></i>
                            </div>
                            <span style="font-weight: 600; color: #334155;">{{ \Carbon\Carbon::parse($agenda->event_date)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.85rem; color: #64748b;">
                            <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.25rem; border-radius: 0.375rem; display: flex;">
                                <i data-lucide="map-pin" style="width: 1rem; height: 1rem;"></i>
                            </div>
                            {{ $agenda->location ?? '-' }}
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($agenda->documentation_link)
                            <a href="{{ $agenda->documentation_link }}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.85rem; color: #3b82f6; text-decoration: none; font-weight: 500; background: #eff6ff; padding: 0.25rem 0.75rem; border-radius: 99px;">
                                <i data-lucide="external-link" style="width: 0.9rem; height: 0.9rem;"></i> Link
                            </a>
                        @else
                            <span style="color: #94a3b8; font-size: 0.85rem; font-style: italic;">-</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        @if($agenda->is_active)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">Aktif</span>
                        @else
                            <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">Selesai/Draft</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.kegiatan.agenda.edit', $agenda->id) }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #3b82f6; background: rgba(59,130,246,0.1); text-decoration: none; padding: 0.4rem 0.75rem; border-radius: 0.375rem; font-size: 0.8rem; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='rgba(59,130,246,0.2)'" onmouseout="this.style.background='rgba(59,130,246,0.1)'">
                                <i data-lucide="edit" style="width: 0.9rem; height: 0.9rem;"></i> Edit
                            </a>
                            <form action="{{ route('admin.kegiatan.agenda.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(239,68,68,0.1); border: none; color: #ef4444; padding: 0.4rem 0.75rem; border-radius: 0.375rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(239,68,68,0.2)'" onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                                    <i data-lucide="trash-2" style="width: 0.9rem; height: 0.9rem;"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem 1.5rem; text-align: center; color: #64748b;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                            <div style="width: 5rem; height: 5rem; background: linear-gradient(135deg, rgba(241, 245, 249, 0.8) 0%, rgba(226, 232, 240, 0.8) 100%); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); transform: rotate(-5deg); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.5);">
                                <i data-lucide="calendar-x" style="width: 2.5rem; height: 2.5rem; color: #94a3b8; transform: rotate(5deg);"></i>
                            </div>
                            <div style="font-weight: 600; color: #475569; margin-top: 0.5rem;">Belum ada data agenda.</div>
                            <p style="font-size: 0.85rem; margin: 0; max-width: 300px;">Tambahkan agenda pertama Anda untuk mulai mengatur jadwal rutinitas lapak baca.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($agendas->hasPages())
    <div style="padding: 1.25rem 1.5rem; border-top: 1px solid rgba(0,0,0,0.05); background: rgba(248, 250, 252, 0.5);">
        {{ $agendas->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection


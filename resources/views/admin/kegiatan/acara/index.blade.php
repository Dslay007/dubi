@extends('layouts.admin')

@section('pageTitle', 'Data Acara / Kampanye')

@section('content')
<x-master-header 
    title="Data Acara & Kampanye" 
    subtitle="Kelola acara besar seperti pendaftaran Volunteer. Hanya satu acara yang bisa ditampilkan di beranda." 
    icon="megaphone"
    createRoute="admin.kegiatan.acara.create"
    createLabel="Tambah Acara"
>
</x-master-header>

<div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05); overflow: hidden;">
    <!-- Table Section -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: rgba(241, 245, 249, 0.5); border-bottom: 2px solid rgba(0,0,0,0.05);">
                    <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Acara</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Jumlah Klik Tautan</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Status Tampil (Beranda)</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: right; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Aksi</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.95rem;">
                @forelse($events as $event)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s; {{ $event->is_active ? 'background: #eff6ff;' : '' }}" onmouseover="this.style.background='{{ $event->is_active ? '#e0f2fe' : 'rgba(248, 250, 252, 0.8)' }}'" onmouseout="this.style.background='{{ $event->is_active ? '#eff6ff' : 'transparent' }}'">
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            @php
                                $photos = $event->photos ? json_decode($event->photos, true) : [];
                                $mainPhoto = !empty($photos) ? $photos[0] : null;
                            @endphp
                            
                            @if($mainPhoto)
                                <div style="width: 60px; height: 60px; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                    <img src="{{ asset('uploads/acara/' . $mainPhoto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div style="width: 60px; height: 60px; border-radius: 0.5rem; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                    <i data-lucide="image" style="width: 1.5rem; height: 1.5rem;"></i>
                                </div>
                            @endif
                            
                            <div>
                                <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">
                                    {{ $event->title }}
                                </div>
                                <div style="font-size: 0.85rem; color: #64748b;">
                                    {{ Str::limit(strip_tags($event->description), 60) }}
                                </div>
                                @if(count($photos) > 1)
                                <div style="font-size: 0.75rem; color: #3b82f6; margin-top: 0.25rem; font-weight: 600;">
                                    {{ count($photos) }} Foto (Mode Carousel)
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <div style="display: inline-flex; flex-direction: column; align-items: center; justify-content: center; background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                            <span style="font-weight: 800; font-size: 1.25rem; color: #0f172a; line-height: 1;">{{ number_format($event->click_count) }}</span>
                            <span style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Klik</span>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        @if($event->is_active)
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.4);">
                                <i data-lucide="check-circle" style="width: 1rem; height: 1rem;"></i> Sedang Tampil
                            </span>
                        @else
                            <form action="{{ route('admin.kegiatan.acara.toggle', $event->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="display: inline-flex; align-items: center; gap: 0.25rem; background: white; color: #475569; padding: 0.5rem 1rem; border-radius: 99px; border: 1px solid #cbd5e1; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8';">
                                    <i data-lucide="monitor-up" style="width: 1rem; height: 1rem;"></i> Tampilkan
                                </button>
                            </form>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.kegiatan.acara.edit', $event->id) }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #3b82f6; background: rgba(59,130,246,0.1); text-decoration: none; padding: 0.4rem 0.75rem; border-radius: 0.375rem; font-size: 0.8rem; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='rgba(59,130,246,0.2)'" onmouseout="this.style.background='rgba(59,130,246,0.1)'">
                                <i data-lucide="edit" style="width: 0.9rem; height: 0.9rem;"></i> Edit
                            </a>
                            <form action="{{ route('admin.kegiatan.acara.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus acara ini? Foto terkait juga akan dihapus.');" style="margin: 0;">
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
                    <td colspan="4" style="padding: 4rem 1.5rem; text-align: center; color: #64748b;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                            <div style="width: 5rem; height: 5rem; background: linear-gradient(135deg, rgba(241, 245, 249, 0.8) 0%, rgba(226, 232, 240, 0.8) 100%); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); transform: rotate(-5deg); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.5);">
                                <i data-lucide="megaphone-off" style="width: 2.5rem; height: 2.5rem; color: #94a3b8; transform: rotate(5deg);"></i>
                            </div>
                            <div style="font-weight: 600; color: #475569; margin-top: 0.5rem;">Belum ada data acara/kampanye.</div>
                            <p style="font-size: 0.85rem; margin: 0; max-width: 300px;">Buat kampanye pertama Anda untuk menampilkannya di halaman beranda Dudukbaca.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($events->hasPages())
    <div style="padding: 1.25rem 1.5rem; border-top: 1px solid rgba(0,0,0,0.05); background: rgba(248, 250, 252, 0.5);">
        {{ $events->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

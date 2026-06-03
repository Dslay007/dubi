@extends('layouts.admin')

@section('pageTitle', 'Data Jurnal Lapak')

@section('content')
<x-master-header 
    title="Jurnal Lapak (Blog & Berita)" 
    subtitle="Kelola artikel, liputan acara, ulasan buku, dan kabar komunitas." 
    icon="newspaper"
    createRoute="admin.kegiatan.jurnal.create"
    createLabel="Tulis Jurnal Baru"
>
</x-master-header>

<div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05); overflow: hidden;">
    <!-- Filter Section -->
    <div style="padding: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: rgba(248, 250, 252, 0.5);">
        <form method="GET" action="{{ route('admin.kegiatan.jurnal.index') }}" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Cari Judul Jurnal</label>
                <div style="position: relative;">
                    <i data-lucide="search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 1.1rem; height: 1.1rem; color: #94a3b8;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." style="width: 100%; padding: 0.65rem 1rem 0.65rem 2.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-size: 0.9rem;">
                </div>
            </div>
            <button type="submit" class="btn" style="padding: 0.65rem 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 600; height: fit-content; margin-bottom: 2px;">
                <i data-lucide="filter" style="width: 1rem; height: 1rem;"></i>
                Saring
            </button>
            @if(request()->hasAny(['search']))
            <a href="{{ route('admin.kegiatan.jurnal.index') }}" class="btn" style="background: white; color: #64748b; border: 1px solid #cbd5e1; padding: 0.65rem 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 600; text-decoration: none; height: fit-content; margin-bottom: 2px;">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table Section -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: rgba(241, 245, 249, 0.5); border-bottom: 2px solid rgba(0,0,0,0.05);">
                    <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Artikel Jurnal</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Status Publikasi</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Tgl Publikasi</th>
                    <th style="padding: 1.25rem 1.5rem; text-align: right; font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Aksi</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.95rem;">
                @forelse($jurnals as $jurnal)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(248, 250, 252, 0.8)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            @if($jurnal->cover_image)
                                <div style="width: 80px; height: 60px; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                    <img src="{{ asset('uploads/jurnal/' . $jurnal->cover_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div style="width: 80px; height: 60px; border-radius: 0.5rem; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                    <i data-lucide="image" style="width: 1.5rem; height: 1.5rem;"></i>
                                </div>
                            @endif
                            
                            <div>
                                <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">
                                    {{ Str::limit($jurnal->title, 60) }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                    <span style="font-size: 0.75rem; font-weight: 600; background: #f1f5f9; color: #475569; padding: 0.1rem 0.5rem; border-radius: 4px;">{{ $jurnal->category ?? 'Berita' }}</span>
                                </div>
                                <div style="font-size: 0.85rem; color: #64748b;">
                                    {{ Str::limit(strip_tags($jurnal->content), 80) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1.25rem 1.5rem; text-align: center;">
                        @if($jurnal->is_published)
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; background: #ecfdf5; color: #059669; padding: 0.4rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #a7f3d0;">
                                <i data-lucide="check-circle" style="width: 0.9rem; height: 0.9rem;"></i> Publik
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; background: #f1f5f9; color: #64748b; padding: 0.4rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #cbd5e1;">
                                <i data-lucide="file-edit" style="width: 0.9rem; height: 0.9rem;"></i> Draft
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1.5rem; text-align: center; color: #475569;">
                        <div style="font-weight: 600;">{{ $jurnal->created_at->format('d M Y') }}</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $jurnal->created_at->format('H:i') }}</div>
                    </td>
                    <td style="padding: 1.25rem 1.5rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.kegiatan.jurnal.edit', $jurnal->id) }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #3b82f6; background: rgba(59,130,246,0.1); text-decoration: none; padding: 0.4rem 0.75rem; border-radius: 0.375rem; font-size: 0.8rem; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='rgba(59,130,246,0.2)'" onmouseout="this.style.background='rgba(59,130,246,0.1)'">
                                <i data-lucide="edit" style="width: 0.9rem; height: 0.9rem;"></i> Edit
                            </a>
                            <form action="{{ route('admin.kegiatan.jurnal.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Hapus artikel jurnal ini secara permanen?');" style="margin: 0;">
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
                                <i data-lucide="newspaper" style="width: 2.5rem; height: 2.5rem; color: #94a3b8; transform: rotate(5deg);"></i>
                            </div>
                            <div style="font-weight: 600; color: #475569; margin-top: 0.5rem;">Belum ada Jurnal/Berita.</div>
                            <p style="font-size: 0.85rem; margin: 0; max-width: 300px;">Tulis berita, liputan acara, atau ulasan buku pertama Anda untuk dipublikasikan di halaman beranda.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jurnals->hasPages())
    <div style="padding: 1.25rem 1.5rem; border-top: 1px solid rgba(0,0,0,0.05); background: rgba(248, 250, 252, 0.5);">
        {{ $jurnals->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

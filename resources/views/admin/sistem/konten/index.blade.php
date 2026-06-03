@extends('layouts.admin')

@section('pageTitle', 'Konten')

@section('content')

<x-master-header 
    title="Sistem Konten (CMS)" 
    subtitle="Kelola halaman statis dan konten deskriptif sistem." 
    icon="file-text"
>
    <a href="{{ route('admin.sistem.konten.create') }}" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        <i data-lucide="plus" style="width: 16px; height: 16px;"></i> Tambah Konten
    </a>
</x-master-header>

<div class="search-container" style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <form action="{{ route('admin.sistem.konten.index') }}" method="GET" style="display: flex; gap: 0.5rem; width: 100%; max-width: 400px; position: relative;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau path konten..."
            class="form-input" style="padding-left: 2.5rem; border-radius: 99px;">
        <i data-lucide="search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8;"></i>
        <button type="submit" class="btn" style="padding: 0.5rem 1rem; background: #3b82f6; color: white; border: none; border-radius: 99px; cursor: pointer; font-weight: 600; font-size: 0.875rem;">Cari</button>
    </form>
</div>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">
    <form action="{{ route('admin.sistem.konten.bulk_delete') }}" method="POST" id="bulk-delete-form">
        @csrf
        @method('DELETE')
        
        <div style="padding: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; gap: 0.5rem; background: #f8fafc;">
            <button type="submit" class="btn" onclick="return confirm('Yakin ingin menghapus data terpilih?');" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 99px; font-size: 0.875rem; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#dc2626';" onmouseout="this.style.background='#ef4444';">
                <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i> Hapus Terpilih
            </button>
            <button type="button" class="btn" id="check-all" style="background: white; color: #475569; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 99px; font-size: 0.875rem; font-weight: 600; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';">
                <i data-lucide="check-square" style="width: 16px; height: 16px;"></i> Tandai Semua
            </button>
            <button type="button" class="btn" id="uncheck-all" style="background: white; color: #475569; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 99px; font-size: 0.875rem; font-weight: 600; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';">
                <i data-lucide="square" style="width: 16px; height: 16px;"></i> Batal Tandai
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                        <th style="padding: 1rem 1.5rem; width: 50px; border-bottom: 1px solid rgba(0,0,0,0.05);">Hapus</th>
                        <th style="padding: 1rem 1.5rem; width: 80px; border-bottom: 1px solid rgba(0,0,0,0.05);">Aksi</th>
                        <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Judul Konten</th>
                        <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Path (URL)</th>
                        <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Terakhir Diubah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $item)
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <input type="checkbox" name="ids[]" value="{{ $item->content_path }}" class="row-checkbox" style="width: 16px; height: 16px; cursor: pointer;">
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <a href="{{ route('admin.sistem.konten.edit', $item->content_path) }}" class="btn" style="background: #f1f5f9; color: #3b82f6; padding: 0.4rem 0.75rem; border-radius: 99px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s;" onmouseover="this.style.background='#e0e7ff';" onmouseout="this.style.background='#f1f5f9';" title="Edit">
                                <i data-lucide="edit-3" style="width: 16px; height: 16px;"></i>
                            </a>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 600; color: #0f172a;">{{ $item->content_title }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b; font-family: monospace;">{{ $item->content_path }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->last_update }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: #94a3b8;">Belum ada konten.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    @if($contents->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid rgba(0,0,0,0.05);">
        {{ $contents->links() }}
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('check-all');
        const uncheckAll = document.getElementById('uncheck-all');
        const checkboxes = document.querySelectorAll('.row-checkbox');

        if(checkAll && uncheckAll) {
            checkAll.addEventListener('click', () => checkboxes.forEach(cb => cb.checked = true));
            uncheckAll.addEventListener('click', () => checkboxes.forEach(cb => cb.checked = false));
        }
    });
</script>
@endsection

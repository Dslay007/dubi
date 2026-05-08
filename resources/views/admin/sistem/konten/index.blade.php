@extends('layouts.admin')

@section('pageTitle', 'Konten')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Konten</h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.sistem.konten.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #cbd5e1;">
                <i data-lucide="list" style="width: 1rem; height: 1rem;"></i> Daftar Konten
            </a>
            <a href="{{ route('admin.sistem.konten.create') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="plus-circle" style="width: 1rem; height: 1rem;"></i> Tambahkan Data Baru
            </a>
        </div>
    </div>

    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.sistem.konten.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 500px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau path konten..."
                style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            <button type="submit" class="btn" style="padding: 0.5rem 1rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-weight: 500; font-size: 0.875rem;">
                <i data-lucide="search" style="width: 1rem; height: 1rem;"></i> Cari
            </button>
        </form>
    </div>

    <form action="{{ route('admin.sistem.konten.bulk_delete') }}" method="POST" id="bulk-delete-form">
        @csrf
        @method('DELETE')
        
        <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; gap: 0.5rem;">
            <button type="submit" class="btn" onclick="return confirm('Yakin ingin menghapus data terpilih?');" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="trash-2" style="width: 1rem; height: 1rem;"></i> Hapus Terpilih
            </button>
            <button type="button" class="btn" id="check-all" style="background: #f8fafc; color: #475569; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="check-square" style="width: 1rem; height: 1rem;"></i> Tandai Semua
            </button>
            <button type="button" class="btn" id="uncheck-all" style="background: #f8fafc; color: #475569; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="square" style="width: 1rem; height: 1rem;"></i> Batal Tandai
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                        <th style="padding: 1rem 1.5rem; width: 50px;">Hapus</th>
                        <th style="padding: 1rem 1.5rem; width: 60px;">Sunting</th>
                        <th style="padding: 1rem 1.5rem;">Judul Konten</th>
                        <th style="padding: 1rem 1.5rem;">Path (Harus Unik)</th>
                        <th style="padding: 1rem 1.5rem;">Terakhir Diubah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $item)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <input type="checkbox" name="ids[]" value="{{ $item->content_path }}" class="row-checkbox">
                        </td>
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <a href="{{ route('admin.sistem.konten.edit', $item->content_path) }}" style="color: #3b82f6; text-decoration: none;">
                                <i data-lucide="edit" style="width: 1rem; height: 1rem;"></i>
                            </a>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #1e293b; font-style: italic;">{{ $item->content_title }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b; font-style: italic;">{{ $item->content_path }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->last_update }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #94a3b8;">Belum ada konten.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    @if($contents->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $contents->links() }}
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('check-all');
        const uncheckAll = document.getElementById('uncheck-all');
        const checkboxes = document.querySelectorAll('.row-checkbox');

        checkAll.addEventListener('click', () => checkboxes.forEach(cb => cb.checked = true));
        uncheckAll.addEventListener('click', () => checkboxes.forEach(cb => cb.checked = false));
    });
</script>
@endsection

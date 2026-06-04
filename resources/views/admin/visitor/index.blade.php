@extends('layouts.admin')

@section('pageTitle', 'Ruang Pengunjung')

@section('content')

<x-master-file-dropdown type="peralatan" current="ruang_pengunjung" />

<x-master-header 
    title="Data Ruang Pengunjung" 
    subtitle="Kelola dan lihat data riwayat kunjungan ke perpustakaan." 
    icon="log-in"
    exportRoute="admin.visitor.export"
/>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.visitor.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID / Nama / Institusi..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Tgl Kunjungan</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">ID Anggota</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Nama Anggota</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Institusi</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visitors as $item)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1e293b;">{{ $item->checkin_date }}</td>
                    <td style="padding: 1rem 1.5rem; color: #3b82f6;">{{ $item->member_id ?: '-' }}</td>
                    <td style="padding: 1rem 1.5rem; color: #1e293b;">{{ $item->member_name }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->institution ?: '-' }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <form action="{{ route('admin.visitor.destroy', $item->visitor_id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">Belum ada data pengunjung.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $visitors->links() }}
    </div>
</div>
@endsection


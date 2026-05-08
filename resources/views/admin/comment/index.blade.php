@extends('layouts.admin')

@section('pageTitle', 'Manajemen Komentar')

@section('content')

<x-master-file-dropdown type="peralatan" current="manajemen_komentar" />

<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Daftar Komentar</h3>
    </div>

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.comment.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Member ID atau Isi Komentar..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Tanggal</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Member ID</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Biblio ID</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 40%;">Komentar</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $item)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1e293b;">{{ $item->last_update }}</td>
                    <td style="padding: 1rem 1.5rem; color: #3b82f6;">{{ $item->member_id }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->biblio_id }}</td>
                    <td style="padding: 1rem 1.5rem; color: #334155;">{{ $item->comment }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <form action="{{ route('admin.comment.destroy', $item->comment_id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">Belum ada komentar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $comments->links() }}
    </div>
</div>
@endsection

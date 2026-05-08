@extends('layouts.admin')

@section('pageTitle', 'Salinan Pangkalan (Backup)')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 2rem;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
        <div>
            <h3 style="font-weight: 700; color: #1e293b; font-size: 1.25rem;">Salinan Pangkalan (Backup Data)</h3>
            <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.25rem;">Buat cadangan database secara berkala untuk mencegah kehilangan data.</p>
        </div>
        
        <form action="{{ route('admin.sistem.backup.run') }}" method="POST" onsubmit="return confirm('Mulai proses backup database? Ini mungkin memakan waktu beberapa saat.');">
            @csrf
            <button type="submit" class="btn" style="background: #10b981; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="database-backup" style="width: 1.25rem; height: 1.25rem;"></i> Mulai Backup Baru
            </button>
        </form>
    </div>
</div>

<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
        <h4 style="font-weight: 700; color: #1e293b;">Tabel Riwayat Backup</h4>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="border-bottom: 1px solid #e2e8f0; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; background: #f1f5f9; color: #475569;">
                    <th style="padding: 1rem 1.5rem;">ID</th>
                    <th style="padding: 1rem 1.5rem;">Waktu Backup</th>
                    <th style="padding: 1rem 1.5rem;">Nama File</th>
                    <th style="padding: 1rem 1.5rem;">Staf / Pengguna</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $b)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $b->backup_log_id }}</td>
                    <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1e293b;">{{ Carbon\Carbon::parse($b->backup_time)->format('d M Y H:i:s') }}</td>
                    <td style="padding: 1rem 1.5rem; color: #3b82f6; font-family: monospace;">{{ $b->backup_file }}</td>
                    <td style="padding: 1rem 1.5rem; color: #475569;">{{ $b->realname ?? $b->username ?? 'Sistem' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #64748b;">Belum ada riwayat backup database.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($backups->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $backups->links() }}
    </div>
    @endif
</div>
@endsection

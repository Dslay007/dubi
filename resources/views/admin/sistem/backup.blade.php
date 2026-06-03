@extends('layouts.admin')

@section('pageTitle', 'Salinan Pangkalan (Backup)')

@section('content')

<x-master-header 
    title="Salinan Pangkalan Data (Backup)" 
    subtitle="Buat cadangan database secara berkala untuk mencegah kehilangan data." 
    icon="database-backup"
>
    <form action="{{ route('admin.sistem.backup.run') }}" method="POST" onsubmit="return confirm('Mulai proses backup database? Ini mungkin memakan waktu beberapa saat tergantung ukuran data Anda.');">
        @csrf
        <button type="submit" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.6rem 1.25rem; border: none; border-radius: 99px; font-weight: 700; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2); cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <i data-lucide="hard-drive-download" style="width: 16px; height: 16px;"></i> Mulai Backup Baru
        </button>
    </form>
</x-master-header>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem 2rem; background: #f8fafc; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; gap: 0.75rem;">
        <i data-lucide="history" style="width: 20px; height: 20px; color: #8b5cf6;"></i>
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 1rem;">Riwayat Backup</h4>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); font-weight: 700; text-transform: uppercase; font-size: 0.75rem; background: white; color: #475569;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">ID Log</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Waktu Backup</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Nama File Backup</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Pengguna (Staf)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $b)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-weight: 600;">#{{ str_pad($b->backup_log_id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #0f172a;">
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <i data-lucide="calendar-clock" style="width: 14px; height: 14px; color: #94a3b8;"></i>
                            {{ Carbon\Carbon::parse($b->backup_time)->format('d M Y, H:i:s') }}
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #2563eb; font-family: monospace; font-size: 0.8rem; background: #eff6ff; border-radius: 0.375rem; display: inline-block; margin: 0.75rem 1.5rem;">
                        {{ $b->backup_file }}
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #475569; font-weight: 500;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 24px; height: 24px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700; color: #475569;">
                                {{ strtoupper(substr($b->realname ?? $b->username ?? 'S', 0, 1)) }}
                            </div>
                            {{ $b->realname ?? $b->username ?? 'Sistem' }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 4rem 2rem; text-align: center; color: #94a3b8;">
                        <i data-lucide="database-zap" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p style="font-weight: 500; color: #475569;">Belum ada riwayat backup database.</p>
                        <p style="font-size: 0.8rem; margin-top: 0.25rem;">Klik tombol "Mulai Backup Baru" di atas untuk membuat cadangan pertama Anda.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($backups->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid rgba(0,0,0,0.05);">
        {{ $backups->links() }}
    </div>
    @endif
</div>
@endsection

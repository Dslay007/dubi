@extends('layouts.admin')

@section('pageTitle', 'Aktifitas Staff')

@section('content')
<div x-data="{ tab: 'log' }">
    
    <!-- Tab Navigation -->
    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">
        <button @click="tab = 'log'" :style="tab === 'log' ? 'border-bottom: 2px solid #3b82f6; color: #3b82f6; font-weight: 600;' : 'color: #64748b;'" style="background: none; border: none; padding: 0.5rem 1rem; cursor: pointer; font-size: 1rem;">
            Log Aktifitas
        </button>
        <button @click="tab = 'akun'" :style="tab === 'akun' ? 'border-bottom: 2px solid #3b82f6; color: #3b82f6; font-weight: 600;' : 'color: #64748b;'" style="background: none; border: none; padding: 0.5rem 1rem; cursor: pointer; font-size: 1rem;">
            Status Akun Staff
        </button>
    </div>

    <!-- Tab 1: Log Aktifitas -->
    <div x-show="tab === 'log'">
        <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
                <h4 style="font-weight: 700; color: #1e293b;">Riwayat Log Aktifitas Sistem</h4>
                <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.25rem;">Mencatat semua perubahan, penambahan, dan penghapusan data oleh staf.</p>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e2e8f0; background: #f1f5f9; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">
                            <th style="padding: 1rem 1.5rem;">Waktu / Tanggal</th>
                            <th style="padding: 1rem 1.5rem;">Staf</th>
                            <th style="padding: 1rem 1.5rem;">Modul</th>
                            <th style="padding: 1rem 1.5rem;">Deskripsi Log</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem 1.5rem; color: #64748b;">{{ Carbon\Carbon::parse($log->log_date)->format('d M Y H:i:s') }}</td>
                            <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1e293b;">{{ $log->realname ?? $log->username ?? 'Sistem' }}</td>
                            <td style="padding: 1rem 1.5rem; color: #3b82f6;">{{ $log->log_location ?? '-' }}</td>
                            <td style="padding: 1rem 1.5rem; color: #475569;">{{ $log->log_msg ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 2rem; text-align: center; color: #64748b;">Belum ada riwayat log aktifitas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
                {{ $logs->appends(['log_page' => $logs->currentPage()])->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Tab 2: Status Akun -->
    <div x-show="tab === 'akun'" style="display: none;">
        <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
                <h4 style="font-weight: 700; color: #1e293b;">Daftar Akun Staf</h4>
                <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.25rem;">Atur status aktif/nonaktif akun staf untuk mengelola akses masuk.</p>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e2e8f0; background: #f1f5f9; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">
                            <th style="padding: 1rem 1.5rem;">Username</th>
                            <th style="padding: 1rem 1.5rem;">Nama Lengkap</th>
                            <th style="padding: 1rem 1.5rem;">Role / Grup</th>
                            <th style="padding: 1rem 1.5rem;">Status Akun</th>
                            <th style="padding: 1rem 1.5rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        @php $isActive = $u->is_active ?? 1; @endphp
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1e293b;">{{ $u->username }}</td>
                            <td style="padding: 1rem 1.5rem; color: #475569;">{{ $u->realname }}</td>
                            <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $u->groups ?? '-' }}</td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($isActive == 1)
                                    <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">Aktif</span>
                                @else
                                    <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">Nonaktif</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($u->user_id != 1 && $u->user_id != auth()->id())
                                <form action="{{ route('admin.sistem.aktifitas.toggle_user', $u->user_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn" style="background: {{ $isActive == 1 ? '#ef4444' : '#10b981' }}; color: white; padding: 0.25rem 0.5rem; border: none; border-radius: 0.25rem; font-size: 0.75rem; cursor: pointer;">
                                        {{ $isActive == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                @else
                                <span style="color: #94a3b8; font-size: 0.75rem;">Utama</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

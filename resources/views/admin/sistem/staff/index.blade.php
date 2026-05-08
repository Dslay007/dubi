@extends('layouts.admin')

@section('pageTitle', 'Manajemen Staff')

@section('content')
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="users-round" style="width: 1.25rem; height: 1.25rem; color: #3b82f6;"></i>
                Manajemen Staff
            </h3>
            <p style="color: #64748b; font-size: 0.85rem; margin-top: 0.25rem;">Kelola akun admin, pustakawan, dan staf lainnya.</p>
        </div>
        <a href="{{ route('admin.sistem.staff.create') }}" class="btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 0.6rem 1.25rem; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 2px 8px rgba(59,130,246,0.3);">
            <i data-lucide="user-plus" style="width: 1rem; height: 1rem;"></i> Tambah Staff
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem;">Username</th>
                    <th style="padding: 1rem 1.5rem;">Nama Lengkap</th>
                    <th style="padding: 1rem 1.5rem;">Role</th>
                    <th style="padding: 1rem 1.5rem;">Email</th>
                    <th style="padding: 1rem 1.5rem;">Status</th>
                    <th style="padding: 1rem 1.5rem; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                @php $isActive = $u->is_active ?? 1; @endphp
                <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2.25rem; height: 2.25rem; background: linear-gradient(135deg, {{ $u->user_id == 1 ? '#f59e0b, #d97706' : '#3b82f6, #6366f1' }}); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;">
                                {{ strtoupper(substr($u->username, 0, 1)) }}
                            </div>
                            <span style="font-weight: 600; color: #1e293b;">{{ $u->username }}</span>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #475569;">{{ $u->realname }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="background: {{ $u->user_id == 1 ? '#fef3c7' : '#eff6ff' }}; color: {{ $u->user_id == 1 ? '#92400e' : '#1d4ed8' }}; padding: 0.25rem 0.65rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">
                            {{ $u->group_name ?? 'Tidak ada' }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.85rem;">{{ $u->email ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($isActive == 1)
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.65rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">
                                <span style="width: 6px; height: 6px; background: #22c55e; border-radius: 50; display: inline-block;"></span> Aktif
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.25rem 0.65rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">
                                <span style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%; display: inline-block;"></span> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; gap: 0.4rem; justify-content: flex-end;">
                            {{-- Toggle Status --}}
                            @if($u->user_id != 1 && $u->user_id != auth()->id())
                            <form action="{{ route('admin.sistem.staff.toggle', $u->user_id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn" title="{{ $isActive == 1 ? 'Nonaktifkan' : 'Aktifkan' }}"
                                    style="background: {{ $isActive == 1 ? '#f59e0b' : '#10b981' }}; color: white; padding: 0.4rem 0.6rem; border: none; border-radius: 0.375rem; font-size: 0.8rem; cursor: pointer;">
                                    <i data-lucide="{{ $isActive == 1 ? 'user-x' : 'user-check' }}" style="width: 0.85rem; height: 0.85rem;"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Edit --}}
                            <a href="{{ route('admin.sistem.staff.edit', $u->user_id) }}" class="btn" 
                               style="background: #3b82f6; color: white; padding: 0.4rem 0.6rem; border-radius: 0.375rem; text-decoration: none; display: inline-flex; align-items: center;"
                               title="Edit">
                                <i data-lucide="pencil" style="width: 0.85rem; height: 0.85rem;"></i>
                            </a>

                            {{-- Delete --}}
                            @if($u->user_id != 1 && $u->user_id != auth()->id())
                            <form action="{{ route('admin.sistem.staff.destroy', $u->user_id) }}" method="POST" style="display: inline;"
                                  onsubmit="return confirm('Hapus akun staff \'{{ $u->username }}\'? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" title="Hapus"
                                    style="background: #ef4444; color: white; padding: 0.4rem 0.6rem; border: none; border-radius: 0.375rem; cursor: pointer;">
                                    <i data-lucide="trash-2" style="width: 0.85rem; height: 0.85rem;"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: #64748b;">
                        <i data-lucide="users" style="width: 2rem; height: 2rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                        <p>Belum ada data staff.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

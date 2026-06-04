@extends('layouts.admin')

@section('pageTitle', 'Manajemen Staff')

@section('content')

<x-master-header 
    title="Manajemen Staff" 
    subtitle="Kelola akun pustakawan, admin, dan hak akses sistem mereka." 
    icon="users-round"
>
    <a href="{{ route('admin.sistem.staff.create') }}" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-size: 0.875rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i> Tambah Staff
    </a>
</x-master-header>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Username</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Nama Lengkap</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Grup Hak Akses</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Email</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Status</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                @php $isActive = $u->is_active ?? 1; @endphp
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, {{ $u->user_id == 1 ? '#f59e0b, #d97706' : '#3b82f6, #6366f1' }}); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1rem; flex-shrink: 0; box-shadow: 0 4px 6px -1px {{ $u->user_id == 1 ? 'rgba(245, 158, 11, 0.3)' : 'rgba(59, 130, 246, 0.3)' }};">
                                {{ strtoupper(substr($u->username, 0, 1)) }}
                            </div>
                            <span style="font-weight: 700; color: #0f172a;">{{ $u->username }}</span>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-weight: 500; color: #334155;">{{ $u->realname }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: {{ $u->user_id == 1 ? '#fef3c7' : '#eff6ff' }}; color: {{ $u->user_id == 1 ? '#92400e' : '#1d4ed8' }}; padding: 0.3rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid {{ $u->user_id == 1 ? '#fde68a' : '#bfdbfe' }};">
                            <i data-lucide="shield" style="width: 12px; height: 12px;"></i>
                            {{ $u->group_name ?? 'Tidak ada grup' }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $u->email ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($isActive == 1)
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bbf7d0;">
                                <span style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%; display: inline-block; box-shadow: 0 0 0 2px rgba(34,197,94,0.2);"></span> Aktif
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fecaca;">
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
                                    style="background: {{ $isActive == 1 ? '#fef3c7' : '#dcfce7' }}; color: {{ $isActive == 1 ? '#d97706' : '#166534' }}; padding: 0.4rem 0.6rem; border: none; border-radius: 99px; font-size: 0.8rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='{{ $isActive == 1 ? '#fde68a' : '#bbf7d0' }}';">
                                    <i data-lucide="{{ $isActive == 1 ? 'user-x' : 'user-check' }}" style="width: 16px; height: 16px;"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Edit --}}
                            <a href="{{ route('admin.sistem.staff.edit', $u->user_id) }}" class="btn" 
                               style="background: #eff6ff; color: #3b82f6; padding: 0.4rem 0.6rem; border-radius: 99px; text-decoration: none; display: inline-flex; align-items: center; transition: 0.2s;" onmouseover="this.style.background='#dbeafe';"
                               title="Edit">
                                <i data-lucide="edit-3" style="width: 16px; height: 16px;"></i>
                            </a>

                            {{-- Delete --}}
                            @if($u->user_id != 1 && $u->user_id != auth()->id())
                            <form action="{{ route('admin.sistem.staff.destroy', $u->user_id) }}" method="POST" style="display: inline;"
                                  onsubmit="return confirm('Hapus akun staff \'{{ $u->username }}\'? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" title="Hapus"
                                    style="background: #fee2e2; color: #ef4444; padding: 0.4rem 0.6rem; border: none; border-radius: 99px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#fecaca';">
                                    <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem 2rem; text-align: center; color: #64748b;">
                        <i data-lucide="users" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p style="font-weight: 500; color: #475569;">Belum ada data staff yang ditambahkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


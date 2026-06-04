@extends('layouts.admin')

@section('pageTitle', 'Aktifitas Staff')

@section('content')

<x-master-header 
    title="Aktifitas Sistem & Staf" 
    subtitle="Pantau log aktifitas dan status akun pustakawan atau admin sistem." 
    icon="activity"
>
</x-master-header>

<div x-data="{ tab: 'log' }">
    
    <!-- Tab Navigation -->
    <div style="display: inline-flex; gap: 0.5rem; margin-bottom: 2rem; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.6); padding: 0.5rem; border-radius: 99px; box-shadow: 0 4px 15px -3px rgba(0,0,0,0.05), inset 0 0 0 1px rgba(255,255,255,0.2);">
        <button @click="tab = 'log'" 
            :style="tab === 'log' ? 'background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); color: #2563eb; font-weight: 700; box-shadow: 0 4px 12px -2px rgba(37, 99, 235, 0.15), 0 0 0 1px rgba(255,255,255,0.8); border: 1px solid transparent;' : 'background: transparent; color: #64748b; font-weight: 600; border: 1px solid transparent;'" 
            style="border-radius: 99px; padding: 0.75rem 1.5rem; cursor: pointer; font-size: 0.95rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: inline-flex; align-items: center; gap: 0.5rem; outline: none;">
            <i data-lucide="list" style="width: 16px; height: 16px;"></i>
            Log Aktifitas
        </button>
        <button @click="tab = 'akun'" 
            :style="tab === 'akun' ? 'background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); color: #2563eb; font-weight: 700; box-shadow: 0 4px 12px -2px rgba(37, 99, 235, 0.15), 0 0 0 1px rgba(255,255,255,0.8); border: 1px solid transparent;' : 'background: transparent; color: #64748b; font-weight: 600; border: 1px solid transparent;'" 
            style="border-radius: 99px; padding: 0.75rem 1.5rem; cursor: pointer; font-size: 0.95rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: inline-flex; align-items: center; gap: 0.5rem; outline: none;">
            <i data-lucide="shield" style="width: 16px; height: 16px;"></i>
            Status Akun Staff
        </button>
    </div>

    <!-- Tab 1: Log Aktifitas -->
    <div x-show="tab === 'log'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
        
        <!-- Search and Sort Bar -->
        <div style="background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.6); padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 15px -3px rgba(0,0,0,0.05); margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem; justify-content: space-between; align-items: center;">
            <form action="{{ route('admin.sistem.aktifitas.index') }}" method="GET" style="display: flex; gap: 1rem; flex: 1; min-width: 0; flex-wrap: wrap;">
                <div style="flex: 1; position: relative;">
                    <i data-lucide="search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 1.25rem; height: 1.25rem; color: #94a3b8;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari log aktifitas (Pesan, Modul, Staff)..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 3rem; border-radius: 99px; border: 1px solid #e2e8f0; background: white; font-size: 0.875rem; box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.02); outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <i data-lucide="filter" style="width: 1.25rem; height: 1.25rem; color: #64748b;"></i>
                    <select name="sort" onchange="this.form.submit()" style="padding: 0.75rem 2rem 0.75rem 1rem; border-radius: 99px; border: 1px solid #e2e8f0; background: white; font-size: 0.875rem; cursor: pointer; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="terbaru" {{ ($sort ?? request('sort', 'terbaru')) == 'terbaru' ? 'selected' : '' }}>Paling Baru (Terbaru)</option>
                        <option value="terlama" {{ ($sort ?? request('sort', 'terbaru')) == 'terlama' ? 'selected' : '' }}>Paling Lama (Terlama)</option>
                    </select>
                </div>
                <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 99px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='brightness(1)'">
                    Terapkan
                </button>
                @if(request()->has('search') || request()->has('sort'))
                <a href="{{ route('admin.sistem.aktifitas.index') }}" style="display: inline-flex; align-items: center; justify-content: center; background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; padding: 0.75rem 1.5rem; border-radius: 99px; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Waktu / Tanggal</th>
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Staf</th>
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Modul</th>
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Deskripsi Log</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                            <td style="padding: 1rem 1.5rem; color: #64748b; font-weight: 500;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-lucide="clock" style="width: 14px; height: 14px; color: #94a3b8;"></i>
                                    {{ Carbon\Carbon::parse($log->log_date)->format('d M Y, H:i:s') }}
                                </div>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <span style="font-weight: 700; color: #0f172a;">{{ $log->realname ?? $log->username ?? 'Sistem' }}</span>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <span style="background: #eff6ff; color: #2563eb; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bfdbfe;">
                                    {{ $log->log_location ?? 'Sistem' }}
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: #475569;">{{ $log->log_msg ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 3rem; text-align: center; color: #94a3b8;">Belum ada riwayat log aktifitas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid rgba(0,0,0,0.05);">
                {{ $logs->appends(['log_page' => $logs->currentPage()])->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Tab 2: Status Akun -->
    <div x-show="tab === 'akun'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
        <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
            <div style="padding: 1.5rem 2rem; background: #eff6ff; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; align-items: flex-start; gap: 0.75rem;">
                <i data-lucide="info" style="width: 1.25rem; height: 1.25rem; color: #3b82f6; flex-shrink: 0; margin-top: 2px;"></i>
                <p style="color: #1e40af; font-size: 0.875rem; margin: 0; line-height: 1.5;">Anda juga dapat mengelola status staf dengan lebih lengkap melalui menu <a href="{{ route('admin.sistem.staff.index') }}" style="color: #2563eb; font-weight: 700; text-decoration: underline;">Manajemen Staff</a>.</p>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Username</th>
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Nama Lengkap</th>
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Role / Grup</th>
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Status Akun</th>
                            <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); text-align: right;">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        @php $isActive = $u->is_active ?? 1; @endphp
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                            <td style="padding: 1rem 1.5rem; font-weight: 700; color: #0f172a;">{{ $u->username }}</td>
                            <td style="padding: 1rem 1.5rem; color: #475569;">{{ $u->realname }}</td>
                            <td style="padding: 1rem 1.5rem;">
                                <span style="background: {{ $u->user_id == 1 ? '#fef3c7' : '#f1f5f9' }}; color: {{ $u->user_id == 1 ? '#92400e' : '#475569' }}; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700;">
                                    {{ $u->groups ?? 'Utama' }}
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($isActive == 1)
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bbf7d0;">
                                        <span style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%;"></span> Aktif
                                    </span>
                                @else
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fecaca;">
                                        <span style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%;"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                @if($u->user_id != 1 && $u->user_id != auth()->id())
                                <form action="{{ route('admin.sistem.aktifitas.toggle_user', $u->user_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn" style="background: {{ $isActive == 1 ? '#fef3c7' : '#dcfce7' }}; color: {{ $isActive == 1 ? '#d97706' : '#166534' }}; padding: 0.4rem 0.75rem; border: 1px solid {{ $isActive == 1 ? '#fde68a' : '#bbf7d0' }}; border-radius: 99px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.filter='brightness(0.95)';">
                                        {{ $isActive == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                @else
                                <span style="background: #f1f5f9; color: #94a3b8; padding: 0.4rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #e2e8f0;">
                                    Tidak bisa diubah
                                </span>
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


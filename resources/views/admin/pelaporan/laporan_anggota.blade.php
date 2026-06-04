@extends('layouts.admin')

@section('pageTitle', 'Laporan Anggota')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<x-master-header 
    title="Laporan & Statistik Anggota" 
    subtitle="Pantau pertumbuhan anggota, komposisi, dan status keanggotaan." 
    icon="users"
>
    <a href="{{ route('admin.member.index') }}" class="btn" style="background: white; color: #475569; border: 1px solid #cbd5e1; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
        <i data-lucide="users" style="width: 16px; height: 16px;"></i> Direktori Anggota
    </a>
</x-master-header>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border-radius: 1.25rem; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="users" style="width: 6rem; height: 6rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem;"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Anggota</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($totalMember) }}</p>
        </div>
    </div>
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 1.25rem; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="user-check" style="width: 6rem; height: 6rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem;"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Masih Aktif</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($totalActive) }}</p>
        </div>
    </div>
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 1.25rem; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="user-minus" style="width: 6rem; height: 6rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem;"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Kadaluarsa</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($totalExpired) }}</p>
        </div>
    </div>
    <div style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border-radius: 1.25rem; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="user-plus" style="width: 6rem; height: 6rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem;"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Baru (30 Hari)</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($totalNew) }}</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Registrasi per Bulan (Area) -->
    <div style="flex: 2 1 300px; min-width: 0; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="trending-up" style="width: 18px; height: 18px; color: #6366f1;"></i>
                Tren Registrasi Anggota (12 Bulan)
            </h4>
        </div>
        @if($regPerMonth->count() > 0)
        <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="regChart"></canvas>
        </div>
        @else
        <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
            <i data-lucide="inbox" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
            <p>Data belum tersedia.</p>
        </div>
        @endif
    </div>

    <div style="flex: 1 1 300px; min-width: 0; display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Gender Pie -->
        <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="pie-chart" style="width: 18px; height: 18px; color: #ec4899;"></i>
                    Komposisi Gender
                </h4>
            </div>
            @if($genderStats->count() > 0)
            <div style="max-width: 220px; margin: 0 auto; position: relative;">
                <canvas id="genderChart"></canvas>
            </div>
            @else
            <div style="text-align: center; padding: 2rem 1rem; color: #94a3b8;">
                <p>Data belum tersedia.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Active vs Expired Status -->
    <div style="flex: 1 1 300px; min-width: 0; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: center;">
        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; text-align: center;">Tingkat Keaktifan</h4>
        
        @php
            $activePct = $totalMember > 0 ? round(($totalActive / $totalMember) * 100) : 0;
            $expiredPct = $totalMember > 0 ? round(($totalExpired / $totalMember) * 100) : 0;
        @endphp
        
        <div style="display: flex; justify-content: space-around; text-align: center; margin-bottom: 1rem;">
            <div>
                <p style="font-size: 2.5rem; font-weight: 800; color: #10b981; margin: 0;">{{ $activePct }}%</p>
                <p style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Aktif</p>
            </div>
            <div>
                <p style="font-size: 2.5rem; font-weight: 800; color: #f59e0b; margin: 0;">{{ $expiredPct }}%</p>
                <p style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Kadaluarsa</p>
            </div>
        </div>
        
        <div style="background: #f1f5f9; border-radius: 99px; height: 1rem; overflow: hidden; display: flex; margin-top: 0.5rem;">
            <div style="background: #10b981; width: {{ $activePct }}%; height: 100%;"></div>
            <div style="background: #f59e0b; width: {{ $expiredPct }}%; height: 100%;"></div>
        </div>
    </div>

    <!-- Per Tipe Anggota (Horizontal Bar) -->
    <div style="flex: 2 1 300px; min-width: 0; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="bar-chart-2" style="width: 18px; height: 18px; color: #8b5cf6;"></i>
                Anggota Berdasarkan Tipe
            </h4>
        </div>
        @if($perType->count() > 0)
        <div style="position: relative; height: 220px; width: 100%;">
            <canvas id="typeChart"></canvas>
        </div>
        @else
        <div style="text-align: center; padding: 2rem 1rem; color: #94a3b8;">
            <p>Data belum tersedia.</p>
        </div>
        @endif
    </div>
</div>

<!-- Recent Members Table -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.25rem 1.5rem; background: #f8fafc; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0;">15 Anggota Terbaru</h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: white; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th style="padding: 1rem 1.5rem; text-align: left;">ID Anggota</th>
                    <th style="padding: 1rem 1.5rem; text-align: left;">Nama Anggota</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Tipe Keanggotaan</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Tgl Terdaftar</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Status Masa Berlaku</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentMembers as $m)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-family: monospace; font-weight: 600;">{{ $m->member_id }}</td>
                    <td style="padding: 1rem 1.5rem; color: #0f172a; font-weight: 700;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 28px; height: 28px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #475569;">
                                {{ strtoupper(substr($m->member_name, 0, 1)) }}
                            </div>
                            {{ $m->member_name }}
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <span style="background: #eff6ff; color: #1d4ed8; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; border: 1px solid #bfdbfe;">
                            {{ $m->member_type_name ?? 'Standar' }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; text-align: center;">{{ \Carbon\Carbon::parse($m->register_date)->format('d M Y') }}</td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        @if($m->expire_date && $m->expire_date < now()->format('Y-m-d'))
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fecaca;">
                                Kadaluarsa ({{ \Carbon\Carbon::parse($m->expire_date)->format('d M Y') }})
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bbf7d0;">
                                Aktif hingga {{ \Carbon\Carbon::parse($m->expire_date)->format('d M Y') }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding: 3rem; text-align: center; color: #94a3b8;">Belum ada anggota yang terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const regCanvas = document.getElementById('regChart');
    if (regCanvas) {
        new Chart(regCanvas, {
            type: 'line',
            data: {
                labels: {!! json_encode($regPerMonth->pluck('bulan')->map(fn($v) => \Carbon\Carbon::parse($v)->translatedFormat('M Y'))) !!},
                datasets: [{
                    label: 'Registrasi Anggota Baru',
                    data: {!! json_encode($regPerMonth->pluck('total')->map(fn($v) => (int)$v)) !!},
                    borderColor: '#6366f1', 
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    fill: true, 
                    tension: 0.4, 
                    borderWidth: 3, 
                    pointRadius: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2
                }]
            },
            options: { 
                maintainAspectRatio: false,
                responsive: true, 
                plugins: { 
                    legend: { display: false },
                    tooltip: { cornerRadius: 8, padding: 12, mode: 'index', intersect: false }
                }, 
                scales: { 
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                } 
            }
        });
    }

    const genderCanvas = document.getElementById('genderChart');
    if (genderCanvas) {
        new Chart(genderCanvas, {
            type: 'pie',
            data: {
                labels: {!! json_encode($genderStats->map(function($g) {
                    if($g->gender === '1' || strtolower($g->gender) === 'laki-laki' || $g->gender === 1) return 'Laki-laki';
                    if($g->gender === '0' || strtolower($g->gender) === 'perempuan' || $g->gender === 0) return 'Perempuan';
                    return 'Lainnya/Tidak Diketahui';
                })->values()) !!},
                datasets: [{ 
                    data: {!! json_encode($genderStats->pluck('total')->map(fn($v) => (int)$v)) !!}, 
                    backgroundColor: ['#3b82f6', '#ec4899', '#94a3b8'], 
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: { 
                maintainAspectRatio: false,
                responsive: true,
                plugins: { 
                    legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, font: { size: 12, family: "'Inter', sans-serif" } } } 
                } 
            }
        });
    }

    const typeCanvas = document.getElementById('typeChart');
    if (typeCanvas) {
        new Chart(typeCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($perType->pluck('member_type_name')->map(fn($v) => $v ?? 'Standar')) !!},
                datasets: [{ 
                    label: 'Jumlah Anggota', 
                    data: {!! json_encode($perType->pluck('total')->map(fn($v) => (int)$v)) !!}, 
                    backgroundColor: 'rgba(139, 92, 246, 0.8)', 
                    hoverBackgroundColor: '#7c3aed',
                    borderRadius: 6,
                    barPercentage: 0.5
                }]
            },
            options: { 
                indexAxis: 'y', 
                maintainAspectRatio: false,
                responsive: true, 
                plugins: { legend: { display: false }, tooltip: { cornerRadius: 8, padding: 12 } }, 
                scales: { 
                    x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false } },
                    y: { grid: { display: false } }
                } 
            }
        });
    }
});
</script>
@endsection


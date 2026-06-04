@extends('layouts.admin')

@section('pageTitle', 'Laporan Pengunjung')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<x-master-header 
    title="Laporan Kunjungan" 
    subtitle="Pantau statistik kehadiran pengunjung dan tamu perpustakaan." 
    icon="users"
>
</x-master-header>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 1.5rem; padding: 1.75rem; color: white; box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="globe" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(15deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.8rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Pengunjung</p>
            <p style="font-size: 2.5rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($totalVisitor) }}</p>
        </div>
    </div>
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 1.5rem; padding: 1.75rem; color: white; box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="calendar-check" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(-10deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.8rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Pengunjung Hari Ini</p>
            <p style="font-size: 2.5rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($todayVisitor) }}</p>
        </div>
    </div>
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 1.5rem; padding: 1.75rem; color: white; box-shadow: 0 10px 30px -10px rgba(245, 158, 11, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="trending-up" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(5deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.8rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Bulan Ini</p>
            <p style="font-size: 2.5rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($thisMonthVisitor) }}</p>
        </div>
    </div>
</div>

<!-- Daily Chart -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="bar-chart-2" style="width: 18px; height: 18px; color: #3b82f6;"></i>
            Grafik Kunjungan Harian (30 Hari Terakhir)
        </h4>
    </div>
    @if($perDay->count() > 0)
    <div style="position: relative; height: 260px; width: 100%;">
        <canvas id="dailyChart"></canvas>
    </div>
    @else
    <div style="text-align: center; padding: 4rem 1rem; color: #94a3b8;">
        <i data-lucide="bar-chart" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
        <p>Belum ada data kunjungan dalam 30 hari terakhir.</p>
    </div>
    @endif
</div>

<!-- Monthly Chart + Per Institusi -->
<div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Monthly Chart -->
    <div style="flex: 2 1 300px; min-width: 0; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden; display: flex; flex-direction: column;">
        <div style="padding: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; background: #f8fafc;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="calendar" style="width: 18px; height: 18px; color: #10b981;"></i>
                Statistik Bulanan
            </h4>
            <form method="GET" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; background: white; border: 1px solid #cbd5e1; border-radius: 99px; padding: 0.2rem 0.5rem; overflow: hidden;">
                    <input type="date" name="date_from" value="{{ $dateFrom }}" style="padding: 0.3rem 0.5rem; border: none; outline: none; font-size: 0.75rem; color: #475569; background: transparent;">
                    <span style="color: #cbd5e1; font-weight: 300;">|</span>
                    <input type="date" name="date_to" value="{{ $dateTo }}" style="padding: 0.3rem 0.5rem; border: none; outline: none; font-size: 0.75rem; color: #475569; background: transparent;">
                </div>
                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 0.4rem 1rem; border: none; border-radius: 99px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                    Filter
                </button>
            </form>
        </div>
        <div style="padding: 1.5rem; flex: 1;">
            @if($perMonth->count() > 0)
            <div style="position: relative; height: 260px; width: 100%;">
                <canvas id="monthlyChart"></canvas>
            </div>
            @else
            <div style="text-align: center; padding: 4rem 1rem; color: #94a3b8; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <i data-lucide="calendar-x" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>Tidak ada data pada rentang tanggal ini.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Top 10 Institusi -->
    <div style="flex: 1 1 300px; min-width: 0; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="building-2" style="width: 18px; height: 18px; color: #f59e0b;"></i>
            Top 10 Institusi Asal
        </h4>
        <div>
            @forelse($perInstitution as $i => $inst)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; {{ !$loop->last ? 'border-bottom: 1px solid rgba(0,0,0,0.05);' : '' }} transition: 0.2s;" onmouseover="this.style.transform='translateX(3px)';">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 1.5rem; height: 1.5rem; border-radius: 50%; background: #f1f5f9; color: #64748b; font-size: 0.7rem; font-weight: 700; display: flex; align-items: center; justify-content: center;">{{ $i + 1 }}</div>
                    <span style="font-size: 0.85rem; font-weight: 600; color: #334155;">{{ Str::limit($inst->institution, 25) }}</span>
                </div>
                <span style="background: #eff6ff; color: #2563eb; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bfdbfe;">
                    {{ number_format($inst->total) }}
                </span>
            </div>
            @empty
            <div style="text-align: center; padding: 2rem 0; color: #94a3b8;">
                <p>Belum ada data institusi.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Visitors Table -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; align-items: center;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="clock" style="width: 18px; height: 18px; color: #3b82f6;"></i>
            20 Pengunjung Terbaru
        </h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: white; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th style="padding: 1rem 2rem; text-align: left;">Nama / Anggota</th>
                    <th style="padding: 1rem 2rem; text-align: left;">ID / Tipe</th>
                    <th style="padding: 1rem 2rem; text-align: left;">Institusi Asal</th>
                    <th style="padding: 1rem 2rem; text-align: center;">Waktu Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentVisitors as $v)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 2rem; color: #0f172a; font-weight: 700;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 28px; height: 28px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #475569;">
                                {{ strtoupper(substr($v->member_name, 0, 1)) }}
                            </div>
                            {{ $v->member_name }}
                        </div>
                    </td>
                    <td style="padding: 1rem 2rem; color: #64748b;">
                        @if($v->member_id)
                            <span style="font-family: monospace; font-weight: 600;">{{ $v->member_id }}</span>
                        @else
                            <span style="background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.7rem; font-weight: 600;">Tamu Umum</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 2rem; color: #475569;">
                        {{ $v->institution ?: '-' }}
                    </td>
                    <td style="padding: 1rem 2rem; color: #64748b; text-align: center; font-weight: 500;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                            <i data-lucide="clock" style="width: 14px; height: 14px; color: #94a3b8;"></i>
                            {{ \Carbon\Carbon::parse($v->checkin_date)->format('d M Y, H:i') }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding: 4rem 1rem; text-align: center; color: #94a3b8;">Belum ada data kunjungan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dailyCanvas = document.getElementById('dailyChart');
    if (dailyCanvas) {
        new Chart(dailyCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($perDay->pluck('tgl')->map(fn($v) => \Carbon\Carbon::parse($v)->format('d M'))) !!},
                datasets: [{
                    label: 'Jumlah Pengunjung', 
                    data: {!! json_encode($perDay->pluck('total')->map(fn($v) => (int)$v)) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)', 
                    hoverBackgroundColor: '#2563eb',
                    borderRadius: 4,
                    barPercentage: 0.8
                }]
            },
            options: { 
                maintainAspectRatio: false,
                responsive: true, 
                plugins: { 
                    legend: { display: false },
                    tooltip: { cornerRadius: 8, padding: 12 }
                }, 
                scales: { 
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false }, ticks: { maxRotation: 45, font: { size: 10 } } }
                } 
            }
        });
    }

    const monthlyCanvas = document.getElementById('monthlyChart');
    if (monthlyCanvas) {
        new Chart(monthlyCanvas, {
            type: 'line',
            data: {
                labels: {!! json_encode($perMonth->pluck('bulan')->map(fn($v) => \Carbon\Carbon::parse($v)->translatedFormat('M Y'))) !!},
                datasets: [{
                    label: 'Pengunjung Bulanan', 
                    data: {!! json_encode($perMonth->pluck('total')->map(fn($v) => (int)$v)) !!},
                    borderColor: '#10b981', 
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    fill: true, 
                    tension: 0.4, 
                    borderWidth: 3, 
                    pointRadius: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
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
});
</script>
@endsection


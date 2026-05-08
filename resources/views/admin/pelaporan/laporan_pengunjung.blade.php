@extends('layouts.admin')

@section('pageTitle', 'Laporan Pengunjung')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
        <div style="background: #eff6ff; border-radius: 0.5rem; padding: 0.75rem;">
            <i data-lucide="users" style="width: 1.5rem; height: 1.5rem; color: #3b82f6;"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Total Pengunjung</p>
            <p style="font-size: 1.75rem; font-weight: 800; color: #1e293b;">{{ number_format($totalVisitor) }}</p>
        </div>
    </div>
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
        <div style="background: #dcfce7; border-radius: 0.5rem; padding: 0.75rem;">
            <i data-lucide="calendar-check" style="width: 1.5rem; height: 1.5rem; color: #10b981;"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Hari Ini</p>
            <p style="font-size: 1.75rem; font-weight: 800; color: #10b981;">{{ number_format($todayVisitor) }}</p>
        </div>
    </div>
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
        <div style="background: #fef3c7; border-radius: 0.5rem; padding: 0.75rem;">
            <i data-lucide="trending-up" style="width: 1.5rem; height: 1.5rem; color: #f59e0b;"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Bulan Ini</p>
            <p style="font-size: 1.75rem; font-weight: 800; color: #f59e0b;">{{ number_format($thisMonthVisitor) }}</p>
        </div>
    </div>
</div>

<!-- Daily Chart -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem;">
    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Pengunjung per Hari (30 Hari Terakhir)</h4>
    <canvas id="dailyChart" style="max-height: 260px;"></canvas>
</div>

<!-- Monthly Chart + Per Institusi -->
<div style="display: grid; grid-template-columns: 3fr 2fr; gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h4 style="font-weight: 700; color: #1e293b;">Statistik Bulanan</h4>
            <form method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
                <input type="date" name="date_from" value="{{ $dateFrom }}" style="padding: 0.35rem 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.8rem;">
                <span style="color: #94a3b8;">—</span>
                <input type="date" name="date_to" value="{{ $dateTo }}" style="padding: 0.35rem 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.8rem;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 0.35rem 0.6rem; border: none; border-radius: 0.375rem; font-size: 0.8rem; cursor: pointer;">Filter</button>
            </form>
        </div>
        <canvas id="monthlyChart" style="max-height: 260px;"></canvas>
    </div>

    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">🏢 Top 10 Institusi</h4>
        @forelse($perInstitution as $i => $inst)
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; {{ !$loop->last ? 'border-bottom: 1px solid #f1f5f9;' : '' }}">
            <span style="font-size: 0.85rem; color: #475569;">{{ $inst->institution }}</span>
            <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">{{ $inst->total }}</span>
        </div>
        @empty
        <p style="color: #94a3b8; text-align: center; font-size: 0.875rem; padding: 1rem 0;">Belum ada data.</p>
        @endforelse
    </div>
</div>

<!-- Recent Visitors Table -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0;">
        <h4 style="font-weight: 700; color: #1e293b;">20 Pengunjung Terbaru</h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.7rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">ID Anggota</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Nama</th>
                    <th style="padding: 0.75rem 1.5rem;">Institusi</th>
                    <th style="padding: 0.75rem 1.5rem;">Waktu Check-in</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentVisitors as $v)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; font-family: monospace;">{{ $v->member_id ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #1e293b; font-weight: 500;">{{ $v->member_name }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $v->institution ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $v->checkin_date }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding: 2rem; text-align: center; color: #94a3b8;">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
new Chart(document.getElementById('dailyChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($perDay->pluck('tgl')) !!},
        datasets: [{
            label: 'Pengunjung', data: {!! json_encode($perDay->pluck('total')) !!},
            backgroundColor: 'rgba(59,130,246,0.6)', borderColor: '#3b82f6', borderWidth: 1, borderRadius: 4
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true }, x: { ticks: { maxRotation: 45, font: { size: 9 } } } } }
});

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($perMonth->pluck('bulan')) !!},
        datasets: [{
            label: 'Pengunjung', data: {!! json_encode($perMonth->pluck('total')) !!},
            borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)',
            fill: true, tension: 0.4, borderWidth: 2.5, pointRadius: 4
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection

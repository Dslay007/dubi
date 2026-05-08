@extends('layouts.admin')

@section('pageTitle', 'Laporan Anggota')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); border-radius: 0.75rem; padding: 1.25rem; color: white;">
        <p style="font-size: 0.75rem; opacity: 0.85; text-transform: uppercase;">Total Anggota</p>
        <p style="font-size: 2rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalMember) }}</p>
    </div>
    <div style="background: linear-gradient(135deg, #10b981, #059669); border-radius: 0.75rem; padding: 1.25rem; color: white;">
        <p style="font-size: 0.75rem; opacity: 0.85; text-transform: uppercase;">Masih Aktif</p>
        <p style="font-size: 2rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalActive) }}</p>
    </div>
    <div style="background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 0.75rem; padding: 1.25rem; color: white;">
        <p style="font-size: 0.75rem; opacity: 0.85; text-transform: uppercase;">Kadaluarsa</p>
        <p style="font-size: 2rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalExpired) }}</p>
    </div>
    <div style="background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 0.75rem; padding: 1.25rem; color: white;">
        <p style="font-size: 0.75rem; opacity: 0.85; text-transform: uppercase;">Baru (30 Hari)</p>
        <p style="font-size: 2rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalNew) }}</p>
    </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Registrasi per Bulan (Area) -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Registrasi Anggota per Bulan (12 Bulan Terakhir)</h4>
        <canvas id="regChart" style="max-height: 280px;"></canvas>
    </div>

    <!-- Gender Pie -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Komposisi Gender</h4>
        <div style="max-width: 240px; margin: 0 auto;">
            <canvas id="genderChart"></canvas>
        </div>
    </div>
</div>

<!-- Per Tipe Anggota (Horizontal Bar) -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem;">
    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Anggota per Tipe</h4>
    <canvas id="typeChart" style="max-height: 250px;"></canvas>
</div>

<!-- Recent Members Table -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0;">
        <h4 style="font-weight: 700; color: #1e293b;">15 Anggota Terbaru</h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.7rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">ID</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Nama</th>
                    <th style="padding: 0.75rem 1.5rem;">Tipe</th>
                    <th style="padding: 0.75rem 1.5rem;">Tgl Daftar</th>
                    <th style="padding: 0.75rem 1.5rem;">Expire</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentMembers as $m)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; font-family: monospace;">{{ $m->member_id }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #1e293b; font-weight: 500;">{{ $m->member_name }}</td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center;">
                        <span style="background: #eff6ff; color: #1d4ed8; padding: 0.15rem 0.5rem; border-radius: 1rem; font-size: 0.7rem;">{{ $m->member_type_name ?? '-' }}</span>
                    </td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $m->register_date }}</td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center;">
                        @if($m->expire_date && $m->expire_date < now()->format('Y-m-d'))
                            <span style="color: #ef4444; font-weight: 500;">{{ $m->expire_date }}</span>
                        @else
                            <span style="color: #64748b;">{{ $m->expire_date ?? '-' }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
new Chart(document.getElementById('regChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($regPerMonth->pluck('bulan')) !!},
        datasets: [{
            label: 'Registrasi', data: {!! json_encode($regPerMonth->pluck('total')) !!},
            borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.1)',
            fill: true, tension: 0.4, borderWidth: 2.5, pointRadius: 4
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('genderChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($genderStats->map(fn($g) => $g->gender == 1 ? 'Laki-laki' : 'Perempuan')->values()) !!},
        datasets: [{ data: {!! json_encode($genderStats->pluck('total')) !!}, backgroundColor: ['#3b82f6','#ec4899'], borderWidth: 0 }]
    },
    options: { plugins: { legend: { position: 'bottom', labels: { padding: 12 } } } }
});

new Chart(document.getElementById('typeChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($perType->pluck('member_type_name')) !!},
        datasets: [{ label: 'Jumlah', data: {!! json_encode($perType->pluck('total')) !!}, backgroundColor: '#8b5cf6', borderRadius: 6 }]
    },
    options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
});
</script>
@endsection

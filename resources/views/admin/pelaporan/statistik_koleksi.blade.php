@extends('layouts.admin')

@section('pageTitle', 'Statistik Koleksi')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 0.75rem; padding: 1.5rem; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="font-size: 0.8rem; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.05em;">Total Judul</p>
                <p style="font-size: 2.5rem; font-weight: 800; line-height: 1.1; margin-top: 0.25rem;">{{ number_format($totalBiblio) }}</p>
            </div>
            <i data-lucide="book-open" style="width: 3rem; height: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
    <div style="background: linear-gradient(135deg, #10b981, #059669); border-radius: 0.75rem; padding: 1.5rem; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="font-size: 0.8rem; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.05em;">Total Eksemplar</p>
                <p style="font-size: 2.5rem; font-weight: 800; line-height: 1.1; margin-top: 0.25rem;">{{ number_format($totalItem) }}</p>
            </div>
            <i data-lucide="layers" style="width: 3rem; height: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Per GMD (Doughnut) -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Koleksi per GMD</h4>
        <div style="max-width: 320px; margin: 0 auto;">
            <canvas id="gmdChart"></canvas>
        </div>
    </div>

    <!-- Per Tahun Terbit (Bar) -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Koleksi per Tahun Terbit</h4>
        <canvas id="yearChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<!-- Per Tipe Koleksi (Horizontal Bar) -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem;">
    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Eksemplar per Tipe Koleksi</h4>
    <canvas id="collTypeChart" style="max-height: 260px;"></canvas>
</div>

<!-- Recent Titles Table -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0;">
        <h4 style="font-weight: 700; color: #1e293b;">10 Judul Terbaru</h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">#</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Judul</th>
                    <th style="padding: 0.75rem 1.5rem;">ISBN</th>
                    <th style="padding: 0.75rem 1.5rem;">Tahun</th>
                    <th style="padding: 0.75rem 1.5rem;">Tanggal Input</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBiblio as $i => $b)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.75rem 1.5rem; color: #94a3b8;">{{ $i + 1 }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #1e293b; font-weight: 500;">{{ Str::limit($b->title, 60) }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $b->isbn_issn ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $b->publish_year ?: '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $b->input_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
const palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1','#14b8a6','#e11d48'];

new Chart(document.getElementById('gmdChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($perGmd->pluck('gmd_name')) !!},
        datasets: [{ data: {!! json_encode($perGmd->pluck('total')) !!}, backgroundColor: palette, borderWidth: 0 }]
    },
    options: { plugins: { legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } } } }
});

new Chart(document.getElementById('yearChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($perYear->pluck('publish_year')) !!},
        datasets: [{ label: 'Jumlah Judul', data: {!! json_encode($perYear->pluck('total')) !!}, backgroundColor: '#3b82f6', borderRadius: 6 }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('collTypeChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($perCollType->pluck('coll_type_name')) !!},
        datasets: [{ label: 'Jumlah Eksemplar', data: {!! json_encode($perCollType->pluck('total')) !!}, backgroundColor: '#10b981', borderRadius: 6 }]
    },
    options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
});
</script>
@endsection

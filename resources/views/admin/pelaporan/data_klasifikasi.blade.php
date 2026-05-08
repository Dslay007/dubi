@extends('layouts.admin')

@section('pageTitle', 'Data Klasifikasi')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<!-- Top Classification Chart -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem;">
    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">15 Klasifikasi Terbanyak</h4>
    <canvas id="classChart" style="max-height: 320px;"></canvas>
</div>

<!-- Data Table -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Daftar Klasifikasi</h3>
    </div>

    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari klasifikasi..."
                style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;">Cari</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.7rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Klasifikasi</th>
                    <th style="padding: 0.75rem 1.5rem; width: 150px;">Jumlah Judul</th>
                    <th style="padding: 0.75rem 1.5rem; width: 300px;">Distribusi</th>
                </tr>
            </thead>
            <tbody>
                @php $maxCount = $classifications->max('total') ?: 1; @endphp
                @forelse($classifications as $c)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.75rem 1.5rem; color: #1e293b; font-weight: 600; font-family: monospace;">{{ $c->classification }}</td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center;">
                        <span style="background: #eff6ff; color: #1d4ed8; padding: 0.2rem 0.6rem; border-radius: 1rem; font-size: 0.8rem; font-weight: 600;">{{ $c->total }}</span>
                    </td>
                    <td style="padding: 0.75rem 1.5rem;">
                        <div style="background: #f1f5f9; border-radius: 1rem; overflow: hidden; height: 0.5rem;">
                            <div style="background: linear-gradient(90deg, #3b82f6, #6366f1); height: 100%; border-radius: 1rem; width: {{ ($c->total / $maxCount) * 100 }}%;"></div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding: 2rem; text-align: center; color: #94a3b8;">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($classifications->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $classifications->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
const palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1','#14b8a6','#e11d48','#a855f7','#0ea5e9','#22c55e'];

new Chart(document.getElementById('classChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topClassifications->pluck('classification')) !!},
        datasets: [{
            label: 'Jumlah Judul',
            data: {!! json_encode($topClassifications->pluck('total')) !!},
            backgroundColor: palette.slice(0, {!! $topClassifications->count() !!}),
            borderRadius: 6
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection

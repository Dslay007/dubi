@extends('layouts.admin')

@section('pageTitle', 'Data Klasifikasi')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<x-master-header 
    title="Data Klasifikasi" 
    subtitle="Laporan pemetaan koleksi perpustakaan berdasarkan sistem klasifikasi (DDC dll)." 
    icon="git-merge"
>
</x-master-header>

<!-- Top Classification Chart -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="bar-chart" style="width: 18px; height: 18px; color: #3b82f6;"></i>
            15 Klasifikasi Terbanyak
        </h4>
    </div>
    @if($topClassifications->count() > 0)
    <div style="position: relative; height: 320px; width: 100%;">
        <canvas id="classChart"></canvas>
    </div>
    @else
    <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
        <i data-lucide="inbox" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
        <p>Data klasifikasi belum tersedia.</p>
    </div>
    @endif
</div>

<!-- Data Table -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="list" style="width: 20px; height: 20px; color: #8b5cf6;"></i>
            Daftar Seluruh Klasifikasi
        </h4>
    </div>

    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: white;">
        <form method="GET" style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; max-width: 400px; position: relative;">
                <i data-lucide="search" style="width: 16px; height: 16px; color: #94a3b8; position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode atau nama klasifikasi..." class="form-input" style="padding-left: 2.5rem; border-radius: 99px;">
            </div>
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.6rem 1.25rem; border: none; border-radius: 99px; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <i data-lucide="search" style="width: 16px; height: 16px;"></i> Cari
            </button>
            @if($search)
            <a href="{{ route('admin.pelaporan.data_klasifikasi') }}" class="btn" style="background: white; color: #475569; padding: 0.6rem 1.25rem; border: 1px solid #cbd5e1; border-radius: 99px; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 2rem; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.05);">Kode / Nama Klasifikasi</th>
                    <th style="padding: 1rem 2rem; width: 200px; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05);">Jumlah Judul Koleksi</th>
                    <th style="padding: 1rem 2rem; width: 400px; border-bottom: 1px solid rgba(0,0,0,0.05);">Proporsi & Distribusi</th>
                </tr>
            </thead>
            <tbody>
                @php $maxCount = $classifications->max('total') ?: 1; @endphp
                @forelse($classifications as $c)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 2rem; color: #0f172a; font-weight: 700; font-family: 'JetBrains Mono', 'Courier New', monospace; font-size: 1rem;">
                        {{ $c->classification }}
                    </td>
                    <td style="padding: 1rem 2rem; text-align: center;">
                        <span style="background: #eff6ff; color: #1d4ed8; padding: 0.25rem 1rem; border-radius: 99px; font-size: 0.85rem; font-weight: 700; border: 1px solid #bfdbfe;">
                            {{ number_format($c->total) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 2rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="flex: 1; background: #e2e8f0; border-radius: 99px; overflow: hidden; height: 0.75rem; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                                <div style="background: linear-gradient(90deg, #3b82f6, #6366f1); height: 100%; border-radius: 99px; width: {{ ($c->total / $maxCount) * 100 }}%; transition: 1s ease-out;"></div>
                            </div>
                            <span style="font-size: 0.75rem; color: #64748b; font-weight: 600; min-width: 40px; text-align: right;">
                                {{ round(($c->total / $maxCount) * 100) }}%
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 4rem 1rem; text-align: center; color: #94a3b8;">
                        <i data-lucide="search-x" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p style="font-weight: 500; color: #475569;">Tidak ada data klasifikasi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($classifications->hasPages())
    <div style="padding: 1.5rem 2rem; border-top: 1px solid rgba(0,0,0,0.05); background: white;">
        {{ $classifications->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classCanvas = document.getElementById('classChart');
    if (classCanvas) {
        const palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1','#14b8a6','#e11d48','#a855f7','#0ea5e9','#22c55e'];
        const dataCount = {!! $topClassifications->count() !!};
        
        // Safety check to ensure we don't slice with 0 or undefined if dataCount is 0
        let bgColors = [];
        if (dataCount > 0) {
            bgColors = palette.slice(0, dataCount);
            // If dataCount > palette length, repeat colors
            if(dataCount > palette.length) {
                for(let i = palette.length; i < dataCount; i++) {
                    bgColors.push(palette[i % palette.length]);
                }
            }
        }

        new Chart(classCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topClassifications->pluck('classification')->map(fn($v) => $v ?? 'Unknown')) !!},
                datasets: [{
                    label: 'Jumlah Judul Koleksi',
                    data: {!! json_encode($topClassifications->pluck('total')->map(fn($v) => (int)$v)) !!},
                    backgroundColor: bgColors,
                    borderRadius: 6,
                    barPercentage: 0.7
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
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false } },
                    x: { grid: { display: false } }
                } 
            }
        });
    }
});
</script>
@endsection


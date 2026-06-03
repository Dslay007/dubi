@extends('layouts.admin')

@section('pageTitle', 'Statistik Koleksi')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<x-master-header 
    title="Statistik Koleksi" 
    subtitle="Ringkasan data bibliografi dan eksemplar koleksi perpustakaan." 
    icon="bar-chart-2"
>
    <a href="{{ route('admin.pelaporan.koleksi_perpustakaan') }}" class="btn" style="background: white; color: #475569; border: 1px solid #cbd5e1; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
        <i data-lucide="book" style="width: 16px; height: 16px;"></i> Detail Koleksi
    </a>
</x-master-header>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 1.5rem; padding: 2rem; color: white; box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.4); position: relative; overflow: hidden;">
        <i data-lucide="book-open" style="width: 8rem; height: 8rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(-10deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.85rem; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem;">Total Judul Koleksi</p>
            <p style="font-size: 3rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($totalBiblio) }}</p>
            <p style="font-size: 0.8rem; opacity: 0.8; margin-top: 1rem;">Total entri bibliografi dalam sistem.</p>
        </div>
    </div>
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 1.5rem; padding: 2rem; color: white; box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.4); position: relative; overflow: hidden;">
        <i data-lucide="layers" style="width: 8rem; height: 8rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(-10deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.85rem; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem;">Total Eksemplar</p>
            <p style="font-size: 3rem; font-weight: 800; line-height: 1; margin: 0;">{{ number_format($totalItem) }}</p>
            <p style="font-size: 0.8rem; opacity: 0.8; margin-top: 1rem;">Total item fisik yang tersedia.</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Per GMD (Doughnut) -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="pie-chart" style="width: 18px; height: 18px; color: #8b5cf6;"></i>
                Distribusi GMD
            </h4>
        </div>
        @if($perGmd->count() > 0)
        <div style="max-width: 250px; margin: 0 auto; position: relative;">
            <canvas id="gmdChart"></canvas>
        </div>
        @else
        <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
            <i data-lucide="inbox" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
            <p>Data belum tersedia.</p>
        </div>
        @endif
    </div>

    <!-- Per Tahun Terbit (Bar) -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="bar-chart" style="width: 18px; height: 18px; color: #3b82f6;"></i>
                Koleksi Berdasarkan Tahun Terbit
            </h4>
        </div>
        @if($perYear->count() > 0)
        <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="yearChart"></canvas>
        </div>
        @else
        <div style="text-align: center; padding: 4rem 1rem; color: #94a3b8;">
            <i data-lucide="inbox" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
            <p>Data belum tersedia.</p>
        </div>
        @endif
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Per Tipe Koleksi (Horizontal Bar) -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="bookmark" style="width: 18px; height: 18px; color: #10b981;"></i>
                Eksemplar per Tipe Koleksi
            </h4>
        </div>
        @if($perCollType->count() > 0)
        <div style="position: relative; height: 260px; width: 100%;">
            <canvas id="collTypeChart"></canvas>
        </div>
        @else
        <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
            <i data-lucide="inbox" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
            <p>Data belum tersedia.</p>
        </div>
        @endif
    </div>
    
    <!-- Top GMD List Insight -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="award" style="width: 18px; height: 18px; color: #f59e0b;"></i>
                Format Populer (GMD)
            </h4>
        </div>
        <div>
            @foreach($perGmd->take(5) as $idx => $gmd)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; {{ !$loop->last ? 'border-bottom: 1px solid rgba(0,0,0,0.05);' : '' }}">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="background: {{ $idx < 3 ? '#fef3c7' : '#f1f5f9' }}; color: {{ $idx < 3 ? '#d97706' : '#64748b' }}; width: 1.75rem; height: 1.75rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">{{ $idx + 1 }}</span>
                    <span style="font-weight: 600; color: #334155;">{{ $gmd->gmd_name ?? 'Tidak Terdefinisi' }}</span>
                </div>
                <span style="background: #eff6ff; color: #2563eb; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700;">{{ number_format($gmd->total) }} judul</span>
            </div>
            @endforeach
            @if($perGmd->isEmpty())
                <p style="color: #94a3b8; text-align: center; padding: 2rem;">Belum ada data.</p>
            @endif
        </div>
    </div>
</div>

<!-- Recent Titles Table -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.25rem 2rem; background: #f8fafc; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; gap: 0.75rem;">
        <i data-lucide="clock" style="width: 20px; height: 20px; color: #3b82f6;"></i>
        <h4 style="font-weight: 800; color: #0f172a; margin: 0;">10 Judul Terbaru Ditambahkan</h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: white; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th style="padding: 1rem 2rem; text-align: left;">#</th>
                    <th style="padding: 1rem 2rem; text-align: left;">Judul Koleksi</th>
                    <th style="padding: 1rem 2rem; text-align: center;">ISBN/ISSN</th>
                    <th style="padding: 1rem 2rem; text-align: center;">Tahun Terbit</th>
                    <th style="padding: 1rem 2rem; text-align: center;">Tanggal Input</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBiblio as $i => $b)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 2rem; color: #94a3b8; font-weight: 600;">{{ $i + 1 }}</td>
                    <td style="padding: 1rem 2rem; color: #0f172a; font-weight: 700;">{{ Str::limit($b->title, 60) }}</td>
                    <td style="padding: 1rem 2rem; color: #64748b; text-align: center; font-family: monospace;">{{ $b->isbn_issn ?: '-' }}</td>
                    <td style="padding: 1rem 2rem; text-align: center;">
                        <span style="background: #f1f5f9; color: #475569; padding: 0.2rem 0.6rem; border-radius: 0.25rem; font-weight: 600; font-size: 0.75rem;">{{ $b->publish_year ?: '-' }}</span>
                    </td>
                    <td style="padding: 1rem 2rem; color: #64748b; text-align: center;">{{ \Carbon\Carbon::parse($b->input_date)->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 3rem 1rem; text-align: center; color: #94a3b8;">Belum ada koleksi yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize charts if canvas exists
    const palette = ['#8b5cf6','#3b82f6','#10b981','#f59e0b','#ec4899','#ef4444','#06b6d4','#84cc16','#f97316','#6366f1','#14b8a6','#e11d48'];

    const gmdCanvas = document.getElementById('gmdChart');
    if (gmdCanvas) {
        new Chart(gmdCanvas, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($perGmd->pluck('gmd_name')->map(fn($v) => $v ?? 'Unknown')) !!},
                datasets: [{ 
                    data: {!! json_encode($perGmd->pluck('total')->map(fn($v) => (int)$v)) !!}, 
                    backgroundColor: palette, 
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: { 
                maintainAspectRatio: false,
                responsive: true,
                plugins: { 
                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, font: { size: 12, family: "'Inter', sans-serif" } } } 
                },
                cutout: '70%'
            }
        });
    }

    const yearCanvas = document.getElementById('yearChart');
    if (yearCanvas) {
        new Chart(yearCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($perYear->pluck('publish_year')) !!},
                datasets: [{ 
                    label: 'Jumlah Judul', 
                    data: {!! json_encode($perYear->pluck('total')->map(fn($v) => (int)$v)) !!}, 
                    backgroundColor: 'rgba(59, 130, 246, 0.8)', 
                    hoverBackgroundColor: '#2563eb',
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: { 
                maintainAspectRatio: false,
                responsive: true, 
                plugins: { legend: { display: false }, tooltip: { cornerRadius: 8, padding: 12 } }, 
                scales: { 
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false } },
                    x: { grid: { display: false } }
                } 
            }
        });
    }

    const collTypeCanvas = document.getElementById('collTypeChart');
    if (collTypeCanvas) {
        new Chart(collTypeCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($perCollType->pluck('coll_type_name')->map(fn($v) => $v ?? 'Unknown')) !!},
                datasets: [{ 
                    label: 'Jumlah Eksemplar', 
                    data: {!! json_encode($perCollType->pluck('total')->map(fn($v) => (int)$v)) !!}, 
                    backgroundColor: 'rgba(16, 185, 129, 0.8)', 
                    hoverBackgroundColor: '#059669',
                    borderRadius: 6,
                    barPercentage: 0.6
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

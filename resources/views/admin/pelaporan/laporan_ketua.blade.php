@extends('layouts.admin')

@section('pageTitle', 'Laporan Ketua')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<x-master-header 
    title="Dashboard Eksekutif" 
    subtitle="Ringkasan krusial operasional perpustakaan untuk pengambilan keputusan strategis." 
    icon="trending-up"
>
</x-master-header>

<!-- Hero Cards (4 Pillars) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Pilar 1: Koleksi -->
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 1.5rem; padding: 1.5rem; color: white; box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="book-open" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(15deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Judul Koleksi</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0; margin-bottom: 0.5rem;">{{ number_format($totalBiblio) }}</p>
            <div style="display: inline-flex; align-items: center; background: rgba(255,255,255,0.2); padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">
                {{ number_format($totalItem) }} Eksemplar Fisik
            </div>
        </div>
    </div>

    <!-- Pilar 2: Anggota -->
    <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 1.5rem; padding: 1.5rem; color: white; box-shadow: 0 10px 30px -10px rgba(139, 92, 246, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="users" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(-10deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Anggota Aktif</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0; margin-bottom: 0.5rem;">{{ number_format($activeMember) }}</p>
            <div style="display: inline-flex; align-items: center; background: rgba(255,255,255,0.2); padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">
                Dari Total {{ number_format($totalMember) }} Pendaftar
            </div>
        </div>
    </div>

    <!-- Pilar 3: Kunjungan -->
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 1.5rem; padding: 1.5rem; color: white; box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="user-check" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(5deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Kunjungan (Bulan Ini)</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0; margin-bottom: 0.5rem;">{{ number_format($visitorBulanIni) }}</p>
            <div style="display: inline-flex; align-items: center; background: rgba(255,255,255,0.2); padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">
                Total Historis: {{ number_format($totalVisitor) }}
            </div>
        </div>
    </div>

    <!-- Pilar 4: Transaksi -->
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 1.5rem; padding: 1.5rem; color: white; box-shadow: 0 10px 30px -10px rgba(245, 158, 11, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="repeat" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(-5deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.75rem; opacity: 0.9; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Peminjaman (Bulan Ini)</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0; margin-bottom: 0.5rem;">{{ number_format($loanBulanIni) }}</p>
            <div style="display: inline-flex; align-items: center; background: rgba(255,255,255,0.2); padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">
                Total Historis: {{ number_format($totalLoan) }}
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Main Trend Chart -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="activity" style="width: 18px; height: 18px; color: #10b981;"></i>
                    Korelasi Kunjungan & Peminjaman
                </h4>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.4rem; margin-left: 1.8rem;">Tren partisipasi anggota dalam 12 bulan terakhir.</p>
            </div>
        </div>
        
        <div style="flex: 1; position: relative; min-height: 280px;">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Secondary Metrics & Top Lists -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Status Operasional Cards -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
            <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
                <div style="background: #eff6ff; color: #3b82f6; width: 3rem; height: 3rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="book-marked" style="width: 1.5rem; height: 1.5rem;"></i>
                </div>
                <div>
                    <p style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Eksemplar Sedang Dipinjam</p>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">{{ number_format($activeLoan) }} <span style="font-size: 0.8rem; font-weight: 500; color: #94a3b8;">Buku</span></p>
                </div>
            </div>

            <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
                <div style="background: #fef2f2; color: #ef4444; width: 3rem; height: 3rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="alert-triangle" style="width: 1.5rem; height: 1.5rem;"></i>
                </div>
                <div>
                    <p style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Tunggakan Denda Berjalan</p>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Top 5 Koleksi -->
        <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); flex: 1;">
            <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="award" style="width: 18px; height: 18px; color: #f59e0b;"></i>
                5 Koleksi Terfavorit
            </h4>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @forelse($topBooks as $i => $book)
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; {{ !$loop->last ? 'border-bottom: 1px dashed rgba(0,0,0,0.05);' : '' }}">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 0.85rem; font-weight: 800; color: #94a3b8; width: 15px;">#{{ $i+1 }}</span>
                        <span style="font-size: 0.85rem; font-weight: 600; color: #334155;">{{ Str::limit($book->title, 35) }}</span>
                    </div>
                    <span style="background: #f8fafc; color: #475569; padding: 0.15rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #e2e8f0;">
                        {{ $book->total }}x
                    </span>
                </div>
                @empty
                <p style="text-align: center; color: #94a3b8; font-size: 0.85rem; padding: 2rem 0;">Belum ada riwayat peminjaman.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trendCanvas = document.getElementById('trendChart');
    if (trendCanvas) {
        new Chart(trendCanvas, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'label')) !!},
                datasets: [
                    {
                        label: 'Pengunjung', 
                        data: {!! json_encode(array_map(fn($v) => (int)$v, array_column($chartData, 'visitor'))) !!},
                        borderColor: '#3b82f6', 
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true, 
                        tension: 0.4, 
                        borderWidth: 3, 
                        pointRadius: 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Transaksi Peminjaman', 
                        data: {!! json_encode(array_map(fn($v) => (int)$v, array_column($chartData, 'loan'))) !!},
                        borderColor: '#f59e0b', 
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        fill: true, 
                        tension: 0.4, 
                        borderWidth: 3, 
                        pointRadius: 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#f59e0b',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: { 
                maintainAspectRatio: false,
                responsive: true, 
                plugins: { 
                    legend: { 
                        position: 'top', 
                        labels: { padding: 20, usePointStyle: true, font: { family: "'Inter', sans-serif", weight: '600' } } 
                    },
                    tooltip: { 
                        cornerRadius: 8, padding: 12, mode: 'index', intersect: false 
                    }
                }, 
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false } 
                    },
                    x: { 
                        grid: { display: false } 
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }
});
</script>
@endsection

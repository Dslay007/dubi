@extends('layouts.admin')

@section('pageTitle', 'Laporan Keuangan & Denda')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<x-master-header 
    title="Keuangan & Denda" 
    subtitle="Laporan akumulasi denda, penerimaan kas, dan sisa tunggakan anggota." 
    icon="wallet"
>
</x-master-header>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Denda Terbit (Debet) -->
    <div style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); border-radius: 1.5rem; padding: 1.75rem; color: white; box-shadow: 0 10px 30px -10px rgba(239, 68, 68, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="receipt" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(-10deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.8rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Denda Terbit (Debet)</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0;">Rp {{ number_format($totalDebet, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <!-- Pembayaran (Kredit) -->
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 1.5rem; padding: 1.75rem; color: white; box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="banknote" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(10deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.8rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Pembayaran (Kredit)</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0;">Rp {{ number_format($totalCredit, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <!-- Tunggakan (Sisa) -->
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 1.5rem; padding: 1.75rem; color: white; box-shadow: 0 10px 30px -10px rgba(245, 158, 11, 0.4); position: relative; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)';">
        <i data-lucide="alert-triangle" style="width: 7rem; height: 7rem; opacity: 0.1; position: absolute; right: -1rem; bottom: -1rem; transform: rotate(-5deg);"></i>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.8rem; opacity: 0.9; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Tunggakan Belum Dibayar</p>
            <p style="font-size: 2.25rem; font-weight: 800; line-height: 1; margin: 0;">Rp {{ number_format($totalOutstanding, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<!-- Denda per Bulan Chart -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="bar-chart" style="width: 18px; height: 18px; color: #3b82f6;"></i>
            Grafik Debet vs Kredit (12 Bulan Terakhir)
        </h4>
    </div>
    @if($dendaPerMonth->count() > 0)
    <div style="position: relative; height: 320px; width: 100%;">
        <canvas id="dendaChart"></canvas>
    </div>
    @else
    <div style="text-align: center; padding: 4rem 1rem; color: #94a3b8;">
        <i data-lucide="inbox" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
        <p>Belum ada data denda / pembayaran dalam 12 bulan terakhir.</p>
    </div>
    @endif
</div>

<!-- Data Table with Filter -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="list" style="width: 18px; height: 18px; color: #8b5cf6;"></i>
            Rincian Transaksi Denda
        </h4>
    </div>

    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: white;">
        <form method="GET" style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
            <div style="position: relative; flex: 1; min-width: 250px;">
                <i data-lucide="search" style="width: 16px; height: 16px; color: #94a3b8; position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau ID anggota..." class="form-input" style="padding-left: 2.5rem; border-radius: 99px;">
            </div>
            
            <div style="display: flex; align-items: center; background: white; border: 1px solid #cbd5e1; border-radius: 99px; padding: 0.2rem 0.5rem; overflow: hidden;">
                <input type="date" name="date_from" value="{{ $dateFrom }}" style="padding: 0.4rem 0.6rem; border: none; outline: none; font-size: 0.8rem; color: #475569; background: transparent;" title="Tanggal Mulai">
                <span style="color: #cbd5e1; font-weight: 300;">|</span>
                <input type="date" name="date_to" value="{{ $dateTo }}" style="padding: 0.4rem 0.6rem; border: none; outline: none; font-size: 0.8rem; color: #475569; background: transparent;" title="Tanggal Akhir">
            </div>

            <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.6rem 1.25rem; border: none; border-radius: 99px; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <i data-lucide="filter" style="width: 16px; height: 16px;"></i> Filter
            </button>
            <a href="{{ route('admin.pelaporan.laporan_denda') }}" class="btn" style="background: white; color: #475569; padding: 0.6rem 1.25rem; border: 1px solid #cbd5e1; border-radius: 99px; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
                Reset
            </a>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 2rem; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.05);">Tanggal Transaksi</th>
                    <th style="padding: 1rem 2rem; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.05);">Anggota</th>
                    <th style="padding: 1rem 2rem; text-align: right; border-bottom: 1px solid rgba(0,0,0,0.05);">Debet (Denda)</th>
                    <th style="padding: 1rem 2rem; text-align: right; border-bottom: 1px solid rgba(0,0,0,0.05);">Kredit (Bayar)</th>
                    <th style="padding: 1rem 2rem; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.05);">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fines as $f)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 2rem; color: #64748b; font-weight: 500;">
                        {{ \Carbon\Carbon::parse($f->fines_date)->format('d M Y') }}
                    </td>
                    <td style="padding: 1rem 2rem;">
                        <p style="font-weight: 700; color: #0f172a; margin: 0;">{{ $f->member_name ?? 'Tidak Diketahui' }}</p>
                        <span style="font-size: 0.75rem; color: #64748b; font-family: monospace;">ID: {{ $f->member_id }}</span>
                    </td>
                    <td style="padding: 1rem 2rem; text-align: right; font-weight: 700;">
                        @if($f->debet > 0)
                            <span style="color: #ef4444; background: #fee2e2; padding: 0.2rem 0.75rem; border-radius: 99px; font-size: 0.8rem;">
                                + Rp {{ number_format($f->debet, 0, ',', '.') }}
                            </span>
                        @else
                            <span style="color: #cbd5e1;">-</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 2rem; text-align: right; font-weight: 700;">
                        @if($f->credit > 0)
                            <span style="color: #10b981; background: #dcfce7; padding: 0.2rem 0.75rem; border-radius: 99px; font-size: 0.8rem;">
                                Rp {{ number_format($f->credit, 0, ',', '.') }}
                            </span>
                        @else
                            <span style="color: #cbd5e1;">-</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 2rem; color: #64748b; max-width: 300px; line-height: 1.4;">
                        {{ $f->description }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem 1rem; text-align: center; color: #94a3b8;">
                        <i data-lucide="search-x" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p style="font-weight: 500; color: #475569;">Tidak ada data transaksi ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fines->hasPages())
    <div style="padding: 1.5rem 2rem; border-top: 1px solid rgba(0,0,0,0.05); background: white;">
        {{ $fines->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dendaCanvas = document.getElementById('dendaChart');
    if (dendaCanvas) {
        new Chart(dendaCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dendaPerMonth->pluck('bulan')->map(fn($v) => \Carbon\Carbon::parse($v)->translatedFormat('M Y'))) !!},
                datasets: [
                    {
                        label: 'Denda Dikenakan (Debet)', 
                        data: {!! json_encode($dendaPerMonth->pluck('total_debet')->map(fn($v) => (float)$v)) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.8)', 
                        hoverBackgroundColor: '#dc2626',
                        borderRadius: 4
                    },
                    {
                        label: 'Pembayaran Diterima (Kredit)', 
                        data: {!! json_encode($dendaPerMonth->pluck('total_credit')->map(fn($v) => (float)$v)) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.8)', 
                        hoverBackgroundColor: '#059669',
                        borderRadius: 4
                    }
                ]
            },
            options: { 
                maintainAspectRatio: false,
                responsive: true, 
                plugins: { 
                    legend: { 
                        position: 'top', 
                        labels: { padding: 20, usePointStyle: true, font: { family: "'Inter', sans-serif" } }
                    },
                    tooltip: { 
                        cornerRadius: 8, 
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }, 
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'M';
                                if (value >= 1000) return 'Rp ' + (value / 1000) + 'K';
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: { grid: { display: false } }
                } 
            }
        });
    }
});
</script>
@endsection


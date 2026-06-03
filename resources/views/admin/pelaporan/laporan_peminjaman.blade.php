@extends('layouts.admin')

@section('pageTitle', 'Laporan Peminjaman')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<x-master-header 
    title="Laporan Peminjaman" 
    subtitle="Pantau aktivitas sirkulasi, statistik peminjaman, dan riwayat sirkulasi koleksi perpustakaan." 
    icon="arrow-right-left"
>
    <a href="{{ route('admin.sistem.aktifitas.index') }}" class="btn" style="background: white; color: #475569; border: 1px solid #cbd5e1; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
        <i data-lucide="activity" style="width: 16px; height: 16px;"></i> Log Aktifitas
    </a>
</x-master-header>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; border-left: 5px solid #3b82f6; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Total Sirkulasi</p>
                <p style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1;">{{ number_format($totalLoan) }}</p>
            </div>
            <div style="background: #eff6ff; padding: 0.5rem; border-radius: 0.5rem; color: #3b82f6;">
                <i data-lucide="refresh-cw" style="width: 20px; height: 20px;"></i>
            </div>
        </div>
    </div>
    <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; border-left: 5px solid #f59e0b; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Sedang Dipinjam</p>
                <p style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1;">{{ number_format($totalActive) }}</p>
            </div>
            <div style="background: #fef3c7; padding: 0.5rem; border-radius: 0.5rem; color: #d97706;">
                <i data-lucide="book-up" style="width: 20px; height: 20px;"></i>
            </div>
        </div>
    </div>
    <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; border-left: 5px solid #10b981; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Telah Kembali</p>
                <p style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1;">{{ number_format($totalReturned) }}</p>
            </div>
            <div style="background: #dcfce7; padding: 0.5rem; border-radius: 0.5rem; color: #166534;">
                <i data-lucide="book-down" style="width: 20px; height: 20px;"></i>
            </div>
        </div>
    </div>
    <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; border-left: 5px solid #ef4444; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Terlambat</p>
                <p style="font-size: 2rem; font-weight: 800; color: #ef4444; margin: 0; line-height: 1;">{{ number_format($totalOverdue) }}</p>
            </div>
            <div style="background: #fee2e2; padding: 0.5rem; border-radius: 0.5rem; color: #991b1b;">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter + Line Chart Row -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; background: #f8fafc;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="trending-up" style="width: 18px; height: 18px; color: #3b82f6;"></i>
            Tren Peminjaman (Filter Waktu)
        </h4>
        <form method="GET" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; background: white; border: 1px solid #cbd5e1; border-radius: 99px; padding: 0.25rem 0.5rem; overflow: hidden;">
                <input type="date" name="date_from" value="{{ $dateFrom }}" style="padding: 0.4rem 0.6rem; border: none; outline: none; font-size: 0.8rem; color: #475569; background: transparent;">
                <span style="color: #cbd5e1; font-weight: 300;">|</span>
                <input type="date" name="date_to" value="{{ $dateTo }}" style="padding: 0.4rem 0.6rem; border: none; outline: none; font-size: 0.8rem; color: #475569; background: transparent;">
            </div>
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.25rem; border: none; border-radius: 99px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.4rem;">
                <i data-lucide="filter" style="width: 14px; height: 14px;"></i> Terapkan
            </button>
        </form>
    </div>
    <div style="padding: 1.5rem;">
        @if($perMonth->count() > 0)
        <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="loanChart"></canvas>
        </div>
        @else
        <div style="text-align: center; padding: 4rem 1rem; color: #94a3b8;">
            <i data-lucide="calendar-x" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
            <p>Tidak ada data peminjaman pada rentang tanggal yang dipilih.</p>
        </div>
        @endif
    </div>
</div>

<!-- Insights Row -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Top Books -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="award" style="width: 18px; height: 18px; color: #f59e0b;"></i>
            Koleksi Paling Sering Dipinjam
        </h4>
        <div>
            @forelse($topBooks as $i => $book)
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; {{ !$loop->last ? 'border-bottom: 1px solid rgba(0,0,0,0.05);' : '' }} transition: 0.2s;" onmouseover="this.style.transform='translateX(5px)';">
                <span style="background: {{ $i < 3 ? 'linear-gradient(135deg, #f59e0b, #d97706)' : '#f1f5f9' }}; color: {{ $i < 3 ? 'white' : '#64748b' }}; min-width: 2rem; height: 2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; box-shadow: {{ $i < 3 ? '0 4px 6px -1px rgba(245, 158, 11, 0.3)' : 'none' }};">{{ $i + 1 }}</span>
                <div style="flex: 1; min-width: 0;">
                    <p style="font-size: 0.9rem; font-weight: 600; color: #1e293b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $book->title }}">{{ $book->title }}</p>
                </div>
                <span style="background: #eff6ff; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; border: 1px solid #bfdbfe;">
                    {{ number_format($book->total) }}x
                </span>
            </div>
            @empty
            <div style="text-align: center; padding: 2rem; color: #94a3b8;">
                <p>Belum ada data peminjaman.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pie chart of loan status -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="pie-chart" style="width: 18px; height: 18px; color: #10b981;"></i>
            Status Keseluruhan
        </h4>
        @if($totalLoan > 0)
        <div style="max-width: 250px; margin: 0 auto; position: relative;">
            <canvas id="statusChart"></canvas>
        </div>
        @else
        <div style="text-align: center; padding: 2rem; color: #94a3b8;">
            <p>Belum ada data.</p>
        </div>
        @endif
    </div>
</div>

<!-- Recent Loans Table -->
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
        <h4 style="font-weight: 800; color: #0f172a; margin: 0;">20 Peminjaman Terakhir</h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: white; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th style="padding: 1rem 1.5rem; text-align: left;">Peminjam</th>
                    <th style="padding: 1rem 1.5rem; text-align: left;">Judul Buku / Item</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Tgl Pinjam</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Batas Kembali</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Status Saat Ini</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLoans as $loan)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1rem 1.5rem; color: #0f172a; font-weight: 700;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 24px; height: 24px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; color: #475569;">
                                <i data-lucide="user" style="width: 12px; height: 12px;"></i>
                            </div>
                            {{ $loan->member_name ?? $loan->member_id }}
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #475569; font-weight: 500;">
                        {{ Str::limit($loan->title ?? 'Tidak Diketahui', 50) }}
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; text-align: center;">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; text-align: center;">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        @if($loan->is_return == 1)
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bbf7d0;">
                                <span style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%;"></span> Kembali
                            </span>
                        @elseif($loan->due_date < now()->format('Y-m-d'))
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fecaca;">
                                <span style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%;"></span> Terlambat
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fef3c7; color: #b45309; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fde68a;">
                                <span style="width: 6px; height: 6px; background: #f59e0b; border-radius: 50%;"></span> Aktif
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding: 3rem; text-align: center; color: #94a3b8;">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loanCanvas = document.getElementById('loanChart');
    if (loanCanvas) {
        new Chart(loanCanvas, {
            type: 'line',
            data: {
                labels: {!! json_encode($perMonth->pluck('bulan')->map(fn($v) => \Carbon\Carbon::parse($v)->translatedFormat('M Y'))) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($perMonth->pluck('total')->map(fn($v) => (int)$v)) !!},
                    borderColor: '#3b82f6', 
                    backgroundColor: 'rgba(59,130,246,0.1)',
                    fill: true, 
                    tension: 0.4, 
                    borderWidth: 3, 
                    pointRadius: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
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

    const statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Sedang Dipinjam', 'Sudah Kembali', 'Terlambat'],
                datasets: [{ 
                    data: [{{ (int)$totalActive }}, {{ (int)$totalReturned }}, {{ (int)$totalOverdue }}], 
                    backgroundColor: ['#f59e0b', '#10b981', '#ef4444'], 
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
                },
                cutout: '70%'
            }
        });
    }
});
</script>
@endsection

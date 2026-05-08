@extends('layouts.admin')

@section('pageTitle', 'Laporan Peminjaman')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; border-left: 4px solid #3b82f6;">
        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Total Peminjaman</p>
        <p style="font-size: 1.75rem; font-weight: 800; color: #1e293b;">{{ number_format($totalLoan) }}</p>
    </div>
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; border-left: 4px solid #f59e0b;">
        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Sedang Dipinjam</p>
        <p style="font-size: 1.75rem; font-weight: 800; color: #f59e0b;">{{ number_format($totalActive) }}</p>
    </div>
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; border-left: 4px solid #10b981;">
        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Sudah Dikembalikan</p>
        <p style="font-size: 1.75rem; font-weight: 800; color: #10b981;">{{ number_format($totalReturned) }}</p>
    </div>
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; border-left: 4px solid #ef4444;">
        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Terlambat</p>
        <p style="font-size: 1.75rem; font-weight: 800; color: #ef4444;">{{ number_format($totalOverdue) }}</p>
    </div>
</div>

<!-- Filter + Line Chart -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h4 style="font-weight: 700; color: #1e293b;">Tren Peminjaman per Bulan</h4>
        <form method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
            <input type="date" name="date_from" value="{{ $dateFrom }}" style="padding: 0.4rem 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.8rem;">
            <span style="color: #94a3b8;">—</span>
            <input type="date" name="date_to" value="{{ $dateTo }}" style="padding: 0.4rem 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.8rem;">
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.4rem 0.8rem; border: none; border-radius: 0.375rem; font-size: 0.8rem; cursor: pointer;">Filter</button>
        </form>
    </div>
    <canvas id="loanChart" style="max-height: 280px;"></canvas>
</div>

<!-- Two Columns -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Top Books -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">🏆 Buku Paling Sering Dipinjam</h4>
        @forelse($topBooks as $i => $book)
        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0; {{ !$loop->last ? 'border-bottom: 1px solid #f1f5f9;' : '' }}">
            <span style="background: {{ $i < 3 ? '#fbbf24' : '#e2e8f0' }}; color: {{ $i < 3 ? '#78350f' : '#64748b' }}; min-width: 1.75rem; height: 1.75rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">{{ $i + 1 }}</span>
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 0.85rem; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $book->title }}</p>
            </div>
            <span style="background: #eff6ff; color: #1d4ed8; padding: 0.15rem 0.5rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">{{ $book->total }}x</span>
        </div>
        @empty
        <p style="color: #94a3b8; font-size: 0.875rem; text-align: center; padding: 2rem 0;">Belum ada data.</p>
        @endforelse
    </div>

    <!-- Pie chart of loan status -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Status Peminjaman</h4>
        <div style="max-width: 280px; margin: 0 auto;">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Loans Table -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0;">
        <h4 style="font-weight: 700; color: #1e293b;">20 Peminjaman Terbaru</h4>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.7rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Anggota</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Judul Buku</th>
                    <th style="padding: 0.75rem 1.5rem;">Tgl Pinjam</th>
                    <th style="padding: 0.75rem 1.5rem;">Tgl Kembali</th>
                    <th style="padding: 0.75rem 1.5rem;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLoans as $loan)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.75rem 1.5rem; color: #1e293b; font-weight: 500;">{{ $loan->member_name ?? $loan->member_id }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #475569;">{{ Str::limit($loan->title ?? '-', 45) }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $loan->loan_date }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; text-align: center;">{{ $loan->due_date }}</td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center;">
                        @if($loan->is_return == 1)
                            <span style="background: #dcfce7; color: #166534; padding: 0.2rem 0.5rem; border-radius: 1rem; font-size: 0.7rem;">Dikembalikan</span>
                        @elseif($loan->due_date < now()->format('Y-m-d'))
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.2rem 0.5rem; border-radius: 1rem; font-size: 0.7rem;">Terlambat</span>
                        @else
                            <span style="background: #fef9c3; color: #854d0e; padding: 0.2rem 0.5rem; border-radius: 1rem; font-size: 0.7rem;">Dipinjam</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding: 2rem; text-align: center; color: #94a3b8;">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
new Chart(document.getElementById('loanChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($perMonth->pluck('bulan')) !!},
        datasets: [{
            label: 'Peminjaman',
            data: {!! json_encode($perMonth->pluck('total')) !!},
            borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)',
            fill: true, tension: 0.4, borderWidth: 2.5, pointRadius: 4
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Sedang Dipinjam', 'Dikembalikan', 'Terlambat'],
        datasets: [{ data: [{{ $totalActive }}, {{ $totalReturned }}, {{ $totalOverdue }}], backgroundColor: ['#f59e0b','#10b981','#ef4444'], borderWidth: 0 }]
    },
    options: { plugins: { legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } } } }
});
</script>
@endsection

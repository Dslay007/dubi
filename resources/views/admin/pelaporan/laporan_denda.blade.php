@extends('layouts.admin')

@section('pageTitle', 'Laporan Denda')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; border-top: 4px solid #ef4444;">
        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Total Denda (Debet)</p>
        <p style="font-size: 1.75rem; font-weight: 800; color: #ef4444;">Rp {{ number_format($totalDebet, 0, ',', '.') }}</p>
    </div>
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; border-top: 4px solid #10b981;">
        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Total Bayar (Kredit)</p>
        <p style="font-size: 1.75rem; font-weight: 800; color: #10b981;">Rp {{ number_format($totalCredit, 0, ',', '.') }}</p>
    </div>
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.25rem; border-top: 4px solid #f59e0b;">
        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;">Sisa Tunggakan</p>
        <p style="font-size: 1.75rem; font-weight: 800; color: #f59e0b;">Rp {{ number_format($totalOutstanding, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Denda per Bulan Chart -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem;">
    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Tren Denda per Bulan (12 Bulan Terakhir)</h4>
    <canvas id="dendaChart" style="max-height: 280px;"></canvas>
</div>

<!-- Data Table with Filter -->
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Daftar Denda</h3>
    </div>

    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form method="GET" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau ID anggota..."
                style="flex: 1; min-width: 200px; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem; outline: none;">
            <input type="date" name="date_from" value="{{ $dateFrom }}" placeholder="Dari" style="padding: 0.5rem 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem;">
            <input type="date" name="date_to" value="{{ $dateTo }}" placeholder="Sampai" style="padding: 0.5rem 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem;">
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;">Filter</button>
            <a href="{{ route('admin.pelaporan.laporan_denda') }}" style="background: #64748b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none;">Reset</a>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.7rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Tanggal</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">ID Anggota</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Nama</th>
                    <th style="padding: 0.75rem 1.5rem;">Debet (Denda)</th>
                    <th style="padding: 0.75rem 1.5rem;">Kredit (Bayar)</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fines as $f)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.75rem 1.5rem; color: #64748b;">{{ $f->fines_date }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; font-family: monospace;">{{ $f->member_id }}</td>
                    <td style="padding: 0.75rem 1.5rem; color: #1e293b; font-weight: 500;">{{ $f->member_name ?? '-' }}</td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center; color: #ef4444; font-weight: 600;">
                        {{ $f->debet > 0 ? 'Rp '.number_format($f->debet, 0, ',', '.') : '-' }}
                    </td>
                    <td style="padding: 0.75rem 1.5rem; text-align: center; color: #10b981; font-weight: 600;">
                        {{ $f->credit > 0 ? 'Rp '.number_format($f->credit, 0, ',', '.') : '-' }}
                    </td>
                    <td style="padding: 0.75rem 1.5rem; color: #64748b; font-size: 0.8rem;">{{ $f->description }}</td>
                </tr>
                @empty
                <tr><td colspan="6" style="padding: 2rem; text-align: center; color: #94a3b8;">Tidak ada data denda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fines->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $fines->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
new Chart(document.getElementById('dendaChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($dendaPerMonth->pluck('bulan')) !!},
        datasets: [
            {
                label: 'Denda (Debet)', data: {!! json_encode($dendaPerMonth->pluck('total_debet')) !!},
                backgroundColor: 'rgba(239,68,68,0.7)', borderRadius: 4
            },
            {
                label: 'Bayar (Kredit)', data: {!! json_encode($dendaPerMonth->pluck('total_credit')) !!},
                backgroundColor: 'rgba(16,185,129,0.7)', borderRadius: 4
            }
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection

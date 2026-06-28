@extends('layouts.admin')

@section('pageTitle', 'Ringkasan Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <!-- Stat Card 1: Total Koleksi -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="background: #eff6ff; padding: 1rem; border-radius: 0.75rem; color: #3b82f6;">
            <i data-lucide="book" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Koleksi</h3>
            <p style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0;">{{ $totalBiblio }}</p>
        </div>
    </div>
    
    <!-- Stat Card 2: Total Anggota -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="background: #f0fdf4; padding: 1rem; border-radius: 0.75rem; color: #22c55e;">
            <i data-lucide="users" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Anggota</h3>
            <p style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0;">{{ $totalMember }}</p>
        </div>
    </div>

    <!-- Stat Card 3: Pengunjung Hari Ini -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="background: #fdf4ff; padding: 1rem; border-radius: 0.75rem; color: #d946ef;">
            <i data-lucide="user-check" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Pengunjung Hari Ini</h3>
            <p style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0;">{{ $visitorToday }}</p>
        </div>
    </div>

    <!-- Stat Card 4: Pinjaman Aktif -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="background: #fffbeb; padding: 1rem; border-radius: 0.75rem; color: #f59e0b;">
            <i data-lucide="arrow-right-left" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Pinjaman Aktif</h3>
            <p style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0;">{{ $activeLoans }}</p>
        </div>
    </div>

    <!-- Stat Card 5: Terlambat -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="background: #fef2f2; padding: 1rem; border-radius: 0.75rem; color: #ef4444;">
            <i data-lucide="alert-triangle" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Terlambat</h3>
            <p style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0;">{{ $overdueLoans }}</p>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <!-- Chart Peminjaman -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
            <span>Tren Peminjaman (7 Hari Terakhir)</span>
            <i data-lucide="trending-up" style="color: #3b82f6; width: 1.25rem;"></i>
        </h3>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="loanChart"></canvas>
        </div>
    </div>

    <!-- Chart Pengunjung -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
            <span>Tren Pengunjung (7 Hari Terakhir)</span>
            <i data-lucide="users" style="color: #d946ef; width: 1.25rem;"></i>
        </h3>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 2.5rem;">
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a;">5 Transaksi Peminjaman Terbaru</h3>
            <a href="{{ route('admin.circulation.history') }}" style="color: #3b82f6; font-size: 0.9rem; text-decoration: none; font-weight: 600;">Lihat Semua</a>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b;">
                        <th style="padding: 0.75rem 1rem;">Anggota</th>
                        <th style="padding: 0.75rem 1rem;">Judul Buku</th>
                        <th style="padding: 0.75rem 1rem;">Tanggal Pinjam</th>
                        <th style="padding: 0.75rem 1rem;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLoans as $loan)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 1rem;">
                            <div style="font-weight: 600; color: #1e293b;">{{ $loan->member->member_name ?? 'Unknown' }}</div>
                            <div style="font-size: 0.8rem; color: #64748b;">{{ $loan->member_id }}</div>
                        </td>
                        <td style="padding: 1rem; color: #334155;">{{ $loan->item->biblio->title ?? 'Unknown' }}</td>
                        <td style="padding: 1rem; color: #334155;">{{ \Carbon\Carbon::parse($loan->loan_date)->isoFormat('D MMM Y') }}</td>
                        <td style="padding: 1rem;">
                            @if($loan->is_return)
                                <span style="background: #dcfce7; color: #16a34a; padding: 0.25rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">Dikembalikan</span>
                            @else
                                @if(\Carbon\Carbon::parse($loan->due_date)->isPast())
                                    <span style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">Terlambat</span>
                                @else
                                    <span style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">Dipinjam</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem; color: #64748b;">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 3rem; border-radius: 1rem; color: white; position: relative; overflow: hidden;">
    <div style="position: relative; z-index: 1;">
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Selamat datang, {{ $user->realname ?? $user->username }}!</h2>
        <p style="color: #94a3b8; font-size: 1.1rem; max-width: 600px;">
            Gunakan tombol cepat di bawah ini untuk memulai aktivitas harian Anda.
        </p>
        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.circulation.index') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 2rem; border-radius: 99px; text-decoration: none;">Sirkulasi Buku</a>
            <a href="{{ route('admin.member.guest_counter') }}" class="btn" style="background: rgba(255,255,255,0.1); color: white; padding: 0.75rem 2rem; border-radius: 99px; text-decoration: none; backdrop-filter: blur(10px);">Buku Tamu</a>
            <a href="{{ route('admin.biblio.create') }}" class="btn" style="background: rgba(255,255,255,0.1); color: white; padding: 0.75rem 2rem; border-radius: 99px; text-decoration: none; backdrop-filter: blur(10px);">Tambah Buku</a>
        </div>
    </div>
    <i data-lucide="library" style="position: absolute; right: -2rem; bottom: -2rem; width: 20rem; height: 20rem; opacity: 0.05; transform: rotate(-15deg);"></i>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartLabels = @json($chartLabels);
    const loanChartData = @json($loanChartData);
    const visitorChartData = @json($visitorChartData);

    // Loan Chart
    const ctxLoan = document.getElementById('loanChart').getContext('2d');
    new Chart(ctxLoan, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Buku Dipinjam',
                data: loanChartData,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Visitor Chart
    const ctxVisitor = document.getElementById('visitorChart').getContext('2d');
    new Chart(ctxVisitor, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Total Pengunjung',
                data: visitorChartData,
                backgroundColor: '#d946ef',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush

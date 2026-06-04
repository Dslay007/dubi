@extends('layouts.admin')

@section('pageTitle', 'Daftar Eksemplar Keluar')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #f59e0b;"><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10.4 12.6a2 2 0 1 1 3 3L8 21l-4 1 1-4Z"/><path d="M20 18v-2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2"/><path d="M20 11V7.5L14.5 2H6a2 2 0 0 0-2 2v5"/></svg>
            Daftar Eksemplar Keluar
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Laporan item/buku yang saat ini sedang dipinjam oleh anggota.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
         <a href="{{ route('admin.item.out.export', request()->all()) }}" class="btn" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#d1fae5';" onmouseout="this.style.background='#ecfdf5';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Export CSV
        </a>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc;">
        <form action="{{ route('admin.item.out') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 1.25rem; align-items: flex-end;">
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Pencarian Judul / Anggota</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." 
                        style="width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; font-family: inherit; font-size: 0.9rem; transition: 0.2s;" onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Tgl Pinjam (Dari)</label>
                <input type="date" name="date_start" value="{{ request('date_start') }}" style="padding: 0.6rem 1rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; font-family: inherit; font-size: 0.9rem; transition: 0.2s;" onfocus="this.style.borderColor='#f59e0b';" onblur="this.style.borderColor='#e2e8f0';">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem;">Tgl Pinjam (Sampai)</label>
                <input type="date" name="date_end" value="{{ request('date_end') }}" style="padding: 0.6rem 1rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; font-family: inherit; font-size: 0.9rem; transition: 0.2s;" onfocus="this.style.borderColor='#f59e0b';" onblur="this.style.borderColor='#e2e8f0';">
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="padding: 0.6rem 1.25rem; background: #0f172a; color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#1e293b';" onmouseout="this.style.background='#0f172a';">Filter</button>
                @if(request()->hasAny(['q', 'date_start', 'date_end']))
                    <a href="{{ route('admin.item.out') }}" style="padding: 0.6rem 1.25rem; background: white; color: #64748b; border: 2px solid #e2e8f0; border-radius: 99px; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.2s; display: flex; align-items: center;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Eksemplar</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Peminjam</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tanggal Pinjam</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Jatuh Tempo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $loan)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem;">
                        <div style="font-weight: 800; color: #1e293b; margin-bottom: 0.25rem;">{{ $loan->item->biblio->title ?? 'N/A' }}</div>
                        <div style="font-weight: 600; color: #64748b; font-family: monospace; letter-spacing: 0.05em; background: #f1f5f9; padding: 0.25rem 0.75rem; border-radius: 0.5rem; display: inline-block; border: 1px solid #e2e8f0; font-size: 0.8rem;">
                            {{ $loan->item->item_code ?? 'N/A' }}
                        </div>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 32px; height: 32px; background: #fef3c7; color: #d97706; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                                {{ substr($loan->member->member_name ?? '?', 0, 1) }}
                            </div>
                            <div style="font-weight: 700; color: #334155;">{{ $loan->member->member_name ?? 'N/A' }}</div>
                        </div>
                    </td>
                    <td style="padding: 1.25rem 1rem; color: #475569; font-weight: 500;">
                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #fef2f2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.8rem; border: 1px solid #fecaca; display: inline-flex; align-items: center; gap: 0.25rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 4rem 2rem; text-align: center;">
                        <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10.4 12.6a2 2 0 1 1 3 3L8 21l-4 1 1-4Z"/><path d="M20 18v-2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2"/><path d="M20 11V7.5L14.5 2H6a2 2 0 0 0-2 2v5"/></svg>
                        </div>
                        <h4 style="font-weight: 800; color: #475569; font-size: 1.1rem; margin-bottom: 0.25rem;">Tidak Ada Data</h4>
                        <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Saat ini tidak ada eksemplar yang sedang dipinjam.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($items->hasPages())
    <div style="padding: 0 2rem 2rem 2rem;">
        {{ $items->links() }}
    </div>
    @endif
</div>
@endsection


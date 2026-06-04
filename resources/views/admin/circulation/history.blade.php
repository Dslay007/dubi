@extends('layouts.admin')

@section('pageTitle', 'Sejarah Peminjaman')

@section('content')
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
         <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
             <div>
                 <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #10b981;"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                     Sejarah Peminjaman
                 </h3>
                 <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Catatan lengkap seluruh transaksi peminjaman perpustakaan.</p>
             </div>
             <a href="{{ route('admin.circulation.history.export', request()->all()) }}" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                 Export CSV
             </a>
         </div>
         
         <!-- Filter Form -->
         <form action="{{ route('admin.circulation.history') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; background: white; padding: 1.25rem; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); margin-top: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
             <div style="flex: 1; min-width: 250px;">
                 <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Pencarian (Buku/Anggota)</label>
                 <div style="position: relative;">
                     <div style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                     </div>
                     <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." style="width: 100%; padding: 0.6rem 0.75rem 0.6rem 2.25rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; color: #1e293b;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'">
                 </div>
             </div>
             
             <div>
                 <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Status</label>
                 <select name="status" style="padding: 0.6rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; background: white; color: #1e293b; min-width: 150px;">
                     <option value="">Semua Status</option>
                     <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Sedang Dipinjam</option>
                     <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Sudah Kembali</option>
                 </select>
             </div>

             <div>
                 <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Tgl Pinjam (Dari)</label>
                 <input type="date" name="date_start" value="{{ request('date_start') }}" style="padding: 0.6rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; color: #1e293b;">
             </div>

             <div>
                 <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Tgl Pinjam (Sampai)</label>
                 <input type="date" name="date_end" value="{{ request('date_end') }}" style="padding: 0.6rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; color: #1e293b;">
             </div>

             <div style="display: flex; gap: 0.5rem;">
                 <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.6rem 1.25rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 700; font-family: inherit; font-size: 0.9rem; transition: 0.2s;" onmouseover="this.style.background='#2563eb';" onmouseout="this.style.background='#3b82f6';">Filter Data</button>
                 @if(request()->hasAny(['q', 'status', 'date_start', 'date_end']))
                     <a href="{{ route('admin.circulation.history') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.6rem 1.25rem; border-radius: 0.5rem; text-decoration: none; font-weight: 700; font-size: 0.9rem; border: 1px solid #cbd5e1; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">Reset</a>
                 @endif
             </div>
         </form>
    </div>

    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Eksemplar</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Judul Buku</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Anggota</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Status</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tgl Pinjam</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tgl Kembali</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem; font-weight: 700; color: #0f172a;">{{ $loan->item_code }}</td>
                    <td style="padding: 1.25rem 1rem; font-weight: 500; color: #334155;">
                        {{ Str::limit(optional(optional($loan->item)->biblio)->title ?? optional($loan->loanHistory)->title ?? 'N/A', 40) }}
                        @if(!optional(optional($loan->item)->biblio)->title && optional($loan->loanHistory)->title)
                            <span style="font-size: 0.7rem; background: #f1f5f9; color: #64748b; padding: 0.15rem 0.4rem; border-radius: 4px; margin-left: 0.25rem;" title="Buku telah dihapus dari sistem">Dihapus</span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem; font-weight: 500; color: #334155;">{{ $loan->member->member_name ?? optional($loan->loanHistory)->member_name ?? 'N/A' }}</td>
                    <td style="padding: 1.25rem 1rem;">
                        @if($loan->is_return)
                            <span style="background: #ecfdf5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #a7f3d0;">Sudah Kembali</span>
                        @else
                            <span style="background: #fffbeb; color: #d97706; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fde68a;">Sedang Dipinjam</span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem; color: #64748b; font-weight: 500;">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                    <td style="padding: 1.25rem 1rem; color: #64748b; font-weight: 500;">{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d M Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem 2rem; text-align: center;">
                        <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        </div>
                        <h4 style="font-weight: 700; color: #475569; font-size: 1.1rem; margin-bottom: 0.25rem;">Data Tidak Ditemukan</h4>
                        <p style="color: #94a3b8; font-size: 0.95rem;">Belum ada sejarah peminjaman yang sesuai dengan filter Anda.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="padding: 1rem 2rem 2rem 2rem;">
        {{ $loans->links() }}
    </div>
</div>
@endsection


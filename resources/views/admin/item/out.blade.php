@extends('layouts.admin')

@section('pageTitle', 'Daftar Eksemplar Keluar')

@section('content')
<div class="card" style="background: white; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 1rem;">
         <div style="display: flex; justify-content: space-between; align-items: center;">
             <h3 style="font-weight: 700; color: #1e293b; margin: 0;">Daftar Eksemplar Keluar (Sedang Dipinjam)</h3>
             <a href="{{ route('admin.item.out.export', request()->all()) }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                 <i data-lucide="download" style="width: 1rem; height: 1rem;"></i> Export CSV
             </a>
         </div>

         <!-- Filter Form -->
         <form action="{{ route('admin.item.out') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
             <div style="flex: 1; min-width: 200px;">
                 <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 0.25rem;">Pencarian (Buku/Anggota)</label>
                 <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-family: inherit;">
             </div>

             <div>
                 <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 0.25rem;">Tgl Pinjam (Dari)</label>
                 <input type="date" name="date_start" value="{{ request('date_start') }}" style="padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-family: inherit;">
             </div>

             <div>
                 <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 0.25rem;">Tgl Pinjam (Sampai)</label>
                 <input type="date" name="date_end" value="{{ request('date_end') }}" style="padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-family: inherit;">
             </div>

             <div>
                 <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600; font-family: inherit;">Filter</button>
                 @if(request()->hasAny(['q', 'date_start', 'date_end']))
                     <a href="{{ route('admin.item.out') }}" class="btn" style="background: #e2e8f0; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; margin-left: 0.5rem;">Reset</a>
                 @endif
             </div>
         </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Item Code</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Title</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Member</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Loan Date</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Due Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $loan)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1e293b;">{{ $loan->item->item_code ?? 'N/A' }}</td>
                    <td style="padding: 1rem 1.5rem;">{{ $loan->item->biblio->title ?? 'N/A' }}</td>
                    <td style="padding: 1rem 1.5rem;">{{ $loan->member->member_name ?? 'N/A' }}</td>
                    <td style="padding: 1rem 1.5rem;">{{ $loan->loan_date }}</td>
                    <td style="padding: 1rem 1.5rem; color: #ef4444; font-weight: 600;">{{ $loan->due_date }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">No items are currently out.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem;">
        {{ $items->links() }}
    </div>
</div>
@endsection

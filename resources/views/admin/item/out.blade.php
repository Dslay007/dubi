@extends('layouts.admin')

@section('pageTitle', 'Daftar Eksemplar Keluar')

@section('content')
<div class="card" style="background: white; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
         <h3 style="font-weight: 700; color: #1e293b;">Items Currently on Loan</h3>
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

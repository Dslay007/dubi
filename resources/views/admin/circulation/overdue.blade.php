@extends('layouts.admin')

@section('pageTitle', 'Daftar Keterlambatan')

@section('content')
<div class="card" style="background: white; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
         <h3 style="font-weight: 700; color: #1e293b;">Daftar Keterlambatan (Overdue Items)</h3>
         
         <!-- Search Filter -->
        <form method="GET" action="{{ route('admin.circulation.overdue') }}" style="display: flex; gap: 0.5rem;">
            <input type="text" name="q" placeholder="Search Member Name/ID..." value="{{ request('q') }}" 
                style="padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; width: 250px;">
            <button type="submit" class="btn" style="background: #0f172a; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem;">Filter</button>
        </form>
    </div>
    
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin: 1rem 1.5rem 0;">{{ session('success') }}</div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Due Date</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Member</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Item Code</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Title</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Days Overdue</th>
                     <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                @php
                    $dueDate = \Carbon\Carbon::parse($loan->due_date);
                    $daysOverdue = max(0, $dueDate->diffInDays(now(), false));
                @endphp
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; color: #ef4444; font-weight: 600;">{{ $loan->due_date }}</td>
                    <td style="padding: 1rem 1.5rem;">{{ $loan->member->member_name ?? 'N/A' }}</td>
                    <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $loan->item_code }}</td>
                    <td style="padding: 1rem 1.5rem;">{{ $loan->item->biblio->title ?? 'N/A' }}</td>
                    <td style="padding: 1rem 1.5rem; color: #b91c1c;">{{ $daysOverdue }} days</td>
                    <td style="padding: 1rem 1.5rem;">
                         <form action="{{ route('admin.circulation.overdue.notify', $loan->loan_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn" style="background: #fbbf24; color: #78350f; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem;">
                                <i data-lucide="mail" style="width: 14px; height: 14px;"></i> Alert
                            </button>
                         </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 2rem; text-align: center; color: #64748b;">No overdue items found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem;">
        {{ $loans->links() }}
    </div>
</div>
@endsection

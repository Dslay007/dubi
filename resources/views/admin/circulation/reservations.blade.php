@extends('layouts.admin')

@section('pageTitle', 'Reservasi')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="font-weight: 700; font-size: 1.25rem; color: #1e293b;">Active Reservations</h3>
    </div>

    <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Date</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Member</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Item</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Status</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem;">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 600; color: #1e293b;">{{ $res->member->member_name ?? 'Unknown' }}</div>
                        <div style="color: #64748b; font-size: 0.75rem;">{{ $res->member_id }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 600; color: #1e293b;">{{ $res->item->biblio->title ?? 'Unknown Title' }}</div>
                        <div style="color: #64748b; font-size: 0.75rem;">{{ $res->item_code }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                         <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.625rem; border-radius: 99px; font-weight: 600; font-size: 0.75rem;">Active</span>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <button style="color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.8rem; font-weight: 600;">Cancel</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2.5rem; text-align: center; color: #64748b;">No active reservations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $reservations->links() }}
    </div>
</div>
@endsection

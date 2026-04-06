@extends('layouts.admin')

@section('pageTitle', 'Aturan Peminjaman')

@section('content')
<div class="card" style="background: white; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
         <h3 style="font-weight: 700; color: #1e293b;">Aturan Peminjaman (Loan Rules)</h3>
    </div>

    <div style="padding: 1.5rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Member Type</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Loan Limit</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Loan Period (Days)</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Fines / Day</th>
                </tr>
            </thead>
            <tbody>
                @foreach($memberTypes as $type)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $type->member_type_name }}</td>
                    <td style="padding: 1rem 1.5rem;">{{ $type->loan_limit }} items</td>
                    <td style="padding: 1rem 1.5rem;">{{ $type->loan_periode }} days</td>
                    <td style="padding: 1rem 1.5rem; color: #ef4444;">Rp {{ number_format($type->fine_each_day, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

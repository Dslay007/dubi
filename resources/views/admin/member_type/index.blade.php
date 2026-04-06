@extends('layouts.admin')

@section('pageTitle', 'Tipe Anggota (Loan Rules)')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="font-weight: 700; font-size: 1.25rem; color: #1e293b;">Daftar Tipe Anggota</h3>
        <a href="{{ route('admin.member_type.create') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none;">+ Add Member Type</a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">{{ session('success') }}</div>
    @endif

    <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Name</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Loan Limit</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Loan Period (Days)</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Fines /Day</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($memberTypes as $type)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $type->member_type_name }}</td>
                    <td style="padding: 1rem 1.5rem;">{{ $type->loan_limit }} items</td>
                    <td style="padding: 1rem 1.5rem;">{{ $type->loan_periode }} days</td>
                    <td style="padding: 1rem 1.5rem;">Rp {{ number_format($type->fine_each_day, 0, ',', '.') }}</td>
                    <td style="padding: 1rem 1.5rem;">
                         <a href="{{ route('admin.member_type.edit', $type->member_type_id) }}" style="color: #3b82f6; font-weight: 600; margin-right: 1rem; text-decoration: none;">Edit</a>
                         <form action="{{ route('admin.member_type.destroy', $type->member_type_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this member type?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 600; cursor: pointer;">Delete</button>
                         </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">No member types found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

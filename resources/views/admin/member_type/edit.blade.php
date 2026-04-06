@extends('layouts.admin')

@section('pageTitle', 'Edit Member Type')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3 style="font-weight: 700; font-size: 1.25rem; color: #1e293b; margin-bottom: 2rem;">Edit Member Type</h3>

    <form action="{{ route('admin.member_type.update', $memberType->member_type_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1.5rem;">
            <label class="label">Member Type Name</label>
            <input type="text" name="member_type_name" class="input" required value="{{ $memberType->member_type_name }}">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div style="margin-bottom: 1.5rem;">
                <label class="label">Loan Limit (Items)</label>
                <input type="number" name="loan_limit" class="input" required min="0" value="{{ $memberType->loan_limit }}">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="label">Loan Period (Days)</label>
                <input type="number" name="loan_periode" class="input" required min="0" value="{{ $memberType->loan_periode }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div style="margin-bottom: 1.5rem;">
                <label class="label">Fine per Day (Rp)</label>
                <input type="number" name="fine_each_day" class="input" required min="0" value="{{ $memberType->fine_each_day }}">
            </div>
             <div style="margin-bottom: 1.5rem;">
                <label class="label">Grace Period (Days)</label>
                <input type="number" name="grace_period" class="input" required min="0" value="{{ $memberType->grace_period }}">
            </div>
        </div>

        <div style="text-align: right;">
            <a href="{{ route('admin.member_type.index') }}" style="color: #64748b; margin-right: 1rem; text-decoration: none;">Cancel</a>
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 2rem; border-radius: 0.375rem; font-weight: 600; border: none; cursor: pointer;">Update</button>
        </div>
    </form>
</div>
@endsection

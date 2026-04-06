@extends('layouts.admin')

@section('pageTitle', 'Add Member Type')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3 style="font-weight: 700; font-size: 1.25rem; color: #1e293b; margin-bottom: 2rem;">Create New Member Type</h3>

    <form action="{{ route('admin.member_type.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label class="label">Member Type Name</label>
            <input type="text" name="member_type_name" class="input" required placeholder="e.g., Standard Member, Dosen">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div style="margin-bottom: 1.5rem;">
                <label class="label">Loan Limit (Items)</label>
                <input type="number" name="loan_limit" class="input" required min="0" value="3">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="label">Loan Period (Days)</label>
                <input type="number" name="loan_periode" class="input" required min="0" value="7">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div style="margin-bottom: 1.5rem;">
                <label class="label">Fine per Day (Rp)</label>
                <input type="number" name="fine_each_day" class="input" required min="0" value="1000">
            </div>
             <div style="margin-bottom: 1.5rem;">
                <label class="label">Grace Period (Days)</label>
                <input type="number" name="grace_period" class="input" required min="0" value="0">
            </div>
        </div>

        <div style="text-align: right;">
            <a href="{{ route('admin.member_type.index') }}" style="color: #64748b; margin-right: 1rem; text-decoration: none;">Cancel</a>
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 2rem; border-radius: 0.375rem; font-weight: 600; border: none; cursor: pointer;">Save</button>
        </div>
    </form>
</div>
@endsection

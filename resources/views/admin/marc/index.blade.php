@extends('layouts.admin')

@section('pageTitle', 'MARC Import/Export')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">MARC Tools</h3>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Import Section -->
        <div>
            <h4 style="font-weight: 600; margin-bottom: 1rem;">Import MARC Records</h4>
            <form action="{{ route('admin.marc.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 0.5rem;">Upload .mrc file</label>
                    <input type="file" name="marc_file" class="input" style="width: 100%; border: 1px solid #cbd5e1; padding: 0.5rem; border-radius: 0.375rem;">
                </div>
                <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none;">Import Records</button>
            </form>
        </div>

        <!-- Export Section -->
        <div style="border-left: 1px solid #e2e8f0; padding-left: 2rem;">
            <h4 style="font-weight: 600; margin-bottom: 1rem;">Export MARC Records</h4>
            <p style="color: #64748b; margin-bottom: 1rem;">Export your current bibliography data to MARC format.</p>
            <a href="{{ route('admin.marc.export') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">Download MARC Export</a>
        </div>
    </div>
</div>
@endsection

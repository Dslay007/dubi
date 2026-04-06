@extends('layouts.admin')

@section('pageTitle', 'Import Bibliography')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0;">
    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Import CSV/Excel</h3>
    
    <form action="{{ route('admin.biblio.process_import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Select File (CSV/XLSX)</label>
            <input type="file" name="file" required style="display: block; width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem;">
            <p style="margin-top: 0.5rem; font-size: 0.85rem; color: #64748b;">
                Ensure your file follows the <a href="#" style="color: #3b82f6;">template format</a>.
            </p>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">Upload & Import</button>
            <a href="{{ route('admin.biblio.index') }}" class="btn" style="background: #cbd5e1; color: #475569; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>
@endsection

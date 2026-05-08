@extends('layouts.admin')

@section('pageTitle', 'Import Role & Permission')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; max-width: 600px;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b; font-size: 1.25rem;">Import Role & Permission</h3>
        <a href="{{ route('admin.sistem.role.index') }}" class="btn" style="background: #334155; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; font-size: 0.875rem; text-decoration: none; font-weight: 500;">← Kembali</a>
    </div>

    <form action="{{ route('admin.sistem.role.process_import') }}" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
        @csrf

        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.375rem; padding: 1rem; margin-bottom: 1.5rem;">
            <p style="font-size: 0.875rem; color: #1e40af; font-weight: 500;">Format CSV yang diterima:</p>
            <code style="font-size: 0.8rem; color: #475569; display: block; margin-top: 0.5rem;">group_id, group_name, module_id, module_name, read, write</code>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem;">Anda bisa mendapatkan file contoh dengan menggunakan fitur <strong>Export CSV</strong> terlebih dahulu.</p>
        </div>

        @error('file') <div style="color: #dc2626; font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Pilih File CSV</label>
            <input type="file" name="file" accept=".csv,.txt" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem;">
        </div>

        <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; font-weight: 600; width: 100%;">Mulai Import</button>
    </form>
</div>
@endsection

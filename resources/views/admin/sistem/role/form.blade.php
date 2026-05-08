@extends('layouts.admin')

@section('pageTitle', $role ? 'Edit Role: ' . $role->group_name : 'Tambah Role Baru')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; max-width: 600px;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">{{ $role ? 'Edit Role' : 'Tambah Role Baru' }}</h3>
        <a href="{{ route('admin.sistem.role.index') }}" class="btn" style="background: #64748b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none;">← Kembali</a>
    </div>

    <form action="{{ $role ? route('admin.sistem.role.update', $role->group_id) : route('admin.sistem.role.store') }}" method="POST" style="padding: 1.5rem;">
        @csrf
        @if($role) @method('PUT') @endif

        @error('group_name') <div style="color: #ef4444; font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $message }}</div> @enderror
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Nama Role / Grup *</label>
            <input type="text" name="group_name" required value="{{ old('group_name', $role->group_name ?? '') }}" placeholder="Contoh: Pustakawan"
                style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 1rem;">
        </div>

        <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; font-weight: 600; width: 100%;">{{ $role ? 'Perbarui Role' : 'Simpan Role Baru' }}</button>
    </form>
</div>
@endsection

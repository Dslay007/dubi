@extends('layouts.admin')

@section('pageTitle', $role ? 'Edit Role: ' . $role->group_name : 'Tambah Role Baru')

@section('content')

<x-form-card 
    title="{{ $role ? 'Edit Role' : 'Tambah Role Baru' }}" 
    icon="shield" 
    action="{{ $role ? route('admin.sistem.role.update', $role->group_id) : route('admin.sistem.role.store') }}" 
    method="{{ $role ? 'PUT' : 'POST' }}" 
    cancelRoute="admin.sistem.role.index"
>
    
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.75rem; padding: 1.25rem; display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 2rem;">
        <i data-lucide="info" style="width: 1.5rem; height: 1.5rem; color: #3b82f6; flex-shrink: 0;"></i>
        <div>
            <h4 style="font-weight: 700; color: #1e40af; margin-bottom: 0.25rem;">Grup Pengguna (Role)</h4>
            <p style="color: #1e3a8a; font-size: 0.875rem; margin: 0; line-height: 1.5;">Grup ini digunakan untuk mengelompokkan staff berdasarkan hak aksesnya. Setelah role dibuat, Anda dapat mengatur menu apa saja yang bisa mereka akses di halaman Hak Akses.</p>
        </div>
    </div>

    @error('group_name') <div style="color: #ef4444; font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $message }}</div> @enderror
    <div style="margin-bottom: 1.5rem;">
        <label class="form-label">Nama Role / Grup <span style="color: #ef4444;">*</span></label>
        <input type="text" name="group_name" required value="{{ old('group_name', $role->group_name ?? '') }}" placeholder="Contoh: Pustakawan" class="form-input">
    </div>

</x-form-card>

@endsection


@extends('layouts.admin')

@section('pageTitle', $staff ? 'Edit Staff: ' . $staff->realname : 'Tambah Staff Baru')

@section('content')

<x-form-card 
    title="{{ $staff ? 'Edit Staff: ' . $staff->realname : 'Tambah Staff Baru' }}" 
    icon="{{ $staff ? 'user-pen' : 'user-plus' }}" 
    action="{{ $staff ? route('admin.sistem.staff.update', $staff->user_id) : route('admin.sistem.staff.store') }}" 
    method="{{ $staff ? 'PUT' : 'POST' }}" 
    cancelRoute="admin.sistem.staff.index"
>

    {{-- Username --}}
    <div style="margin-bottom: 1.5rem;">
        <label class="form-label">
            Username <span style="color: #ef4444;">*</span>
        </label>
        <input type="text" name="username" required 
               value="{{ old('username', $staff->username ?? '') }}" 
               placeholder="Contoh: pustakawan01"
               class="form-input">
        @error('username') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
    </div>

    {{-- Nama Lengkap --}}
    <div style="margin-bottom: 1.5rem;">
        <label class="form-label">
            Nama Lengkap <span style="color: #ef4444;">*</span>
        </label>
        <input type="text" name="realname" required 
               value="{{ old('realname', $staff->realname ?? '') }}" 
               placeholder="Contoh: Ahmad Pustakawan"
               class="form-input">
        @error('realname') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
    </div>

    {{-- Email --}}
    <div style="margin-bottom: 1.5rem;">
        <label class="form-label">
            Email <span style="color: #94a3b8; font-weight: 400;">(opsional)</span>
        </label>
        <input type="email" name="email" 
               value="{{ old('email', $staff->email ?? '') }}" 
               placeholder="email@contoh.com"
               class="form-input">
        @error('email') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
    </div>

    {{-- Password --}}
    <div style="margin-bottom: 1.5rem;">
        <label class="form-label">
            Password 
            @if($staff)
                <span style="color: #94a3b8; font-weight: 400;">(kosongkan jika tidak ingin mengubah)</span>
            @else
                <span style="color: #ef4444;">*</span>
            @endif
        </label>
        <div style="position: relative;">
            <input type="password" name="password" id="passwordInput"
                   {{ $staff ? '' : 'required' }}
                   placeholder="{{ $staff ? '••••••••' : 'Minimal 4 karakter' }}"
                   class="form-input" style="padding-right: 3rem;">
            <button type="button" onclick="togglePassword()" 
                    style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0.25rem;"
                    title="Tampilkan/Sembunyikan">
                <i data-lucide="eye" id="eyeIcon" style="width: 1.1rem; height: 1.1rem;"></i>
            </button>
        </div>
        @error('password') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
    </div>

    {{-- Role --}}
    <div style="margin-bottom: 1.75rem;">
        <label class="form-label">
            Role / Grup <span style="color: #ef4444;">*</span>
        </label>
        <select name="groups" required class="form-input">
            <option value="">— Pilih Role —</option>
            @foreach($roles as $role)
            <option value="{{ $role->group_id }}" {{ old('groups', $staff->groups ?? '') == $role->group_id ? 'selected' : '' }}>
                {{ $role->group_name }}
            </option>
            @endforeach
        </select>
        @error('groups') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
    </div>

    {{-- Info box --}}
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; padding: 1rem; display: flex; align-items: flex-start; gap: 0.75rem;">
        <i data-lucide="info" style="width: 1.25rem; height: 1.25rem; color: #3b82f6; flex-shrink: 0; margin-top: 2px;"></i>
        <p style="color: #1e40af; font-size: 0.875rem; line-height: 1.5; margin: 0;">
            Hak akses menu ditentukan oleh <strong>Role</strong> yang dipilih. Untuk mengatur hak akses, buka 
            <a href="{{ route('admin.sistem.role.index') }}" style="color: #2563eb; text-decoration: underline; font-weight: 600;">Grup Pengguna</a> 
            → Hak Akses.
        </p>
    </div>

</x-form-card>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('data-lucide', 'eye-off');
    } else {
        input.type = 'password';
        icon.setAttribute('data-lucide', 'eye');
    }
    lucide.createIcons();
}
</script>
@endsection


@extends('layouts.admin')

@section('pageTitle', $staff ? 'Edit Staff: ' . $staff->realname : 'Tambah Staff Baru')

@section('content')
<div style="max-width: 640px;">
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
            <div>
                <h3 style="font-weight: 700; color: white; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="{{ $staff ? 'user-pen' : 'user-plus' }}" style="width: 1.15rem; height: 1.15rem;"></i>
                    {{ $staff ? 'Edit Staff' : 'Tambah Staff Baru' }}
                </h3>
                @if($staff)
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 0.25rem;">{{ $staff->username }}</p>
                @endif
            </div>
            <a href="{{ route('admin.sistem.staff.index') }}" class="btn" style="background: rgba(255,255,255,0.15); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; border: 1px solid rgba(255,255,255,0.2);">← Kembali</a>
        </div>

        <form action="{{ $staff ? route('admin.sistem.staff.update', $staff->user_id) : route('admin.sistem.staff.store') }}" method="POST" style="padding: 1.5rem;">
            @csrf
            @if($staff) @method('PUT') @endif

            {{-- Username --}}
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">
                    Username <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="username" required 
                       value="{{ old('username', $staff->username ?? '') }}" 
                       placeholder="Contoh: pustakawan01"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-size: 0.95rem; transition: border-color 0.2s;"
                       onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                       onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                @error('username') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">
                    Nama Lengkap <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="realname" required 
                       value="{{ old('realname', $staff->realname ?? '') }}" 
                       placeholder="Contoh: Ahmad Pustakawan"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-size: 0.95rem; transition: border-color 0.2s;"
                       onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                       onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                @error('realname') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">
                    Email <span style="color: #94a3b8; font-weight: 400;">(opsional)</span>
                </label>
                <input type="email" name="email" 
                       value="{{ old('email', $staff->email ?? '') }}" 
                       placeholder="email@contoh.com"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-size: 0.95rem; transition: border-color 0.2s;"
                       onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                       onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                @error('email') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">
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
                           style="width: 100%; padding: 0.75rem; padding-right: 3rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-size: 0.95rem; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                           onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                    <button type="button" onclick="togglePassword()" 
                            style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0.25rem;"
                            title="Tampilkan/Sembunyikan">
                        <i data-lucide="eye" id="eyeIcon" style="width: 1.1rem; height: 1.1rem;"></i>
                    </button>
                </div>
                @error('password') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
            </div>

            {{-- Role --}}
            <div style="margin-bottom: 1.75rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">
                    Role / Grup <span style="color: #ef4444;">*</span>
                </label>
                <select name="groups" required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-size: 0.95rem; background: white; cursor: pointer; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                        onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
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
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; padding: 0.85rem 1rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.6rem;">
                <i data-lucide="info" style="width: 1rem; height: 1rem; color: #3b82f6; flex-shrink: 0; margin-top: 2px;"></i>
                <p style="color: #1e40af; font-size: 0.8rem; line-height: 1.5; margin: 0;">
                    Hak akses menu ditentukan oleh <strong>Role</strong> yang dipilih. Untuk mengatur hak akses, buka 
                    <a href="{{ route('admin.sistem.role.index') }}" style="color: #2563eb; text-decoration: underline;">Role and Permission</a> 
                    → Atur Hak Akses.
                </p>
            </div>

            {{-- Submit --}}
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.9rem; flex: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                    <i data-lucide="save" style="width: 1rem; height: 1rem;"></i>
                    {{ $staff ? 'Perbarui Data' : 'Simpan Staff Baru' }}
                </button>
                <a href="{{ route('admin.sistem.staff.index') }}" style="background: white; color: #475569; padding: 0.75rem 1.25rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-weight: 500; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center;">Batal</a>
            </div>
        </form>
    </div>
</div>

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

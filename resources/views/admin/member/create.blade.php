@extends('layouts.admin')

@section('pageTitle', 'Add New Member')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05);">
        
        <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <h3 style="font-weight: 800; color: #0f172a; font-size: 1.5rem; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                Pendaftaran Anggota Baru
            </h3>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Isi formulir di bawah ini untuk menambahkan anggota ke perpustakaan.</p>
        </div>

        <form action="{{ route('admin.member.store') }}" method="POST" style="padding: 2.5rem 2rem;">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                     <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">ID Anggota <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="member_id" required class="input form-input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
                 <div>
                     <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="member_name" required class="input form-input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Alamat Email</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <input type="email" name="member_email" class="input form-input" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div style="position: relative;">
                     <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Kata Sandi <span style="color: #ef4444;">*</span></label>
                    <input type="password" name="passwd" id="passwd" required class="input form-input" style="width: 100%; padding: 0.8rem 1rem; padding-right: 2.5rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            <div style="margin-bottom: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="position: relative;">
                         <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Kata Sandi <span style="color: #ef4444;">*</span></label>
                        <input type="password" name="passwd" id="passwd" required class="input form-input" style="width: 100%; padding: 0.8rem 1rem; padding-right: 2.5rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                        <button type="button" onclick="togglePassword('passwd', this)" style="position: absolute; right: 0.75rem; bottom: 0.85rem; background: none; border: none; cursor: pointer; color: #64748b;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                     <div style="position: relative;">
                         <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Konfirmasi Kata Sandi <span style="color: #ef4444;">*</span></label>
                        <input type="password" name="passwd_confirmation" id="passwd_confirmation" required class="input form-input" style="width: 100%; padding: 0.8rem 1rem; padding-right: 2.5rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                        <button type="button" onclick="togglePassword('passwd_confirmation', this)" style="position: absolute; right: 0.75rem; bottom: 0.85rem; background: none; border: none; cursor: pointer; color: #64748b;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                @error('passwd') <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</div> @enderror
                @include('components.password-strength', ['inputId' => 'passwd'])
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2.5rem;">
                <div>
                     <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Jenis Kelamin</label>
                    <select name="gender" class="input form-input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; color: #1e293b; background: white; cursor: pointer; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                        <option value="1">Laki-laki</option>
                        <option value="0">Perempuan</option>
                    </select>
                </div>
                 <div>
                     <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Tipe Keanggotaan</label>
                    <select name="member_type_id" class="input form-input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; color: #1e293b; background: white; cursor: pointer; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                        @if(isset($memberTypes) && $memberTypes->count() > 0)
                            @foreach($memberTypes as $type)
                                <option value="{{ $type->member_type_id }}">{{ $type->member_type_name }}</option>
                            @endforeach
                        @else
                            <option value="1">Standard Member</option>
                        @endif
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid rgba(0,0,0,0.05);">
                <a href="{{ route('admin.member.index') }}" style="padding: 0.8rem 1.75rem; background: #f1f5f9; color: #475569; text-decoration: none; border-radius: 99px; font-weight: 700; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';">Batal</a>
                <button type="submit" class="btn" style="padding: 0.8rem 1.75rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">Simpan Anggota</button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    
    if (isPassword) {
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>`;
    } else {
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }
}
</script>
@endsection


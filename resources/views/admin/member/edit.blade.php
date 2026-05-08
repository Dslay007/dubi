@extends('layouts.admin')

@section('pageTitle', 'Edit Data Anggota')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05);">
        
        <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <h3 style="font-weight: 800; color: #0f172a; font-size: 1.5rem; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                Ubah Data Anggota
            </h3>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Perbarui informasi, kontak, dan keanggotaan pengguna.</p>
        </div>

        @if ($errors->any())
            <div style="margin: 2rem 2rem 0; background: #fef2f2; color: #b91c1c; padding: 1rem 1.5rem; border-radius: 1rem; border: 1px solid #fecaca; display: flex; gap: 0.75rem; align-items: flex-start;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 0.1rem;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div>
                    <h4 style="font-weight: 700; margin: 0 0 0.25rem 0; font-size: 0.95rem;">Terjadi Kesalahan</h4>
                    <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.9rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.member.update', $member->member_id) }}" method="POST" enctype="multipart/form-data" style="padding: 2.5rem 2rem;">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">ID Anggota <span style="color: #ef4444;">*</span></label>
                <input type="text" value="{{ $member->member_id }}" disabled class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; background: #f8fafc; color: #94a3b8; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; cursor: not-allowed; font-weight: 600;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Nama Anggota <span style="color: #ef4444;">*</span></label>
                <input type="text" name="member_name" value="{{ old('member_name', $member->member_name) }}" required class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Tanggal Lahir <span style="color: #ef4444;">*</span></label>
                <input type="date" name="birth_date" value="{{ old('birth_date', $member->birth_date) }}" class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Anggota Sejak <span style="color: #ef4444;">*</span></label>
                <input type="date" name="member_since_date" value="{{ old('member_since_date', $member->member_since_date) }}" class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Tanggal Registrasi <span style="color: #ef4444;">*</span></label>
                <input type="date" name="register_date" value="{{ old('register_date', $member->register_date) }}" class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Berlaku Hingga <span style="color: #ef4444;">*</span></label>
                <input type="date" name="expire_date" value="{{ old('expire_date', $member->expire_date) }}" required class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Institusi</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10v11"/><path d="M20 10v11"/><path d="M12 15v6"/><path d="M4 10l8-6 8 6"/><path d="M4 10h16"/></svg>
                    </div>
                    <input type="text" name="inst_name" value="{{ old('inst_name', $member->inst_name) }}" class="input" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Tipe Keanggotaan <span style="color: #ef4444;">*</span></label>
                <select name="member_type_id" class="input" required style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; color: #1e293b; background: white; cursor: pointer; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                    @foreach($memberTypes as $type)
                        <option value="{{ $type->member_type_id }}" {{ old('member_type_id', $member->member_type_id) == $type->member_type_id ? 'selected' : '' }}>{{ $type->member_type_name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Jenis Kelamin</label>
                <div style="display: flex; gap: 1.5rem; background: #f8fafc; padding: 0.8rem 1rem; border-radius: 0.75rem; border: 2px solid #e2e8f0;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 600; cursor: pointer;">
                        <input type="radio" name="gender" value="1" {{ old('gender', $member->gender) == '1' ? 'checked' : '' }} style="accent-color: #3b82f6; width: 1.1rem; height: 1.1rem;"> Laki-laki
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 600; cursor: pointer;">
                        <input type="radio" name="gender" value="0" {{ old('gender', $member->gender) == '0' ? 'checked' : '' }} style="accent-color: #3b82f6; width: 1.1rem; height: 1.1rem;"> Perempuan
                    </label>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: start;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; padding-top: 0.75rem;">Alamat</label>
                <textarea name="member_address" class="input" rows="3" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">{{ old('member_address', $member->member_address) }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $member->postal_code) }}" class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: start;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; padding-top: 0.75rem;">Alamat Surat</label>
                <textarea name="member_mail_address" class="input" rows="3" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">{{ old('member_mail_address', $member->member_mail_address) }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Nomor Telepon</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <input type="text" name="member_phone" value="{{ old('member_phone', $member->member_phone) }}" class="input" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Nomor Faks</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <input type="text" name="member_fax" value="{{ old('member_fax', $member->member_fax) }}" class="input" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Nomor Identitas (NIK)</label>
                <input type="text" name="nik" value="{{ old('nik', $member->nik) }}" class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: start;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; padding-top: 0.75rem;">Catatan</label>
                <textarea name="member_notes" class="input" rows="3" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">{{ old('member_notes', $member->member_notes) }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Tunda Keanggotaan</label>
                <div style="background: #f8fafc; padding: 0.8rem 1rem; border-radius: 0.75rem; border: 2px solid #e2e8f0; display: inline-flex;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="is_pending" value="1" {{ old('is_pending', $member->is_pending) == 1 ? 'checked' : '' }} style="accent-color: #3b82f6; width: 1.1rem; height: 1.1rem;"> Ya, tangguhkan
                    </label>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 2rem; align-items: start; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 2rem;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; padding-top: 0.5rem;">Foto</label>
                <div>
                    @if($member->member_image)
                        <div style="margin-bottom: 1rem;">
                            <img src="{{ asset('images/members/' . $member->member_image) }}" alt="Member Photo" style="max-width: 150px; border-radius: 0.75rem; border: 2px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                        </div>
                    @endif
                    <div style="position: relative;">
                        <input type="file" name="member_image" accept="image/png, image/jpeg, image/jpg, image/gif" class="input" style="width: 100%; padding: 0.8rem 1rem; border: 2px dashed #cbd5e1; border-radius: 0.75rem; outline: none; font-size: 0.95rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.borderColor='#3b82f6'; this.style.backgroundColor='#f8fafc';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.backgroundColor='transparent';">
                    </div>
                    <p style="font-size: 0.8rem; color: #64748b; margin: 0.5rem 0 0 0; display: flex; align-items: center; gap: 0.3rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        Maksimum 2000 KB. (2x3, PNG/JPG)
                    </p>
                </div>
            </div>
            
            <h4 style="font-weight: 800; color: #0f172a; font-size: 1.15rem; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Kredensial & Keamanan
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Surel (Email) Akun</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <input type="email" name="member_email" value="{{ old('member_email', $member->member_email) }}" class="input" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Kata Sandi Baru</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <input type="password" name="passwd" class="input" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" placeholder="Kosongkan jika tidak ingin mengubah" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 2rem; align-items: center;">
                <label class="label" style="font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Konfirmasi Sandi Baru</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <input type="password" name="passwd_confirmation" class="input" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1.5rem;">
                <a href="{{ route('admin.member.index') }}" class="btn" style="padding: 0.8rem 1.75rem; background: #f1f5f9; color: #475569; text-decoration: none; border-radius: 99px; font-weight: 700; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';">Batal</a>
                <button type="submit" class="btn" style="padding: 0.8rem 1.75rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

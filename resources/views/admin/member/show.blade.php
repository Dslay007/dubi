@extends('layouts.admin')

@section('pageTitle', 'Detail Anggota')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Detail Informasi Anggota
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Informasi lengkap terkait anggota perpustakaan.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.member.edit', $member->member_id) }}" class="btn" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: none; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(245,158,11,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
            Edit Data
        </a>
        <a href="{{ route('admin.member.index') }}" class="btn" style="background: white; color: #475569; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: 2px solid #e2e8f0; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Bagian Kiri: Profil Singkat -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2rem; align-self: start;">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            @if($member->member_image)
                <img src="{{ asset('images/members/' . $member->member_image) }}" alt="Foto {{ $member->member_name }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 4px solid #eff6ff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 1rem;">
            @else
                <div style="width: 150px; height: 150px; border-radius: 50%; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; border: 4px solid #dbeafe;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            @endif
            <h3 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin: 0 0 0.25rem 0;">{{ $member->member_name }}</h3>
            <div style="color: #3b82f6; font-weight: 700; font-size: 0.95rem; margin-bottom: 0.5rem; letter-spacing: 0.05em;">{{ $member->member_id }}</div>
            
            <div style="display: inline-block; padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #f1f5f9; color: #475569; margin-bottom: 1rem;">
                {{ $member->memberType ? $member->memberType->member_type_name : 'Tidak Ada Tipe' }}
            </div>
            
            @if($member->is_pending)
            <div style="display: inline-block; padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #fef3c7; color: #d97706;">
                Pending
            </div>
            @endif
            
            @if(Carbon\Carbon::parse($member->expire_date)->isPast())
            <div style="display: inline-block; padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #fee2e2; color: #b91c1c;">
                Kedaluwarsa
            </div>
            @else
            <div style="display: inline-block; padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #dcfce7; color: #166534;">
                Aktif
            </div>
            @endif
        </div>
        
        <div style="border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1.5rem;">
            <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem; color: #475569;">
                <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #64748b;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Telepon</div>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #1e293b;">{{ $member->member_phone ?: '-' }}</div>
                </div>
            </div>
            
            <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem; color: #475569;">
                <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #64748b;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Email</div>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #1e293b;">{{ $member->member_email ?: '-' }}</div>
                </div>
            </div>
            
            <div style="display: flex; align-items: flex-start; gap: 0.75rem; color: #475569;">
                <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #64748b; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Alamat</div>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #1e293b; line-height: 1.4;">{{ $member->member_address ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Kanan: Detail Lainnya -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Informasi Keanggotaan -->
        <div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
            <div style="padding: 1.25rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    Informasi Keanggotaan
                </h3>
            </div>
            <div style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Institusi / Universitas</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->inst_name ?: '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">NIK / Identitas Lain</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->nik ?: '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Tanggal Registrasi</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->register_date ? date('d M Y', strtotime($member->register_date)) : '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Tanggal Berlaku Hingga</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->expire_date ? date('d M Y', strtotime($member->expire_date)) : '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Anggota Sejak</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->member_since_date ? date('d M Y', strtotime($member->member_since_date)) : '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Terakhir Diperbarui</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->last_update ? date('d M Y H:i', strtotime($member->last_update)) : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Informasi Pribadi -->
        <div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
            <div style="padding: 1.25rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Data Pribadi & Alamat
                </h3>
            </div>
            <div style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Jenis Kelamin</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">
                            @if($member->gender == '1') Laki-laki @elseif($member->gender == '0') Perempuan @else - @endif
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Tanggal Lahir</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->birth_date ? date('d M Y', strtotime($member->birth_date)) : '-' }}</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Alamat Surat Menyurat</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->member_mail_address ?: '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Kode Pos</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->postal_code ?: '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Fax</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b;">{{ $member->member_fax ?: '-' }}</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Catatan Khusus</div>
                        <div style="font-size: 1rem; font-weight: 500; color: #1e293b; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; border: 1px solid rgba(0,0,0,0.05); min-height: 60px;">
                            {{ $member->member_notes ?: 'Tidak ada catatan.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

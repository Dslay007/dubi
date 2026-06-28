@extends('layouts.admin')

@section('pageTitle', 'Aturan Peminjaman')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
            Aturan Peminjaman & Sirkulasi
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Ringkasan kebijakan sirkulasi yang berlaku untuk setiap tipe keanggotaan perpustakaan.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
    @forelse($memberTypes as $type)
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 40px -10px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 30px -10px rgba(0,0,0,0.05)';">
        <!-- Header Card -->
        <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: white; border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); color: #3b82f6;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Tipe Anggota</div>
                <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; margin: 0;">{{ $type->member_type_name }}</h3>
            </div>
        </div>

        <!-- Body Card -->
        <div style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <!-- Batas Pinjam -->
                <div style="background: #f8fafc; padding: 1rem; border-radius: 1rem; text-align: center; border: 1px solid rgba(0,0,0,0.03);">
                    <div style="color: #64748b; font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                        Maks Pinjam
                    </div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #3b82f6;">{{ $type->loan_limit }} <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">Buku</span></div>
                </div>

                <!-- Lama Pinjam -->
                <div style="background: #f8fafc; padding: 1rem; border-radius: 1rem; text-align: center; border: 1px solid rgba(0,0,0,0.03);">
                    <div style="color: #64748b; font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Lama Pinjam
                    </div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #10b981;">{{ $type->loan_periode }} <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">Hari</span></div>
                </div>
            </div>

            <!-- List Aturan Lainnya -->
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px dashed rgba(0,0,0,0.1);">
                    <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Denda / Hari</span>
                    <span style="font-weight: 700; color: #ef4444; font-size: 0.95rem;">Rp {{ number_format($type->fine_each_day, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px dashed rgba(0,0,0,0.1);">
                    <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Masa Toleransi</span>
                    <span style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">{{ $type->grace_period }} Hari</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Batas Reservasi</span>
                    <span style="font-weight: 700; color: #8b5cf6; font-size: 0.95rem;">{{ $type->reservation_limit }} Buku</span>
                </div>
            </div>
        </div>
        
        <!-- Footer / Action -->
        <div style="padding: 1rem 1.5rem; background: #f8fafc; border-top: 1px solid rgba(0,0,0,0.05); text-align: right;">
            <a href="{{ route('admin.member_type.edit', $type->member_type_id) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; color: #3b82f6; border: 1px solid #bfdbfe; padding: 0.5rem 1rem; border-radius: 99px; font-weight: 700; font-size: 0.85rem; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#93c5fd';" onmouseout="this.style.background='white'; this.style.borderColor='#bfdbfe';">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                Ubah Aturan
            </a>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05);">
        <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        </div>
        <h4 style="font-weight: 800; color: #475569; font-size: 1.1rem; margin-bottom: 0.25rem;">Tidak Ada Data</h4>
        <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Belum ada tipe anggota yang dikonfigurasi.</p>
    </div>
    @endforelse
</div>
@endsection

@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- Sub-header with subtle gradient -->
<div style="background: linear-gradient(to right, rgba(30, 64, 175, 0.05), rgba(225, 29, 72, 0.05)); border-bottom: 1px solid rgba(0,0,0,0.05); padding: 2rem 0; margin-bottom: 2rem;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
        <h1 style="font-size: 2rem; font-weight: 800; color: hsl(var(--text-main)); letter-spacing: -0.025em; margin-bottom: 0.5rem;">Halo, {{ explode(' ', $member->member_name)[0] }}! 👋</h1>
        <p style="color: hsl(var(--text-muted)); font-size: 1.05rem;">Selamat datang di dasbor perpustakaan pribadi Anda. Pantau semua aktivitas Anda di sini.</p>
    </div>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem 4rem 1.5rem;">
    <div style="display: grid; grid-template-columns: 340px 1fr; gap: 3rem; align-items: start;">
        
        <!-- Kolom Kiri: Profil & ID Card -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Digital ID Card (Glassmorphism & Gradient) -->
            <div style="position: relative; border-radius: 1.5rem; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); background: #0f172a;">
                <!-- Decorative animated blob -->
                <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(139,92,246,0.3) 0%, rgba(15,23,42,0) 50%); animation: spin 10s linear infinite; pointer-events: none;"></div>
                <div style="position: absolute; bottom: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(56,189,248,0.2) 0%, rgba(15,23,42,0) 50%); animation: spin 15s linear infinite reverse; pointer-events: none;"></div>
                
                <style>
                    @keyframes spin { 100% { transform: rotate(360deg); } }
                </style>

                <div style="position: relative; z-index: 10; padding: 1px; border-radius: 1.5rem; background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.05));">
                    <div style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(20px); border-radius: 1.5rem; padding: 2rem;">
                        
                        <!-- Header Card -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                            <div style="font-weight: 800; color: white; font-size: 1.1rem; letter-spacing: -0.025em; display: flex; align-items: center; gap: 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                                Dudukbaca.
                            </div>
                            <span style="background: rgba(56, 189, 248, 0.15); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.3); padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                Member
                            </span>
                        </div>

                        <!-- Body Card -->
                        <div style="text-align: center;">
                            <div style="width: 100px; height: 100px; margin: 0 auto 1.25rem; border-radius: 50%; padding: 4px; background: linear-gradient(135deg, #38bdf8, #818cf8); box-shadow: 0 10px 25px -5px rgba(56,189,248,0.5);">
                                <div style="width: 100%; height: 100%; background: #1e293b; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                    @if($member->member_image)
                                        <img src="{{ asset('storage/member_images/' . $member->member_image) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    @endif
                                </div>
                            </div>

                            <h3 style="color: white; font-size: 1.35rem; font-weight: 700; margin-bottom: 0.25rem; letter-spacing: -0.01em;">{{ $member->member_name }}</h3>
                            <p style="color: #94a3b8; font-family: monospace; font-size: 0.95rem; letter-spacing: 0.05em; margin-bottom: 2rem;">{{ $member->member_id }}</p>

                            <!-- QR Code Container -->
                            <div style="background: white; padding: 0.75rem; border-radius: 1rem; display: inline-block; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                <div id="member-qr" data-id="{{ $member->member_id }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Info Profil -->
            <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <h4 style="font-weight: 700; color: #1e293b; font-size: 1.05rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                        Informasi Profil
                    </h4>
                </div>
                <div style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Email</div>
                        <div style="color: #334155; font-size: 0.95rem; font-weight: 500;">{{ $member->member_email ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">No. Telepon</div>
                        <div style="color: #334155; font-size: 0.95rem; font-weight: 500;">{{ $member->member_phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Instansi / Lembaga</div>
                        <div style="color: #334155; font-size: 0.95rem; font-weight: 500;">{{ $member->inst_name ?? '-' }}</div>
                    </div>
                    @php 
                        $isValidDate = $member->expire_date && $member->expire_date !== '0000-00-00' && $member->expire_date !== '0000-00-00 00:00:00' && !str_contains($member->expire_date, '-0001');
                        $isExpired = $isValidDate ? \Carbon\Carbon::parse($member->expire_date)->isPast() : true; 
                    @endphp
                    <div style="background: {{ $isExpired ? '#fef2f2' : '#f0fdf4' }}; padding: 1rem; border-radius: 0.75rem; border: 1px solid {{ $isExpired ? '#fecaca' : '#bbf7d0' }};">
                        <div style="font-size: 0.75rem; font-weight: 700; color: {{ $isExpired ? '#dc2626' : '#166534' }}; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Masa Berlaku Sampai</div>
                        <div style="color: {{ $isExpired ? '#b91c1c' : '#15803d' }}; font-size: 1.05rem; font-weight: 800;">
                            {{ $isValidDate ? \Carbon\Carbon::parse($member->expire_date)->format('d F Y') : '-' }}
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Total Kunjungan Card -->
            <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 1.25rem; box-shadow: 0 10px 30px -10px rgba(16,185,129,0.3); overflow: hidden; position: relative; padding: 1.5rem;">
                <div style="position: absolute; right: -1rem; top: -1rem; opacity: 0.1;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div style="position: relative; z-index: 10;">
                    <h4 style="font-weight: 700; color: rgba(255,255,255,0.9); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Total Kunjungan
                    </h4>
                    <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                        <span style="font-size: 2.5rem; font-weight: 800; color: white; line-height: 1;">{{ $totalVisits ?? 0 }}</span>
                        <span style="color: rgba(255,255,255,0.8); font-weight: 600; font-size: 1rem;">Kali</span>
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <form action="{{ route('member.logout') }}" method="POST">
                @csrf
                <button type="submit" style="width: 100%; padding: 1rem; background: white; color: #ef4444; border: 1px solid #fecaca; border-radius: 1rem; cursor: pointer; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); transition: all 0.2s; display: flex; justify-content: center; align-items: center; gap: 0.5rem;" onmouseover="this.style.background='#fef2f2'; this.style.borderColor='#f87171';" onmouseout="this.style.background='white'; this.style.borderColor='#fecaca';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout Akun
                </button>
            </form>
        </div>

        <!-- Kolom Kanan: Main Content (Loans & Reservations) -->
        <div style="display: flex; flex-direction: column; gap: 3rem;">
            
            <!-- Section: Peminjaman Aktif -->
            <section>
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem;">
                    <div>
                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 0.5rem;">
                            Buku di Tangan Anda
                        </h2>
                        <p style="color: #64748b; font-size: 0.95rem;">Jangan sampai terlewat batas pengembaliannya ya!</p>
                    </div>
                </div>

                @if($loans->count() > 0)
                    <div style="display: grid; gap: 1rem;">
                        @foreach($loans as $loan)
                        @php $isLate = \Carbon\Carbon::parse($loan->due_date)->isPast(); @endphp
                        <div style="background: white; padding: 1.5rem; border-radius: 1.25rem; border: 1px solid {{ $isLate ? '#fecaca' : 'rgba(0,0,0,0.05)' }}; display: flex; gap: 1.5rem; align-items: center; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 40px -10px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 30px -10px rgba(0,0,0,0.05)';">
                            <div style="width: 56px; height: 56px; background: {{ $isLate ? '#fef2f2' : '#f0f9ff' }}; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: {{ $isLate ? '#ef4444' : '#0284c7' }}; flex-shrink: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="font-weight: 800; font-size: 1.15rem; color: #1e293b; margin-bottom: 0.35rem; line-height: 1.3;">
                                    {{ optional(optional($loan->item)->biblio)->title ?? 'Unknown Title' }}
                                </h4>
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; color: #64748b; font-size: 0.85rem; font-weight: 500;">
                                    <span style="display: flex; align-items: center; gap: 0.35rem;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg> Eksemplar: {{ $loan->item_code }}</span>
                                    <span style="display: flex; align-items: center; gap: 0.35rem;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> No. Panggil: {{ optional($loan->item)->call_number ?? '-' }}</span>
                                    <span style="display: flex; align-items: center; gap: 0.35rem;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> Dipinjam: {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M') }}</span>
                                </div>
                            </div>
                            <div style="text-align: right; background: {{ $isLate ? '#fef2f2' : '#f8fafc' }}; padding: 1rem 1.25rem; border-radius: 1rem; border: 1px solid {{ $isLate ? '#fecaca' : '#f1f5f9' }};">
                                <div style="font-size: 0.75rem; color: {{ $isLate ? '#dc2626' : '#64748b' }}; text-transform: uppercase; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                                    {{ $isLate ? 'Terlambat!' : 'Batas Kembali' }}
                                </div>
                                <div style="color: {{ $isLate ? '#b91c1c' : '#0f172a' }}; font-weight: 800; font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem; justify-content: flex-end;">
                                    @if($isLate)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                                    @endif
                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 4rem 2rem; text-align: center; background: white; border-radius: 1.5rem; border: 2px dashed #e2e8f0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                        <div style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        </div>
                        <h4 style="font-weight: 800; color: #1e293b; font-size: 1.2rem; margin-bottom: 0.5rem;">Wah, Tangan Anda Kosong!</h4>
                        <p style="color: #64748b; font-size: 1rem; max-width: 450px; margin: 0 auto;">Anda tidak memiliki buku yang sedang dipinjam. Yuk, jelajahi katalog kami dan temukan petualangan membaca Anda berikutnya.</p>
                        <a href="{{ route('opac.index') }}" style="display: inline-block; margin-top: 1.5rem; padding: 0.75rem 1.5rem; background: white; border: 1px solid #cbd5e1; color: #475569; font-weight: 600; border-radius: 99px; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#94a3b8';" onmouseout="this.style.background='white'; this.style.borderColor='#cbd5e1';">
                            Mulai Cari Buku
                        </a>
                    </div>
                @endif
            </section>

            <!-- Section: Status Reservasi -->
            <section>
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem;">
                    <div>
                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a;">Reservasi Saya</h2>
                        <p style="color: #64748b; font-size: 0.95rem;">Pantau status pemesanan buku Anda.</p>
                    </div>
                    <a href="{{ route('opac.index') }}" style="background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--accent))); color: white; padding: 0.75rem 1.5rem; border-radius: 99px; font-weight: 700; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4); transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px -5px rgba(59, 130, 246, 0.5)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px -5px rgba(59, 130, 246, 0.4)';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Cari Buku Baru
                    </a>
                </div>

                @if(isset($reservations) && $reservations->count() > 0)
                    <div style="display: grid; gap: 1rem;">
                        @foreach($reservations as $reserve)
                        <div style="background: white; padding: 1.25rem 1.5rem; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
                            <div>
                                <h4 style="font-weight: 800; font-size: 1.1rem; color: #1e293b; margin-bottom: 0.35rem;">
                                    {{ optional(optional($reserve->item)->biblio)->title ?? 'Unknown Title' }}
                                </h4>
                                <div style="color: #64748b; font-size: 0.85rem; font-weight: 500; display: flex; flex-wrap: wrap; gap: 1.25rem; align-items: center;">
                                    <span style="display: flex; align-items: center; gap: 0.35rem;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> Dipesan: {{ \Carbon\Carbon::parse($reserve->reserve_date)->format('d M') }}</span>
                                    <span style="display: flex; align-items: center; gap: 0.35rem; color: #94a3b8;">&bull; Eksemplar: {{ $reserve->item_code }}</span>
                                    <span style="display: flex; align-items: center; gap: 0.35rem; color: #94a3b8;">&bull; No. Panggil: {{ optional($reserve->item)->call_number ?? '-' }}</span>
                                </div>
                            </div>
                            
                            <!-- Badges Status -->
                            <div>
                                @if($reserve->status === 'pending')
                                    <span style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a; padding: 0.5rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        Menunggu
                                    </span>
                                @elseif($reserve->status === 'approved')
                                    <span style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; padding: 0.5rem 1.25rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 2px 4px rgba(21,128,61,0.1);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Tersedia (Bisa Diambil)
                                    </span>
                                @else
                                    <span style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700;">
                                        {{ ucfirst($reserve->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 3rem 2rem; text-align: center; background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05);">
                        <p style="color: #94a3b8; font-size: 0.95rem; font-weight: 500; margin: 0;">Belum ada pesanan aktif.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrContainer = document.getElementById('member-qr');
        if (qrContainer) {
            new QRCode(qrContainer, {
                text: qrContainer.getAttribute('data-id'),
                width: 130,
                height: 130,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    });
</script>
@endsection


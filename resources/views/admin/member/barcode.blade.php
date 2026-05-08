@extends('layouts.admin')

@section('pageTitle', 'Cetak Kartu Anggota (Filter)')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #4f46e5;"><path d="M3 5v14"/><path d="M8 5v14"/><path d="M12 5v14"/><path d="M17 5v14"/><path d="M21 5v14"/></svg>
            Cetak Kartu Anggota
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Gunakan filter khusus atau pilih manual anggota untuk dicetak kartunya.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.member.index') }}" class="btn" style="background: white; color: #475569; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: 2px solid #e2e8f0; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

@if(session('error'))
    <div style="margin-bottom: 1.5rem; background: #fef2f2; color: #b91c1c; padding: 1rem 1.5rem; border-radius: 1rem; border: 1px solid #fecaca; display: flex; gap: 0.75rem; align-items: flex-start;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 0.1rem;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <h4 style="font-weight: 700; margin: 0 0 0.25rem 0; font-size: 0.95rem;">Perhatian</h4>
            <p style="margin: 0; font-size: 0.9rem;">{{ session('error') }}</p>
        </div>
    </div>
@endif

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2.5rem;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M22 11v1a10 10 0 1 1-9-10"/><path d="M8 14v.01"/><path d="M12 14v.01"/><path d="M16 14v.01"/><path d="M22 4h-6"/><path d="M19 1l-3 3 3 3"/></svg>
            Opsi 1: Cetak Massal Berdasarkan Kriteria
        </h3>
    </div>

    <form action="{{ route('admin.member.print_barcodes_filter') }}" method="POST" target="_blank" style="padding: 2rem;">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            
            <!-- Date Range -->
            <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 2px solid #e2e8f0; transition: 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                <h4 style="font-size: 0.95rem; font-weight: 800; margin-top: 0; margin-bottom: 1rem; color: #334155; display: flex; align-items: center; gap: 0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    Berdasarkan Tanggal Registrasi
                </h4>
                <div style="margin-bottom: 1rem;">
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase;">Mulai Tanggal</label>
                    <input type="date" name="date_start" class="input" style="width: 100%; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
                <div>
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase;">Sampai Tanggal</label>
                    <input type="date" name="date_end" class="input" style="width: 100%; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
            </div>

            <!-- Member ID Pattern -->
            <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 2px solid #e2e8f0; transition: 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                <h4 style="font-size: 0.95rem; font-weight: 800; margin-top: 0; margin-bottom: 1rem; color: #334155; display: flex; align-items: center; gap: 0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10v11"/><path d="M20 10v11"/><path d="M12 15v6"/><path d="M4 10l8-6 8 6"/><path d="M4 10h16"/></svg>
                    Berdasarkan ID Anggota
                </h4>
                <div style="margin-bottom: 1rem;">
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase;">Pola ID (Contoh: 140102)</label>
                    <input type="text" name="member_id_pattern" placeholder="ID diawali dengan..." class="input" style="width: 100%; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
            </div>

            <!-- Other Options -->
            <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 2px solid #e2e8f0; transition: 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                <h4 style="font-size: 0.95rem; font-weight: 800; margin-top: 0; margin-bottom: 1rem; color: #334155; display: flex; align-items: center; gap: 0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Opsi Lainnya
                </h4>
                <div style="margin-bottom: 1rem;">
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase;">Tipe Keanggotaan</label>
                    <select name="member_type_id" class="input" style="width: 100%; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                        <option value="">Semua Tipe</option>
                        @foreach($memberTypes as $type)
                            <option value="{{ $type->member_type_id }}">{{ $type->member_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase;">Batasi Hasil (Maksimal)</label>
                    <input type="number" name="limit" value="50" min="1" max="500" class="input" style="width: 100%; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; border-radius: 0.75rem; outline: none; font-family: inherit; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                </div>
            </div>

        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1.5rem;">
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 0.8rem 2rem; border-radius: 99px; font-weight: 700; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(15,23,42,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Cetak Semua Sesuai Filter
            </button>
        </div>
    </form>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem; align-items: center;">
        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #6366f1;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
            Opsi 2: Pilih Manual Anggota (Pencarian & Centang)
        </h3>
        <button type="button" onclick="printSelected()" class="btn" style="background: white; color: #0f172a; border: 2px solid #e2e8f0; padding: 0.6rem 1.25rem; border-radius: 99px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
            Cetak Terpilih
        </button>
    </div>

    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05);">
        <form action="{{ route('admin.member.barcode') }}" method="GET" style="display: flex; gap: 0.75rem; width: 100%; flex-wrap: wrap; align-items: center;">
            <div style="position: relative;">
                <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID/Nama..." 
                    style="padding: 0.6rem 1rem 0.6rem 2.5rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; width: 220px; font-family: inherit; font-size: 0.9rem; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>
            
            <select name="member_type_id" style="padding: 0.6rem 1rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; background: white; font-family: inherit; font-size: 0.9rem; font-weight: 500; color: #475569; cursor: pointer; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                <option value="">Semua Tipe</option>
                @if(isset($memberTypes))
                    @foreach($memberTypes as $type)
                        <option value="{{ $type->member_type_id }}" {{ request('member_type_id') == $type->member_type_id ? 'selected' : '' }}>
                            {{ $type->member_type_name }}
                        </option>
                    @endforeach
                @endif
            </select>

            <select name="sort" style="padding: 0.6rem 1rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; background: white; font-family: inherit; font-size: 0.9rem; font-weight: 500; color: #475569; cursor: pointer; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                <option value="last_update" {{ request('sort') == 'last_update' ? 'selected' : '' }}>Urut: Terakhir Update</option>
                <option value="member_name" {{ request('sort') == 'member_name' ? 'selected' : '' }}>Urut: Nama Anggota</option>
                <option value="member_id" {{ request('sort') == 'member_id' ? 'selected' : '' }}>Urut: ID Anggota</option>
            </select>

            <select name="order" style="padding: 0.6rem 1rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; background: white; font-family: inherit; font-size: 0.9rem; font-weight: 500; color: #475569; cursor: pointer; transition: 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e2e8f0';">
                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z-A / Baru-Lama</option>
                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A-Z / Lama-Baru</option>
            </select>

            <button type="submit" style="padding: 0.6rem 1.25rem; background: #64748b; color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#475569';" onmouseout="this.style.background='#64748b';">Filter Pencarian</button>
            <a href="{{ route('admin.member.barcode') }}" style="padding: 0.6rem 1.25rem; background: white; color: #64748b; border: 2px solid #e2e8f0; border-radius: 99px; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">Reset</a>
        </form>
    </div>

    <form id="printForm" action="{{ route('admin.member.print_barcodes') }}" method="POST" target="_blank" style="display: none;">
        @csrf
        <div id="printInputs"></div>
    </form>

    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); width: 40px; text-align: center;">
                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll()" style="width: 1.1rem; height: 1.1rem; cursor: pointer; accent-color: #3b82f6;">
                    </th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">ID Anggota</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Nama / Email</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tipe Keanggotaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem; text-align: center;">
                        <input type="checkbox" class="member-checkbox" value="{{ $member->member_id }}" style="width: 1.1rem; height: 1.1rem; cursor: pointer; accent-color: #3b82f6;">
                    </td>
                    <td style="padding: 1.25rem 1rem; font-weight: 700; color: #0f172a;">
                        {{ $member->member_id }}
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.2rem;">{{ $member->member_name }}</div>
                        <div style="color: #64748b; font-size: 0.8rem; display: flex; align-items: center; gap: 0.35rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            {{ $member->member_email ?? 'Tidak ada email' }}
                        </div>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #eff6ff; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.75rem; border: 1px solid #bfdbfe;">
                            {{ $member->member_type_id }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 4rem 2rem; text-align: center;">
                        <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                        </div>
                        <h4 style="font-weight: 800; color: #475569; font-size: 1.1rem; margin-bottom: 0.25rem;">Tidak Ada Data</h4>
                        <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Tidak ada anggota yang ditemukan berdasarkan kriteria pencarian.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($members->hasPages())
    <div style="padding: 1rem 2rem 2rem 2rem;">
        {{ $members->links() }}
    </div>
    @endif

<script>
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.member-checkbox');
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    }

    function printSelected() {
        const checkboxes = document.querySelectorAll('.member-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih setidaknya satu anggota untuk dicetak.');
            return;
        }

        const printInputs = document.getElementById('printInputs');
        printInputs.innerHTML = ''; // Clear previous

        checkboxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'members[]';
            input.value = cb.value;
            printInputs.appendChild(input);
        });

        document.getElementById('printForm').submit();
    }
</script>
@endsection

@extends('layouts.admin')

@section('pageTitle', 'Membership')

@section('content')
<style>
    .filter-form {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }
    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch !important;
        }
        .filter-form > * {
            width: 100% !important;
        }
        .filter-form input, .filter-form select, .filter-form button, .filter-form a {
            width: 100% !important;
            box-sizing: border-box;
            text-align: center;
        }
        .filter-form .search-container {
            width: 100% !important;
        }
        .filter-form .search-container input {
            width: 100% !important;
            text-align: left;
        }
    }
</style>
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #6366f1;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Daftar Anggota
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Kelola data anggota perpustakaan, pencetakan kartu, dan status member.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.member.create') }}" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Anggota
        </a>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem;">
        <form action="{{ route('admin.member.index') }}" method="GET" class="filter-form">
            <div class="search-container" style="position: relative;">
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

            <button type="submit" style="padding: 0.6rem 1.25rem; background: #0f172a; color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#1e293b';" onmouseout="this.style.background='#0f172a';">Filter</button>
            <a href="{{ route('admin.member.index') }}" style="padding: 0.6rem 1.25rem; background: white; color: #64748b; border: 2px solid #e2e8f0; border-radius: 99px; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">Reset</a>
        </form>
        
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <button type="button" onclick="printSelected()" class="btn" style="background: white; color: #0f172a; border: 2px solid #e2e8f0; padding: 0.6rem 1.25rem; border-radius: 99px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Cetak Terpilih
            </button>
            <a href="{{ route('admin.member.barcode') }}" class="btn" style="background: white; color: #4f46e5; border: 2px solid #c7d2fe; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#e0e7ff';" onmouseout="this.style.background='white';">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5v14"/><path d="M8 5v14"/><path d="M12 5v14"/><path d="M17 5v14"/><path d="M21 5v14"/></svg>
                Cetak Barcode Kustom
            </a>
            <div style="border-left: 2px solid #e2e8f0; margin: 0 0.25rem;"></div>
            <a href="{{ route('admin.member.export') }}" class="btn" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#d1fae5';" onmouseout="this.style.background='#ecfdf5';">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Export
            </a>
            <a href="{{ route('admin.member.import') }}" class="btn" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#fef3c7';" onmouseout="this.style.background='#fffbeb';">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                Import
            </a>
        </div>
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
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
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
                    <td style="padding: 1.25rem 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.member.show', $member->member_id) }}" style="background: #f0fdf4; color: #16a34a; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#dcfce7';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                Detail
                            </a>
                            <a href="{{ route('admin.member.edit', $member->member_id) }}" style="background: #f1f5f9; color: #475569; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.member.destroy', $member->member_id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: white; border: 1px solid #fecaca; color: #ef4444; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.8rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#fef2f2';">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem 2rem; text-align: center;">
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
</div>

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


@extends('layouts.admin')

@section('pageTitle', 'Tipe Anggota (Loan Rules)')

@section('content')
<x-master-header 
    title="Tipe Anggota (Aturan Peminjaman)" 
    subtitle="Kelola jenis-jenis keanggotaan beserta batas pinjam dan denda." 
    icon="user-cog"
    importRoute="admin.member_type.import"
    exportRoute="admin.member_type.export"
    createRoute="admin.member_type.create"
    createLabel="Tambah Tipe"
/>

@if(session('success'))
    <div style="margin-bottom: 2rem; background: #ecfdf5; color: #065f46; padding: 1rem 1.5rem; border-radius: 1rem; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 0.75rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
@endif

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Nama Tipe Anggota</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Batas Buku</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Batas Reservasi</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Lama Pinjam</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Denda / Hari</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($memberTypes as $type)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem; font-weight: 700; color: #0f172a; font-size: 1rem;">
                        {{ $type->member_type_name }}
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #eff6ff; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.85rem;">
                            {{ $type->loan_limit }} Buku
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #fdf4ff; color: #c026d3; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.85rem;">
                            {{ $type->reservation_limit }} Buku
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #f0fdf4; color: #16a34a; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.85rem;">
                            {{ $type->loan_periode }} Hari
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1rem; font-weight: 700; color: #ef4444;">
                        Rp {{ number_format($type->fine_each_day, 0, ',', '.') }}
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.member_type.edit', $type->member_type_id) }}" style="background: #f1f5f9; color: #475569; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                                <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                Edit
                            </a>
                            <form action="{{ route('admin.member_type.destroy', $type->member_type_id) }}" method="POST" onsubmit="return confirm('Hapus tipe anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: white; border: 1px solid #fecaca; color: #ef4444; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.8rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#fef2f2';" onmouseout="this.style.background='white';">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
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
                        <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Belum ada tipe anggota yang dibuat.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


@extends('layouts.admin')

@section('pageTitle', 'Manajemen Reservasi')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #6366f1;"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/><path d="M8 11h8"/><path d="M8 7h6"/></svg>
            Manajemen Reservasi
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Kelola permintaan reservasi buku dari anggota perpustakaan.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <button onclick="openAddModal()" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Reservasi Baru
        </button>
        <a href="{{ route('admin.circulation.reservations.settings') }}" class="btn" style="background: white; color: #4f46e5; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: 1px solid #c7d2fe; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 4px rgba(79,70,229,0.05); transition: 0.2s;" onmouseover="this.style.background='#e0e7ff';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Pengaturan
        </a>
    </div>
</div>

<!-- 1. Pending Reservations -->
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
        <h3 style="font-weight: 800; font-size: 1.125rem; color: #b45309; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Permintaan Reservasi (Menunggu Persetujuan)
        </h3>
    </div>
    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tanggal</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Member</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Item / Buku</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Status</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pending as $res)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem; color: #64748b; font-weight: 500;">{{ \Carbon\Carbon::parse($res->reserve_date)->format('d M Y H:i') }}</td>
                    <td style="padding: 1.25rem 1rem;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ $res->member->member_name ?? 'Unknown' }}</div>
                        <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">{{ $res->member_id }}</span>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ Str::limit($res->item->biblio->title ?? 'Unknown Title', 40) }}</div>
                        <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">{{ $res->item_code }}</span>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #fffbeb; color: #d97706; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fde68a;">Pending</span>
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <form action="{{ route('admin.circulation.reservations.approve', $res->reserve_id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; cursor: pointer; font-weight: 700; transition: 0.2s; box-shadow: 0 2px 4px rgba(59,130,246,0.2);" onmouseover="this.style.background='#2563eb';">Setuju</button>
                            </form>
                            <button onclick="openRejectModal({{ $res->reserve_id }})" style="background: white; color: #ef4444; border: 1px solid #fca5a5; padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; cursor: pointer; font-weight: 700; transition: 0.2s;" onmouseover="this.style.background='#fef2f2';">Tolak</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 3rem 2rem; text-align: center;">
                        <div style="width: 48px; height: 48px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 0.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        </div>
                        <p style="color: #64748b; font-weight: 500;">Tidak ada permintaan reservasi baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 2. Approved Reservations -->
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);">
        <h3 style="font-weight: 800; font-size: 1.125rem; color: #065f46; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Buku Siap Diambil (Telah Disetujui)
        </h3>
    </div>
    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tanggal</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Member</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Item / Buku</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Status</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($approved as $res)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem; color: #64748b; font-weight: 500;">{{ \Carbon\Carbon::parse($res->reserve_date)->format('d M Y H:i') }}</td>
                    <td style="padding: 1.25rem 1rem;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ $res->member->member_name ?? 'Unknown' }}</div>
                        <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">{{ $res->member_id }}</span>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ Str::limit($res->item->biblio->title ?? 'Unknown Title', 40) }}</div>
                        <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">{{ $res->item_code }}</span>
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #ecfdf5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #a7f3d0;">Approved</span>
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: right;">
                        <form action="{{ route('admin.circulation.reservations.handover', $res->reserve_id) }}" method="POST" style="display: flex; justify-content: flex-end;">
                            @csrf
                            <button type="submit" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 0.5rem 1.25rem; border-radius: 99px; font-size: 0.8rem; cursor: pointer; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                                Serahkan Buku
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 3rem 2rem; text-align: center;">
                        <p style="color: #64748b; font-weight: 500;">Tidak ada buku yang menunggu diambil.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 3. History Reservations -->
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <h3 style="font-weight: 800; font-size: 1.125rem; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
            Histori Keseluruhan
        </h3>
    </div>
    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tanggal</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Member</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Item / Buku</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Status</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $res)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem; vertical-align: top; color: #64748b; font-weight: 500;">{{ \Carbon\Carbon::parse($res->reserve_date)->format('d M Y H:i') }}</td>
                    <td style="padding: 1.25rem 1rem; vertical-align: top;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ $res->member->member_name ?? 'Unknown' }}</div>
                        <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">{{ $res->member_id }}</span>
                    </td>
                    <td style="padding: 1.25rem 1rem; vertical-align: top;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ Str::limit($res->item->biblio->title ?? 'Unknown Title', 40) }}</div>
                        <span style="background: #f1f5f9; color: #475569; padding: 0.15rem 0.5rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">{{ $res->item_code }}</span>
                    </td>
                    <td style="padding: 1.25rem 1rem; vertical-align: top;">
                        @if($res->status == 'pending')
                            <span style="background: #fffbeb; color: #d97706; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fde68a;">Pending</span>
                        @elseif($res->status == 'approved')
                            <span style="background: #ecfdf5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #a7f3d0;">Approved</span>
                        @elseif($res->status == 'rejected')
                            <span style="background: #fef2f2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #fecaca;">Rejected</span>
                        @elseif($res->status == 'completed')
                            <span style="background: #eff6ff; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #bfdbfe;">Completed</span>
                        @elseif($res->status == 'cancelled')
                            <span style="background: #f8fafc; color: #475569; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; border: 1px solid #e2e8f0;">Cancelled</span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem; vertical-align: top; color: #64748b; font-weight: 500;">
                        {{ $res->notes ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 3rem 2rem; text-align: center;">
                        <p style="color: #64748b; font-weight: 500;">Tidak ada histori reservasi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="padding: 1rem 2rem 2rem 2rem;">
        {{ $history->links() }}
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 50; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 1.5rem; width: 100%; max-width: 450px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
        <h3 style="font-weight: 800; margin-bottom: 1.5rem; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #ef4444;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            Tolak Reservasi
        </h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Alasan Penolakan</label>
                <textarea name="notes" required rows="3" style="width: 100%; padding: 1rem; border: 2px solid #cbd5e1; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 1rem; transition: 0.2s;" onfocus="this.style.borderColor='#ef4444';" onblur="this.style.borderColor='#cbd5e1';"></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeRejectModal()" style="padding: 0.75rem 1.5rem; background: #f1f5f9; color: #475569; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';">Batal</button>
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(239,68,68,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">Tolak Reservasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Reservasi -->
<div id="addModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 50; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 1.5rem; width: 100%; max-width: 550px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
        <h3 style="font-weight: 800; margin-bottom: 1.5rem; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #10b981;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Reservasi Manual
        </h3>
        <form action="{{ route('admin.circulation.reservations.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Cari Anggota (ID atau Nama)</label>
                <select id="memberSelect" name="member_id" style="width: 100%;" required>
                    <option value="">Ketik untuk mencari...</option>
                </select>
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Pilih Buku (Bisa lebih dari 1)</label>
                <select id="biblioSelect" name="biblio_ids[]" multiple="multiple" style="width: 100%;" required>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeAddModal()" style="padding: 0.75rem 1.5rem; background: #f1f5f9; color: #475569; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';">Batal</button>
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">Simpan Reservasi</button>
            </div>
        </form>
    </div>
</div>

<!-- jQuery & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function openRejectModal(id) {
        document.getElementById('rejectModal').style.display = 'flex';
        document.getElementById('rejectForm').action = "{{ url('admin/circulation/reservations/reject') }}/" + id;
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function openAddModal() {
        document.getElementById('addModal').style.display = 'flex';
    }

    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
    }

    $(document).ready(function() {
        // Autocomplete Member
        $('#memberSelect').select2({
            ajax: {
                url: '{{ route('admin.circulation.search_member') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.member_id + ' - ' + item.member_name,
                                id: item.member_id
                            }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 2,
            placeholder: 'Ketik ID atau Nama Anggota'
        });

        // Autocomplete Biblio
        $('#biblioSelect').select2({
            ajax: {
                url: '{{ route('admin.circulation.reservations.search_biblio') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.title + (item.isbn_issn ? ' (ISBN: ' + item.isbn_issn + ')' : ''),
                                id: item.biblio_id
                            }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 2,
            placeholder: 'Ketik Judul Buku'
        });
    });
</script>
@endsection

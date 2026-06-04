@extends('layouts.admin')

@section('pageTitle', 'Aturan Peminjaman')

@section('content')
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
         <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #6366f1;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Aturan Peminjaman
         </h3>
         <p style="color: #64748b; font-size: 0.95rem; margin-top: 0.25rem;">Batas pinjam dan denda berdasarkan tipe keanggotaan.</p>
    </div>

    <div style="padding: 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
            <thead>
                <tr style="background: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem 0 0 0.5rem;">Tipe Anggota</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Batas Buku</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Periode (Hari)</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); border-radius: 0 0.5rem 0.5rem 0;">Denda / Hari</th>
                </tr>
            </thead>
            <tbody>
                @foreach($memberTypes as $type)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1.5rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #6366f1;"></div>
                        {{ $type->member_type_name }}
                    </td>
                    <td style="padding: 1.25rem 1.5rem; color: #475569; font-weight: 500;">
                        <span style="background: #e0e7ff; color: #3730a3; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.85rem; font-weight: 700;">
                            {{ $type->loan_limit }} Buku
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1.5rem; color: #475569; font-weight: 500;">
                        <span style="background: #f1f5f9; color: #334155; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.85rem; font-weight: 700;">
                            {{ $type->loan_periode }} Hari
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1.5rem; color: #ef4444; font-weight: 700;">
                        Rp {{ number_format($type->fine_each_day, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


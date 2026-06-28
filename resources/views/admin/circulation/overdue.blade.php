@extends('layouts.admin')

@section('pageTitle', 'Daftar Keterlambatan')

@section('content')
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #fef2f2 0%, #fefce8 100%);">
         <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
             <div>
                 <h3 style="font-weight: 800; color: #7f1d1d; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #ef4444;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                     Daftar Keterlambatan
                 </h3>
                 <p style="color: #991b1b; font-size: 0.95rem; margin: 0; font-weight: 500;">Buku yang belum dikembalikan melewati batas waktu.</p>
             </div>
             
             <!-- Search Filter -->
            <form method="GET" action="{{ route('admin.circulation.overdue') }}" style="display: flex; gap: 0.5rem; background: white; padding: 0.5rem; border-radius: 1rem; border: 1px solid rgba(239, 68, 68, 0.2); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="position: relative;">
                    <div style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #ef4444;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                    <input type="text" name="q" placeholder="Cari Nama/ID Anggota..." value="{{ request('q') }}" 
                        style="padding: 0.5rem 0.5rem 0.5rem 2.25rem; border: none; outline: none; width: 250px; font-family: inherit; font-size: 0.95rem; background: transparent;">
                </div>
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 1.25rem; border-radius: 0.75rem; border: none; font-weight: 700; cursor: pointer; transition: 0.2s; box-shadow: 0 2px 4px rgba(239,68,68,0.2);" onmouseover="this.style.transform='translateY(-1px)';" onmouseout="this.style.transform='none';">Filter</button>
            </form>
         </div>
    </div>
    
    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 1rem 1.5rem; border-radius: 0.75rem; margin: 1.5rem 2rem 0; border: 1px solid #a7f3d0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tgl Jatuh Tempo</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Anggota</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Eksemplar</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Judul Buku</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Keterlambatan</th>
                     <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                @php
                    $dueDate = \Carbon\Carbon::parse($loan->due_date);
                    $daysOverdue = max(0, $dueDate->diffInDays(now(), false));
                    
                    $finePerDay = $loan->member->memberType->fine_each_day ?? 1000;
                    
                    // Format phone for WA
                    $phone = $loan->member->member_phone ?? '';
                    if (str_starts_with($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    }
                    $email = $loan->member->member_email ?? '';
                @endphp
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem; color: #ef4444; font-weight: 700;">{{ $dueDate->format('d M Y') }}</td>
                    <td style="padding: 1.25rem 1rem; font-weight: 600; color: #1e293b;">
                        {{ $loan->member->member_name ?? 'N/A' }}<br>
                        <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">
                            {{ $loan->member->member_phone ?? 'Tidak ada No WA' }}
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1rem; font-weight: 700; color: #0f172a;">{{ $loan->item_code }}</td>
                    <td style="padding: 1.25rem 1rem; font-weight: 500; color: #334155;">{{ Str::limit($loan->item->biblio->title ?? 'N/A', 40) }}</td>
                    <td style="padding: 1.25rem 1rem;">
                        <span style="background: #fef2f2; color: #b91c1c; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; border: 1px solid #fecaca; display: inline-block;">
                            {{ floor($daysOverdue) }} Hari
                        </span>
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: right;">
                        <button type="button" class="btn" onclick="showNotifyOptions('{{ addslashes($loan->member->member_name ?? '') }}', '{{ $phone }}', '{{ $email }}', '{{ addslashes($loan->item->biblio->title ?? '') }}', {{ floor($daysOverdue) }}, {{ $loan->loan_id }}, {{ $finePerDay }})" style="background: white; color: #d97706; padding: 0.4rem 1rem; border-radius: 99px; border: 1px solid #fcd34d; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.8rem; box-shadow: 0 2px 4px rgba(245,158,11,0.1); transition: 0.2s;" onmouseover="this.style.background='#fffbeb';" onmouseout="this.style.background='white';">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg> 
                            Peringatkan
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem 2rem; text-align: center;">
                        <div style="width: 64px; height: 64px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981; margin: 0 auto 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h4 style="font-weight: 800; color: #065f46; font-size: 1.1rem; margin-bottom: 0.25rem;">Bersih!</h4>
                        <p style="color: #047857; font-size: 0.95rem; font-weight: 500;">Tidak ada keterlambatan peminjaman saat ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 2rem 2rem 2rem;">
        {{ $loans->links() }}
    </div>
</div>

<script>
    function showNotifyOptions(memberName, phone, email, title, daysOverdue, loanId, finePerDay) {
        const fines = daysOverdue * finePerDay;
        const formattedFines = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(fines);
        
        let htmlText = `
            <div style="font-size: 0.95rem; color: #334155; margin-bottom: 1rem; text-align: left;">
                Pilih metode pengiriman peringatan keterlambatan buku untuk <b>${memberName}</b>.
            </div>
            <div style="background: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 0.75rem; border-radius: 0.375rem; font-size: 0.9rem; text-align: left; margin-bottom: 1rem;">
                📚 <b>${title}</b><br>
                ⏳ Terlambat: <b>${daysOverdue} Hari</b><br>
                💰 Perkiraan Denda: <b>${formattedFines}</b>
            </div>
        `;

        // Template Pesan
        const msg = `Halo ${memberName},

Kami dari Dudukbaca ingin mengingatkan bahwa Anda memiliki keterlambatan pengembalian buku:

Judul: ${title}
Terlambat: ${daysOverdue} Hari
Estimasi Denda: ${formattedFines}

Mohon segera mengembalikan buku tersebut untuk menghindari bertambahnya denda. Terima kasih.`;

        Swal.fire({
            title: 'Kirim Peringatan',
            html: htmlText,
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonColor: '#25D366', // WA Green
            denyButtonColor: '#ea4335',    // Gmail Red
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'WhatsApp',
            denyButtonText: 'Email Langsung',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                if(!phone) {
                    Swal.fire('Gagal', 'Anggota ini tidak memiliki nomor HP (WhatsApp).', 'error');
                } else {
                    window.open(`https://wa.me/${phone}?text=${encodeURIComponent(msg)}`, '_blank');
                }
            } else if (result.isDenied) {
                if(!email) {
                    Swal.fire('Gagal', 'Anggota ini tidak memiliki alamat Email.', 'error');
                } else {
                    Swal.fire({
                        title: 'Mengirim Email...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading() }
                    });
                    
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('/admin/circulation/overdue/notify') }}/${loanId}`;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{!! session('success') !!}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{!! session('error') !!}'
        });
    @endif
</script>
@endsection


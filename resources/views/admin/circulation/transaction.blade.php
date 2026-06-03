@extends('layouts.admin')

@section('pageTitle', 'Circulation Transaction')

@section('content')
<div style="display: grid; grid-template-columns: 320px 1fr; gap: 2.5rem; align-items: start;">
    <!-- Left Column: Member Info and Finish -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <h4 style="font-weight: 800; color: #1e293b; text-align: center; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Profil Anggota
                </h4>
            </div>
            <div style="padding: 2rem 1.5rem; text-align: center;">
                <div style="width: 90px; height: 90px; background: linear-gradient(135deg, #e0f2fe, #bae6fd); border-radius: 50%; margin: 0 auto 1.25rem; display: flex; align-items: center; justify-content: center; color: #0284c7; font-weight: 800; font-size: 2rem; box-shadow: 0 10px 20px -5px rgba(2, 132, 199, 0.2); border: 4px solid white;">
                    {{ substr($member->member_name, 0, 1) }}
                </div>
                <h3 style="color: #0f172a; font-weight: 800; font-size: 1.25rem; margin-bottom: 0.25rem;">{{ $member->member_name }}</h3>
                <p style="color: #64748b; font-family: monospace; font-size: 0.95rem; margin-bottom: 1.5rem; background: #f1f5f9; display: inline-block; padding: 0.25rem 0.75rem; border-radius: 99px; letter-spacing: 0.05em;">{{ $member->member_id }}</p>
                
                <div style="text-align: left; background: #f8fafc; padding: 1.25rem; border-radius: 1rem; border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Tipe Keanggotaan</div>
                        <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">Standar Member</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Email</div>
                        <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">{{ $member->member_email ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.circulation.index') }}" onclick="confirmFinish(event, this.href)" class="btn" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; width: 100%; padding: 1.1rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 1.05rem; text-decoration: none; box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 25px -5px rgba(16, 185, 129, 0.5)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 20px -5px rgba(16, 185, 129, 0.4)';">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Selesai Transaksi
        </a>
    </div>

    <!-- Right Column: Loan Form and Current Loans -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Loan Form -->
        <div style="background: white; padding: 2rem; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(to right, #3b82f6, #8b5cf6);"></div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h4 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                    Peminjaman Buku Baru
                </h4>
                <button type="button" onclick="startScanner()" style="font-size: 0.85rem; font-weight: 700; background: #f8fafc; color: #475569; padding: 0.5rem 1rem; border-radius: 99px; border: 1px solid #cbd5e1; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='#f8fafc';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                    Scan Barcode
                </button>
            </div>
            
            <!-- Scanner Container -->
            <div id="reader-container" style="margin-bottom: 1.5rem; display: none; text-align: center; border-radius: 1rem; overflow: hidden; border: 2px solid #e2e8f0;">
                <div id="reader" style="width: 100%; margin: 0 auto; min-height: 250px; background: #000;"></div>
                <button type="button" onclick="stopScanner()" style="width: 100%; color: white; background: #ef4444; border: none; padding: 0.75rem; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Hentikan Kamera</button>
            </div>

            <form id="loanForm" action="{{ route('admin.circulation.loan.store', $member->member_id) }}" method="POST" style="display: flex; gap: 1rem;" onsubmit="confirmLoan(event, this)">
                @csrf
                <div style="flex: 1; position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    </div>
                    <input type="text" id="item_code_input" name="item_code" required autofocus autocomplete="off"
                        style="width: 100%; padding: 1rem 1rem 1rem 3rem; border: 2px solid #cbd5e1; border-radius: 0.75rem; outline: none; font-size: 1.05rem; font-weight: 500; color: #1e293b; transition: border-color 0.2s;"
                        placeholder="Ketik / Scan Kode Eksemplar Buku..."
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)';" 
                        onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                </div>
                <button type="submit" style="padding: 1rem 2.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; border: none; border-radius: 0.75rem; font-weight: 800; font-size: 1.05rem; cursor: pointer; box-shadow: 0 4px 10px rgba(139,92,246,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">Proses Pinjam</button>
            </form>
            @error('item_code')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 0.35rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Current Loans List -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <h4 style="font-weight: 800; color: #0f172a; font-size: 1.25rem;">Buku di Tangan Anggota</h4>
            
            <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                            <th style="padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Eksemplar</th>
                            <th style="padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Judul Buku</th>
                            <th style="padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Tgl Pinjam</th>
                            <th style="padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Batas Kembali</th>
                            <th style="padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                        @php 
                            $isLate = \Carbon\Carbon::parse($loan->due_date)->isPast(); 
                            $daysOverdue = max(0, (int) \Carbon\Carbon::parse($loan->due_date)->startOfDay()->diffInDays(now()->startOfDay(), false));
                            $fines = $daysOverdue * 1000;
                        @endphp
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                             <td style="padding: 1.25rem 1.5rem;">
                                <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">{{ $loan->item_code }}</div>
                                <div style="font-size: 0.8rem; color: #64748b; display: flex; align-items: center; gap: 0.25rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                    {{ $loan->item->call_number ?? '-' }}
                                </div>
                             </td>
                             <td style="padding: 1.25rem 1.5rem; font-weight: 500; color: #334155;">
                                {{ $loan->item->biblio->title ?? 'Unknown Title' }}
                             </td>
                             <td style="padding: 1.25rem 1.5rem; color: #64748b;">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                             <td style="padding: 1.25rem 1.5rem;">
                                @if($isLate)
                                    <span style="background: #fef2f2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.8rem; border: 1px solid #fecaca; display: inline-block;">
                                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                        (Terlambat)
                                    </span>
                                @else
                                    <span style="color: #0f172a; font-weight: 600;">
                                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                    </span>
                                @endif
                             </td>
                             <td style="padding: 1.25rem 1.5rem; display: flex; justify-content: flex-end; gap: 0.5rem;">
                                <form action="{{ route('admin.circulation.extend', $loan->loan_id) }}" method="POST" onsubmit="confirmExtend(event, this, '{{ addslashes($loan->item->biblio->title ?? '') }}')">
                                    @csrf
                                    <button type="submit" style="background: white; border: 1px solid #3b82f6; color: #2563eb; padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: 0.2s; box-shadow: 0 2px 4px rgba(59,130,246,0.1);" onmouseover="this.style.background='#eff6ff';" onmouseout="this.style.background='white';">Perpanjang</button>
                                </form>
                                <form action="{{ route('admin.circulation.return', $loan->loan_id) }}" method="POST" onsubmit="confirmReturn(event, this, '{{ addslashes($loan->item->biblio->title ?? '') }}', {{ $fines }})">
                                    @csrf
                                    <button type="submit" style="background: #10b981; border: none; color: white; padding: 0.4rem 1.25rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.3);" onmouseover="this.style.background='#059669';" onmouseout="this.style.background='#10b981';">Kembalikan</button>
                                </form>
                             </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 4rem 2rem; text-align: center;">
                                <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                </div>
                                <h4 style="font-weight: 700; color: #475569; font-size: 1.1rem; margin-bottom: 0.25rem;">Tidak Ada Buku Dipinjam</h4>
                                <p style="color: #94a3b8; font-size: 0.95rem;">Anggota ini belum meminjam buku apapun.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        document.getElementById('reader-container').style.display = 'block';
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "user" }, // Changed to 'user' (front camera) for laptop compatibility
            { fps: 10, qrbox: { width: 250, height: 150 } },
            (decodedText, decodedResult) => {
                document.getElementById('item_code_input').value = decodedText;
                stopScanner();
                // Optional: Auto submit
                // document.querySelector('form').submit();
            },
            (errorMessage) => {
            }
        ).catch(err => {
            console.error(err);
            alert("Camera failed to start: " + err + "\n\nMake sure you are using 'localhost' or HTTPS.");
            stopScanner();
        });
    }

    function stopScanner() {
        if(html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear();
                document.getElementById('reader-container').style.display = 'none';
            }).catch(err => {
                console.error(err);
                document.getElementById('reader-container').style.display = 'none';
            });
        }
    }

    function confirmLoan(event, form) {
        event.preventDefault();
        let itemCode = document.getElementById('item_code_input').value;
        if (!itemCode) return;

        // Tampilkan loading state
        Swal.fire({
            title: 'Mencari Data Buku...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Lookup item ke server
        fetch(`{{ url('admin/circulation/lookup-item?item_code=') }}${itemCode}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Konfirmasi Peminjaman',
                        html: `Apakah Anda yakin ingin meminjamkan buku:<br><b>${data.item.title}</b><br>(Kode Item: ${data.item.item_code})`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Pinjamkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            }).catch(err => {
                Swal.fire('Error', 'Terjadi kesalahan sistem saat mencari item.', 'error');
            });
    }

    function confirmReturn(event, form, title, fines = 0) {
        event.preventDefault();
        
        let htmlText = `Apakah Anda yakin ingin mengembalikan buku:<br><b>${title}</b>?`;
        
        if (fines > 0) {
            let formattedFines = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(fines);
            htmlText += `<br><br><div style="background: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 0.75rem; border-radius: 0.375rem; font-size: 0.9rem;">
                            ⚠️ Buku ini terlambat dikembalikan!<br>
                            Perkiraan Denda: <b>${formattedFines}</b>
                         </div>`;
        }

        Swal.fire({
            title: 'Kembalikan Buku?',
            html: htmlText,
            icon: fines > 0 ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmExtend(event, form, title) {
        event.preventDefault();
        Swal.fire({
            title: 'Perpanjang Peminjaman?',
            html: `Apakah Anda yakin ingin memperpanjang durasi peminjaman buku:<br><b>${title}</b> selama 1 minggu ke depan?`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Perpanjang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmFinish(event, url) {
        event.preventDefault();
        Swal.fire({
            title: 'Selesai Transaksi?',
            text: 'Apakah Anda yakin ingin mengakhiri sesi transaksi member ini?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Belum'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    // Tampilkan SweetAlert untuk sukses dan error bawaan Laravel
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#3b82f6'
        });
    @endif
</script>
@endsection

@extends('layouts.admin')

@section('pageTitle', 'Pengembalian Kilat')

@section('content')
<div style="background: white; padding: 3.5rem 3rem; border-radius: 1.5rem; max-width: 650px; margin: 3rem auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1), 0 0 0 1px rgba(226, 232, 240, 0.5); text-align: center;">
    
    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 50%; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(255,255,255,0.5), 0 4px 6px -1px rgba(16,185,129,0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h13a5 5 0 0 1 0 10H7"/><polyline points="7 4 3 9 7 14"/></svg>
    </div>

    <h3 style="font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; font-size: 1.75rem; letter-spacing: -0.025em;">Pengembalian Kilat</h3>
    <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2.5rem;">Pindai atau masukkan kode eksemplar buku untuk memproses pengembalian secara cepat tanpa harus membuka profil anggota.</p>
    
    <!-- Scanner Section -->
    <div id="reader-container" style="margin-bottom: 2rem; text-align: center; display: none; border-radius: 1rem; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
        <div id="reader" style="width: 100%; margin: 0 auto; min-height: 300px; background: #000;"></div>
        <button type="button" onclick="stopScanner()" style="width: 100%; color: white; background: #ef4444; border: none; padding: 1rem; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Hentikan Kamera</button>
    </div>

    <div style="margin-bottom: 2rem;">
        <button type="button" onclick="startScanner()" class="btn" style="background: #f8fafc; color: #334155; padding: 0.85rem 1.75rem; border: 1px solid #cbd5e1; border-radius: 99px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);" onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#94a3b8'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#cbd5e1'; this.style.transform='none';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
            Gunakan Kamera Scanner
        </button>
    </div>

    <div style="display: flex; align-items: center; margin-bottom: 2rem;">
        <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
        <span style="padding: 0 1rem; color: #94a3b8; font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">ATAU KETIK MANUAL</span>
        <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
    </div>

    <!-- Input Form -->
    <div style="position: relative; max-width: 550px; margin: 0 auto;">
        <div style="display: flex; gap: 0.5rem; background: #f8fafc; padding: 0.5rem; border-radius: 1rem; border: 1px solid #cbd5e1; transition: border-color 0.2s, box-shadow 0.2s;" id="input-container">
            <div style="display: flex; align-items: center; justify-content: center; padding-left: 1rem; color: #94a3b8;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <input type="text" id="item_code_input" placeholder="Masukkan Kode Eksemplar Buku..." class="input" style="flex: 1; padding: 1rem 0.5rem; border: none; background: transparent; outline: none; font-size: 1.05rem; font-weight: 500; color: #1e293b;" autocomplete="off" oninput="searchLoanItem(this.value)" onfocus="document.getElementById('input-container').style.borderColor='#10b981'; document.getElementById('input-container').style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)';" onblur="document.getElementById('input-container').style.borderColor='#cbd5e1'; document.getElementById('input-container').style.boxShadow='none';">
            <button type="button" onclick="lookupLoan()" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0 2rem; border-radius: 0.75rem; border: none; font-weight: 800; cursor: pointer; transition: transform 0.2s; box-shadow: 0 4px 10px rgba(16,185,129,0.3);" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='none';">Cek Data</button>
        </div>
        
        <!-- Autocomplete Dropdown -->
        <ul id="autocomplete-list" style="display: none; position: absolute; top: calc(100% + 0.5rem); left: 0; right: 0; background: white; border: 1px solid #cbd5e1; border-radius: 0.75rem; list-style: none; padding: 0; margin: 0; max-height: 250px; overflow-y: auto; text-align: left; z-index: 50; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);"></ul>
    </div>
    
    <!-- Hidden form to process return -->
    <form id="returnForm" method="POST" action="" style="display:none;">
        @csrf
    </form>
</div>



<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        document.getElementById('reader-container').style.display = 'block';
        // Give basic feedback or instructions
        
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" }, // Changed to 'environment' (rear camera)
            { fps: 10, qrbox: { width: 250, height: 150 } },
            (decodedText, decodedResult) => {
                document.getElementById('item_code_input').value = decodedText;
                stopScanner();
                lookupLoan(); // Auto check
            },
            (errorMessage) => {
                // scanning...
            }
        ).catch(err => {
            console.error(err);
            alert("Camera failed to start: " + err + "\n\nMake sure you are using 'localhost' or HTTPS, and have allowed camera permissions.");
            stopScanner();
        });
    }

    function stopScanner() {
        if(html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear(); // Clears canvas
                document.getElementById('reader-container').style.display = 'none';
            }).catch(err => {
                console.error(err);
                document.getElementById('reader-container').style.display = 'none';
            });
        } else {
             document.getElementById('reader-container').style.display = 'none';
        }
    }

    function lookupLoan() {
        let code = document.getElementById('item_code_input').value;
        if(!code) return Swal.fire('Oops...', 'Silakan masukkan kode item atau cari judul buku.', 'error');

        document.getElementById('autocomplete-list').style.display = 'none';

        Swal.fire({
            title: 'Mencari Data...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch(`{{ route('admin.circulation.lookup_loan') }}?item_code=${code}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showModal(data.loan);
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan sistem saat mencari item.', 'error');
            });
    }

    function showModal(loan) {
        let htmlText = `<div style="text-align: left; background: #f8fafc; padding: 1rem; border-radius: 0.5rem;">
            <p style="margin-bottom: 0.5rem;"><strong>Buku:</strong> <br>${loan.title} (${loan.item_code})</p>
            <p style="margin-bottom: 0.5rem;"><strong>Peminjam:</strong> <br>${loan.member_name} (${loan.member_id})</p>
            <p style="margin-bottom: 0.5rem;"><strong>Tgl. Pinjam:</strong> <br>${loan.loan_date}</p>
            <p style="margin-bottom: 0;"><strong>Tgl. Jatuh Tempo:</strong> <br>${loan.due_date}</p>
        </div>`;
        
        if (loan.overdue_days > 0) {
            let formattedFines = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(loan.fines);
            htmlText += `<div style="background: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 0.75rem; border-radius: 0.375rem; font-size: 0.9rem; margin-top: 1rem; text-align: left;">
                            ⚠️ <strong>Terlambat ${loan.overdue_days} hari!</strong><br>
                            Perkiraan Denda: <b>${formattedFines}</b>
                         </div>`;
        }

        Swal.fire({
            title: 'Kembalikan Buku Ini?',
            html: htmlText,
            icon: loan.overdue_days > 0 ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let actionUrl = "{{ route('admin.circulation.return', ':id') }}";
                actionUrl = actionUrl.replace(':id', loan.loan_id);
                document.getElementById('returnForm').action = actionUrl;
                document.getElementById('returnForm').submit();
            } else {
                document.getElementById('item_code_input').value = '';
                // document.getElementById('item_code_input').focus();
            }
        });
    }

    let searchTimeout = null;
    function searchLoanItem(query) {
        let list = document.getElementById('autocomplete-list');
        if (query.trim().length < 2) {
            list.style.display = 'none';
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetch(`{{ url('admin/circulation/search-loan?q=') }}${query}`)
                .then(res => res.json())
                .then(data => {
                    list.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            let li = document.createElement('li');
                            li.style.padding = '0.75rem 1rem';
                            li.style.cursor = 'pointer';
                            li.style.borderBottom = '1px solid #f1f5f9';
                            li.innerHTML = `<strong>${item.item_code}</strong> - ${item.title} <small style="color: #64748b;">(Peminjam: ${item.member_name})</small>`;
                            li.onclick = function() {
                                document.getElementById('item_code_input').value = item.item_code;
                                list.style.display = 'none';
                                lookupLoan();
                            };
                            li.onmouseover = function() { this.style.backgroundColor = '#f8fafc'; };
                            li.onmouseout = function() { this.style.backgroundColor = 'white'; };
                            list.appendChild(li);
                        });
                        list.style.display = 'block';
                    } else {
                        list.style.display = 'none';
                    }
                });
        }, 300);
    }

    document.addEventListener('click', function(e) {
        if (e.target.id !== 'item_code_input') {
            document.getElementById('autocomplete-list').style.display = 'none';
        }
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection


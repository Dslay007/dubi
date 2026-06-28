@extends('layouts.admin')

@section('pageTitle', 'Absensi Anggota')

@section('content')
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Absensi Anggota
        </h3>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Scan kartu anggota atau ketik nama untuk mencatat kunjungan.</p>
    </div>
    
    <div style="padding: 3rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        
        <div style="width: 100%; max-width: 550px; text-align: center;">
            <div style="width: 80px; height: 80px; background: #eff6ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: inset 0 0 0 6px #dbeafe;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M3 7V5c0-1.1.9-2 2-2h2"/><path d="M17 3h2c1.1 0 2 .9 2 2v2"/><path d="M21 17v2c0 1.1-.9 2-2 2h-2"/><path d="M7 21H5c-1.1 0-2-.9-2-2v-2"/><rect x="7" y="7" width="10" height="10" rx="1"/></svg>
            </div>
            
            <div id="reader-container" style="margin-bottom: 2rem; text-align: center; display: none; border-radius: 1rem; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                <div id="reader" style="width: 100%; margin: 0 auto; min-height: 250px; background: #000;"></div>
                <button type="button" onclick="stopScanner()" style="width: 100%; color: white; background: #ef4444; border: none; padding: 1rem; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Hentikan Kamera</button>
            </div>

            <form action="{{ route('admin.member.attendance.store') }}" method="POST" id="attendanceForm">
                @csrf
                <div style="position: relative; margin-bottom: 1.5rem;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                    <input type="text" id="member_id_input" name="member_id" required autocomplete="off"
                        style="width: 100%; padding: 1.1rem 3.5rem 1.1rem 3rem; border: 2px solid #cbd5e1; border-radius: 0.75rem; outline: none; font-size: 1.05rem; font-weight: 500; color: #1e293b; transition: border-color 0.2s;"
                        placeholder="Scan Barcode atau Ketik Nama..."
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" 
                        onblur="setTimeout(() => { document.getElementById('autocomplete-dropdown').style.display='none'; this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'; }, 200);"
                        oninput="searchMembers(this.value)">
                        
                    <button type="button" onclick="startScanner()" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #3b82f6; cursor: pointer; padding: 0.25rem; display: flex; align-items: center; justify-content: center; border-radius: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#eff6ff';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                    </button>

                    <!-- Dropdown untuk autocomplete -->
                    <div id="autocomplete-dropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; margin-top: 0.5rem; max-height: 200px; overflow-y: auto; z-index: 50; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); text-align: left;">
                        <!-- Items will be injected here -->
                    </div>
                </div>
                
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 1rem 2rem; border: none; border-radius: 99px; font-weight: 800; font-size: 1rem; width: 100%; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    Catat Kunjungan
                </button>
            </form>
            
            <p style="margin-top: 2rem; color: #94a3b8; font-size: 0.85rem;">Anda dapat memindai barcode menggunakan scanner, atau mengetik ID/Nama secara manual.</p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;
    let isProcessing = false;

    function startScanner() {
        document.getElementById('reader-container').style.display = 'block';
        
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }
        
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" },
            { fps: 5, qrbox: { width: 250, height: 150 } },
            (decodedText, decodedResult) => {
                if (isProcessing) return;
                isProcessing = true;
                document.getElementById('member_id_input').value = decodedText;
                
                // Submit form via JS
                document.getElementById('attendanceForm').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            },
            (errorMessage) => { }
        ).catch(err => {
            console.error(err);
            alert("Camera failed to start: " + err + "\n\nPastikan kamera tersedia dan diizinkan.");
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

    // Autocomplete Logic
    let searchTimeout = null;
    function searchMembers(query) {
        clearTimeout(searchTimeout);
        const dropdown = document.getElementById('autocomplete-dropdown');
        
        if (query.length < 2) {
            dropdown.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('admin.circulation.search_member') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    dropdown.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(member => {
                            const item = document.createElement('div');
                            item.style.cssText = 'padding: 0.75rem 1rem; cursor: pointer; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;';
                            item.innerHTML = `<div style="font-weight: 600; color: #1e293b;">${member.member_name}</div><div style="font-size: 0.8rem; color: #64748b;">NIK: ${member.member_id}</div>`;
                            
                            item.onmouseover = () => item.style.background = '#f8fafc';
                            item.onmouseout = () => item.style.background = 'transparent';
                            
                            item.onclick = () => {
                                document.getElementById('member_id_input').value = member.member_id;
                                dropdown.style.display = 'none';
                                // Otomatis submit setelah dipilih
                                document.getElementById('attendanceForm').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                            };
                            dropdown.appendChild(item);
                        });
                        dropdown.style.display = 'block';
                    } else {
                        const noItem = document.createElement('div');
                        noItem.style.cssText = 'padding: 0.75rem 1rem; color: #94a3b8; font-style: italic; text-align: center; font-size: 0.9rem;';
                        noItem.textContent = 'Tidak ditemukan.';
                        dropdown.appendChild(noItem);
                        dropdown.style.display = 'block';
                    }
                })
                .catch(error => console.error('Error fetching members:', error));
        }, 300); // debounce
    }

    document.getElementById('attendanceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isProcessing) return;
        isProcessing = true;

        let inputEl = document.getElementById('member_id_input');
        let memberId = inputEl.value;

        if(!memberId) {
            isProcessing = false;
            return;
        }

        // 1. Cek data member dulu untuk konfirmasi
        fetch(`{{ url('admin/member/check-attendance') }}?member_id=${encodeURIComponent(memberId)}`)
            .then(res => res.json())
            .then(checkData => {
                if (checkData.success) {
                    let m = checkData.data;
                    
                    // 2. Tampilkan Konfirmasi Pop-up
                    Swal.fire({
                        title: 'Konfirmasi Kunjungan',
                        html: `Apakah Anda yakin ingin mencatat absensi untuk:<br><br>
                               <div style="background:#f8fafc; padding:1rem; border-radius:0.5rem; text-align:left; border:1px solid #e2e8f0;">
                                   <strong style="color:#0f172a; font-size:1.1rem;">${m.member_name}</strong><br>
                                   <span style="color:#64748b; font-size:0.9rem;">ID: ${m.member_id}</span>
                               </div>`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Ya, Catat',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // 3. Jika OK, submit data sebenarnya
                            let formData = new FormData(document.getElementById('attendanceForm'));
                            
                            fetch("{{ route('admin.member.attendance.store') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    let storedMember = data.member;
                                    let titleHtml = data.merch_reward 
                                        ? `<div style="color: #f59e0b; font-size: 1.25rem; font-weight: 800;">🎉 SELAMAT! MERCHANDISE GRATIS 🎉</div>` 
                                        : `Berhasil!`;

                                    let bodyHtml = `
                                        <h3 style="font-weight: 800; color: #1e293b; margin-bottom: 0.5rem; font-size: 1.25rem;">${storedMember.name}</h3>
                                        <div style="background: #f8fafc; padding: 1rem; border-radius: 1rem; text-align: left; margin-top: 1rem; border: 1px solid #f1f5f9;">
                                            <div style="display: flex; justify-content: space-between;">
                                                <span style="color: #64748b; font-weight: 600; font-size: 0.9rem;">Total Kunjungan</span>
                                                <span style="color: #3b82f6; font-weight: 800; font-size: 0.9rem;">${storedMember.visit_count} Kali</span>
                                            </div>
                                        </div>
                                    `;

                                    Swal.fire({
                                        icon: 'success',
                                        title: titleHtml,
                                        html: bodyHtml,
                                        timer: data.merch_reward ? undefined : 2000,
                                        showConfirmButton: !!data.merch_reward,
                                        confirmButtonText: 'Luar Biasa!',
                                        confirmButtonColor: '#f59e0b'
                                    }).then(() => {
                                        inputEl.value = '';
                                        isProcessing = false;
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: data.message || 'Gagal menyimpan absensi.',
                                        timer: 2500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        inputEl.value = '';
                                        isProcessing = false;
                                    });
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire('Error', 'Terjadi kesalahan sistem saat menyimpan.', 'error').then(() => {
                                    inputEl.value = '';
                                    isProcessing = false;
                                });
                            });
                        } else {
                            // Dibatalkan
                            inputEl.value = '';
                            isProcessing = false;
                        }
                    });

                } else {
                    // Member tidak ditemukan
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Ditemukan',
                        text: checkData.message || 'Anggota tidak terdaftar.',
                        timer: 2500,
                        showConfirmButton: false
                    }).then(() => {
                        inputEl.value = '';
                        isProcessing = false;
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Gagal memverifikasi data anggota.', 'error').then(() => {
                    inputEl.value = '';
                    isProcessing = false;
                });
            });
    });
</script>
@endsection


@extends('layouts.admin')

@section('pageTitle', 'Circulation Service')

@section('content')
<div style="background: white; padding: 3.5rem 3rem; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); max-width: 550px; margin: 3rem auto; text-align: center; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1), 0 0 0 1px rgba(226, 232, 240, 0.5);">
    
    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 50%; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(255,255,255,0.5), 0 4px 6px -1px rgba(59,130,246,0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/><path d="m15 5 3 3-3 3"/><path d="M8 8h10"/></svg>
    </div>

    <h3 style="font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; font-size: 1.75rem; letter-spacing: -0.025em;">Mulai Transaksi</h3>
    <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2.5rem;">Pindai kartu anggota atau cari berdasarkan nama/ID untuk memulai peminjaman & pengembalian.</p>

    <!-- Scanner Section -->
    <div id="reader-container" style="margin-bottom: 2rem; display: none; border-radius: 1rem; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
        <div id="reader" style="width: 100%; margin: 0 auto; min-height: 250px; background: #000;"></div>
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
        <span style="padding: 0 1rem; color: #94a3b8; font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">ATAU</span>
        <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
    </div>

    <form id="circulationForm" action="{{ route('admin.circulation.start') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 2rem; position: relative;">
            <div style="position: relative;">
                <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <input type="text" id="member_id_input" name="member_id" required autocomplete="off"
                    oninput="searchMember(this.value)"
                    style="width: 100%; padding: 1.1rem 1rem 1.1rem 3rem; border: 2px solid #cbd5e1; border-radius: 0.75rem; outline: none; font-size: 1.1rem; color: #1e293b; font-weight: 500; transition: border-color 0.2s;"
                    placeholder="Ketik ID / Nama Anggota..."
                    onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)';" 
                    onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
            </div>
            
            <!-- Autocomplete Dropdown -->
            <ul id="autocomplete-list" style="display: none; position: absolute; top: calc(100% + 0.5rem); left: 0; right: 0; background: white; border: 1px solid #cbd5e1; border-radius: 0.75rem; list-style: none; padding: 0; margin: 0; max-height: 250px; overflow-y: auto; text-align: left; z-index: 50; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);"></ul>

            @error('member_id')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.75rem; text-align: left; font-weight: 500; display: flex; align-items: center; gap: 0.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 1.1rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 0.75rem; font-weight: 800; font-size: 1.05rem; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 0.5rem; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 25px -5px rgba(37, 99, 235, 0.5)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 20px -5px rgba(37, 99, 235, 0.4)';">
            Lanjut Proses
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>
    </form>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        document.getElementById('reader-container').style.display = 'block';
        
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" }, // Changed to 'environment' (rear camera)
            { fps: 10, qrbox: { width: 250, height: 150 } },
            (decodedText, decodedResult) => {
                document.getElementById('member_id_input').value = decodedText;
                stopScanner();
                document.getElementById('autocomplete-list').style.display = 'none';
                document.getElementById('circulationForm').submit();
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

    let searchTimeout = null;
    function searchMember(query) {
        let list = document.getElementById('autocomplete-list');
        if (query.trim().length < 2) {
            list.style.display = 'none';
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetch(`{{ url('admin/circulation/search-member?q=') }}${query}`)
                .then(res => res.json())
                .then(data => {
                    list.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            let li = document.createElement('li');
                            li.style.padding = '0.75rem 1rem';
                            li.style.cursor = 'pointer';
                            li.style.borderBottom = '1px solid #f1f5f9';
                            li.innerHTML = `<strong>${item.member_id}</strong> - ${item.member_name}`;
                            li.onclick = function() {
                                document.getElementById('member_id_input').value = item.member_id;
                                list.style.display = 'none';
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

    // Hide dropdown if clicked outside
    document.addEventListener('click', function(e) {
        if (e.target.id !== 'member_id_input') {
            document.getElementById('autocomplete-list').style.display = 'none';
        }
    });
</script>
@endsection

@extends('layouts.admin')

@section('pageTitle', 'Rekaman Inventaris')

@section('content')

@if(!$activeStockTake)
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 3rem; text-align: center; display: flex; flex-direction: column; align-items: center; margin-bottom: 2rem;">
    <div style="width: 4rem; height: 4rem; background: #fef3c7; color: #d97706; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
        <i data-lucide="info" style="width: 2rem; height: 2rem;"></i>
    </div>
    <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; margin-bottom: 0.5rem;">Tidak Ada Sesi Aktif</h3>
    <p style="color: #64748b; margin-bottom: 2rem; max-width: 500px;">
        Belum ada sesi inventarisasi yang sedang berjalan. Silakan buat sesi baru di menu Inisialisasi terlebih dahulu.
    </p>
    <a href="{{ route('admin.inventarisasi.inisialisasi') }}" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 99px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        Ke Menu Inisialisasi
    </a>
</div>
@else

<!-- Header Sesi Aktif -->
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <i data-lucide="activity" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
            {{ $activeStockTake->stock_take_name }}
        </h2>
        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; font-size: 0.95rem; color: #64748b; align-items: center;">
            <span style="display: flex; align-items: center; gap: 0.25rem;"><i data-lucide="package" style="width:16px;height:16px;"></i> Total Item: <strong style="color:#0f172a;">{{ $activeStockTake->total_item_stock_taked }}</strong></span>
            <span style="display: flex; align-items: center; gap: 0.25rem;"><i data-lucide="check-circle" style="width:16px;height:16px;color:#10b981;"></i> Ditemukan: <strong style="color: #10b981;">{{ $activeStockTake->total_item_exists }}</strong></span>
            <span style="display: flex; align-items: center; gap: 0.25rem;"><i data-lucide="x-circle" style="width:16px;height:16px;color:#ef4444;"></i> Hilang: <strong style="color: #ef4444;">{{ $activeStockTake->total_item_lost }}</strong></span>
            <span style="display: flex; align-items: center; gap: 0.25rem;"><i data-lucide="clock" style="width:16px;height:16px;color:#f59e0b;"></i> Dipinjam: <strong style="color: #f59e0b;">{{ $activeStockTake->total_item_loan }}</strong></span>
        </div>
    </div>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.inventarisasi.export', [$activeStockTake->stock_take_id, 'exists']) }}" class="btn" style="background: white; color: #059669; border: 2px solid #a7f3d0; padding: 0.75rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#ecfdf5';" onmouseout="this.style.background='white';">
            <i data-lucide="download" style="width: 16px; height: 16px;"></i> Ditemukan
        </a>
        <a href="{{ route('admin.inventarisasi.export', [$activeStockTake->stock_take_id, 'lost']) }}" class="btn" style="background: white; color: #dc2626; border: 2px solid #fca5a5; padding: 0.75rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#fef2f2';" onmouseout="this.style.background='white';">
            <i data-lucide="download" style="width: 16px; height: 16px;"></i> Hilang
        </a>
        <a href="{{ route('admin.inventarisasi.export', [$activeStockTake->stock_take_id, 'all']) }}" class="btn" style="background: #1e293b; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 99px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <i data-lucide="file-text" style="width: 16px; height: 16px;"></i> Export Semua
        </a>
    </div>
</div>

<!-- Panel Scan Barcode / Import -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 2.5rem;">
    
    <!-- Rekaman Manual & Kamera -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2rem;">
        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="scan" style="width: 20px; height: 20px; color: #8b5cf6;"></i>
            Manual Scan
        </h4>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem;">Ketik atau scan barcode eksemplar untuk menandainya sebagai "Ditemukan".</p>
        
        <form action="{{ route('admin.inventarisasi.scan') }}" method="POST" id="scan-form">
            @csrf
            <div style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem;">
                <input type="text" name="item_code" id="item_code_input" required autofocus placeholder="Barcode / Item Code" class="form-input" style="flex: 1;">
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.4rem;">
                    <i data-lucide="check" style="width: 16px; height: 16px;"></i> Scan
                </button>
            </div>
        </form>

        <div style="border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1.5rem;">
            <button type="button" id="start-camera-btn" class="btn" style="width: 100%; background: #f1f5f9; color: #334155; padding: 1rem; border: 1px solid #cbd5e1; border-radius: 1rem; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                <i data-lucide="camera" style="width: 20px; height: 20px;"></i> Gunakan Kamera (QR/Barcode Scanner)
            </button>
        </div>

        <!-- Camera Container (Hidden by default) -->
        <div id="camera-container" style="display: none; margin-top: 1.5rem; border: 2px dashed #cbd5e1; border-radius: 1rem; padding: 0.5rem; position: relative; background: #f8fafc;">
            <button type="button" id="stop-camera-btn" style="position: absolute; top: 1rem; right: 1rem; z-index: 10; background: #ef4444; color: white; border: none; border-radius: 99px; padding: 0.4rem 1rem; cursor: pointer; font-size: 0.875rem; font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">
                <i data-lucide="x" style="width: 14px; height: 14px;"></i> Tutup
            </button>
            <div id="reader" style="width: 100%; border-radius: 0.5rem; overflow: hidden;"></div>
        </div>
    </div>

    <!-- Import / Upload -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); padding: 2rem;">
        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="upload-cloud" style="width: 20px; height: 20px; color: #8b5cf6;"></i>
            Upload Berkas Scan
        </h4>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem;">Unggah file <code>.txt</code> atau <code>.csv</code> berisi daftar barcode hasil scan kolektif.</p>
        
        <form action="{{ route('admin.inventarisasi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="file" name="file" required accept=".txt,.csv" class="form-input" style="padding: 1rem; background: #f8fafc; border: 2px dashed #cbd5e1; cursor: pointer;">
                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 0.875rem; border: none; border-radius: 99px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#059669';" onmouseout="this.style.background='#10b981';">
                    <i data-lucide="upload" style="width: 18px; height: 18px;"></i> Upload & Proses Barcode
                </button>
            </div>
        </form>
    </div>
</div>

@endif

<!-- Arsip Aset (Riwayat Inventaris) -->
<x-master-header 
    title="Arsip Inventarisasi" 
    subtitle="Daftar seluruh sesi inventarisasi yang pernah dilakukan sebelumnya." 
    icon="archive"
/>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Nama Sesi</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Tanggal Mulai</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Tanggal Selesai</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Total / Found / Lost</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); width: 100px;">Status</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($archives as $arc)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); {{ $arc->is_active ? 'background: #f0fdf4;' : 'background: white;' }} transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='{{ $arc->is_active ? '#f0fdf4' : 'white' }}';">
                    <td style="padding: 1rem 1.5rem; font-weight: 700; color: #0f172a;">{{ $arc->stock_take_name }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $arc->start_date }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $arc->end_date ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem; font-weight: 500;">
                        <span style="color:#0f172a">{{ $arc->total_item_stock_taked }}</span> / <span style="color: #10b981;">{{ $arc->total_item_exists }}</span> / <span style="color: #ef4444;">{{ $arc->total_item_lost }}</span>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($arc->is_active)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">Aktif</span>
                        @else
                            <span style="background: #f1f5f9; color: #475569; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">Selesai</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <a href="{{ route('admin.inventarisasi.export', [$arc->stock_take_id, 'all']) }}" class="btn" style="display: inline-flex; align-items: center; gap: 0.25rem; background: #e2e8f0; color: #334155; padding: 0.4rem 0.75rem; border-radius: 99px; text-decoration: none; font-weight: 600; font-size: 0.75rem; transition: 0.2s;" onmouseover="this.style.background='#cbd5e1';">
                            <i data-lucide="download" style="width: 14px; height: 14px;"></i> CSV
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: #64748b;">Belum ada arsip sesi inventarisasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scanForm = document.getElementById('scan-form');
        const itemInput = document.getElementById('item_code_input');
        const startCameraBtn = document.getElementById('start-camera-btn');
        const stopCameraBtn = document.getElementById('stop-camera-btn');
        const cameraContainer = document.getElementById('camera-container');
        
        let html5QrCode = null;

        if (!startCameraBtn) return; // In case there's no active stock take

        // Form Submit Handler (AJAX)
        scanForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const code = itemInput.value.trim();
            if(!code) return;

            fetch(scanForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ item_code: code })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: data.info ? 'info' : 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    // Update totals on page dynamically if we have them
                    if(data.totals) {
                        const tFound = document.querySelector('strong[style="color: #10b981;"]');
                        const tLost = document.querySelector('strong[style="color: #ef4444;"]');
                        if(tFound) tFound.textContent = data.totals.exists;
                        if(tLost) tLost.textContent = data.totals.missing;
                    }

                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                
                // Keep input focused for continuous scanning
                itemInput.value = '';
                itemInput.focus();
            })
            .catch(err => {
                console.error(err);
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan sistem.'});
            });
        });

        // Camera Scanner Handler
        startCameraBtn.addEventListener('click', function() {
            cameraContainer.style.display = 'block';
            startCameraBtn.style.display = 'none';

            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 250, height: 100 } };

            html5QrCode.start(
                { facingMode: "environment" }, 
                config,
                (decodedText, decodedResult) => {
                    // Success callback
                    itemInput.value = decodedText;
                    
                    // Pause scanner briefly to avoid multiple scans of the same code rapidly
                    html5QrCode.pause(true);
                    
                    // Submit form programmatically
                    scanForm.dispatchEvent(new Event('submit'));
                    
                    // Resume scanner after 1.5 seconds
                    setTimeout(() => {
                        if(html5QrCode.getState() === Html5QrcodeScannerState.PAUSED) {
                            html5QrCode.resume();
                        }
                    }, 1500);
                },
                (errorMessage) => {
                    // Ignored, happens when no barcode is detected in frame
                }
            )
            .catch((err) => {
                console.log(err);
                Swal.fire({icon: 'error', title: 'Kamera Gagal', text: 'Tidak dapat mengakses kamera. Pastikan Anda memberi izin.'});
                stopCamera();
            });
        });

        stopCameraBtn.addEventListener('click', stopCamera);

        function stopCamera() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    cameraContainer.style.display = 'none';
                    startCameraBtn.style.display = 'flex';
                }).catch(err => {
                    console.log(err);
                });
            } else {
                cameraContainer.style.display = 'none';
                startCameraBtn.style.display = 'flex';
            }
        }
    });
</script>

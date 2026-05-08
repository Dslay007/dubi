@extends('layouts.admin')

@section('pageTitle', 'Rekaman Inventaris')

@section('content')

@if(!$activeStockTake)
<div style="background: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 1rem 1.5rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
    <strong>Perhatian:</strong> Tidak ada sesi inventarisasi yang sedang aktif. Silakan buat sesi baru di menu <strong>Inisialisasi</strong> terlebih dahulu.
</div>
@else

<!-- Panel Scan Barcode / Import -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    
    <!-- Rekaman Manual & Kamera -->
    <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 600; color: #334155; margin-bottom: 1rem;">Rekaman Inventaris (Manual Scan)</h4>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem;">Scan atau ketik barcode eksemplar untuk menandainya sebagai "Ditemukan" (Exists).</p>
        
        <form action="{{ route('admin.inventarisasi.scan') }}" method="POST" id="scan-form">
            @csrf
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                <input type="text" name="item_code" id="item_code_input" required autofocus placeholder="Masukkan Barcode / Item Code"
                    style="flex: 1; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 1rem; outline: none;">
                <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; font-weight: 500;">Submit</button>
            </div>
        </form>

        <div style="border-top: 1px solid #e2e8f0; padding-top: 1rem;">
            <button type="button" id="start-camera-btn" class="btn" style="width: 100%; background: #0f172a; color: white; padding: 0.75rem; border: none; border-radius: 0.375rem; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i data-lucide="camera" style="width: 1.25rem; height: 1.25rem;"></i> Gunakan Kamera HP (Scanner)
            </button>
        </div>

        <!-- Camera Container (Hidden by default) -->
        <div id="camera-container" style="display: none; margin-top: 1rem; border: 2px dashed #cbd5e1; border-radius: 0.5rem; padding: 0.5rem; position: relative;">
            <button type="button" id="stop-camera-btn" style="position: absolute; top: 0.5rem; right: 0.5rem; z-index: 10; background: #ef4444; color: white; border: none; border-radius: 0.25rem; padding: 0.25rem 0.5rem; cursor: pointer; font-size: 0.75rem;">Tutup</button>
            <div id="reader" style="width: 100%;"></div>
        </div>
    </div>

    <!-- Import / Upload -->
    <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 1.5rem;">
        <h4 style="font-weight: 600; color: #334155; margin-bottom: 1rem;">Import Rekaman (Upload Teks)</h4>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem;">Unggah file <code>.txt</code> atau <code>.csv</code> berisi daftar barcode (satu barcode per baris) hasil scan kolektif.</p>
        
        <form action="{{ route('admin.inventarisasi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <input type="file" name="file" required accept=".txt,.csv"
                    style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; background: #f8fafc;">
                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; font-weight: 500;">Upload & Proses</button>
            </div>
        </form>
    </div>
</div>

<!-- Laporan / Export Sesi Aktif -->
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h4 style="font-weight: 700; color: #1e293b;">Sesi Aktif: {{ $activeStockTake->stock_take_name }}</h4>
            <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem; font-size: 0.9rem; color: #64748b;">
                <span>Total Item: <strong>{{ $activeStockTake->total_item_stock_taked }}</strong></span>
                <span>Ditemukan: <strong style="color: #10b981;">{{ $activeStockTake->total_item_exists }}</strong></span>
                <span>Hilang: <strong style="color: #ef4444;">{{ $activeStockTake->total_item_lost }}</strong></span>
                <span>Dipinjam: <strong style="color: #f59e0b;">{{ $activeStockTake->total_item_loan }}</strong></span>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.inventarisasi.export', [$activeStockTake->stock_take_id, 'exists']) }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Export Ditemukan</a>
            <a href="{{ route('admin.inventarisasi.export', [$activeStockTake->stock_take_id, 'lost']) }}" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Export Hilang (Lost)</a>
            <a href="{{ route('admin.inventarisasi.export', [$activeStockTake->stock_take_id, 'all']) }}" class="btn" style="background: #64748b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Export Semua</a>
        </div>
    </div>
</div>

@endif

<!-- Arsip Aset (Riwayat Inventaris) -->
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
        <h4 style="font-weight: 700; color: #1e293b;">Arsip Aset (Riwayat Inventarisasi)</h4>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.25rem;">Daftar seluruh sesi inventarisasi yang pernah dilakukan.</p>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Nama Sesi</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Tanggal Mulai</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Tanggal Selesai</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Total / Found / Lost</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 100px;">Status</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Export Laporan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($archives as $arc)
                <tr style="border-bottom: 1px solid #e2e8f0; {{ $arc->is_active ? 'background: #f0fdf4;' : '' }}">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1e293b;">{{ $arc->stock_take_name }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $arc->start_date }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $arc->end_date ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem; color: #334155;">
                        {{ $arc->total_item_stock_taked }} / <span style="color: #10b981;">{{ $arc->total_item_exists }}</span> / <span style="color: #ef4444;">{{ $arc->total_item_lost }}</span>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($arc->is_active)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Aktif</span>
                        @else
                            <span style="background: #f1f5f9; color: #475569; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Selesai</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <a href="{{ route('admin.inventarisasi.export', [$arc->stock_take_id, 'all']) }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">⬇ CSV</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 2rem; text-align: center; color: #64748b;">Belum ada arsip aset inventaris.</td>
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

@extends('layouts.admin')

@section('pageTitle', 'Circulation Service')

@section('content')
<div style="background: white; padding: 3rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; max-width: 500px; margin: 2rem auto; text-align: center;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 2rem; font-size: 1.5rem;">Start Transaction</h3>

    <!-- Scanner Section -->
    <div id="reader-container" style="margin-bottom: 2rem; display: none;">
        <div id="reader" style="width: 100%; max-width: 400px; margin: 0 auto; min-height: 250px; background: #000;"></div>
        <button type="button" onclick="stopScanner()" style="margin-top: 1rem; color: #ef4444; background: none; border: 1px solid #ef4444; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer;">Stop Camera</button>
    </div>

    <div style="margin-bottom: 2rem;">
        <button type="button" onclick="startScanner()" class="btn" style="background: #e2e8f0; color: #1e293b; padding: 0.75rem 1.5rem; border-radius: 99px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="camera"></i> Scan Member ID
        </button>
    </div>

    <form action="{{ route('admin.circulation.start') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 2rem;">
            <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem; text-align: left;">Enter Member ID</label>
            <input type="text" id="member_id_input" name="member_id" required autofocus
                style="width: 100%; padding: 1rem; border: 2px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-size: 1.1rem; text-align: center; letter-spacing: 0.05em;"
                placeholder="Scan or Type Member ID">
            @error('member_id')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; text-align: left;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 1rem; background: #3b82f6; color: white; border: none; border-radius: 0.5rem; font-weight: 700; font-size: 1rem; cursor: pointer;">Start Circulation</button>
    </form>
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
                document.getElementById('member_id_input').value = decodedText;
                stopScanner();
                // Optional: Auto submit if scanning
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
</script>
@endsection

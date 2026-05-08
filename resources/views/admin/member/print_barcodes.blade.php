<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota (QR Code)</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 3rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        .barcode-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .barcode-card {
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            padding: 2rem 1.5rem;
            text-align: center;
            border-radius: 1.25rem;
            page-break-inside: avoid;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
        }
        
        .barcode-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
        }

        .member-name {
            font-size: 1.15rem;
            margin-bottom: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .qrcode img {
            margin: 0 auto;
            border: 4px solid white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        
        .btn-print {
            position: fixed;
            bottom: 2.5rem;
            right: 2.5rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 99px;
            font-weight: 800;
            font-size: 1.05rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 25px -5px rgba(37,99,235,0.4);
            transition: 0.2s;
            display: flex;
            align-items: center;
            z-index: 100;
        }
        
        .btn-print:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(37,99,235,0.5);
        }

        @media print {
            body { background: white; padding: 0; }
            .btn-print { display: none; }
            .barcode-container {
                display: block; 
            }
            .barcode-card {
                border: 1px dashed #ccc;
                float: left;
                width: 45%; 
                margin: 2%;
                height: 220px;
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem; vertical-align: middle;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
        Cetak Kartu
    </button>

    <div class="barcode-container">
        @foreach($members as $member)
        <div class="barcode-card">
            <div class="member-name">{{ $member->member_name }}</div>
            <div class="qrcode" data-value="{{ $member->member_id }}"></div>
            <div style="margin-top: 0.75rem; font-size: 0.9rem; font-weight: 700; letter-spacing: 1px; color: #475569;">
                {{ $member->member_id }}
            </div>
        </div>
        @endforeach
    </div>

    <script>
        document.querySelectorAll('.qrcode').forEach(function(element) {
            new QRCode(element, {
                text: element.getAttribute('data-value'),
                width: 100,
                height: 100,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        });
    </script>
</body>
</html>

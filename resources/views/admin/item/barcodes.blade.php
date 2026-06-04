<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcodes</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 2rem;
            background: #f1f5f9;
        }
        
        .barcode-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .barcode-card {
            background: white;
            border: 1px solid #cbd5e1;
            padding: 1rem;
            text-align: center;
            border-radius: 0.5rem;
            page-break-inside: avoid;
        }

        .item-title {
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: bold;
        }

        svg {
            max-width: 100%;
            height: auto;
        }
        
        .btn-print {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #0f172a;
            color: white;
            padding: 1rem 2rem;
            border-radius: 99px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        @media print {
            body { background: white; padding: 0; }
            .btn-print { display: none; }
            .barcode-container {
                display: block; /* Or grid depending on label sheet */
            }
            .barcode-card {
                border: 1px dashed #ccc; /* Guide lines, separate via CSS if needed */
                float: left;
                width: 45%; 
                margin: 2%;
                height: 120px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
        }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">Print Barcodes</button>

    <div class="barcode-container">
        @foreach($items as $item)
        <div class="barcode-card">
            <div class="item-title">{{ Str::limit($item->biblio->title ?? 'Unknown', 30) }}</div>
            <svg class="barcode"
                 jsbarcode-format="CODE128"
                 jsbarcode-value="{{ $item->item_code }}"
                 jsbarcode-textmargin="0"
                 jsbarcode-fontoptions="bold">
            </svg>
        </div>
        @endforeach
    </div>

    <script>
        JsBarcode(".barcode").init();
    </script>
</body>
</html>


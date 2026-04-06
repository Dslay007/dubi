@extends('layouts.admin')

@section('pageTitle', 'Pengembalian Kilat')

@section('content')
@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 800px; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h3 style="font-size: 1.25rem; font-weight: 600; text-align: center; margin-bottom: 2rem;">Pengembalian Kilat (Quick Return)</h3>
    
    <!-- Scanner Section -->
    <div id="reader-container" style="margin-bottom: 2rem; text-align: center; display: none;">
        <div id="reader" style="width: 100%; max-width: 400px; margin: 0 auto; min-height: 300px; background: #000;"></div>
        <button type="button" onclick="stopScanner()" style="margin-top: 1rem; color: #ef4444; background: none; border: 1px solid #ef4444; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer;">Stop Camera</button>
    </div>

    <div style="text-align: center; margin-bottom: 2rem;">
        <button type="button" onclick="startScanner()" class="btn" style="background: #e2e8f0; color: #1e293b; padding: 0.75rem 1.5rem; border-radius: 99px; font-weight: 600; margin-bottom: 1rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="camera"></i> Scan with Camera
        </button>
        <p style="color: #64748b;">Or enter item code manually below:</p>
    </div>

    <!-- Input Form -->
    <div style="display: flex; gap: 0.5rem; max-width: 500px; margin: 0 auto;">
        <input type="text" id="item_code_input" placeholder="Enter Item Code..." class="input" style="flex: 1; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 1rem;" autofocus>
        <button type="button" onclick="lookupLoan()" class="btn" style="background: #0f172a; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; font-weight: 600;">Check</button>
    </div>
</div>

<!-- Modal Confirmation -->
<div id="confirmationModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 50;">
    <div style="background: white; padding: 2rem; border-radius: 0.5rem; width: 90%; max-width: 500px;">
        <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">Confirm Return</h4>
        
        <div style="margin-bottom: 1.5rem;">
            <p><strong>Member:</strong> <span id="modal_member_name">-</span> (<span id="modal_member_id">-</span>)</p>
            <p><strong>Item:</strong> <span id="modal_title">-</span></p>
            <p><strong>Due Date:</strong> <span id="modal_due_date" style="color: #64748b;">-</span></p>
            <p id="overdue_warning" style="display: none; color: #b91c1c; background: #fee2e2; padding: 0.5rem; border-radius: 0.25rem; margin-top: 0.5rem;">
                <strong>OVERDUE:</strong> <span id="modal_days_overdue">0</span> days. Fine: Rp <span id="modal_fines">0</span>
            </p>
        </div>

        <form id="returnForm" method="POST" action="">
            @csrf
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="background: #94a3b8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 600;">Confirm Return</button>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        document.getElementById('reader-container').style.display = 'block';
        // Give basic feedback or instructions
        
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "user" }, // Changed to 'user' (front camera) for laptop compatibility
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
    // ... existing lookupLoan ...
        let code = document.getElementById('item_code_input').value;
        if(!code) return alert('Please enter item code');

        fetch(`{{ route('admin.circulation.lookup_loan') }}?item_code=${code}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showModal(data.loan);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function showModal(loan) {
        document.getElementById('modal_member_name').innerText = loan.member_name;
        document.getElementById('modal_member_id').innerText = loan.member_id;
        document.getElementById('modal_title').innerText = loan.title;
        document.getElementById('modal_due_date').innerText = loan.due_date;
        
        if (loan.overdue_days > 0) {
            document.getElementById('overdue_warning').style.display = 'block';
            document.getElementById('modal_days_overdue').innerText = loan.overdue_days;
            document.getElementById('modal_fines').innerText = loan.fines;
        } else {
            document.getElementById('overdue_warning').style.display = 'none';
        }

        // Set form action dynamically
        let actionUrl = "{{ route('admin.circulation.return', ':id') }}";
        actionUrl = actionUrl.replace(':id', loan.loan_id);
        document.getElementById('returnForm').action = actionUrl;

        document.getElementById('confirmationModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('confirmationModal').style.display = 'none';
        document.getElementById('item_code_input').value = '';
        document.getElementById('item_code_input').focus();
    }
</script>
@endsection

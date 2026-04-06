@extends('layouts.admin')

@section('pageTitle', 'Circulation Transaction')

@section('content')
<div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem;">
    <!-- Left Column: Member Info and Finish -->
    <div>
        <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; margin-bottom: 1rem;">
            <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f1f5f9;">Member Profile</h4>
            <div style="text-align: center; margin-bottom: 1rem;">
                <!-- Placeholder Avatar -->
                <div style="width: 80px; height: 80px; background: #e2e8f0; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 700; font-size: 1.5rem;">
                    {{ substr($member->member_name, 0, 1) }}
                </div>
            </div>
            <div style="margin-bottom: 0.5rem;"><strong>ID:</strong> {{ $member->member_id }}</div>
            <div style="margin-bottom: 0.5rem;"><strong>Name:</strong> {{ $member->member_name }}</div>
            <div style="margin-bottom: 0.5rem;"><strong>Type:</strong> Standard Member</div>
            <div><strong>Email:</strong> {{ $member->member_email ?? '-' }}</div>
        </div>

        <a href="{{ route('admin.circulation.index') }}" class="btn" style="display: block; width: 100%; padding: 1rem; background: #10b981; color: white; border: none; border-radius: 0.5rem; font-weight: 700; text-align: center; text-decoration: none;">Finish Transaction</a>
    </div>

    <!-- Right Column: Loan Form and Current Loans -->
    <div>
        <!-- Loan Form -->
        <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
            <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Loan Item</h4>
            
            <!-- Scanner Toggle -->
            <div style="margin-bottom: 1rem; text-align: right;">
                 <button type="button" onclick="startScanner()" style="font-size: 0.8rem; background: #e2e8f0; padding: 0.25rem 0.75rem; border-radius: 99px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem;">
                    <i data-lucide="camera" style="width: 14px; height: 14px;"></i> Scan
                </button>
            </div>
             <!-- Scanner Container -->
            <div id="reader-container" style="margin-bottom: 1rem; display: none; text-align: center;">
                <div id="reader" style="width: 100%; margin: 0 auto; min-height: 250px; background: #000;"></div>
                <button type="button" onclick="stopScanner()" style="margin-top: 0.5rem; color: #ef4444; background: none; border: 1px solid #ef4444; padding: 0.25rem 0.5rem; border-radius: 0.25rem; cursor: pointer; font-size: 0.8rem;">Stop Camera</button>
            </div>

            <form action="{{ route('admin.circulation.loan', $member->member_id) }}" method="POST" style="display: flex; gap: 1rem;">
                @csrf
                <input type="text" id="item_code_input" name="item_code" required autofocus 
                    style="flex: 1; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 1rem;"
                    placeholder="Scan Item Barcode">
                <button type="submit" style="padding: 0.75rem 2rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; font-weight: 600; cursor: pointer;">Loan</button>
            </form>
            @error('item_code')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
            @if(session('success'))
                <div style="color: #10b981; font-size: 0.875rem; margin-top: 0.5rem;">{{ session('success') }}</div>
            @endif
        </div>

        <!-- Current Loans List -->
        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Current Loans</h4>
        <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Item Code</th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Title</th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Loan Date</th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Due Date</th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                         <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $loan->item_code }}</td>
                         <td style="padding: 1rem 1.5rem;">
                            {{ $loan->item->biblio->title ?? 'Unknown Title' }}
                         </td>
                         <td style="padding: 1rem 1.5rem;">{{ $loan->loan_date }}</td>
                         <td style="padding: 1rem 1.5rem; color: {{ \Carbon\Carbon::parse($loan->due_date)->isPast() ? '#ef4444' : '#1e293b' }}; font-weight: {{ \Carbon\Carbon::parse($loan->due_date)->isPast() ? '700' : 'normal' }};">
                            {{ $loan->due_date }}
                         </td>
                         <td style="padding: 1rem 1.5rem;">
                            <form action="{{ route('admin.circulation.return', $loan->loan_id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; cursor: pointer; color: #334155;">Return</button>
                            </form>
                         </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">No active loans.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
</script>
@endsection

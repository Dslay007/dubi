@extends('layouts.modern_landing')

@section('content')
<div class="container" style="min-height: 60vh;">
    <div style="max-width: 400px; margin: 4rem auto; position: relative;">
        <!-- Back Button -->
        <a href="javascript:history.back()" style="position: absolute; top: -40px; left: 0; color: #64748b; font-weight: 600; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem;">
            &larr; Kembali
        </a>

        <!-- Badge indicating Admin -->
        <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #0f172a; color: white; padding: 0.25rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
            Akses Pustakawan
        </div>

        <div style="background: white; padding: 2rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);">
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; text-align: center; color: #1e293b;">Login Admin</h1>
            <p style="text-align: center; color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Kelola koleksi perpustakaan dan anggota</p>
            
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label for="username" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Username</label>
                    <input type="text" name="username" id="username" required autofocus
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;">
                </div>

                <div style="margin-bottom: 1.5rem; position: relative;">
                    <label for="password" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Password</label>
                    <input type="password" name="password" id="password" required 
                        style="width: 100%; padding: 0.75rem; padding-right: 2.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;">
                    <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 0.75rem; bottom: 0.75rem; background: none; border: none; cursor: pointer; color: #64748b;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>

                @if($errors->any())
                <div style="margin-bottom: 1.5rem; padding: 0.75rem; background: #fee2e2; color: #b91c1c; border-radius: 0.5rem; font-size: 0.875rem;">
                    {{ $errors->first() }}
                </div>
                @endif

                <button type="submit" class="btn" style="width: 100%; justify-content: center; display: flex; background: #0f172a;">
                    Login ke Dashboard
                </button>

                <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
                    <span style="color: #64748b;">Bukan pustakawan?</span> 
                    <a href="{{ route('login') }}" style="color: #3b82f6; font-weight: 600;">Login sebagai Member</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    
    if (isPassword) {
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>`;
    } else {
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }
}
</script>
@endsection

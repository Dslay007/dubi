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
            Librarian Access
        </div>

        <div style="background: white; padding: 2rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);">
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; text-align: center; color: #1e293b;">Admin Login</h1>
            <p style="text-align: center; color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Manage library collections and members</p>
            
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label for="username" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Username</label>
                    <input type="text" name="username" id="username" required autofocus
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Password</label>
                    <input type="password" name="password" id="password" required 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;">
                </div>

                @if($errors->any())
                <div style="margin-bottom: 1.5rem; padding: 0.75rem; background: #fee2e2; color: #b91c1c; border-radius: 0.5rem; font-size: 0.875rem;">
                    {{ $errors->first() }}
                </div>
                @endif

                <button type="submit" class="btn" style="width: 100%; justify-content: center; display: flex; background: #0f172a;">
                    Login to Dashboard
                </button>

                <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
                    <span style="color: #64748b;">Not a librarian?</span> 
                    <a href="{{ route('login') }}" style="color: #3b82f6; font-weight: 600;">Login as Member</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


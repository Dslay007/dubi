@extends('layouts.app')

@section('content')
<div class="container">
    <div style="max-width: 600px; margin: 4rem auto;">
        <div style="background: white; padding: 2rem; border-radius: 0.75rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; text-align: center; color: #1e293b;">Member Registration</h1>
            
            <form action="{{ route('member.register.post') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1rem;">
                    <label for="member_id" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">NIK (Nomor Induk Kependudukan - 16 Digit)</label>
                    <input type="text" name="member_id" id="member_id" value="{{ old('member_id') }}" required maxlength="16" placeholder="Masukkan 16 digit NIK Anda (Akan digunakan untuk login)"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; box-sizing: border-box;">
                    @error('member_id') <div style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="member_name" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Full Name</label>
                    <input type="text" name="member_name" id="member_name" value="{{ old('member_name') }}" required 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; box-sizing: border-box;">
                    @error('member_name') <div style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label for="member_email" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Email Address</label>
                        <input type="email" name="member_email" id="member_email" value="{{ old('member_email') }}" required 
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; box-sizing: border-box;">
                        @error('member_email') <div style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="member_phone" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Phone Number (HP)</label>
                        <input type="text" name="member_phone" id="member_phone" value="{{ old('member_phone') }}" required 
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; box-sizing: border-box;">
                        @error('member_phone') <div style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="member_address" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Address (Domicile in Malang)</label>
                    <textarea name="member_address" id="member_address" rows="3" required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; box-sizing: border-box;">{{ old('member_address') }}</textarea>
                    @error('member_address') <div style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                     <div>
                        <label for="gender" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Gender</label>
                        <select name="gender" id="gender" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; background: white; box-sizing: border-box;">
                            <option value="1">Male</option>
                            <option value="0">Female</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <div style="position: relative;">
                        <label for="password" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Password</label>
                        <input type="password" name="password" id="password" required 
                            style="width: 100%; padding: 0.75rem; padding-right: 2.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; box-sizing: border-box;">
                        <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 0.75rem; bottom: 0.75rem; background: none; border: none; cursor: pointer; color: #64748b;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                         @error('password') <div style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                    </div>
                    @include('components.password-strength', ['inputId' => 'password'])
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <div style="position: relative;">
                        <label for="password_confirmation" style="display: block; font-weight: 500; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                            style="width: 100%; padding: 0.75rem; padding-right: 2.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; box-sizing: border-box;">
                        <button type="button" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 0.75rem; bottom: 0.75rem; background: none; border: none; cursor: pointer; color: #64748b;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn" style="width: 100%; justify-content: center; display: flex;">
                    Register
                </button>
                
                <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
                    <span style="color: #64748b;">Already have an account?</span> 
                    <a href="{{ route('login') }}" style="color: #3b82f6; font-weight: 600;">Login here</a>
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

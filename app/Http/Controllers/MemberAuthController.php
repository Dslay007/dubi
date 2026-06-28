<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MemberAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('member.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'member_id' => 'required',
            'password' => 'required',
        ]);

        $this->ensureIsNotRateLimited($request);

        $member = Member::where('member_id', $credentials['member_id'])->first();

        // Check if member exists and verify password
        $passwordMatches = false;
        $needsUpgrade = false;
        
        if ($member) {
            // 1. Coba Bcrypt dulu (format paling aman & modern)
            if (\Illuminate\Support\Facades\Hash::check($credentials['password'], $member->mpasswd)) {
                $passwordMatches = true;
            // 2. Coba SHA256 (format SLiMS lama)
            } elseif (hash('sha256', $credentials['password']) === $member->mpasswd) {
                $passwordMatches = true;
                $needsUpgrade = true;
            // 3. Coba MD5 (format SLiMS legacy)
            } elseif (md5($credentials['password']) === $member->mpasswd) {
                $passwordMatches = true;
                $needsUpgrade = true;
            }
        }

        if ($passwordMatches) {
            if ($member->is_pending == 1) {
                return back()->withErrors([
                    'member_id' => 'Akun Anda sedang dalam MASA TUNGGU. Silakan datang ke lapak baca dengan membawa KTP asli untuk verifikasi.',
                ])->onlyInput('member_id');
            }

            // Auto-upgrade password lama (SHA256/MD5) ke Bcrypt yang lebih aman
            if ($needsUpgrade) {
                Member::where('member_id', $member->member_id)->update([
                    'mpasswd' => \Illuminate\Support\Facades\Hash::make($credentials['password'])
                ]);
            }

            Auth::guard('member')->login($member);
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));
            return redirect()->intended('/member/dashboard');
        }

        RateLimiter::hit($this->throttleKey($request));

        return back()->withErrors([
            'member_id' => 'Login gagal! ID Anggota atau password salah.',
        ])->onlyInput('member_id');
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'member_id' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.',
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->input('member_id')).'|'.$request->ip());
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\SystemLog;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah user sudah mencoba login gagal lebih dari batas maksimal (5 kali)
        $this->ensureIsNotRateLimited($request);

        $user = User::where('username', $credentials['username'])->first();

        // 1. Try SHA256 (Modern SLiMS)
        if ($user && hash('sha256', $credentials['password']) === $user->passwd) {
            // AUTO-UPGRADE PASSWORD KE BCRYPT YANG LEBIH AMAN
            $user->update(['passwd' => \Illuminate\Support\Facades\Hash::make($credentials['password'])]);

            Auth::guard('admin')->login($user);
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));
            SystemLog::write('login', 'User berhasil login (SHA256->Bcrypt Upgraded)', 'System', 'Login');
            return redirect()->intended(route('admin.dashboard'));
        }

        // 2. Try MD5 (Legacy SLiMS)
        if ($user && md5($credentials['password']) === $user->passwd) {
            // AUTO-UPGRADE PASSWORD KE BCRYPT YANG LEBIH AMAN
            $user->update(['passwd' => \Illuminate\Support\Facades\Hash::make($credentials['password'])]);

            Auth::guard('admin')->login($user);
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));
            SystemLog::write('login', 'User berhasil login (MD5->Bcrypt Upgraded)', 'System', 'Login');
            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Try generic Laravel hashing (Manual Check)
        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->passwd)) {
             Auth::guard('admin')->login($user);
             $request->session()->regenerate();
             RateLimiter::clear($this->throttleKey($request));
             SystemLog::write('login', 'User berhasil login (Bcrypt)', 'System', 'Login');
             return redirect()->intended(route('admin.dashboard'));
        }

        // Catat percobaan gagal ini ke RateLimiter
        RateLimiter::hit($this->throttleKey($request));

        return back()->withErrors([
            'username' => 'These credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $userId = Auth::guard('admin')->user()->username ?? 'Unknown';
        SystemLog::write('logout', 'User logout: ' . $userId, 'System', 'Login');
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Memastikan request login belum melampaui batas percobaan.
     */
    protected function ensureIsNotRateLimited(Request $request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'username' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.',
        ]);
    }

    /**
     * Membuat kunci identifikasi unik berdasarkan IP dan Username.
     */
    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->input('username')).'|'.$request->ip());
    }
}

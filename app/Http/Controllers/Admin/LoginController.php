<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\SystemLog;

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

        $user = User::where('username', $credentials['username'])->first();

        // 1. Try SHA256 (Modern SLiMS)
        if ($user && hash('sha256', $credentials['password']) === $user->passwd) {
            Auth::guard('admin')->login($user);
            $request->session()->regenerate();
            SystemLog::write('login', 'User berhasil login (SHA256)', 'System', 'Login');
            return redirect()->intended(route('admin.dashboard'));
        }

        // 2. Try MD5 (Legacy SLiMS)
        if ($user && md5($credentials['password']) === $user->passwd) {
            Auth::guard('admin')->login($user);
            $request->session()->regenerate();
            SystemLog::write('login', 'User berhasil login (MD5)', 'System', 'Login');
            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Try generic Laravel hashing (Manual Check)
        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->passwd)) {
             Auth::guard('admin')->login($user);
             $request->session()->regenerate();
             SystemLog::write('login', 'User berhasil login (Bcrypt)', 'System', 'Login');
             return redirect()->intended(route('admin.dashboard'));
        }

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
}

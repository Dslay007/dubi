<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

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

        $member = Member::where('member_id', $credentials['member_id'])->first();

        // Check if member exists and verify password
        // SLiMS uanlly uses SHA256 to hash 'mpasswd'
        $passwordMatches = false;
        
        if ($member) {
            if (hash('sha256', $credentials['password']) === $member->mpasswd) {
                $passwordMatches = true;
            } elseif (md5($credentials['password']) === $member->mpasswd) {
                $passwordMatches = true;
            } elseif (\Illuminate\Support\Facades\Hash::check($credentials['password'], $member->mpasswd)) {
                $passwordMatches = true;
            }
        }

        if ($passwordMatches) {
            if ($member->is_pending == 1) {
                return back()->withErrors([
                    'member_id' => 'Akun Anda sedang dalam MASA TUNGGU. Silakan datang ke perpustakaan dengan membawa KTP asli untuk verifikasi.',
                ])->onlyInput('member_id');
            }

            Auth::guard('member')->login($member);
            $request->session()->regenerate();
            return redirect()->intended('/member/dashboard');
        }

        return back()->withErrors([
            'member_id' => 'The provided credentials do not match our records.',
        ])->onlyInput('member_id');
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

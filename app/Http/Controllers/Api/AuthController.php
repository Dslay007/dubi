<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $member = Member::where('member_id', $request->member_id)->first();

        // Cek kecocokan password dengan berbagai format (Bcrypt, SHA256, atau MD5)
        $passwordMatches = false;
        $needsUpgrade = false;

        if (Hash::check($request->password, $member->mpasswd)) {
            $passwordMatches = true;
        } elseif (hash('sha256', $request->password) === $member->mpasswd) {
            $passwordMatches = true;
            $needsUpgrade = true;
        } elseif (md5($request->password) === $member->mpasswd) {
            $passwordMatches = true;
            $needsUpgrade = true;
        }

        if (!$member || !$passwordMatches) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID Member atau Password salah.'
            ], 401);
        }

        // Auto-upgrade password lama ke Bcrypt yang aman
        if ($needsUpgrade) {
            $member->update(['mpasswd' => Hash::make($request->password)]);
        }

        // Generate Sanctum Token
        $token = $member->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'member' => $member,
                'token' => $token,
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string|unique:member,member_id',
            'member_name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $member = Member::create([
            'member_id' => $request->member_id,
            'member_name' => $request->member_name,
            'mpasswd' => Hash::make($request->password),
            'inst_name' => 'Umum', // Default atau bisa disesuaikan
            'is_pending' => 0,
        ]);

        $token = $member->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran berhasil',
            'data' => [
                'member' => $member,
                'token' => $token,
            ]
        ], 201);
    }

    public function logout(Request $request)
    {
        // Menghapus token yang sedang digunakan untuk request ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('member_id')).'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'status' => 'error',
                'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.'
            ], 429);
        }

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
            RateLimiter::hit($throttleKey);
            return response()->json([
                'status' => 'error',
                'message' => 'ID Member atau Password salah.'
            ], 401);
        }

        // Cek apakah akun masih dalam masa tunggu (belum diverifikasi admin)
        if ($member->is_pending == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun Anda sedang dalam MASA TUNGGU. Silakan datang ke lapak baca dengan membawa KTP asli untuk verifikasi.'
            ], 403);
        }

        // Auto-upgrade password lama ke Bcrypt yang aman
        if ($needsUpgrade) {
            $member->update(['mpasswd' => Hash::make($request->password)]);
        }

        // Generate Sanctum Token
        $token = $member->createToken('mobile-app')->plainTextToken;
        
        RateLimiter::clear($throttleKey);

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
            'member_id' => 'required|string|max:20|unique:member,member_id',
            'member_name' => 'required|string',
            'member_email' => 'required|email|unique:member,member_email',
            'member_phone' => 'required|string|unique:member,member_phone',
            'member_address' => 'required|string',
            'gender' => 'required|in:0,1',
            'password' => ['required', 'string', 'min:8', 'confirmed', new StrongPassword],
        ]);

        $member = Member::create([
            'member_id' => $request->member_id,
            'member_name' => $request->member_name,
            'member_email' => $request->member_email,
            'member_phone' => $request->member_phone,
            'member_address' => $request->member_address,
            'gender' => $request->gender,
            'mpasswd' => Hash::make($request->password),
            'inst_name' => 'Umum', // Default atau bisa disesuaikan
            'is_pending' => 1,
            'member_type_id' => 1,
            'member_image' => 'person.png',
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

    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'member' => $request->user()
            ]
        ]);
    }
    public function updateImage(Request $request)
    {
        $request->validate([
            'member_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $member = $request->user();

        if ($request->hasFile('member_image')) {
            $image = $request->file('member_image');
            $name = time() . '_' . $image->hashName();
            $destinationPath = public_path('/images/persons');
            
            if ($member->member_image && file_exists($destinationPath.'/'.$member->member_image)) {
                @unlink($destinationPath.'/'.$member->member_image);
            }
            
            $image->move($destinationPath, $name);
            
            Member::where('member_id', $member->member_id)->update(['member_image' => $name]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Foto profil berhasil diperbarui.',
                'image_url' => asset('images/persons/' . $name)
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengunggah foto.'
        ], 400);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', 'min:8', new StrongPassword],
        ]);

        $member = $request->user();

        $passwordMatches = false;
        if (Hash::check($request->old_password, $member->mpasswd)) {
            $passwordMatches = true;
        } elseif (hash('sha256', $request->old_password) === $member->mpasswd) {
            $passwordMatches = true;
        } elseif (md5($request->old_password) === $member->mpasswd) {
            $passwordMatches = true;
        }

        if (!$passwordMatches) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password lama tidak cocok.'
            ], 400);
        }

        Member::where('member_id', $member->member_id)->update([
            'mpasswd' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah.'
        ]);
    }
}

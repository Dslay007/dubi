<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Rules\StrongPassword;

class MemberRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('member.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|string|max:20|unique:member,member_id', // Ini NIK/NIM
            'member_name' => 'required|string|max:255',
            'member_email' => 'required|string|email|max:255|unique:member,member_email',
            'member_phone' => 'required|string|max:20|unique:member,member_phone',
            'member_address' => 'required|string',
            'gender' => 'required|in:0,1',
            'password' => ['required', 'string', 'min:8', 'confirmed', new StrongPassword],
        ]);

        $member = new Member();
        $member->member_id = $validated['member_id'];
        $member->nik = $validated['member_id']; // Kita tetap isi kolom nik agar aman dengan SLiMS
        $member->member_name = $validated['member_name'];
        $member->member_email = $validated['member_email'];
        $member->member_phone = $validated['member_phone'];
        $member->member_address = $validated['member_address'];
        $member->gender = $validated['gender'];
        $member->mpasswd = Hash::make($validated['password']); 
        
        $member->member_type_id = 1; // Default to Standard Member
        $member->member_image = 'person.png'; // Default image
        
        $member->is_pending = 1; // Menunggu verifikasi admin
        
        $member->input_date = now();
        $member->last_update = now();
        // register_date dan expire_date kita kosongkan atau set default, nanti diisi saat di-approve
        $member->register_date = null;
        $member->member_since_date = null;
        
        $member->save();

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang dalam status MASA TUNGGU. Silakan datang ke lapak baca dengan membawa KTP asli untuk verifikasi dan aktivasi akun.');
    }
}

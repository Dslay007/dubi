<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\StrongPassword;

class MemberController extends Controller
{
    public function dashboard()
    {
        $member = Auth::guard('member')->user();
        
        // Eager load loans with item and biblio info
        $loans = $member->loans()
            ->where('is_return', 0) // Only active loans
            ->with(['item.biblio'])
            ->orderBy('due_date', 'asc')
            ->get();
            
        // Get active reservations (status null, pending, approved, etc. - anything not completed/rejected)
        $reservations = $member->reservations()
            ->where(function($q) {
                $q->whereNull('status')
                  ->orWhereNotIn('status', ['completed', 'rejected']);
            })
            ->with(['item.biblio'])
            ->orderBy('reserve_date', 'desc')
            ->get();
            
        // Get Loan History
        $loanHistory = $member->loans()
            ->where('is_return', 1)
            ->with(['item.biblio'])
            ->orderBy('loan_date', 'desc')
            ->get();
            
        // Get Reservation History
        $reservationHistory = $member->reservations()
            ->whereNotNull('status')
            ->whereIn('status', ['completed', 'rejected'])
            ->with(['item.biblio'])
            ->orderBy('reserve_date', 'desc')
            ->get();

        // Get total visits
        $totalVisits = \App\Models\VisitorCount::where('member_id', $member->member_id)->count();

        return view('member.dashboard', compact('member', 'loans', 'reservations', 'loanHistory', 'reservationHistory', 'totalVisits'));
    }
    public function updateImage(Request $request)
    {
        $request->validate([
            'member_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $member = Auth::guard('member')->user();

        if ($request->hasFile('member_image')) {
            $image = $request->file('member_image');
            $name = time() . '_' . $image->hashName();
            $destinationPath = public_path('/images/persons');
            
            if ($member->member_image && file_exists($destinationPath.'/'.$member->member_image)) {
                @unlink($destinationPath.'/'.$member->member_image);
            }
            
            $image->move($destinationPath, $name);
            
            // Save using query to avoid needing fillable for this explicitly if it's not guarded
            \App\Models\Member::where('member_id', $member->member_id)->update(['member_image' => $name]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', 'min:8', 'confirmed', new StrongPassword],
        ]);

        $member = Auth::guard('member')->user();

        $passwordMatches = false;
        if (\Illuminate\Support\Facades\Hash::check($request->old_password, $member->mpasswd)) {
            $passwordMatches = true;
        } elseif (hash('sha256', $request->old_password) === $member->mpasswd) {
            $passwordMatches = true;
        } elseif (md5($request->old_password) === $member->mpasswd) {
            $passwordMatches = true;
        }

        if (!$passwordMatches) {
            return back()->withErrors(['old_password' => 'Password lama tidak cocok.']);
        }

        \App\Models\Member::where('member_id', $member->member_id)->update([
            'mpasswd' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemActivityController extends Controller
{
    public function index()
    {
        // Log Aktifitas
        $logs = DB::table('system_log')
            ->leftJoin('user', 'system_log.id', '=', 'user.username')
            ->select('system_log.*', 'user.username', 'user.realname')
            ->orderBy('log_date', 'desc')
            ->paginate(20, ['*'], 'log_page');

        // Status Akun Staff
        $users = DB::table('user')
            ->select('user.*')
            ->get();

        return view('admin.sistem.aktifitas.index', compact('logs', 'users'));
    }

    public function toggleUserStatus($id)
    {
        if ($id == 1 || $id == auth()->id()) {
            return back()->with('error', 'Tidak dapat menonaktifkan akun utama atau akun yang sedang digunakan.');
        }

        $user = DB::table('user')->where('user_id', $id)->first();
        if ($user) {
            // SLiMS doesn't strictly have an "is_active" field by default in old versions, but usually it's handled by groups or specific flags. 
            // If they don't have is_active, we might just simulate it or check if we can update the group.
            // Let's assume there is an active/inactive toggle if they asked for 'status akun'
            $currentStatus = $user->is_active ?? 1; // Default to 1 if not exists
            
            DB::table('user')->where('user_id', $id)->update([
                'is_active' => $currentStatus == 1 ? 0 : 1
            ]);
            
            return back()->with('success', 'Status akun berhasil diperbarui.');
        }

        return back()->with('error', 'User tidak ditemukan.');
    }
}

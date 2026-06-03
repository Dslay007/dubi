<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SystemLog
{
    /**
     * Tulis log aktifitas ke tabel system_log.
     * Fitur ini mengadopsi standar logging SLiMS.
     *
     * @param string $action    Aksi yang dilakukan ('insert', 'update', 'delete', 'login', dll)
     * @param string $logMsg    Pesan detail log
     * @param string $location  Modul utama (misal: 'Bibliography', 'Membership')
     * @param string $subModule Sub-modul (opsional)
     * @param string $logType   Tipe log ('staff', 'member', 'system')
     */
    public static function write($action, $logMsg, $location = 'Sistem', $subModule = '', $logType = 'staff')
    {
        try {
            // Ambil ID pengguna saat ini. 
            // SLiMS menggunakan 'username' sebagai 'id' di system_log
            $userId = null;
            if (Auth::guard('admin')->check()) {
                $user = Auth::guard('admin')->user();
                $userId = $user->username ?? $user->user_id ?? $user->id;
            } elseif (Auth::check()) {
                $user = Auth::user();
                $userId = $user->username ?? $user->user_id ?? $user->id;
            }

            DB::table('system_log')->insert([
                'log_type' => $logType,
                'id' => $userId,
                'log_location' => $location,
                'sub_module' => $subModule,
                'action' => $action,
                'log_msg' => $logMsg,
                'log_date' => now()
            ]);
        } catch (\Exception $e) {
            // Abaikan error log agar tidak mengganggu transaksi utama
            // Log::error('Gagal menulis system_log: ' . $e->getMessage());
        }
    }
}

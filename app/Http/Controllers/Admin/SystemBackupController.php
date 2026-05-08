<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SystemBackupController extends Controller
{
    public function index()
    {
        $backups = DB::table('backup_log')
            ->leftJoin('user', 'backup_log.user_id', '=', 'user.user_id')
            ->select('backup_log.*', 'user.username', 'user.realname')
            ->orderBy('backup_time', 'desc')
            ->paginate(20);

        return view('admin.sistem.backup', compact('backups'));
    }

    public function runBackup(Request $request)
    {
        // Simulasi pembuatan backup database (Di produksi, gunakan spatie/laravel-backup atau mysqldump)
        $fileName = 'backup_dudukbaca_' . date('Y_m_d_His') . '.sql';
        
        // Simpan file dummy untuk demonstrasi fitur
        Storage::disk('local')->put('backups/' . $fileName, '-- Dummy SQL Backup File generated at ' . Carbon::now());

        DB::table('backup_log')->insert([
            'user_id' => auth()->user()->user_id ?? 1,
            'backup_time' => Carbon::now(),
            'backup_file' => $fileName
        ]);

        return back()->with('success', "Backup database berhasil dibuat: {$fileName}");
    }
}

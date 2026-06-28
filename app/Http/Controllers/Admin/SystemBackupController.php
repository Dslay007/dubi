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
        $fileName = 'backup_dudukbaca_' . date('Y_m_d_His') . '.sql';
        $path = storage_path('app/backups/');
        
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $filePath = $path . $fileName;
        
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPass = env('DB_PASSWORD', '');
        $dbName = env('DB_DATABASE', 'dudukbaca');

        // Note: mysqldump must be available in system PATH
        $command = "mysqldump -h {$dbHost} -P {$dbPort} -u {$dbUser} ";
        if (!empty($dbPass)) {
            $command .= "-p{$dbPass} ";
        }
        $command .= "{$dbName} > {$filePath}";

        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return back()->withErrors(['Gagal membuat backup database. Pastikan mysqldump terinstall dan dapat diakses.']);
        }

        DB::table('backup_log')->insert([
            'user_id' => auth()->user()->user_id ?? 1,
            'backup_time' => Carbon::now(),
            'backup_file' => $fileName
        ]);

        return back()->with('success', "Backup database berhasil dibuat: {$fileName}");
    }
}

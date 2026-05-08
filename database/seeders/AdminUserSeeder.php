<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan role "Administrator" ada di user_group dengan group_id = 1
        $exists = DB::table('user_group')->where('group_id', 1)->first();
        if (!$exists) {
            DB::table('user_group')->insert([
                'group_id'   => 1,
                'group_name' => 'Administrator',
                'input_date' => now()->toDateString(),
                'last_update' => now()->toDateString(),
            ]);
            $this->command->info('✅ Role "Administrator" (group_id=1) berhasil dibuat.');
        } else {
            $this->command->info('ℹ️  Role "Administrator" sudah ada.');
        }

        // 2. Pastikan akun admin utama ada di tabel user
        $adminUser = DB::table('user')->where('username', 'admin')->first();
        if (!$adminUser) {
            DB::table('user')->insert([
                'username'    => 'admin',
                'realname'    => 'Administrator',
                'passwd'      => hash('sha256', 'admin'), // Password default: admin
                'email'       => null,
                'groups'      => 1, // Administrator Utama
                'user_type'   => 1,
                'is_active'   => 1,
                'input_date'  => now()->toDateString(),
                'last_update' => now()->toDateString(),
            ]);
            $this->command->info('✅ Akun admin utama berhasil dibuat (username: admin, password: admin).');
        } else {
            // Update groups ke 1 jika belum
            if ($adminUser->groups != 1) {
                DB::table('user')->where('username', 'admin')->update(['groups' => 1]);
                $this->command->info('✅ Akun "admin" sudah ada, groups diperbarui ke Administrator (1).');
            } else {
                $this->command->info('ℹ️  Akun admin utama sudah ada dengan role Administrator.');
            }
        }

        $this->command->warn('⚠️  Segera ganti password default setelah login!');
    }
}

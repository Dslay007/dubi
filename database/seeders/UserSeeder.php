<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Ensure admin exists and reset password
        $user = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'realname' => 'System Administrator',
                'passwd' => Hash::make('admin'), // Force Bcrypt
                'groups' => '1',
            ]
        );
        
        $this->command->info('Admin user seeded. Username: admin, Password: admin');
    }
}

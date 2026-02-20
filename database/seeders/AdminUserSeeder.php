<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['user_email' => 'admin@tadika.edu'],
            [
                'user_name' => 'Admin Tadika',
                'password' => Hash::make('admin123'),
                'user_role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user seeded: admin@tadika.edu / admin123');
    }
}


<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@tadika.edu')->exists()) {
            User::create([
                'name' => 'Admin Tadika',
                'email' => 'admin@tadika.edu',
                'password' => Hash::make('admin123'),
                'user_role' => 'admin',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('✅ Admin user created successfully!');
            $this->command->info('📧 Email: admin@tadika.edu');
            $this->command->info('🔑 Password: admin123');
        } else {
            $this->command->warn('⚠️ Admin user already exists. Skipping...');
        }
    }
}
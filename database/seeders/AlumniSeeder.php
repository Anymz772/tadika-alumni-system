<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $alumniData = [
            [
                'name' => 'Ahmad Farhan Abdullah',
                'alumni_email' => 'ahmad.farhan@tadika.edu',
                'alumni_name' => 'Ahmad Farhan bin Abdullah',
                'alumni_ic' => '950512-14-5678',
                'grad_year' => 2018,
                'workplace' => 'Google Malaysia',
                'position' => 'Senior Software Engineer',
                'phone' => '012-3456789',
                'alumni_address' => 'No 25, Jalan Mewah, Damansara Heights, 50490 Kuala Lumpur',
                'father' => 'Abdullah bin Hassan',
                'mother' => 'Siti Aminah binti Ahmad',
                'parent_phone' => '013-9876543'
            ],
            [
                'name' => 'Siti Nurul Hassan',
                'alumni_email' => 'siti.nurul@tadika.edu',
                'alumni_name' => 'Siti Nurul binti Hassan',
                'alumni_ic' => '970825-08-1234',
                'grad_year' => 2020,
                'workplace' => 'Sekolah Kebangsaan Taman Melati',
                'position' => 'Primary School Teacher',
                'phone' => '011-2233445',
                'alumni_address' => 'No 8, Lorong Aman, Taman Melati, 53100 Kuala Lumpur',
                'father' => 'Hassan bin Ismail',
                'mother' => 'Fatimah binti Yusof',
                'parent_phone' => '012-5566778'
            ],
            [
                'name' => 'Muhammad Ali Rahman',
                'alumni_email' => 'ali.rahman@tadika.edu',
                'alumni_name' => 'Muhammad Ali bin Rahman',
                'alumni_ic' => '960715-10-4567',
                'grad_year' => 2019,
                'workplace' => 'Maybank Berhad',
                'position' => 'Financial Analyst',
                'phone' => '016-7788990',
                'alumni_address' => 'No 15, Jalan Damai, Taman Tun Dr Ismail, 60000 KL',
                'father' => 'Rahman bin Omar',
                'mother' => 'Khadijah binti Musa',
                'parent_phone' => '019-3344556'
            ],
            [
                'name' => 'Nur Aisyah Mohd',
                'alumni_email' => 'nur.aisyah@tadika.edu',
                'alumni_name' => 'Nur Aisyah binti Mohd',
                'alumni_ic' => '981230-05-7890',
                'grad_year' => 2021,
                'workplace' => 'Hospital Kuala Lumpur',
                'position' => 'Medical Officer',
                'phone' => '017-9988776',
                'alumni_address' => 'No 42, Persiaran Indah, Bangsar, 59000 KL',
                'father' => 'Mohd bin Zulkifli',
                'mother' => 'Mariam binti Haris',
                'parent_phone' => '011-6655443'
            ],
            [
                'name' => 'Kamal Zulkifli',
                'alumni_email' => 'kamal.z@tadika.edu',
                'alumni_name' => 'Kamal bin Zulkifli',
                'alumni_ic' => '940320-12-3456',
                'grad_year' => 2017,
                'workplace' => 'Petronas',
                'position' => 'Project Manager',
                'phone' => '019-1122334',
                'alumni_address' => 'No 33, Jalan Bestari, Cyberjaya, 63000 Selangor',
                'father' => 'Zulkifli bin Ahmad',
                'mother' => 'Zainab binti Osman',
                'parent_phone' => '013-7788990'
            ]
        ];

        $createdCount = 0;

        foreach ($alumniData as $data) {
            // Check if user already exists
            if (User::where('alumni_email', $data['alumni_email'])->exists()) {
                $this->command->warn("⚠️ Skipping {$data['alumni_name']} - alumni_email already exists");
                continue;
            }

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'alumni_email' => $data['alumni_email'],
                'password' => Hash::make('password123'),
                'role' => 'alumni',
                'alumni_email_verified_at' => now(),
            ]);

            // Create alumni profile
            Alumni::create([
                'user_id' => $user->id,
                'alumni_name' => $data['alumni_name'],
                'alumni_ic' => $data['alumni_ic'],
                'grad_year' => $data['grad_year'],
                'current_workplace' => $data['workplace'],
                'job_position' => $data['position'],
                'alumni_phone' => $data['phone'],
                'alumni_address' => $data['alumni_address'],
                'father_name' => $data['father'],
                'mother_name' => $data['mother'],
                'parent_phone' => $data['parent_phone'],
                'alumni_email' => $data['alumni_email']
            ]);

            $createdCount++;
            $this->command->info("✅ Created alumni: {$data['alumni_name']}");
        }

        $this->command->info("\n🎓 Total created: {$createdCount} alumni");
        $this->command->info("📧 Login with any alumni alumni_email + password: password123");
    }
}
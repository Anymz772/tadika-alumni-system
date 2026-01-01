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
                'email' => 'ahmad.farhan@tadika.edu',
                'full_name' => 'Ahmad Farhan bin Abdullah',
                'ic_number' => '950512-14-5678',
                'year_graduated' => 2018,
                'workplace' => 'Google Malaysia',
                'position' => 'Senior Software Engineer',
                'phone' => '012-3456789',
                'address' => 'No 25, Jalan Mewah, Damansara Heights, 50490 Kuala Lumpur',
                'father' => 'Abdullah bin Hassan',
                'mother' => 'Siti Aminah binti Ahmad',
                'parent_phone' => '013-9876543'
            ],
            [
                'name' => 'Siti Nurul Hassan',
                'email' => 'siti.nurul@tadika.edu',
                'full_name' => 'Siti Nurul binti Hassan',
                'ic_number' => '970825-08-1234',
                'year_graduated' => 2020,
                'workplace' => 'Sekolah Kebangsaan Taman Melati',
                'position' => 'Primary School Teacher',
                'phone' => '011-2233445',
                'address' => 'No 8, Lorong Aman, Taman Melati, 53100 Kuala Lumpur',
                'father' => 'Hassan bin Ismail',
                'mother' => 'Fatimah binti Yusof',
                'parent_phone' => '012-5566778'
            ],
            [
                'name' => 'Muhammad Ali Rahman',
                'email' => 'ali.rahman@tadika.edu',
                'full_name' => 'Muhammad Ali bin Rahman',
                'ic_number' => '960715-10-4567',
                'year_graduated' => 2019,
                'workplace' => 'Maybank Berhad',
                'position' => 'Financial Analyst',
                'phone' => '016-7788990',
                'address' => 'No 15, Jalan Damai, Taman Tun Dr Ismail, 60000 KL',
                'father' => 'Rahman bin Omar',
                'mother' => 'Khadijah binti Musa',
                'parent_phone' => '019-3344556'
            ],
            [
                'name' => 'Nur Aisyah Mohd',
                'email' => 'nur.aisyah@tadika.edu',
                'full_name' => 'Nur Aisyah binti Mohd',
                'ic_number' => '981230-05-7890',
                'year_graduated' => 2021,
                'workplace' => 'Hospital Kuala Lumpur',
                'position' => 'Medical Officer',
                'phone' => '017-9988776',
                'address' => 'No 42, Persiaran Indah, Bangsar, 59000 KL',
                'father' => 'Mohd bin Zulkifli',
                'mother' => 'Mariam binti Haris',
                'parent_phone' => '011-6655443'
            ],
            [
                'name' => 'Kamal Zulkifli',
                'email' => 'kamal.z@tadika.edu',
                'full_name' => 'Kamal bin Zulkifli',
                'ic_number' => '940320-12-3456',
                'year_graduated' => 2017,
                'workplace' => 'Petronas',
                'position' => 'Project Manager',
                'phone' => '019-1122334',
                'address' => 'No 33, Jalan Bestari, Cyberjaya, 63000 Selangor',
                'father' => 'Zulkifli bin Ahmad',
                'mother' => 'Zainab binti Osman',
                'parent_phone' => '013-7788990'
            ]
        ];

        $createdCount = 0;

        foreach ($alumniData as $data) {
            // Check if user already exists
            if (User::where('email', $data['email'])->exists()) {
                $this->command->warn("⚠️ Skipping {$data['full_name']} - email already exists");
                continue;
            }

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'role' => 'alumni',
                'email_verified_at' => now(),
            ]);

            // Create alumni profile
            Alumni::create([
                'user_id' => $user->id,
                'full_name' => $data['full_name'],
                'ic_number' => $data['ic_number'],
                'year_graduated' => $data['year_graduated'],
                'current_workplace' => $data['workplace'],
                'job_position' => $data['position'],
                'contact_number' => $data['phone'],
                'address' => $data['address'],
                'father_name' => $data['father'],
                'mother_name' => $data['mother'],
                'parent_contact' => $data['parent_phone'],
                'email' => $data['email']
            ]);

            $createdCount++;
            $this->command->info("✅ Created alumni: {$data['full_name']}");
        }

        $this->command->info("\n🎓 Total created: {$createdCount} alumni");
        $this->command->info("📧 Login with any alumni email + password: password123");
    }
}
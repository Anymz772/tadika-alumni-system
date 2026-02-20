<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Tadika;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlumniProfileSeeder extends Seeder
{
    public function run(): void
    {
        $tadikaByName = Tadika::query()->get()->keyBy('tadika_name');

        $rows = [
            [
                'user_name' => 'Aiman Farid',
                'user_email' => 'aiman.farid@alumni.edu',
                'alumni_name' => 'Aiman Farid bin Rahman',
                'alumni_ic' => '970210-10-1234',
                'grad_year' => 2015,
                'alumni_status' => 'working',
                'company' => 'TechVentures',
                'job_position' => 'Software Engineer',
                'alumni_phone' => '0124567890',
                'alumni_state' => 'SELANGOR',
                'alumni_district' => 'PETALING',
                'alumni_postcode' => '40100',
                'alumni_address' => 'Seksyen 7, Shah Alam',
                'tadika_name' => 'Tadika Cahaya Ilmu',
                'gender' => 'male',
                'age' => 29,
                'father_name' => 'Farid Rahman',
                'mother_name' => 'Siti Mariam',
                'parent_phone' => '0131122334',
            ],
            [
                'user_name' => 'Nur Izzati',
                'user_email' => 'nur.izzati@alumni.edu',
                'alumni_name' => 'Nur Izzati binti Hamzah',
                'alumni_ic' => '980722-08-5678',
                'grad_year' => 2016,
                'alumni_status' => 'studying',
                'institution' => 'Universiti Malaya',
                'alumni_phone' => '01134567890',
                'alumni_state' => 'SELANGOR',
                'alumni_district' => 'KLANG',
                'alumni_postcode' => '41000',
                'alumni_address' => 'Bandar Bukit Tinggi',
                'tadika_name' => 'Tadika Mutiara Bestari',
                'gender' => 'female',
                'age' => 28,
                'father_name' => 'Hamzah Osman',
                'mother_name' => 'Rohani Salmah',
                'parent_phone' => '0172233445',
            ],
            [
                'user_name' => 'Daniel Hakim',
                'user_email' => 'daniel.hakim@alumni.edu',
                'alumni_name' => 'Daniel Hakim bin Kamal',
                'alumni_ic' => '990101-14-2468',
                'grad_year' => 2017,
                'alumni_status' => 'working',
                'company' => 'EduSpark',
                'job_position' => 'Project Executive',
                'alumni_phone' => '0197788990',
                'alumni_state' => 'SELANGOR',
                'alumni_district' => 'GOMBAK',
                'alumni_postcode' => '53100',
                'alumni_address' => 'Taman Melawati',
                'tadika_name' => 'Tadika Bistari Pintar',
                'gender' => 'male',
                'age' => 27,
                'father_name' => 'Kamaluddin',
                'mother_name' => 'Hasnah',
                'parent_phone' => '0126677889',
            ],
            [
                'user_name' => 'Farah Anis',
                'user_email' => 'farah.anis@alumni.edu',
                'alumni_name' => 'Farah Anis binti Zulkifli',
                'alumni_ic' => '000512-10-9753',
                'grad_year' => 2018,
                'alumni_status' => 'working',
                'company' => 'MediCare Plus',
                'job_position' => 'Assistant Pharmacist',
                'alumni_phone' => '0182233556',
                'alumni_state' => 'SELANGOR',
                'alumni_district' => 'PETALING',
                'alumni_postcode' => '40100',
                'alumni_address' => 'U13 Shah Alam',
                'tadika_name' => 'Tadika Cahaya Ilmu',
                'gender' => 'female',
                'age' => 26,
                'father_name' => 'Zulkifli Arif',
                'mother_name' => 'Maimunah',
                'parent_phone' => '0163344556',
            ],
        ];

        foreach ($rows as $row) {
            $user = User::updateOrCreate(
                ['user_email' => $row['user_email']],
                [
                    'user_name' => $row['user_name'],
                    'password' => Hash::make('password123'),
                    'user_role' => 'alumni',
                    'email_verified_at' => now(),
                ]
            );

            $tadika = $tadikaByName->get($row['tadika_name']);

            Alumni::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'tadika_id' => $tadika?->tadika_id,
                    'alumni_name' => $row['alumni_name'],
                    'alumni_ic' => $row['alumni_ic'],
                    'grad_year' => $row['grad_year'],
                    'alumni_status' => $row['alumni_status'],
                    'institution' => $row['institution'] ?? null,
                    'company' => $row['company'] ?? null,
                    'job_position' => $row['job_position'] ?? null,
                    'alumni_phone' => $row['alumni_phone'],
                    'alumni_state' => $row['alumni_state'],
                    'alumni_district' => $row['alumni_district'],
                    'alumni_postcode' => $row['alumni_postcode'],
                    'alumni_address' => $row['alumni_address'],
                    'tadika_name' => $row['tadika_name'],
                    'gender' => $row['gender'],
                    'age' => $row['age'],
                    'father_name' => $row['father_name'],
                    'mother_name' => $row['mother_name'],
                    'parent_phone' => $row['parent_phone'],
                    'alumni_email' => $row['user_email'],
                ]
            );
        }

        $this->command->info('Alumni profiles seeded (password: password123).');
    }
}


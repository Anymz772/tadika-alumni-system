<?php

namespace Database\Seeders;

use App\Models\Tadika;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TadikaProfileSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'user_name' => 'Tadika Cahaya Owner',
                'user_email' => 'owner.cahaya@tadika.edu',
                'tadika_name' => 'Tadika Cahaya Ilmu',
                'tadika_reg_no' => 'TDI-0001',
                'tadika_address' => 'No 12, Jalan Anggerik 1, Seksyen 4',
                'tadika_district' => 'PETALING',
                'tadika_state' => 'SELANGOR',
                'tadika_postcode' => '40100',
                'tadika_phone' => '0123344556',
                'tadika_email' => 'contact.cahaya@tadika.edu',
                'tadika_owner' => 'Puan Sofia',
                'tadika_location' => 'Shah Alam',
            ],
            [
                'user_name' => 'Tadika Mutiara Owner',
                'user_email' => 'owner.mutiara@tadika.edu',
                'tadika_name' => 'Tadika Mutiara Bestari',
                'tadika_reg_no' => 'TDI-0002',
                'tadika_address' => 'No 8, Jalan Cempaka 2, Bandar Baru',
                'tadika_district' => 'KLANG',
                'tadika_state' => 'SELANGOR',
                'tadika_postcode' => '41000',
                'tadika_phone' => '01122334455',
                'tadika_email' => 'contact.mutiara@tadika.edu',
                'tadika_owner' => 'En Amir',
                'tadika_location' => 'Klang',
            ],
            [
                'user_name' => 'Tadika Bistari Owner',
                'user_email' => 'owner.bistari@tadika.edu',
                'tadika_name' => 'Tadika Bistari Pintar',
                'tadika_reg_no' => 'TDI-0003',
                'tadika_address' => 'No 5, Jalan Kenanga 7, Taman Harmoni',
                'tadika_district' => 'GOMBAK',
                'tadika_state' => 'SELANGOR',
                'tadika_postcode' => '53100',
                'tadika_phone' => '0135566778',
                'tadika_email' => 'contact.bistari@tadika.edu',
                'tadika_owner' => 'Pn Hana',
                'tadika_location' => 'Gombak',
            ],
        ];

        foreach ($rows as $row) {
            $owner = User::updateOrCreate(
                ['user_email' => $row['user_email']],
                [
                    'user_name' => $row['user_name'],
                    'password' => Hash::make('password123'),
                    'user_role' => 'tadika',
                    'email_verified_at' => now(),
                ]
            );

            Tadika::updateOrCreate(
                ['owner_user_id' => $owner->user_id],
                [
                    'tadika_name' => $row['tadika_name'],
                    'tadika_reg_no' => $row['tadika_reg_no'],
                    'tadika_address' => $row['tadika_address'],
                    'tadika_district' => $row['tadika_district'],
                    'tadika_state' => $row['tadika_state'],
                    'tadika_postcode' => $row['tadika_postcode'],
                    'tadika_phone' => $row['tadika_phone'],
                    'tadika_email' => $row['tadika_email'],
                    'tadika_owner' => $row['tadika_owner'],
                    'tadika_location' => $row['tadika_location'],
                ]
            );
        }

        $this->command->info('Tadika profiles seeded (password: password123 for owners).');
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $doctorRole = DB::table('roles')->where('name', 'doctor')->first();
        $staffRole = DB::table('roles')->where('name', 'staff')->first();
        $patientRole = DB::table('roles')->where('name', 'patient')->first();

        $users = [
            [
                'name' => 'Dr. Renu',
                'email' => 'renu@drrenudentalclinic.com',
                'phone' => '+91 9650935061',
                'role_id' => $adminRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Ravi Chaudhary',
                'email' => 'ravi.chaudhary@drrenudentalclinic.com',
                'phone' => '+91 98290 84920',
                'role_id' => $doctorRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Neha Agarwal',
                'email' => 'neha.agarwal@drrenudentalclinic.com',
                'phone' => '+91 98291 11223',
                'role_id' => $doctorRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Pooja Sharma',
                'email' => 'pooja.sharma@drrenudentalclinic.com',
                'phone' => '+91 98292 77889',
                'role_id' => $staffRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Sunil Meena',
                'email' => 'sunil.meena@drrenudentalclinic.com',
                'phone' => '+91 98293 44556',
                'role_id' => $staffRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Kavita Rathore',
                'email' => 'kavita.rathore@drrenudentalclinic.com',
                'phone' => '+91 98294 11223',
                'role_id' => $staffRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Rahul Sharma',
                'email' => 'rahul.sharma@example.com',
                'phone' => '+91 98290 12345',
                'role_id' => $patientRole?->id,
                'status' => 'active',
            ],
        ];

        foreach ($users as $u) {
            $existing = DB::table('users')->where('phone', $u['phone'])->first();

            DB::table('users')->updateOrInsert(
                ['phone' => $u['phone']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'clinic_id' => $clinic?->id,
                    'role_id' => $u['role_id'],
                    'name' => $u['name'],
                    'email' => $u['email'],
                    'phone_verified_at' => now(),
                    'email_verified_at' => now(),
                    'password' => Hash::make('Clinic@123'),
                    'status' => $u['status'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Clinic Administrator & Chief Dentist',
                'description' => 'Full administrative, financial, and clinical management privileges across all clinic modules.',
            ],
            [
                'name' => 'doctor',
                'display_name' => 'Consultant Dental Surgeon',
                'description' => 'Clinical access for patient examination, 32-tooth odontogram, treatment planning, prescriptions, and surgery logs.',
            ],
            [
                'name' => 'staff',
                'display_name' => 'Front Desk & Chairside Staff',
                'description' => 'Operatory queue management, patient check-in, appointment scheduling, billing, and inventory tracking.',
            ],
            [
                'name' => 'patient',
                'display_name' => 'Registered Clinic Patient',
                'description' => 'Patient portal access for viewing personal treatment timelines, prescription downloads, and invoice payments.',
            ],
        ];

        foreach ($roles as $role) {
            $existing = DB::table('roles')->where('name', $role['name'])->first();

            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'display_name' => $role['display_name'],
                    'description' => $role['description'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

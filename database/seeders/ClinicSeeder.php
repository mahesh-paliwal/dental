<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinicData = [
            'name' => 'Dr. Renu Dental Clinic',
            'code' => 'DR-RENU-JAIPUR',
            'registration_number' => 'RJ-DC-2015-8492',
            'certifications' => 'CBCT and GBT certified',
            'phone' => '+91 9650935061',
            'email' => 'renu@drrenudentalclinic.com',
            'address_line1' => '33, Shiv Shakti Nagar',
            'address_line2' => 'Nirman Nagar',
            'city' => 'Jaipur',
            'state' => 'Rajasthan',
            'postal_code' => '302019',
            'country' => 'India',
            'timezone' => 'Asia/Kolkata',
            'is_active' => true,
        ];

        $existing = DB::table('clinics')->where('code', $clinicData['code'])->first();

        DB::table('clinics')->updateOrInsert(
            ['code' => $clinicData['code']],
            array_merge($clinicData, [
                'id' => $existing ? $existing->id : (string) Str::uuid(),
                'created_at' => $existing ? $existing->created_at : now(),
                'updated_at' => now(),
            ])
        );
    }
}

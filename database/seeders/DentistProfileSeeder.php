<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DentistProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $renuUser = DB::table('users')->where('email', 'renu@drrenudentalclinic.com')->first();
        $raviUser = DB::table('users')->where('email', 'ravi.chaudhary@drrenudentalclinic.com')->first();
        $nehaUser = DB::table('users')->where('email', 'neha.agarwal@drrenudentalclinic.com')->first();

        $dentists = [
            [
                'user_id' => $renuUser?->id,
                'license_number' => 'DCI-RJ-8492',
                'designation' => 'Chief Dental Surgeon & Founder',
                'specialization' => 'chief_dentist',
                'qualification' => 'BDS, MDS (Oral & Maxillofacial Pathology)',
                'bio' => '14+ Years of clinical experience in Endodontics, Single-Visit RCT, and Cosmetic Smile Makeovers. Founder of Dr. Renu Dental Clinic.',
                'consultation_fee' => 500.00,
            ],
            [
                'user_id' => $raviUser?->id,
                'license_number' => 'DCI-RJ-7612',
                'designation' => 'Senior Consultant Implantologist',
                'specialization' => 'implantologist',
                'qualification' => 'BDS, MDS (Prosthodontics & Implantology)',
                'bio' => '12+ Years experience in Dental Implants, Full Mouth Rehabilitation, Crowns & Bridges.',
                'consultation_fee' => 700.00,
            ],
            [
                'user_id' => $nehaUser?->id,
                'license_number' => 'DCI-RJ-9104',
                'designation' => 'Visiting Orthodontist & Aligner Specialist',
                'specialization' => 'orthodontist',
                'qualification' => 'BDS, MDS (Orthodontics)',
                'bio' => '9+ Years experience in Invisible Clear Aligners, Damon Self-Ligating Braces, and Lingual Orthodontics.',
                'consultation_fee' => 600.00,
            ],
        ];

        foreach ($dentists as $doc) {
            if (! $doc['user_id']) {
                continue;
            }

            $existing = DB::table('dentist_profiles')->where('user_id', $doc['user_id'])->first();

            DB::table('dentist_profiles')->updateOrInsert(
                ['user_id' => $doc['user_id']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'license_number' => $doc['license_number'],
                    'designation' => $doc['designation'],
                    'specialization' => $doc['specialization'],
                    'qualification' => $doc['qualification'],
                    'bio' => $doc['bio'],
                    'consultation_fee' => $doc['consultation_fee'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

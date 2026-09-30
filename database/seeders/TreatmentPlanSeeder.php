<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TreatmentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rahul = DB::table('patients')->where('patient_id', 'RD-2024-0412')->first();
        $priya = DB::table('patients')->where('patient_id', 'RD-2024-0589')->first();
        $amit = DB::table('patients')->where('patient_id', 'RD-2024-0195')->first();
        $sunita = DB::table('patients')->where('patient_id', 'RD-2024-0714')->first();

        $renuDoc = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Renu')
            ->select('dentist_profiles.id')
            ->first();

        $raviDoc = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Ravi Chaudhary')
            ->select('dentist_profiles.id')
            ->first();

        $nehaDoc = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Neha Agarwal')
            ->select('dentist_profiles.id')
            ->first();

        $plans = [
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'title' => 'Single-Visit RCT with Monolithic Zirconia Crown (#16, #15)',
                'treatment_type' => 'rct',
                'status' => 'completed',
                'total_estimated_cost' => 13000.00,
                'start_date' => '2026-09-12',
                'expected_completion_date' => '2026-09-20',
                'notes' => 'Endodontic protocol with rotary shaping, bioceramic obturation, and CAD/CAM milled monolithic crown.',
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'title' => 'Full Course Invisible Clear Aligners Orthodontic Therapy',
                'treatment_type' => 'aligners',
                'status' => 'active',
                'total_estimated_cost' => 75000.00,
                'start_date' => '2026-03-01',
                'expected_completion_date' => '2026-12-31',
                'notes' => '25-aligner series with composite attachments and targeted anterior IPR. 22 hours daily compliance.',
            ],
            [
                'patient_id' => $amit?->id,
                'doctor_id' => $raviDoc?->id,
                'title' => 'Computer-Guided Titanium Dental Implant Surgery (#46)',
                'treatment_type' => 'implants',
                'status' => 'active',
                'total_estimated_cost' => 28000.00,
                'start_date' => '2026-09-05',
                'expected_completion_date' => '2026-12-15',
                'notes' => 'CBCT-planned flapless surgical placement of Osstem TSIII fixture with 3-month osseointegration period.',
            ],
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'title' => 'Anterior Aesthetic Smile Design (4 IPS e.max Porcelain Veneers)',
                'treatment_type' => 'crowns_bridges',
                'status' => 'completed',
                'total_estimated_cost' => 44000.00,
                'start_date' => '2026-09-16',
                'expected_completion_date' => '2026-09-24',
                'notes' => 'Minimally invasive enamel preparation on teeth 12, 11, 21, 22. Adhesive cementation under dental dam.',
            ],
        ];

        foreach ($plans as $p) {
            if (! $p['patient_id'] || ! $p['doctor_id']) {
                continue;
            }

            $existing = DB::table('treatment_plans')
                ->where('patient_id', $p['patient_id'])
                ->where('title', $p['title'])
                ->first();

            DB::table('treatment_plans')->updateOrInsert(
                [
                    'patient_id' => $p['patient_id'],
                    'title' => $p['title'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'doctor_id' => $p['doctor_id'],
                    'treatment_type' => $p['treatment_type'],
                    'status' => $p['status'],
                    'total_estimated_cost' => $p['total_estimated_cost'],
                    'start_date' => $p['start_date'],
                    'expected_completion_date' => $p['expected_completion_date'],
                    'notes' => $p['notes'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

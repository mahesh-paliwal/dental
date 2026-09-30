<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TreatmentTimelineSeeder extends Seeder
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

        $p01 = DB::table('dental_procedures')->where('code', 'P01')->first();
        $p03 = DB::table('dental_procedures')->where('code', 'P03')->first();
        $p04 = DB::table('dental_procedures')->where('code', 'P04')->first();
        $p06 = DB::table('dental_procedures')->where('code', 'P06')->first();
        $p07 = DB::table('dental_procedures')->where('code', 'P07')->first();
        $p08 = DB::table('dental_procedures')->where('code', 'P08')->first();
        $p09 = DB::table('dental_procedures')->where('code', 'P09')->first();

        $timelines = [
            // Rahul Sharma
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'procedure_id' => $p04?->id,
                'procedure_name' => 'Zirconia High-Translucency Crown',
                'tooth_number' => '15',
                'treatment_date' => '2026-09-20',
                'clinical_notes' => 'Trial done, occlusion checked and cemented with RelyX U200. Patient comfortable.',
                'cost' => 8500.00,
            ],
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'procedure_id' => $p01?->id,
                'procedure_name' => 'Single Visit Root Canal Treatment (RCT)',
                'tooth_number' => '16',
                'treatment_date' => '2026-09-12',
                'clinical_notes' => 'Biomechanical preparation using rotary Protaper Gold. Obturation with Gutta-percha & AH Plus.',
                'cost' => 4500.00,
            ],
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $raviDoc?->id,
                'procedure_id' => $p07?->id,
                'procedure_name' => 'Teeth Scaling & Polishing (EMS Guided Biofilm)',
                'tooth_number' => 'FM',
                'treatment_date' => '2026-06-10',
                'clinical_notes' => 'Supragingival calculus removed. Subgingival airflow with erythritol powder. Oral hygiene instructions given.',
                'cost' => 1500.00,
            ],

            // Priya Verma
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'procedure_id' => $p06?->id,
                'procedure_name' => 'Invisible Clear Aligners - Progress Review',
                'tooth_number' => '11-41',
                'treatment_date' => '2026-09-18',
                'clinical_notes' => 'Delivered aligner set #14 through #18. Good tracking. Patient instructed to wear 22 hrs daily.',
                'cost' => 0.00,
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $renuDoc?->id,
                'procedure_id' => $p08?->id,
                'procedure_name' => 'Zoom In-Office Teeth Whitening (1 Hour)',
                'tooth_number' => 'FM',
                'treatment_date' => '2026-04-10',
                'clinical_notes' => '3 cycles of 15 min Philips Zoom WhiteSpeed. Shade improved from A3 to B1.',
                'cost' => 9000.00,
            ],

            // Amit Meena
            [
                'patient_id' => $amit?->id,
                'doctor_id' => $raviDoc?->id,
                'procedure_id' => $p03?->id,
                'procedure_name' => 'Dental Implant (Titanium - Nobel Biocare/Osstem)',
                'tooth_number' => '46',
                'treatment_date' => '2026-09-15',
                'clinical_notes' => 'Flapless computer guided implant placement. Primary stability 40 Ncm achieved. Healing abutment placed.',
                'cost' => 28000.00,
            ],

            // Sunita Rajawat
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'procedure_id' => $p09?->id,
                'procedure_name' => 'Porcelain Veneers / Smile Design',
                'tooth_number' => '12-22',
                'treatment_date' => '2026-09-24',
                'clinical_notes' => 'Final bonding of 4 anterior IPS e.max veneers with Variolink Esthetic. Margins polished, smile aesthetics approved by patient.',
                'cost' => 44000.00,
            ],
        ];

        foreach ($timelines as $t) {
            if (! $t['patient_id'] || ! $t['doctor_id']) {
                continue;
            }

            $existing = DB::table('treatment_timelines')
                ->where('patient_id', $t['patient_id'])
                ->where('treatment_date', $t['treatment_date'])
                ->where('procedure_name', $t['procedure_name'])
                ->first();

            DB::table('treatment_timelines')->updateOrInsert(
                [
                    'patient_id' => $t['patient_id'],
                    'treatment_date' => $t['treatment_date'],
                    'procedure_name' => $t['procedure_name'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'doctor_id' => $t['doctor_id'],
                    'procedure_id' => $t['procedure_id'],
                    'tooth_number' => $t['tooth_number'],
                    'clinical_notes' => $t['clinical_notes'],
                    'cost' => $t['cost'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

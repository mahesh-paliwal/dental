<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DentalChartSeeder extends Seeder
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

        $charts = [
            // Rahul Sharma
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 16,
                'status' => 'completed_rct',
                'clinical_notes_material' => 'Single visit RCT with bioceramic sealer and gutta percha obturation',
                'updated_at_clinical' => '2026-09-12 11:30:00',
            ],
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 15,
                'status' => 'zirconia_ceramic_crown',
                'clinical_notes_material' => 'Shade A2 monolithic multilayer zirconia crown cemented with RelyX U200',
                'updated_at_clinical' => '2026-09-20 11:45:00',
            ],
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 26,
                'status' => 'caries',
                'clinical_notes_material' => 'Class I occlusal cavity with active dentinal caries, scheduled for restoration',
                'updated_at_clinical' => '2026-09-20 12:00:00',
            ],
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 36,
                'status' => 'extracted_missing',
                'clinical_notes_material' => 'Extracted in 2023 due to chronic apical abscess; dental implant placement recommended',
                'updated_at_clinical' => '2026-01-15 10:00:00',
            ],
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 46,
                'status' => 'composite_filling',
                'clinical_notes_material' => 'Class I occlusal nano-hybrid composite restoration with 3M Filtek Z350',
                'updated_at_clinical' => '2026-06-10 12:30:00',
            ],

            // Priya Verma (Aligners)
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'tooth_number' => 11,
                'status' => 'healthy',
                'clinical_notes_material' => 'Clear Aligner Tray #14 tracking nicely, composite attachment intact',
                'updated_at_clinical' => '2026-09-18 17:00:00',
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'tooth_number' => 21,
                'status' => 'healthy',
                'clinical_notes_material' => 'Clear Aligner Tray #14 tracking nicely, composite attachment intact',
                'updated_at_clinical' => '2026-09-18 17:00:00',
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'tooth_number' => 31,
                'status' => 'healthy',
                'clinical_notes_material' => 'IPR 0.2mm performed, crowding relieved',
                'updated_at_clinical' => '2026-09-18 17:00:00',
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'tooth_number' => 41,
                'status' => 'healthy',
                'clinical_notes_material' => 'Crowding resolved by 80%',
                'updated_at_clinical' => '2026-09-18 17:00:00',
            ],

            // Amit Meena
            [
                'patient_id' => $amit?->id,
                'doctor_id' => $raviDoc?->id,
                'tooth_number' => 46,
                'status' => 'titanium_implant',
                'clinical_notes_material' => 'Osstem TSIII 4.5x10mm titanium fixture placed with 40 Ncm primary stability',
                'updated_at_clinical' => '2026-09-15 16:30:00',
            ],
            [
                'patient_id' => $amit?->id,
                'doctor_id' => $raviDoc?->id,
                'tooth_number' => 47,
                'status' => 'zirconia_ceramic_crown',
                'clinical_notes_material' => 'Existing ceramic crown in functional occlusion',
                'updated_at_clinical' => '2026-02-18 11:00:00',
            ],

            // Sunita Rajawat (Smile Makeover - 4 Veneers)
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 11,
                'status' => 'porcelain_veneer',
                'clinical_notes_material' => 'IPS e.max CAD lithium disilicate veneer bonded with Variolink Esthetic',
                'updated_at_clinical' => '2026-09-24 12:00:00',
            ],
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 12,
                'status' => 'porcelain_veneer',
                'clinical_notes_material' => 'IPS e.max CAD lithium disilicate veneer bonded with Variolink Esthetic',
                'updated_at_clinical' => '2026-09-24 12:00:00',
            ],
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 21,
                'status' => 'porcelain_veneer',
                'clinical_notes_material' => 'IPS e.max CAD lithium disilicate veneer bonded with Variolink Esthetic',
                'updated_at_clinical' => '2026-09-24 12:00:00',
            ],
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'tooth_number' => 22,
                'status' => 'porcelain_veneer',
                'clinical_notes_material' => 'IPS e.max CAD lithium disilicate veneer bonded with Variolink Esthetic',
                'updated_at_clinical' => '2026-09-24 12:00:00',
            ],
        ];

        foreach ($charts as $c) {
            if (! $c['patient_id'] || ! $c['doctor_id']) {
                continue;
            }

            $existing = DB::table('dental_charts')
                ->where('patient_id', $c['patient_id'])
                ->where('tooth_number', $c['tooth_number'])
                ->first();

            DB::table('dental_charts')->updateOrInsert(
                [
                    'patient_id' => $c['patient_id'],
                    'tooth_number' => $c['tooth_number'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'doctor_id' => $c['doctor_id'],
                    'status' => $c['status'],
                    'clinical_notes_material' => $c['clinical_notes_material'],
                    'updated_at_clinical' => $c['updated_at_clinical'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientMedicalHistorySeeder extends Seeder
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
        $staff = DB::table('users')->where('email', 'pooja.sharma@drrenudentalclinic.com')->first();

        $histories = [
            [
                'patient_id' => $rahul?->id,
                'allergies' => 'No known drug allergies. Tolerates local anesthesia (Lignocaine with Adrenaline).',
                'has_diabetes' => false,
                'has_hypertension' => true,
                'has_cardiac_disease' => false,
                'has_bleeding_disorder' => false,
                'is_pregnant' => false,
                'current_medications' => 'Tab Telmisartan 20mg once daily',
                'medical_notes' => 'Patient has mild essential hypertension under active physician control. Blood pressure recorded at 128/82 mmHg on examination.',
            ],
            [
                'patient_id' => $priya?->id,
                'allergies' => 'None',
                'has_diabetes' => false,
                'has_hypertension' => false,
                'has_cardiac_disease' => false,
                'has_bleeding_disorder' => false,
                'is_pregnant' => false,
                'current_medications' => 'None',
                'medical_notes' => 'No systemic medical contraindications. Cleared for comprehensive orthodontic aligner therapy.',
            ],
            [
                'patient_id' => $amit?->id,
                'allergies' => 'None reported',
                'has_diabetes' => true,
                'has_hypertension' => false,
                'has_cardiac_disease' => false,
                'has_bleeding_disorder' => false,
                'is_pregnant' => false,
                'current_medications' => 'Tab Metformin 500mg BD after meals',
                'medical_notes' => 'Type 2 Diabetes well-regulated. Fasting blood sugar 112 mg/dL, HbA1c 6.4%. Osseointegration prognosis favorable for implant surgery.',
            ],
            [
                'patient_id' => $sunita?->id,
                'allergies' => 'None',
                'has_diabetes' => false,
                'has_hypertension' => false,
                'has_cardiac_disease' => false,
                'has_bleeding_disorder' => false,
                'is_pregnant' => false,
                'current_medications' => 'None',
                'medical_notes' => 'Excellent general health. Full clearance for elective cosmetic dental procedures.',
            ],
        ];

        foreach ($histories as $h) {
            if (! $h['patient_id']) {
                continue;
            }

            $existing = DB::table('patient_medical_histories')->where('patient_id', $h['patient_id'])->first();

            DB::table('patient_medical_histories')->updateOrInsert(
                ['patient_id' => $h['patient_id']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'allergies' => $h['allergies'],
                    'has_diabetes' => $h['has_diabetes'],
                    'has_hypertension' => $h['has_hypertension'],
                    'has_cardiac_disease' => $h['has_cardiac_disease'],
                    'has_bleeding_disorder' => $h['has_bleeding_disorder'],
                    'is_pregnant' => $h['is_pregnant'],
                    'current_medications' => $h['current_medications'],
                    'medical_notes' => $h['medical_notes'],
                    'recorded_by_user_id' => $staff?->id,
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

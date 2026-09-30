<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();

        // Get doctors
        $renuProfile = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Renu')
            ->select('dentist_profiles.id')
            ->first();

        $raviProfile = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Ravi Chaudhary')
            ->select('dentist_profiles.id')
            ->first();

        $nehaProfile = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Neha Agarwal')
            ->select('dentist_profiles.id')
            ->first();

        $patients = [
            [
                'patient_id' => 'RD-2024-0412',
                'full_name' => 'Rahul Sharma',
                'phone' => '+91 98290 12345',
                'age' => 34,
                'date_of_birth' => '1992-04-14',
                'gender' => 'male',
                'blood_group' => 'B+',
                'city' => 'Jaipur',
                'residential_address' => 'B-42, Shyam Nagar, Ajmer Road, Jaipur, Rajasthan 302019',
                'medical_alerts' => 'Mild Hypertension; No known drug allergies',
                'attending_doctor_id' => $renuProfile?->id,
                'treatment_status' => 'active_treatments',
                'billing_balance' => 0.00,
                'recent_treatment' => 'Zirconia High-Translucency Crown (#15)',
                'last_visit_at' => '2026-09-20 11:00:00',
            ],
            [
                'patient_id' => 'RD-2024-0589',
                'full_name' => 'Priya Verma',
                'phone' => '+91 98291 56789',
                'age' => 28,
                'date_of_birth' => '1998-07-22',
                'gender' => 'female',
                'blood_group' => 'O+',
                'city' => 'Jaipur',
                'residential_address' => 'Plot 18, Vaishali Nagar, Jaipur, Rajasthan 302021',
                'medical_alerts' => 'None',
                'attending_doctor_id' => $nehaProfile?->id,
                'treatment_status' => 'active_treatments',
                'billing_balance' => 20000.00,
                'recent_treatment' => 'Invisible Clear Aligners - Progress Review',
                'last_visit_at' => '2026-09-18 17:30:00',
            ],
            [
                'patient_id' => 'RD-2024-0195',
                'full_name' => 'Amit Meena',
                'phone' => '+91 98292 34567',
                'age' => 52,
                'date_of_birth' => '1974-11-05',
                'gender' => 'male',
                'blood_group' => 'A+',
                'city' => 'Jaipur',
                'residential_address' => '74, Nirman Nagar East, Janpath, Jaipur, Rajasthan 302019',
                'medical_alerts' => 'Type 2 Diabetes (Controlled - HbA1c 6.4)',
                'attending_doctor_id' => $raviProfile?->id,
                'treatment_status' => 'active_treatments',
                'billing_balance' => 0.00,
                'recent_treatment' => 'Dental Implant (Titanium - Nobel Biocare/Osstem)',
                'last_visit_at' => '2026-09-15 16:30:00',
            ],
            [
                'patient_id' => 'RD-2024-0714',
                'full_name' => 'Sunita Rajawat',
                'phone' => '+91 98293 78901',
                'age' => 44,
                'date_of_birth' => '1982-05-19',
                'gender' => 'female',
                'blood_group' => 'AB+',
                'city' => 'Jaipur',
                'residential_address' => 'C-12, Officers Campus, Sirsi Road, Jaipur, Rajasthan 302012',
                'medical_alerts' => 'None',
                'attending_doctor_id' => $renuProfile?->id,
                'treatment_status' => 'completed',
                'billing_balance' => 0.00,
                'recent_treatment' => 'Porcelain Veneers / Smile Design',
                'last_visit_at' => '2026-09-24 12:15:00',
            ],
            [
                'patient_id' => 'RD-2024-0820',
                'full_name' => 'Vikram Rathore',
                'phone' => '+91 98294 56712',
                'age' => 38,
                'date_of_birth' => '1988-02-10',
                'gender' => 'male',
                'blood_group' => 'B+',
                'city' => 'Jaipur',
                'residential_address' => 'Sector 7, Mansarovar, Jaipur, Rajasthan 302020',
                'medical_alerts' => 'None',
                'attending_doctor_id' => $renuProfile?->id,
                'treatment_status' => 'active_treatments',
                'billing_balance' => 0.00,
                'recent_treatment' => 'Consultation & Pulp Vitality Test',
                'last_visit_at' => '2026-09-28 14:00:00',
            ],
            [
                'patient_id' => 'RD-2024-0912',
                'full_name' => 'Meera Choudhary',
                'phone' => '+91 98295 67834',
                'age' => 29,
                'date_of_birth' => '1997-09-18',
                'gender' => 'female',
                'blood_group' => 'O+',
                'city' => 'Jaipur',
                'residential_address' => 'Prithviraj Road, C-Scheme, Jaipur, Rajasthan 302001',
                'medical_alerts' => 'None',
                'attending_doctor_id' => $raviProfile?->id,
                'treatment_status' => 'follow_ups_due',
                'billing_balance' => 0.00,
                'recent_treatment' => 'OPG Diagnostic Assessment',
                'last_visit_at' => '2026-09-25 18:00:00',
            ],
        ];

        foreach ($patients as $p) {
            $existing = DB::table('patients')->where('patient_id', $p['patient_id'])->first();

            DB::table('patients')->updateOrInsert(
                ['patient_id' => $p['patient_id']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'clinic_id' => $clinic->id,
                    'attending_doctor_id' => $p['attending_doctor_id'],
                    'full_name' => $p['full_name'],
                    'phone' => $p['phone'],
                    'age' => $p['age'],
                    'date_of_birth' => $p['date_of_birth'],
                    'gender' => $p['gender'],
                    'blood_group' => $p['blood_group'],
                    'city' => $p['city'],
                    'residential_address' => $p['residential_address'],
                    'medical_alerts' => $p['medical_alerts'],
                    'treatment_status' => $p['treatment_status'],
                    'billing_balance' => $p['billing_balance'],
                    'recent_treatment' => $p['recent_treatment'],
                    'last_visit_at' => $p['last_visit_at'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

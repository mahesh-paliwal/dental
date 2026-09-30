<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientConsentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rahul = DB::table('patients')->where('patient_id', 'RD-2024-0412')->first();
        $priya = DB::table('patients')->where('patient_id', 'RD-2024-0589')->first();
        $amit = DB::table('patients')->where('patient_id', 'RD-2024-0195')->first();
        $pooja = DB::table('users')->where('email', 'pooja.sharma@drrenudentalclinic.com')->first();

        $consents = [
            [
                'patient_id' => $rahul?->id,
                'consent_type' => 'root_canal_treatment',
                'is_agreed' => true,
                'digital_signature_hash' => hash('sha256', 'rahul_sharma_rct_consent_20260912'),
                'ip_address' => '127.0.0.1',
                'agreed_at' => '2026-09-12 11:00:00',
                'witnessed_by_user_id' => $pooja?->id,
            ],
            [
                'patient_id' => $rahul?->id,
                'consent_type' => 'dpdp_act_data_privacy',
                'is_agreed' => true,
                'digital_signature_hash' => hash('sha256', 'rahul_sharma_dpdp_consent_20240115'),
                'ip_address' => '127.0.0.1',
                'agreed_at' => '2024-01-15 10:15:00',
                'witnessed_by_user_id' => $pooja?->id,
            ],
            [
                'patient_id' => $priya?->id,
                'consent_type' => 'clear_aligners_orthodontic',
                'is_agreed' => true,
                'digital_signature_hash' => hash('sha256', 'priya_verma_aligner_consent_20260301'),
                'ip_address' => '127.0.0.1',
                'agreed_at' => '2026-03-01 13:45:00',
                'witnessed_by_user_id' => $pooja?->id,
            ],
            [
                'patient_id' => $amit?->id,
                'consent_type' => 'dental_implant_surgery',
                'is_agreed' => true,
                'digital_signature_hash' => hash('sha256', 'amit_meena_implant_consent_20260915'),
                'ip_address' => '127.0.0.1',
                'agreed_at' => '2026-09-15 15:45:00',
                'witnessed_by_user_id' => $pooja?->id,
            ],
        ];

        foreach ($consents as $c) {
            if (! $c['patient_id']) {
                continue;
            }

            $existing = DB::table('patient_consents')
                ->where('patient_id', $c['patient_id'])
                ->where('consent_type', $c['consent_type'])
                ->first();

            DB::table('patient_consents')->updateOrInsert(
                [
                    'patient_id' => $c['patient_id'],
                    'consent_type' => $c['consent_type'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'is_agreed' => $c['is_agreed'],
                    'digital_signature_hash' => $c['digital_signature_hash'],
                    'ip_address' => $c['ip_address'],
                    'agreed_at' => $c['agreed_at'],
                    'witnessed_by_user_id' => $c['witnessed_by_user_id'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

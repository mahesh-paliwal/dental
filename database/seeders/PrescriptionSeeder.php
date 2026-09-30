<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rahul = DB::table('patients')->where('patient_id', 'RD-2024-0412')->first();
        $priya = DB::table('patients')->where('patient_id', 'RD-2024-0589')->first();
        $amit = DB::table('patients')->where('patient_id', 'RD-2024-0195')->first();

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

        $prescriptions = [
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'prescription_number' => 'RX-4091',
                'prescription_date' => '2026-09-12',
                'post_op_advice' => 'Avoid chewing hard food on upper right side for 48 hours. Warm saline gargles 3 times a day.',
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $renuDoc?->id,
                'prescription_number' => 'RX-3890',
                'prescription_date' => '2026-04-10',
                'post_op_advice' => 'Avoid coffee, tea, turmeric, and colored sodas for 48 hours following whitening.',
            ],
            [
                'patient_id' => $amit?->id,
                'doctor_id' => $raviDoc?->id,
                'prescription_number' => 'RX-4078',
                'prescription_date' => '2026-09-15',
                'post_op_advice' => 'Apply ice pack externally for 20 mins intervals today. Soft, cool diet only. No smoking or straw suction.',
            ],
        ];

        foreach ($prescriptions as $p) {
            if (! $p['patient_id'] || ! $p['doctor_id']) {
                continue;
            }

            $existing = DB::table('prescriptions')->where('prescription_number', $p['prescription_number'])->first();

            DB::table('prescriptions')->updateOrInsert(
                ['prescription_number' => $p['prescription_number']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'patient_id' => $p['patient_id'],
                    'doctor_id' => $p['doctor_id'],
                    'prescription_date' => $p['prescription_date'],
                    'post_op_advice' => $p['post_op_advice'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

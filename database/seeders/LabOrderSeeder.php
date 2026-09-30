<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LabOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $craftLab = DB::table('dental_labs')->where('name', 'like', '%Jaipur Dental Craft%')->first();
        $apexLab = DB::table('dental_labs')->where('name', 'like', '%Apex Precision Aligners%')->first();

        $rahul = DB::table('patients')->where('patient_id', 'RD-2024-0412')->first();
        $priya = DB::table('patients')->where('patient_id', 'RD-2024-0589')->first();
        $sunita = DB::table('patients')->where('patient_id', 'RD-2024-0714')->first();

        $renuDoc = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Renu')
            ->select('dentist_profiles.id')
            ->first();

        $nehaDoc = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Neha Agarwal')
            ->select('dentist_profiles.id')
            ->first();

        $orders = [
            [
                'lab_id' => $craftLab?->id,
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'order_number' => 'LAB-2026-0120',
                'restoration_type' => 'zirconia_ceramic_crown',
                'tooth_number' => '15',
                'shade' => 'VITA A2',
                'order_date' => '2026-09-13',
                'due_date' => '2026-09-18',
                'received_date' => '2026-09-19',
                'status' => 'fitted',
                'lab_cost' => 2200.00,
                'instructions' => 'Monolithic high-translucency zirconia crown with natural anatomy and tight proximal contact points.',
            ],
            [
                'lab_id' => $apexLab?->id,
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'order_number' => 'LAB-2026-0108',
                'restoration_type' => 'clear_aligner_set',
                'tooth_number' => '11, 21, 31, 41',
                'shade' => null,
                'order_date' => '2026-03-02',
                'due_date' => '2026-03-12',
                'received_date' => '2026-03-11',
                'status' => 'fitted',
                'lab_cost' => 22000.00,
                'instructions' => 'Complete clear aligner sequence trays #1 through #25 with attachment templates.',
            ],
            [
                'lab_id' => $craftLab?->id,
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'order_number' => 'LAB-2026-0135',
                'restoration_type' => 'porcelain_veneer',
                'tooth_number' => '12, 11, 21, 22',
                'shade' => 'VITA BL2',
                'order_date' => '2026-09-16',
                'due_date' => '2026-09-22',
                'received_date' => '2026-09-23',
                'status' => 'fitted',
                'lab_cost' => 8800.00,
                'instructions' => '4 Anterior IPS e.max press ceramic veneers with incisal halo effect and lifelike surface micro-texture.',
            ],
        ];

        foreach ($orders as $ord) {
            if (! $ord['lab_id'] || ! $ord['patient_id'] || ! $ord['doctor_id']) {
                continue;
            }

            $existing = DB::table('lab_orders')->where('order_number', $ord['order_number'])->first();

            DB::table('lab_orders')->updateOrInsert(
                ['order_number' => $ord['order_number']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'lab_id' => $ord['lab_id'],
                    'patient_id' => $ord['patient_id'],
                    'doctor_id' => $ord['doctor_id'],
                    'restoration_type' => $ord['restoration_type'],
                    'tooth_number' => $ord['tooth_number'],
                    'shade' => $ord['shade'],
                    'order_date' => $ord['order_date'],
                    'due_date' => $ord['due_date'],
                    'received_date' => $ord['received_date'],
                    'status' => $ord['status'],
                    'lab_cost' => $ord['lab_cost'],
                    'instructions' => $ord['instructions'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

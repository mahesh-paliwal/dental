<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrescriptionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rx4091 = DB::table('prescriptions')->where('prescription_number', 'RX-4091')->first();
        $rx3890 = DB::table('prescriptions')->where('prescription_number', 'RX-3890')->first();
        $rx4078 = DB::table('prescriptions')->where('prescription_number', 'RX-4078')->first();

        $items = [
            // RX-4091 (Rahul Sharma - Post RCT)
            [
                'prescription_id' => $rx4091?->id,
                'medication_name' => 'Augmentin 625mg (Amoxicillin + Clavulanate)',
                'dosage' => '1 tablet',
                'frequency' => 'Twice daily (BD)',
                'duration' => '5 Days',
                'instructions' => 'After meals with full glass of water',
            ],
            [
                'prescription_id' => $rx4091?->id,
                'medication_name' => 'Ketorol-DT 10mg (Ketorolac Tromethamine)',
                'dosage' => '1 dispersible tablet',
                'frequency' => 'SOS (When in acute pain)',
                'duration' => '3 Days',
                'instructions' => 'Dissolve in 1 tablespoon of drinking water before taking',
            ],
            [
                'prescription_id' => $rx4091?->id,
                'medication_name' => 'Clohex Plus Antiseptic Mouthwash',
                'dosage' => '10 ml',
                'frequency' => 'Twice daily (BD)',
                'duration' => '7 Days',
                'instructions' => 'Swish for 60 seconds; do not eat or drink for 30 minutes after',
            ],

            // RX-3890 (Priya Verma - Post Whitening)
            [
                'prescription_id' => $rx3890?->id,
                'medication_name' => 'Sensodyne Rapid Relief Toothpaste',
                'dosage' => 'Pea-sized amount',
                'frequency' => 'Twice daily',
                'duration' => '1 Month',
                'instructions' => 'Apply gently with soft-bristle toothbrush for sensitivity relief',
            ],

            // RX-4078 (Amit Meena - Post Implant Surgery)
            [
                'prescription_id' => $rx4078?->id,
                'medication_name' => 'Amoxicillin + Clavulanic Acid 625mg',
                'dosage' => '1 tablet',
                'frequency' => 'Thrice daily (TDS)',
                'duration' => '5 Days',
                'instructions' => 'Take with food to avoid gastric irritation',
            ],
            [
                'prescription_id' => $rx4078?->id,
                'medication_name' => 'Aceclofenac + Paracetamol + Serratiopeptidase',
                'dosage' => '1 tablet',
                'frequency' => 'Twice daily (BD)',
                'duration' => '3 Days',
                'instructions' => 'Anti-inflammatory and pain relief, take after breakfast and dinner',
            ],
            [
                'prescription_id' => $rx4078?->id,
                'medication_name' => 'Chlorhexidine 0.2% Antiseptic Rinse',
                'dosage' => '10 ml undiluted',
                'frequency' => 'Twice daily',
                'duration' => '10 Days',
                'instructions' => 'Gentle oral bathe, avoid vigorous spitting or suction',
            ],
        ];

        foreach ($items as $item) {
            if (! $item['prescription_id']) {
                continue;
            }

            $existing = DB::table('prescription_items')
                ->where('prescription_id', $item['prescription_id'])
                ->where('medication_name', $item['medication_name'])
                ->first();

            DB::table('prescription_items')->updateOrInsert(
                [
                    'prescription_id' => $item['prescription_id'],
                    'medication_name' => $item['medication_name'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'dosage' => $item['dosage'],
                    'frequency' => $item['frequency'],
                    'duration' => $item['duration'],
                    'instructions' => $item['instructions'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

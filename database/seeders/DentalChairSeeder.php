<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DentalChairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();

        if (! $clinic) {
            return;
        }

        $chairs = [
            [
                'name' => 'Dental Chair 1 (Main Operatory)',
                'chair_type' => 'main_operatory',
                'room_number' => 'Operatory 1',
                'status' => 'available',
            ],
            [
                'name' => 'Dental Chair 2 (Surgical & Implants)',
                'chair_type' => 'surgical_implants',
                'room_number' => 'Operatory 2 (Sterile OT)',
                'status' => 'available',
            ],
            [
                'name' => 'CBCT & OPG Diagnostic Bay',
                'chair_type' => 'diagnostic_bay',
                'room_number' => 'Imaging Suite',
                'status' => 'available',
            ],
        ];

        foreach ($chairs as $chair) {
            $existing = DB::table('dental_chairs')
                ->where('clinic_id', $clinic->id)
                ->where('name', $chair['name'])
                ->first();

            DB::table('dental_chairs')->updateOrInsert(
                [
                    'clinic_id' => $clinic->id,
                    'name' => $chair['name'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'chair_type' => $chair['chair_type'],
                    'room_number' => $chair['room_number'],
                    'status' => $chair['status'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

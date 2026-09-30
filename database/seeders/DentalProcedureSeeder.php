<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DentalProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('procedure_categories')->pluck('id', 'code');

        $procedures = [
            [
                'code' => 'P01',
                'category_code' => 'ENDO',
                'name' => 'Single Visit Root Canal Treatment (RCT)',
                'description' => 'Biomechanical preparation using rotary Protaper Gold with bioceramic obturation under rubber dam isolation.',
                'standard_rate' => 4500.00,
                'sitting_duration_minutes' => 45,
            ],
            [
                'code' => 'P02',
                'category_code' => 'ENDO',
                'name' => 'Root Canal Re-treatment with Microscope',
                'description' => 'Microscopic retrieval of previous obturation, apical disinfection, and MTA apexification/re-obturation.',
                'standard_rate' => 6500.00,
                'sitting_duration_minutes' => 60,
            ],
            [
                'code' => 'P03',
                'category_code' => 'IMPL',
                'name' => 'Dental Implant (Titanium - Nobel Biocare/Osstem)',
                'description' => 'Surgical placement of grade-IV titanium dental implant fixture with surgical guide and cover screw.',
                'standard_rate' => 28000.00,
                'sitting_duration_minutes' => 60,
            ],
            [
                'code' => 'P04',
                'category_code' => 'PROS',
                'name' => 'Zirconia High-Translucency Crown',
                'description' => 'CAD/CAM milled monolithic high-translucency multilayer zirconia crown cemented with resin cement.',
                'standard_rate' => 8500.00,
                'sitting_duration_minutes' => 30,
            ],
            [
                'code' => 'P05',
                'category_code' => 'PROS',
                'name' => 'CAD/CAM PFM Ceramic Crown',
                'description' => 'Laser-sintered CAD/CAM porcelain-fused-to-metal crown with aesthetic ceramic margin.',
                'standard_rate' => 4500.00,
                'sitting_duration_minutes' => 30,
            ],
            [
                'code' => 'P06',
                'category_code' => 'ORTH',
                'name' => 'Invisible Clear Aligners (Full Course)',
                'description' => 'Custom 3D-planned orthodontic aligner trays course with digital monitoring and refinement trays.',
                'standard_rate' => 75000.00,
                'sitting_duration_minutes' => 40,
            ],
            [
                'code' => 'P07',
                'category_code' => 'PREV',
                'name' => 'Teeth Scaling & Polishing (EMS Guided Biofilm)',
                'description' => 'Swiss EMS Guided Biofilm Therapy (GBT) with AIRFLOW erythritol powder and ultrasonic PIEZON scaling.',
                'standard_rate' => 1500.00,
                'sitting_duration_minutes' => 30,
            ],
            [
                'code' => 'P08',
                'category_code' => 'COSM',
                'name' => 'Zoom In-Office Teeth Whitening (1 Hour)',
                'description' => 'Philips Zoom WhiteSpeed blue LED light-activated 25% hydrogen peroxide power whitening in three 15-minute cycles.',
                'standard_rate' => 9000.00,
                'sitting_duration_minutes' => 60,
            ],
            [
                'code' => 'P09',
                'category_code' => 'COSM',
                'name' => 'Porcelain Veneers / Smile Design (Per Tooth)',
                'description' => 'Ultra-thin IPS e.max lithium disilicate ceramic veneers bonded with light-cure aesthetic luting composite.',
                'standard_rate' => 11000.00,
                'sitting_duration_minutes' => 45,
            ],
            [
                'code' => 'P10',
                'category_code' => 'REST',
                'name' => 'Tooth-Colored Composite Restoration',
                'description' => 'Direct nano-hybrid resin composite filling with biomimetic layering and high-gloss polishing.',
                'standard_rate' => 1200.00,
                'sitting_duration_minutes' => 30,
            ],
            [
                'code' => 'P11',
                'category_code' => 'SURG',
                'name' => 'Surgical Wisdom Tooth Disimpaction',
                'description' => 'Surgical extraction of impacted third molar with bone guttering, tooth sectioning, and resorbable sutures.',
                'standard_rate' => 5500.00,
                'sitting_duration_minutes' => 45,
            ],
            [
                'code' => 'P12',
                'category_code' => 'DIAG',
                'name' => 'CBCT 3D Scan & Digital OPG X-Ray',
                'description' => 'High-resolution cone beam computed tomography (CBCT) volume volumetric scan and digital orthopantomogram.',
                'standard_rate' => 2000.00,
                'sitting_duration_minutes' => 15,
            ],
        ];

        foreach ($procedures as $proc) {
            $catId = $categories[$proc['category_code']] ?? null;
            if (! $catId) {
                continue;
            }

            $existing = DB::table('dental_procedures')->where('code', $proc['code'])->first();

            DB::table('dental_procedures')->updateOrInsert(
                ['code' => $proc['code']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'category_id' => $catId,
                    'name' => $proc['name'],
                    'description' => $proc['description'],
                    'standard_rate' => $proc['standard_rate'],
                    'sitting_duration_minutes' => $proc['sitting_duration_minutes'],
                    'is_active' => true,
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

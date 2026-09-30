<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcedureCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Endodontics',
                'code' => 'ENDO',
                'description' => 'Root canal treatments, re-treatments, and microscopic endodontic procedures.',
            ],
            [
                'name' => 'Implantology',
                'code' => 'IMPL',
                'description' => 'Titanium & zirconia dental implants, computer guided surgical placements, and ridge augmentation.',
            ],
            [
                'name' => 'Prosthodontics',
                'code' => 'PROS',
                'description' => 'Zirconia & ceramic crowns, fixed partial dentures (bridges), and full mouth rehabilitation.',
            ],
            [
                'name' => 'Orthodontics',
                'code' => 'ORTH',
                'description' => 'Invisible clear aligners, self-ligating Damon braces, and malocclusion correction.',
            ],
            [
                'name' => 'Preventive',
                'code' => 'PREV',
                'description' => 'EMS Guided Biofilm Therapy (GBT), supragingival/subgingival scaling, polishing, and topical fluoridation.',
            ],
            [
                'name' => 'Cosmetic',
                'code' => 'COSM',
                'description' => 'In-office Zoom teeth whitening, IPS e.max porcelain veneers, and aesthetic smile designing.',
            ],
            [
                'name' => 'Restorative',
                'code' => 'REST',
                'description' => 'Tooth-colored composite restorations, aesthetic direct bonding, and dentin biomimetic fillings.',
            ],
            [
                'name' => 'Oral Surgery',
                'code' => 'SURG',
                'description' => 'Surgical wisdom tooth disimpaction, atraumatic tooth extractions, and minor oral surgery.',
            ],
            [
                'name' => 'Diagnostics',
                'code' => 'DIAG',
                'description' => 'CBCT 3D volume scan, digital OPG panoramic x-rays, and intraoral RVG radiographic imaging.',
            ],
        ];

        foreach ($categories as $cat) {
            $existing = DB::table('procedure_categories')->where('code', $cat['code'])->first();

            DB::table('procedure_categories')->updateOrInsert(
                ['code' => $cat['code']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

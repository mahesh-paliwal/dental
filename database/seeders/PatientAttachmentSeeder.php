<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rahul = DB::table('patients')->where('patient_id', 'RD-2024-0412')->first();
        $priya = DB::table('patients')->where('patient_id', 'RD-2024-0589')->first();
        $amit = DB::table('patients')->where('patient_id', 'RD-2024-0195')->first();

        $sunil = DB::table('users')->where('email', 'sunil.meena@drrenudentalclinic.com')->first();
        $renu = DB::table('users')->where('email', 'renu@drrenudentalclinic.com')->first();

        $attachments = [
            [
                'patient_id' => $rahul?->id,
                'file_name' => 'rahul_sharma_post_op_rvg_16.png',
                'file_path' => 'attachments/patients/rahul_sharma_post_op_rvg_16.png',
                'file_type' => 'image/png',
                'file_size_bytes' => 1048576,
                'category' => 'rvg_xray',
                'tooth_number' => '16',
                'notes' => 'Post-Obturation RVG X-Ray (#16) showing hermetic apical seal.',
                'uploaded_by_user_id' => $sunil?->id ?? $renu?->id,
            ],
            [
                'patient_id' => $rahul?->id,
                'file_name' => 'rahul_sharma_opg_panoramic.png',
                'file_path' => 'attachments/patients/rahul_sharma_opg_panoramic.png',
                'file_type' => 'image/png',
                'file_size_bytes' => 4194304,
                'category' => 'opg_panoramic',
                'tooth_number' => null,
                'notes' => 'Full Mouth Digital OPG Panoramic X-Ray screening.',
                'uploaded_by_user_id' => $sunil?->id ?? $renu?->id,
            ],
            [
                'patient_id' => $priya?->id,
                'file_name' => 'priya_verma_ortho_cephalogram.png',
                'file_path' => 'attachments/patients/priya_verma_ortho_cephalogram.png',
                'file_type' => 'image/png',
                'file_size_bytes' => 3670016,
                'category' => 'opg_panoramic',
                'tooth_number' => null,
                'notes' => 'Pre-Orthodontic Lateral Cephalogram & OPG for aligner simulation.',
                'uploaded_by_user_id' => $sunil?->id ?? $renu?->id,
            ],
            [
                'patient_id' => $amit?->id,
                'file_name' => 'amit_meena_cbct_3d_scan.dcm',
                'file_path' => 'attachments/patients/amit_meena_cbct_3d_scan.dcm',
                'file_type' => 'application/dicom',
                'file_size_bytes' => 15728640,
                'category' => 'cbct_3d',
                'tooth_number' => '46',
                'notes' => 'CBCT 3D Scan Pre-Implant Assessment verifying bone volume.',
                'uploaded_by_user_id' => $sunil?->id ?? $renu?->id,
            ],
        ];

        foreach ($attachments as $att) {
            if (! $att['patient_id'] || ! $att['uploaded_by_user_id']) {
                continue;
            }

            $existing = DB::table('patient_attachments')
                ->where('patient_id', $att['patient_id'])
                ->where('file_name', $att['file_name'])
                ->first();

            DB::table('patient_attachments')->updateOrInsert(
                [
                    'patient_id' => $att['patient_id'],
                    'file_name' => $att['file_name'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'file_path' => $att['file_path'],
                    'file_type' => $att['file_type'],
                    'file_size_bytes' => $att['file_size_bytes'],
                    'category' => $att['category'],
                    'tooth_number' => $att['tooth_number'],
                    'notes' => $att['notes'],
                    'uploaded_by_user_id' => $att['uploaded_by_user_id'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

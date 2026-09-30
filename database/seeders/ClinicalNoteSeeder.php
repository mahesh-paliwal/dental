<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClinicalNoteSeeder extends Seeder
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

        $nehaDoc = DB::table('dentist_profiles')
            ->join('users', 'dentist_profiles.user_id', '=', 'users.id')
            ->where('users.name', 'Dr. Neha Agarwal')
            ->select('dentist_profiles.id')
            ->first();

        $notes = [
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'chief_complaint' => 'Severe acute throbbing pain in upper right back tooth (#16), aggravated by hot and cold.',
                'clinical_findings' => 'Deep occlusal caries approaching pulp chamber on #16. Tenderness to percussion positive. Negative cold responsiveness.',
                'diagnosis' => 'Symptomatic Irreversible Pulpitis with Acute Apical Periodontitis #16.',
                'procedure_performed' => 'Single-visit rotary RCT completed under rubber dam isolation. Canals shaped to F2, irrigated with 3% NaOCl and EDTA, obturated with bioceramic sealer.',
                'post_op_advice' => 'Avoid chewing hard substances on upper right side for 48 hours. Warm saline gargles. Prescribed analgesics SOS.',
                'note_date' => '2026-09-12 11:30:00',
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'chief_complaint' => 'Routine progress evaluation for clear aligners orthodontic therapy.',
                'clinical_findings' => 'Aligner tray #14 tracking accurately on maxillary and mandibular anterior sectors. No active gingival inflammation.',
                'diagnosis' => 'Angle Class I Malocclusion with mild anterior crowding undergoing clear aligner correction.',
                'procedure_performed' => 'Delivered aligner trays #15 through #18. Verified seating and attachment engagement.',
                'post_op_advice' => 'Wear aligners for minimum 22 hours per day. Change to tray #15 after 10 days.',
                'note_date' => '2026-09-18 17:30:00',
            ],
            [
                'patient_id' => $amit?->id,
                'doctor_id' => $raviDoc?->id,
                'chief_complaint' => 'Missing right lower first molar (#46), difficulty chewing.',
                'clinical_findings' => 'Adequate bone width and height on CBCT 3D scan. Healthy keratinized gingiva.',
                'diagnosis' => 'Partially edentulous lower right quadrant (missing #46).',
                'procedure_performed' => 'Flapless computer-guided surgical placement of Osstem TSIII 4.5x10mm titanium fixture. Primary torque 40 Ncm achieved. Healing screw placed.',
                'post_op_advice' => 'Soft cold diet for 48 hours. Apply cold compress externally. Antibiotic course for 5 days.',
                'note_date' => '2026-09-15 16:30:00',
            ],
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'chief_complaint' => 'Aesthetic dissatisfaction with color and minor incisal chipping of upper front teeth.',
                'clinical_findings' => 'Mild enamel hypocalcification and incisal edge wear on teeth 12, 11, 21, 22. Stable anterior guidance.',
                'diagnosis' => 'Aesthetic anterior smile disharmony and mild microdontia.',
                'procedure_performed' => 'Bonded 4 custom IPS e.max lithium disilicate porcelain veneers with Variolink Esthetic. Margins finished and polished.',
                'post_op_advice' => 'Avoid biting hard items with front teeth (nuts, ice, hard fruit). Maintain regular dental flossing.',
                'note_date' => '2026-09-24 12:30:00',
            ],
        ];

        foreach ($notes as $n) {
            if (! $n['patient_id'] || ! $n['doctor_id']) {
                continue;
            }

            $existing = DB::table('clinical_notes')
                ->where('patient_id', $n['patient_id'])
                ->where('note_date', $n['note_date'])
                ->first();

            DB::table('clinical_notes')->updateOrInsert(
                [
                    'patient_id' => $n['patient_id'],
                    'note_date' => $n['note_date'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'doctor_id' => $n['doctor_id'],
                    'chief_complaint' => $n['chief_complaint'],
                    'clinical_findings' => $n['clinical_findings'],
                    'diagnosis' => $n['diagnosis'],
                    'procedure_performed' => $n['procedure_performed'],
                    'post_op_advice' => $n['post_op_advice'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

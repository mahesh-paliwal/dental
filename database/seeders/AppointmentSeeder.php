<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentSeeder extends Seeder
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
        $vikram = DB::table('patients')->where('patient_id', 'RD-2024-0820')->first();
        $meera = DB::table('patients')->where('patient_id', 'RD-2024-0912')->first();

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

        $chair1 = DB::table('dental_chairs')->where('name', 'like', '%Chair 1%')->first();
        $chair2 = DB::table('dental_chairs')->where('name', 'like', '%Chair 2%')->first();
        $diagBay = DB::table('dental_chairs')->where('name', 'like', '%Diagnostic Bay%')->first();

        $rctProc = DB::table('dental_procedures')->where('code', 'P01')->first();
        $alignerProc = DB::table('dental_procedures')->where('code', 'P06')->first();
        $implantProc = DB::table('dental_procedures')->where('code', 'P03')->first();
        $veneerProc = DB::table('dental_procedures')->where('code', 'P09')->first();
        $compositeProc = DB::table('dental_procedures')->where('code', 'P10')->first();
        $cbctProc = DB::table('dental_procedures')->where('code', 'P12')->first();

        $appointments = [
            [
                'patient_id' => $rahul?->id,
                'doctor_id' => $renuDoc?->id,
                'chair_id' => $chair1?->id,
                'procedure_id' => $compositeProc?->id,
                'appointment_date' => now()->toDateString(),
                'time_slot' => '09:30 AM - 10:15 AM',
                'scheduled_start' => now()->toDateString().' 09:30:00',
                'scheduled_end' => now()->toDateString().' 10:15:00',
                'status' => 'in_chair',
                'is_walk_in' => false,
                'queue_order' => 1,
                'purpose' => 'Class I Occlusal Composite Restoration (#26)',
            ],
            [
                'patient_id' => $priya?->id,
                'doctor_id' => $nehaDoc?->id,
                'chair_id' => $chair2?->id,
                'procedure_id' => $alignerProc?->id,
                'appointment_date' => now()->toDateString(),
                'time_slot' => '10:15 AM - 11:00 AM',
                'scheduled_start' => now()->toDateString().' 10:15:00',
                'scheduled_end' => now()->toDateString().' 11:00:00',
                'status' => 'completed',
                'is_walk_in' => false,
                'queue_order' => 2,
                'purpose' => 'Invisible Clear Aligners Progress Checkup & Next Trays Delivery',
            ],
            [
                'patient_id' => $amit?->id,
                'doctor_id' => $raviDoc?->id,
                'chair_id' => $chair2?->id,
                'procedure_id' => $implantProc?->id,
                'appointment_date' => now()->toDateString(),
                'time_slot' => '11:00 AM - 11:45 AM',
                'scheduled_start' => now()->toDateString().' 11:00:00',
                'scheduled_end' => now()->toDateString().' 11:45:00',
                'status' => 'confirmed',
                'is_walk_in' => false,
                'queue_order' => 3,
                'purpose' => 'Implant Stability Assessment & Healing Check (#46)',
            ],
            [
                'patient_id' => $sunita?->id,
                'doctor_id' => $renuDoc?->id,
                'chair_id' => $chair1?->id,
                'procedure_id' => $veneerProc?->id,
                'appointment_date' => now()->toDateString(),
                'time_slot' => '11:45 AM - 12:30 PM',
                'scheduled_start' => now()->toDateString().' 11:45:00',
                'scheduled_end' => now()->toDateString().' 12:30:00',
                'status' => 'scheduled',
                'is_walk_in' => false,
                'queue_order' => 4,
                'purpose' => 'Porcelain Veneers Routine Polish & Occlusal Verification',
            ],
            [
                'patient_id' => $vikram?->id,
                'doctor_id' => $renuDoc?->id,
                'chair_id' => $chair1?->id,
                'procedure_id' => $rctProc?->id,
                'appointment_date' => now()->toDateString(),
                'time_slot' => '12:30 PM - 01:15 PM',
                'scheduled_start' => now()->toDateString().' 12:30:00',
                'scheduled_end' => now()->toDateString().' 13:15:00',
                'status' => 'scheduled',
                'is_walk_in' => true,
                'queue_order' => 5,
                'purpose' => 'Single Visit Root Canal Treatment (#46) - Walk-in Emergency Pain',
            ],
            [
                'patient_id' => $meera?->id,
                'doctor_id' => $raviDoc?->id,
                'chair_id' => $diagBay?->id,
                'procedure_id' => $cbctProc?->id,
                'appointment_date' => now()->toDateString(),
                'time_slot' => '04:30 PM - 05:00 PM',
                'scheduled_start' => now()->toDateString().' 16:30:00',
                'scheduled_end' => now()->toDateString().' 17:00:00',
                'status' => 'scheduled',
                'is_walk_in' => false,
                'queue_order' => 6,
                'purpose' => 'Full Mouth Digital OPG & CBCT Radiographic Assessment',
            ],
        ];

        foreach ($appointments as $app) {
            if (! $app['patient_id'] || ! $app['doctor_id']) {
                continue;
            }

            $existing = DB::table('appointments')
                ->where('patient_id', $app['patient_id'])
                ->where('appointment_date', $app['appointment_date'])
                ->where('time_slot', $app['time_slot'])
                ->first();

            DB::table('appointments')->updateOrInsert(
                [
                    'patient_id' => $app['patient_id'],
                    'appointment_date' => $app['appointment_date'],
                    'time_slot' => $app['time_slot'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'doctor_id' => $app['doctor_id'],
                    'chair_id' => $app['chair_id'],
                    'procedure_id' => $app['procedure_id'],
                    'scheduled_start' => $app['scheduled_start'],
                    'scheduled_end' => $app['scheduled_end'],
                    'status' => $app['status'],
                    'is_walk_in' => $app['is_walk_in'],
                    'queue_order' => $app['queue_order'],
                    'purpose' => $app['purpose'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientFollowUpRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rahul = DB::table('patients')->where('patient_id', 'RD-2024-0412')->first();
        $priya = DB::table('patients')->where('patient_id', 'RD-2024-0589')->first();
        $staff = DB::table('users')->where('email', 'pooja.sharma@drrenudentalclinic.com')->first();

        $requests = [
            [
                'patient_id' => $rahul?->id,
                'preferred_date' => now()->addDays(5)->toDateString(),
                'preferred_time_slot' => 'morning',
                'pain_symptoms' => 'Need routine checkup for upper tooth restoration (#26)',
                'status' => 'confirmed',
                'confirmation_channel' => 'whatsapp',
                'confirmed_by_user_id' => $staff?->id,
                'staff_response_notes' => 'Confirmed via WhatsApp with patient. Appointment booked with Dr. Renu.',
            ],
            [
                'patient_id' => $priya?->id,
                'preferred_date' => now()->addDays(14)->toDateString(),
                'preferred_time_slot' => 'evening',
                'pain_symptoms' => 'Next aligner set pickup and routine tracking review',
                'status' => 'pending',
                'confirmation_channel' => 'whatsapp',
                'confirmed_by_user_id' => null,
                'staff_response_notes' => null,
            ],
        ];

        foreach ($requests as $req) {
            if (! $req['patient_id']) {
                continue;
            }

            $existing = DB::table('patient_follow_up_requests')
                ->where('patient_id', $req['patient_id'])
                ->where('preferred_date', $req['preferred_date'])
                ->first();

            DB::table('patient_follow_up_requests')->updateOrInsert(
                [
                    'patient_id' => $req['patient_id'],
                    'preferred_date' => $req['preferred_date'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'preferred_time_slot' => $req['preferred_time_slot'],
                    'pain_symptoms' => $req['pain_symptoms'],
                    'status' => $req['status'],
                    'confirmation_channel' => $req['confirmation_channel'],
                    'confirmed_by_user_id' => $req['confirmed_by_user_id'],
                    'staff_response_notes' => $req['staff_response_notes'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

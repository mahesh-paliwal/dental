<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BroadcastTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => '6-Month Teeth Scaling & GBT Recall',
                'channel' => 'sms',
                'dlt_template_id' => 'DLT-RJ-SCAL-01',
                'message_template' => 'Dear {patient_name}, your 6-month routine dental cleaning & Guided Biofilm Therapy (GBT) recall is due at Dr. Renu Dental Clinic. Protect your gums and teeth! Book your appointment at {portal_link} or call {clinic_phone}.',
                'is_active' => true,
            ],
            [
                'name' => 'Free Dental Camp & Oral Cancer Screening',
                'channel' => 'whatsapp',
                'dlt_template_id' => 'DLT-RJ-CAMP-02',
                'message_template' => 'Namaste {patient_name}, Dr. Renu Dental Clinic is hosting a Free Community Dental Health & Oral Cancer Screening Camp this Sunday at Nirman Nagar, Jaipur. Call {clinic_phone} to register your slot.',
                'is_active' => true,
            ],
            [
                'name' => 'Festive Clinic Greetings & Hours Notice',
                'channel' => 'sms',
                'dlt_template_id' => 'DLT-RJ-FEST-03',
                'message_template' => 'Warm festive greetings from Dr. Renu Dental Clinic! Please note clinic holiday hours: 10:00 AM to 02:00 PM. For dental emergencies, please call {clinic_phone}. Have a bright and healthy smile!',
                'is_active' => true,
            ],
            [
                'name' => 'Special 20% Privilege Offer (Whitening)',
                'channel' => 'whatsapp',
                'dlt_template_id' => 'DLT-RJ-WHIT-04',
                'message_template' => 'Exclusive Privilege Offer for {patient_name}: Enjoy 20% off on Philips Zoom 1-Hour In-Office Teeth Whitening & Cosmetic Smile Design at Dr. Renu Dental Clinic. Consult {doctor_name} today at {clinic_phone}.',
                'is_active' => true,
            ],
            [
                'name' => 'Post-Op Care & Recovery Check-in',
                'channel' => 'sms',
                'dlt_template_id' => 'DLT-RJ-POST-05',
                'message_template' => 'Dear {patient_name}, {doctor_name} hopes you are recovering comfortably after your dental procedure. Remember warm saline rinses and soft diet. For any pain or query, contact our clinic at {clinic_phone}.',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $t) {
            $existing = DB::table('broadcast_templates')->where('name', $t['name'])->first();

            DB::table('broadcast_templates')->updateOrInsert(
                ['name' => $t['name']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'channel' => $t['channel'],
                    'dlt_template_id' => $t['dlt_template_id'],
                    'message_template' => $t['message_template'],
                    'is_active' => $t['is_active'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BroadcastCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();
        $user = DB::table('users')->where('email', 'renu@drrenudentalclinic.com')->first();

        $scalingTemplate = DB::table('broadcast_templates')->where('name', '6-Month Teeth Scaling & GBT Recall')->first();
        $offerTemplate = DB::table('broadcast_templates')->where('name', 'Special 20% Privilege Offer (Whitening)')->first();

        $campaigns = [
            [
                'title' => 'Routine 6-Month Dental Scaling Recall Reminder',
                'template_id' => $scalingTemplate?->id,
                'channel' => 'sms',
                'audience_segment' => 'six_month_scaling_recall',
                'message_body' => 'Dear patient, your 6-month routine dental cleaning & GBT recall is due at Dr. Renu Dental Clinic. Book at drrenudentalclinic.com or call +919650935061.',
                'dlt_sender_id' => 'DRRENU',
                'total_recipients' => 420,
                'sent_count' => 420,
                'delivered_count' => 412,
                'failed_count' => 8,
                'credits_used' => 420,
                'status' => 'completed',
                'scheduled_at' => '2026-09-01 10:00:00',
                'sent_at' => '2026-09-01 10:02:15',
            ],
            [
                'title' => 'Festive Smile Privilege 20% Whitening Offer',
                'template_id' => $offerTemplate?->id,
                'channel' => 'whatsapp',
                'audience_segment' => 'all_patients',
                'message_body' => 'Exclusive Privilege Offer: Enjoy 20% off on Zoom 1-Hour Teeth Whitening at Dr. Renu Dental Clinic. Consult Dr. Renu today at +919650935061.',
                'dlt_sender_id' => 'DRRENU',
                'total_recipients' => 6428,
                'sent_count' => 6428,
                'delivered_count' => 6390,
                'failed_count' => 38,
                'credits_used' => 6428,
                'status' => 'completed',
                'scheduled_at' => '2026-09-15 09:00:00',
                'sent_at' => '2026-09-15 09:05:40',
            ],
        ];

        foreach ($campaigns as $camp) {
            if (! $clinic || ! $user) {
                continue;
            }

            $existing = DB::table('broadcast_campaigns')->where('title', $camp['title'])->first();

            DB::table('broadcast_campaigns')->updateOrInsert(
                ['title' => $camp['title']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'clinic_id' => $clinic->id,
                    'template_id' => $camp['template_id'],
                    'channel' => $camp['channel'],
                    'audience_segment' => $camp['audience_segment'],
                    'message_body' => $camp['message_body'],
                    'dlt_sender_id' => $camp['dlt_sender_id'],
                    'total_recipients' => $camp['total_recipients'],
                    'sent_count' => $camp['sent_count'],
                    'delivered_count' => $camp['delivered_count'],
                    'failed_count' => $camp['failed_count'],
                    'credits_used' => $camp['credits_used'],
                    'status' => $camp['status'],
                    'scheduled_at' => $camp['scheduled_at'],
                    'sent_at' => $camp['sent_at'],
                    'created_by_user_id' => $user->id,
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

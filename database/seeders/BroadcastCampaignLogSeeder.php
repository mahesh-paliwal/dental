<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BroadcastCampaignLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaign = DB::table('broadcast_campaigns')->first();
        $patients = DB::table('patients')->limit(4)->get();

        if (! $campaign || $patients->isEmpty()) {
            return;
        }

        foreach ($patients as $p) {
            $existing = DB::table('broadcast_campaign_logs')
                ->where('campaign_id', $campaign->id)
                ->where('patient_id', $p->id)
                ->first();

            DB::table('broadcast_campaign_logs')->updateOrInsert(
                [
                    'campaign_id' => $campaign->id,
                    'patient_id' => $p->id,
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'mobile_phone' => $p->phone,
                    'status' => 'delivered',
                    'gateway_message_id' => 'GW-'.strtoupper(Str::random(10)),
                    'error_message' => null,
                    'delivered_at' => now()->subDays(2),
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

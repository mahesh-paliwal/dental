<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HistoricalDataSyncLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();
        $user = DB::table('users')->where('email', 'renu@drrenudentalclinic.com')->first();

        if (! $clinic || ! $user) {
            return;
        }

        $fileName = 'historical_patients_6000.csv';
        $existing = DB::table('historical_data_sync_logs')->where('file_name', $fileName)->first();

        DB::table('historical_data_sync_logs')->updateOrInsert(
            ['file_name' => $fileName],
            [
                'id' => $existing ? $existing->id : (string) Str::uuid(),
                'clinic_id' => $clinic->id,
                'total_rows_detected' => 6428,
                'synced_count' => 6428,
                'failed_count' => 0,
                'status' => 'completed',
                'sync_summary' => 'Successfully indexed and imported 6,428 historical patient records. Fully mapped by Indian mobile phone, custom patient ID, and dental treatment records.',
                'synced_by_user_id' => $user->id,
                'created_at' => $existing ? $existing->created_at : now(),
                'updated_at' => now(),
            ]
        );
    }
}

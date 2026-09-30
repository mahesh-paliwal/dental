<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DentistScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();
        $dentists = DB::table('dentist_profiles')->get();

        if (! $clinic || $dentists->isEmpty()) {
            return;
        }

        // Dr. Renu: Mon - Sat 09:30 - 20:30, Sun 10:00 - 14:00
        // Other consultants: specific visiting days
        foreach ($dentists as $dentist) {
            for ($day = 0; $day <= 6; $day++) {
                $isSunday = ($day === 0);
                $startTime = $isSunday ? '10:00:00' : '09:30:00';
                $endTime = $isSunday ? '14:00:00' : '20:30:00';
                $breakStart = $isSunday ? null : '13:30:00';
                $breakEnd = $isSunday ? null : '14:30:00';

                $existing = DB::table('dentist_schedules')
                    ->where('dentist_id', $dentist->id)
                    ->where('clinic_id', $clinic->id)
                    ->where('day_of_week', $day)
                    ->first();

                DB::table('dentist_schedules')->updateOrInsert(
                    [
                        'dentist_id' => $dentist->id,
                        'clinic_id' => $clinic->id,
                        'day_of_week' => $day,
                    ],
                    [
                        'id' => $existing ? $existing->id : (string) Str::uuid(),
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'break_start' => $breakStart,
                        'break_end' => $breakEnd,
                        'is_active' => true,
                        'created_at' => $existing ? $existing->created_at : now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}

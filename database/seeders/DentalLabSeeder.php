<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DentalLabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labs = [
            [
                'name' => 'Jaipur Dental Craft Ceramic Studio',
                'contact_person' => 'Mahesh Agarwal',
                'phone' => '+91 98295 12345',
                'email' => 'jaipurdentalcraft@gmail.com',
                'city' => 'Jaipur',
                'average_turnaround_days' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Apex Precision Aligners & CAD/CAM Lab',
                'contact_person' => 'Rajesh Soni',
                'phone' => '+91 98296 23456',
                'email' => 'apexaligners.jaipur@gmail.com',
                'city' => 'Jaipur',
                'average_turnaround_days' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($labs as $lab) {
            $existing = DB::table('dental_labs')->where('name', $lab['name'])->first();

            DB::table('dental_labs')->updateOrInsert(
                ['name' => $lab['name']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'contact_person' => $lab['contact_person'],
                    'phone' => $lab['phone'],
                    'email' => $lab['email'],
                    'city' => $lab['city'],
                    'average_turnaround_days' => $lab['average_turnaround_days'],
                    'is_active' => $lab['is_active'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

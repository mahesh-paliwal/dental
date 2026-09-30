<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();

        if (! $clinic) {
            return;
        }

        $items = [
            [
                'item_name' => 'EMS AirFlow PLUS Powder (Erythritol - GBT)',
                'sku' => 'INV-EMS-GBT-100',
                'category' => 'Preventive Consumables',
                'unit' => 'Bottle',
                'stock_quantity' => 18,
                'low_stock_alert_threshold' => 5,
                'unit_price' => 2400.00,
                'expiry_date' => '2027-12-31',
            ],
            [
                'item_name' => 'Osstem TSIII SA Dental Implant Fixture (4.5x10mm)',
                'sku' => 'INV-OSS-TS3-4510',
                'category' => 'Surgical & Implants',
                'unit' => 'Unit',
                'stock_quantity' => 12,
                'low_stock_alert_threshold' => 3,
                'unit_price' => 9500.00,
                'expiry_date' => '2029-06-30',
            ],
            [
                'item_name' => '3M ESPE RelyX U200 Self-Adhesive Resin Cement',
                'sku' => 'INV-3M-RLX-U200',
                'category' => 'Prosthodontic Materials',
                'unit' => 'Automix Syringe',
                'stock_quantity' => 8,
                'low_stock_alert_threshold' => 2,
                'unit_price' => 3850.00,
                'expiry_date' => '2027-08-31',
            ],
            [
                'item_name' => '3M Filtek Z350 XT Universal Restorative Composite (A2)',
                'sku' => 'INV-3M-FLT-A2',
                'category' => 'Restorative Materials',
                'unit' => 'Syringe',
                'stock_quantity' => 24,
                'low_stock_alert_threshold' => 6,
                'unit_price' => 1850.00,
                'expiry_date' => '2028-03-31',
            ],
            [
                'item_name' => 'Dentsply ProTaper Gold Rotary Files (SX-F3 Assorted)',
                'sku' => 'INV-DPS-PTG-AST',
                'category' => 'Endodontic Consumables',
                'unit' => 'Pack of 6',
                'stock_quantity' => 30,
                'low_stock_alert_threshold' => 8,
                'unit_price' => 2100.00,
                'expiry_date' => '2028-11-30',
            ],
            [
                'item_name' => 'Philips Zoom DayWhite 14% Hydrogen Peroxide Take-Home Kit',
                'sku' => 'INV-PHL-ZOM-14',
                'category' => 'Cosmetic Materials',
                'unit' => 'Kit',
                'stock_quantity' => 15,
                'low_stock_alert_threshold' => 4,
                'unit_price' => 4200.00,
                'expiry_date' => '2027-05-31',
            ],
        ];

        foreach ($items as $item) {
            $existing = DB::table('inventory_items')->where('sku', $item['sku'])->first();

            DB::table('inventory_items')->updateOrInsert(
                ['sku' => $item['sku']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'clinic_id' => $clinic->id,
                    'item_name' => $item['item_name'],
                    'category' => $item['category'],
                    'unit' => $item['unit'],
                    'stock_quantity' => $item['stock_quantity'],
                    'low_stock_alert_threshold' => $item['low_stock_alert_threshold'],
                    'unit_price' => $item['unit_price'],
                    'expiry_date' => $item['expiry_date'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

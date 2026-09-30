<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inv1842 = DB::table('invoices')->where('invoice_number', 'INV-2026-1842')->first();
        $inv1790 = DB::table('invoices')->where('invoice_number', 'INV-2026-1790')->first();
        $inv1620 = DB::table('invoices')->where('invoice_number', 'INV-2026-1620')->first();
        $inv1410 = DB::table('invoices')->where('invoice_number', 'INV-2026-1410')->first();
        $inv1805 = DB::table('invoices')->where('invoice_number', 'INV-2026-1805')->first();
        $inv1890 = DB::table('invoices')->where('invoice_number', 'INV-2026-1890')->first();

        $p01 = DB::table('dental_procedures')->where('code', 'P01')->first();
        $p03 = DB::table('dental_procedures')->where('code', 'P03')->first();
        $p04 = DB::table('dental_procedures')->where('code', 'P04')->first();
        $p06 = DB::table('dental_procedures')->where('code', 'P06')->first();
        $p08 = DB::table('dental_procedures')->where('code', 'P08')->first();
        $p09 = DB::table('dental_procedures')->where('code', 'P09')->first();
        $p12 = DB::table('dental_procedures')->where('code', 'P12')->first();

        $items = [
            // INV-2026-1842 (Rahul Sharma)
            [
                'invoice_id' => $inv1842?->id,
                'procedure_id' => $p04?->id,
                'service_name' => 'Zirconia High-Translucency Crown (#15)',
                'tooth_number' => '15',
                'quantity' => 1,
                'standard_rate' => 8500.00,
                'discount' => 500.00,
                'total' => 8000.00,
            ],

            // INV-2026-1790 (Rahul Sharma)
            [
                'invoice_id' => $inv1790?->id,
                'procedure_id' => $p01?->id,
                'service_name' => 'Single Visit RCT with Digital Apex Locator (#16)',
                'tooth_number' => '16',
                'quantity' => 1,
                'standard_rate' => 4500.00,
                'discount' => 0.00,
                'total' => 4500.00,
            ],
            [
                'invoice_id' => $inv1790?->id,
                'procedure_id' => $p12?->id,
                'service_name' => 'Digital RVG Periapical X-Ray (Pre & Post op)',
                'tooth_number' => '16',
                'quantity' => 2,
                'standard_rate' => 300.00,
                'discount' => 600.00,
                'total' => 0.00,
            ],

            // INV-2026-1620 (Priya Verma)
            [
                'invoice_id' => $inv1620?->id,
                'procedure_id' => $p08?->id,
                'service_name' => 'Zoom In-Office Teeth Whitening (1 Hour)',
                'tooth_number' => null,
                'quantity' => 1,
                'standard_rate' => 9000.00,
                'discount' => 0.00,
                'total' => 9000.00,
            ],

            // INV-2026-1410 (Priya Verma)
            [
                'invoice_id' => $inv1410?->id,
                'procedure_id' => $p06?->id,
                'service_name' => 'Invisible Clear Aligners (Full Course Package)',
                'tooth_number' => null,
                'quantity' => 1,
                'standard_rate' => 75000.00,
                'discount' => 5000.00,
                'total' => 70000.00,
            ],

            // INV-2026-1805 (Amit Meena)
            [
                'invoice_id' => $inv1805?->id,
                'procedure_id' => $p03?->id,
                'service_name' => 'Osstem Dental Implant Fixture & Surgery (#46)',
                'tooth_number' => '46',
                'quantity' => 1,
                'standard_rate' => 28000.00,
                'discount' => 2000.00,
                'total' => 26000.00,
            ],
            [
                'invoice_id' => $inv1805?->id,
                'procedure_id' => $p12?->id,
                'service_name' => 'CBCT 3D Surgical Guide Planning',
                'tooth_number' => '46',
                'quantity' => 1,
                'standard_rate' => 3000.00,
                'discount' => 0.00,
                'total' => 3000.00,
            ],

            // INV-2026-1890 (Sunita Rajawat)
            [
                'invoice_id' => $inv1890?->id,
                'procedure_id' => $p09?->id,
                'service_name' => 'IPS e.max Porcelain Veneers (Anterior 4 teeth)',
                'tooth_number' => '12-22',
                'quantity' => 4,
                'standard_rate' => 11000.00,
                'discount' => 4000.00,
                'total' => 40000.00,
            ],
        ];

        foreach ($items as $item) {
            if (! $item['invoice_id']) {
                continue;
            }

            $existing = DB::table('invoice_items')
                ->where('invoice_id', $item['invoice_id'])
                ->where('service_name', $item['service_name'])
                ->first();

            DB::table('invoice_items')->updateOrInsert(
                [
                    'invoice_id' => $item['invoice_id'],
                    'service_name' => $item['service_name'],
                ],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'procedure_id' => $item['procedure_id'],
                    'tooth_number' => $item['tooth_number'],
                    'quantity' => $item['quantity'],
                    'standard_rate' => $item['standard_rate'],
                    'discount' => $item['discount'],
                    'total' => $item['total'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic = DB::table('clinics')->where('code', 'DR-RENU-JAIPUR')->first();

        $rahul = DB::table('patients')->where('patient_id', 'RD-2024-0412')->first();
        $priya = DB::table('patients')->where('patient_id', 'RD-2024-0589')->first();
        $amit = DB::table('patients')->where('patient_id', 'RD-2024-0195')->first();
        $sunita = DB::table('patients')->where('patient_id', 'RD-2024-0714')->first();

        $invoices = [
            [
                'patient_id' => $rahul?->id,
                'invoice_number' => 'INV-2026-1842',
                'invoice_date' => '2026-09-20',
                'standard_rate' => 8500.00,
                'privilege_discount' => 500.00,
                'taxable_amount' => 8000.00,
                'cgst_rate' => 0.00,
                'cgst_amount' => 0.00,
                'sgst_rate' => 0.00,
                'sgst_amount' => 0.00,
                'igst_rate' => 0.00,
                'igst_amount' => 0.00,
                'net_payable' => 8000.00,
                'paid_amount' => 8000.00,
                'balance_due' => 0.00,
                'payment_mode' => 'upi_phonepe_gpay',
                'status' => 'paid',
                'notes' => 'Zirconia crown delivery and cementation.',
            ],
            [
                'patient_id' => $rahul?->id,
                'invoice_number' => 'INV-2026-1790',
                'invoice_date' => '2026-09-12',
                'standard_rate' => 5100.00,
                'privilege_discount' => 600.00,
                'taxable_amount' => 4500.00,
                'cgst_rate' => 0.00,
                'cgst_amount' => 0.00,
                'sgst_rate' => 0.00,
                'sgst_amount' => 0.00,
                'igst_rate' => 0.00,
                'igst_amount' => 0.00,
                'net_payable' => 4500.00,
                'paid_amount' => 4500.00,
                'balance_due' => 0.00,
                'payment_mode' => 'card',
                'status' => 'paid',
                'notes' => 'Single visit root canal treatment with complimentary digital RVG.',
            ],
            [
                'patient_id' => $priya?->id,
                'invoice_number' => 'INV-2026-1620',
                'invoice_date' => '2026-04-10',
                'standard_rate' => 9000.00,
                'privilege_discount' => 0.00,
                'taxable_amount' => 9000.00,
                'cgst_rate' => 0.00,
                'cgst_amount' => 0.00,
                'sgst_rate' => 0.00,
                'sgst_amount' => 0.00,
                'igst_rate' => 0.00,
                'igst_amount' => 0.00,
                'net_payable' => 9000.00,
                'paid_amount' => 9000.00,
                'balance_due' => 0.00,
                'payment_mode' => 'upi_phonepe_gpay',
                'status' => 'paid',
                'notes' => 'In-office Philips Zoom WhiteSpeed laser teeth whitening session.',
            ],
            [
                'patient_id' => $priya?->id,
                'invoice_number' => 'INV-2026-1410',
                'invoice_date' => '2026-03-01',
                'standard_rate' => 75000.00,
                'privilege_discount' => 5000.00,
                'taxable_amount' => 70000.00,
                'cgst_rate' => 0.00,
                'cgst_amount' => 0.00,
                'sgst_rate' => 0.00,
                'sgst_amount' => 0.00,
                'igst_rate' => 0.00,
                'igst_amount' => 0.00,
                'net_payable' => 70000.00,
                'paid_amount' => 50000.00,
                'balance_due' => 20000.00,
                'payment_mode' => 'bajaj_finserv_emi',
                'status' => 'partially_paid',
                'notes' => 'Invisible Clear Aligners full course package with No Cost EMI financing.',
            ],
            [
                'patient_id' => $amit?->id,
                'invoice_number' => 'INV-2026-1805',
                'invoice_date' => '2026-09-15',
                'standard_rate' => 31000.00,
                'privilege_discount' => 2000.00,
                'taxable_amount' => 29000.00,
                'cgst_rate' => 0.00,
                'cgst_amount' => 0.00,
                'sgst_rate' => 0.00,
                'sgst_amount' => 0.00,
                'igst_rate' => 0.00,
                'igst_amount' => 0.00,
                'net_payable' => 29000.00,
                'paid_amount' => 29000.00,
                'balance_due' => 0.00,
                'payment_mode' => 'net_banking',
                'status' => 'paid',
                'notes' => 'Osstem titanium fixture surgical placement and CBCT 3D guided planning.',
            ],
            [
                'patient_id' => $sunita?->id,
                'invoice_number' => 'INV-2026-1890',
                'invoice_date' => '2026-09-24',
                'standard_rate' => 44000.00,
                'privilege_discount' => 4000.00,
                'taxable_amount' => 40000.00,
                'cgst_rate' => 0.00,
                'cgst_amount' => 0.00,
                'sgst_rate' => 0.00,
                'sgst_amount' => 0.00,
                'igst_rate' => 0.00,
                'igst_amount' => 0.00,
                'net_payable' => 40000.00,
                'paid_amount' => 40000.00,
                'balance_due' => 0.00,
                'payment_mode' => 'card',
                'status' => 'paid',
                'notes' => '4 IPS e.max Porcelain Veneers anterior smile makeover.',
            ],
        ];

        foreach ($invoices as $inv) {
            if (! $inv['patient_id'] || ! $clinic) {
                continue;
            }

            $existing = DB::table('invoices')->where('invoice_number', $inv['invoice_number'])->first();

            DB::table('invoices')->updateOrInsert(
                ['invoice_number' => $inv['invoice_number']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'clinic_id' => $clinic->id,
                    'patient_id' => $inv['patient_id'],
                    'invoice_date' => $inv['invoice_date'],
                    'standard_rate' => $inv['standard_rate'],
                    'privilege_discount' => $inv['privilege_discount'],
                    'taxable_amount' => $inv['taxable_amount'],
                    'cgst_rate' => $inv['cgst_rate'],
                    'cgst_amount' => $inv['cgst_amount'],
                    'sgst_rate' => $inv['sgst_rate'],
                    'sgst_amount' => $inv['sgst_amount'],
                    'igst_rate' => $inv['igst_rate'],
                    'igst_amount' => $inv['igst_amount'],
                    'net_payable' => $inv['net_payable'],
                    'paid_amount' => $inv['paid_amount'],
                    'balance_due' => $inv['balance_due'],
                    'payment_mode' => $inv['payment_mode'],
                    'status' => $inv['status'],
                    'notes' => $inv['notes'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

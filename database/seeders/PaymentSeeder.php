<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pooja = DB::table('users')->where('email', 'pooja.sharma@drrenudentalclinic.com')->first();

        $inv1842 = DB::table('invoices')->where('invoice_number', 'INV-2026-1842')->first();
        $inv1790 = DB::table('invoices')->where('invoice_number', 'INV-2026-1790')->first();
        $inv1620 = DB::table('invoices')->where('invoice_number', 'INV-2026-1620')->first();
        $inv1410 = DB::table('invoices')->where('invoice_number', 'INV-2026-1410')->first();
        $inv1805 = DB::table('invoices')->where('invoice_number', 'INV-2026-1805')->first();
        $inv1890 = DB::table('invoices')->where('invoice_number', 'INV-2026-1890')->first();

        $payments = [
            [
                'invoice_id' => $inv1842?->id,
                'patient_id' => $inv1842?->patient_id,
                'receipt_number' => 'RCP-2026-1842',
                'amount' => 8000.00,
                'payment_mode' => 'upi_phonepe_gpay',
                'transaction_reference' => 'UPI/2609201842/PHONEPE',
                'payment_date' => '2026-09-20 11:45:00',
                'received_by_user_id' => $pooja?->id,
                'notes' => 'Settled via PhonePe QR at reception desk.',
            ],
            [
                'invoice_id' => $inv1790?->id,
                'patient_id' => $inv1790?->patient_id,
                'receipt_number' => 'RCP-2026-1790',
                'amount' => 4500.00,
                'payment_mode' => 'card',
                'transaction_reference' => 'HDFC/VISA/AUTH-9012',
                'payment_date' => '2026-09-12 12:15:00',
                'received_by_user_id' => $pooja?->id,
                'notes' => 'Swiped Visa Credit Card at POS terminal.',
            ],
            [
                'invoice_id' => $inv1620?->id,
                'patient_id' => $inv1620?->patient_id,
                'receipt_number' => 'RCP-2026-1620',
                'amount' => 9000.00,
                'payment_mode' => 'upi_phonepe_gpay',
                'transaction_reference' => 'UPI/2604101620/GPAY',
                'payment_date' => '2026-04-10 16:30:00',
                'received_by_user_id' => $pooja?->id,
                'notes' => 'Google Pay transaction confirmed.',
            ],
            [
                'invoice_id' => $inv1410?->id,
                'patient_id' => $inv1410?->patient_id,
                'receipt_number' => 'RCP-2026-1410',
                'amount' => 50000.00,
                'payment_mode' => 'bajaj_finserv_emi',
                'transaction_reference' => 'BAJAJ-EMI-FIN-982915',
                'payment_date' => '2026-03-01 14:00:00',
                'received_by_user_id' => $pooja?->id,
                'notes' => 'First installment disbursed under No-Cost EMI tenure.',
            ],
            [
                'invoice_id' => $inv1805?->id,
                'patient_id' => $inv1805?->patient_id,
                'receipt_number' => 'RCP-2026-1805',
                'amount' => 29000.00,
                'payment_mode' => 'net_banking',
                'transaction_reference' => 'NEFT-HDFC-992381023',
                'payment_date' => '2026-09-15 17:00:00',
                'received_by_user_id' => $pooja?->id,
                'notes' => 'NEFT direct credit verified by accounts.',
            ],
            [
                'invoice_id' => $inv1890?->id,
                'patient_id' => $inv1890?->patient_id,
                'receipt_number' => 'RCP-2026-1890',
                'amount' => 40000.00,
                'payment_mode' => 'card',
                'transaction_reference' => 'SBI/MC/AUTH-8123',
                'payment_date' => '2026-09-24 13:00:00',
                'received_by_user_id' => $pooja?->id,
                'notes' => 'Mastercard swipe completed.',
            ],
        ];

        foreach ($payments as $pay) {
            if (! $pay['invoice_id'] || ! $pay['patient_id'] || ! $pay['received_by_user_id']) {
                continue;
            }

            $existing = DB::table('payments')->where('receipt_number', $pay['receipt_number'])->first();

            DB::table('payments')->updateOrInsert(
                ['receipt_number' => $pay['receipt_number']],
                [
                    'id' => $existing ? $existing->id : (string) Str::uuid(),
                    'invoice_id' => $pay['invoice_id'],
                    'patient_id' => $pay['patient_id'],
                    'amount' => $pay['amount'],
                    'payment_mode' => $pay['payment_mode'],
                    'transaction_reference' => $pay['transaction_reference'],
                    'payment_date' => $pay['payment_date'],
                    'received_by_user_id' => $pay['received_by_user_id'],
                    'notes' => $pay['notes'],
                    'created_at' => $existing ? $existing->created_at : now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

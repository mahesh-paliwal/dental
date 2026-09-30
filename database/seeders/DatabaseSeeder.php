<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ClinicSeeder::class,
            UserSeeder::class,
            DentalChairSeeder::class,
            DentistProfileSeeder::class,
            DentistScheduleSeeder::class,
            ProcedureCategorySeeder::class,
            DentalProcedureSeeder::class,
            PatientSeeder::class,
            PatientMedicalHistorySeeder::class,
            DentalChartSeeder::class,
            AppointmentSeeder::class,
            PatientFollowUpRequestSeeder::class,
            TreatmentPlanSeeder::class,
            TreatmentTimelineSeeder::class,
            ClinicalNoteSeeder::class,
            PrescriptionSeeder::class,
            PrescriptionItemSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
            PaymentSeeder::class,
            BroadcastTemplateSeeder::class,
            BroadcastCampaignSeeder::class,
            BroadcastCampaignLogSeeder::class,
            PatientAttachmentSeeder::class,
            PatientConsentSeeder::class,
            HistoricalDataSyncLogSeeder::class,
            DentalLabSeeder::class,
            LabOrderSeeder::class,
            InventoryItemSeeder::class,
        ]);
    }
}

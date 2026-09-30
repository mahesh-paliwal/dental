-- ============================================================================
-- Dr. Renu Dental Clinic, Nirman Nagar, Jaipur
-- Clinic Management & Patient Portal - Complete MySQL 8.0+ Schema
-- Primary Keys: UUID auto-generated via DEFAULT (UUID())
-- Fully aligned with Website R&D and Flow Requirements Document
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `dental` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dental`;

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- 1. ROLES & PERMISSIONS
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `name` VARCHAR(50) NOT NULL COMMENT 'admin (Dr. Renu), doctor (Dr. Ravi Chaudhary), staff (Pooja), patient',
    `display_name` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 2. CLINIC PROFILE (Dr. Renu Dental Clinic, Jaipur)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `clinics`;
CREATE TABLE `clinics` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `name` VARCHAR(150) NOT NULL DEFAULT 'Dr. Renu Dental Clinic',
    `code` VARCHAR(50) NOT NULL DEFAULT 'DR-RENU-JAIPUR',
    `registration_number` VARCHAR(100) NOT NULL DEFAULT 'RJ-DC-2015',
    `certifications` VARCHAR(255) NOT NULL DEFAULT 'CBCT and GBT certified',
    `phone` VARCHAR(30) NOT NULL DEFAULT '+91 9650935061',
    `email` VARCHAR(150) NULL,
    `address_line1` VARCHAR(255) NOT NULL DEFAULT '33, Shiv Shakti Nagar',
    `address_line2` VARCHAR(255) NULL DEFAULT 'Nirman Nagar',
    `city` VARCHAR(100) NOT NULL DEFAULT 'Jaipur',
    `state` VARCHAR(100) NOT NULL DEFAULT 'Rajasthan',
    `postal_code` VARCHAR(20) NOT NULL DEFAULT '302019',
    `country` VARCHAR(100) NOT NULL DEFAULT 'India',
    `timezone` VARCHAR(50) NOT NULL DEFAULT 'Asia/Kolkata',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `clinics_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 3. USERS (STAFF, DOCTORS, ADMINS)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `clinic_id` CHAR(36) NULL,
    `role_id` CHAR(36) NULL,
    `name` VARCHAR(150) NOT NULL COMMENT 'Dr. Renu, Dr. Ravi Chaudhary, Pooja',
    `email` VARCHAR(150) NULL,
    `phone` VARCHAR(30) NOT NULL,
    `phone_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NULL,
    `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_phone_unique` (`phone`),
    UNIQUE KEY `users_email_unique` (`email`),
    INDEX `idx_users_role` (`role_id`),
    CONSTRAINT `fk_users_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 4. PATIENT PHONE OTP LOGINS (Patient Portal Login Gateway)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `patient_otps`;
CREATE TABLE `patient_otps` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `phone` VARCHAR(20) NOT NULL,
    `otp_code` VARCHAR(10) NOT NULL,
    `expires_at` DATETIME NOT NULL,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `attempts` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_otps_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 5. OPERATORY CHAIRS & DIAGNOSTIC BAY (Section 4.3 & 5.2)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `dental_chairs`;
CREATE TABLE `dental_chairs` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `clinic_id` CHAR(36) NOT NULL,
    `name` VARCHAR(100) NOT NULL COMMENT 'Chair 1 Main Operatory, Chair 2 Surgical & Implants, CBCT & OPG Diagnostic Bay',
    `chair_type` ENUM('main_operatory', 'surgical_implants', 'diagnostic_bay', 'general') NOT NULL DEFAULT 'general',
    `room_number` VARCHAR(50) NULL,
    `status` ENUM('available', 'in_use', 'maintenance', 'inactive') NOT NULL DEFAULT 'available',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_chairs_clinic` (`clinic_id`, `status`),
    CONSTRAINT `fk_chairs_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 6. DENTIST / DOCTOR PROFILES (Section 4.6)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `dentist_profiles`;
CREATE TABLE `dentist_profiles` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `user_id` CHAR(36) NOT NULL,
    `license_number` VARCHAR(100) NULL,
    `designation` VARCHAR(100) NOT NULL DEFAULT 'Dentist' COMMENT 'Chief Dentist, Implantologist, Orthodontist',
    `specialization` ENUM(
        'chief_dentist',
        'implantologist',
        'orthodontist',
        'endodontist',
        'periodontist',
        'prosthodontist',
        'oral_surgeon',
        'general_dentist'
    ) NOT NULL DEFAULT 'general_dentist',
    `qualification` VARCHAR(255) NOT NULL DEFAULT 'BDS',
    `bio` TEXT NULL,
    `consultation_fee` DECIMAL(10, 2) NOT NULL DEFAULT 500.00,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `dentist_profiles_user_unique` (`user_id`),
    CONSTRAINT `fk_dentist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 7. DENTIST SCHEDULES
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `dentist_schedules`;
CREATE TABLE `dentist_schedules` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `dentist_id` CHAR(36) NOT NULL,
    `clinic_id` CHAR(36) NOT NULL,
    `day_of_week` TINYINT UNSIGNED NOT NULL COMMENT '0=Sunday, 6=Saturday',
    `start_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,
    `break_start` TIME NULL,
    `break_end` TIME NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_schedules_dentist_day` (`dentist_id`, `clinic_id`, `day_of_week`),
    CONSTRAINT `fk_schedules_dentist` FOREIGN KEY (`dentist_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_schedules_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 8. PATIENTS & EMR (6,428 demo records, RD-YYYY-XXXX format)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `patients`;
CREATE TABLE `patients` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `clinic_id` CHAR(36) NOT NULL,
    `attending_doctor_id` CHAR(36) NULL,
    `patient_id` VARCHAR(50) NOT NULL COMMENT 'E.g. RD-2024-0412',
    `full_name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL COMMENT 'Indian phone number +91',
    `age` SMALLINT UNSIGNED NULL,
    `date_of_birth` DATE NULL,
    `gender` ENUM('male', 'female', 'other') NOT NULL,
    `blood_group` VARCHAR(10) NOT NULL DEFAULT 'Unknown',
    `city` VARCHAR(100) NOT NULL DEFAULT 'Jaipur',
    `residential_address` TEXT NULL COMMENT 'Residential Address in Jaipur',
    `medical_alerts` TEXT NULL COMMENT 'Allergies and medical warnings',
    `treatment_status` ENUM(
        'active_treatments',
        'follow_ups_due',
        'completed',
        'inactive'
    ) NOT NULL DEFAULT 'active_treatments',
    `billing_balance` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'Pending amount due',
    `recent_treatment` VARCHAR(200) NULL,
    `last_visit_at` DATETIME NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `patients_id_code_unique` (`patient_id`),
    INDEX `idx_patients_search` (`full_name`, `phone`),
    INDEX `idx_patients_status` (`treatment_status`, `billing_balance`),
    CONSTRAINT `fk_patients_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_patients_doctor` FOREIGN KEY (`attending_doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 9. PATIENT MEDICAL HISTORIES
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `patient_medical_histories`;
CREATE TABLE `patient_medical_histories` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `allergies` TEXT NULL COMMENT 'E.g. Penicillin, Latex, Local Anesthetics',
    `has_diabetes` TINYINT(1) NOT NULL DEFAULT 0,
    `has_hypertension` TINYINT(1) NOT NULL DEFAULT 0,
    `has_cardiac_disease` TINYINT(1) NOT NULL DEFAULT 0,
    `has_bleeding_disorder` TINYINT(1) NOT NULL DEFAULT 0,
    `is_pregnant` TINYINT(1) NOT NULL DEFAULT 0,
    `current_medications` TEXT NULL,
    `medical_notes` TEXT NULL,
    `recorded_by_user_id` CHAR(36) NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `med_history_patient_unique` (`patient_id`),
    CONSTRAINT `fk_med_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_med_user` FOREIGN KEY (`recorded_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 10. TREATMENTS CATALOG (Section 4.5)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `procedure_categories`;
CREATE TABLE `procedure_categories` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `name` VARCHAR(100) NOT NULL COMMENT 'RCT, Implants, Aligners, Scaling & GBT, Whitening, Diagnostics',
    `code` VARCHAR(50) NOT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `proc_cat_name_unique` (`name`),
    UNIQUE KEY `proc_cat_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dental_procedures`;
CREATE TABLE `dental_procedures` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `category_id` CHAR(36) NOT NULL,
    `code` VARCHAR(50) NOT NULL,
    `name` VARCHAR(200) NOT NULL COMMENT 'E.g. Single Sitting RCT, GBT Scaling, Titanium Implant, Zirconia Crown',
    `description` TEXT NULL,
    `standard_rate` DECIMAL(10, 2) NOT NULL DEFAULT 4500.00 COMMENT 'Standard Clinic Pricing (₹)',
    `sitting_duration_minutes` INT UNSIGNED NOT NULL DEFAULT 45,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `proc_code_unique` (`code`),
    INDEX `idx_procedures_cat` (`category_id`, `is_active`),
    CONSTRAINT `fk_proc_category` FOREIGN KEY (`category_id`) REFERENCES `procedure_categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 11. TODAY'S OPERATORY QUEUE & APPOINTMENTS (Section 4.1, 4.3 & 5.2)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `doctor_id` CHAR(36) NOT NULL,
    `chair_id` CHAR(36) NULL COMMENT 'Chair 1, Chair 2, Diagnostic Bay',
    `procedure_id` CHAR(36) NULL,
    `appointment_date` DATE NOT NULL,
    `time_slot` VARCHAR(50) NOT NULL COMMENT 'E.g. 10:30 AM - 11:15 AM',
    `scheduled_start` DATETIME NOT NULL,
    `scheduled_end` DATETIME NOT NULL,
    `status` ENUM(
        'scheduled',
        'confirmed',
        'in_chair',
        'completed',
        'cancelled',
        'no_show'
    ) NOT NULL DEFAULT 'scheduled',
    `is_walk_in` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '+ Add Walk-In Patient',
    `queue_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `purpose` TEXT NULL,
    `cancellation_reason` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_appointments_date_status` (`appointment_date`, `status`),
    INDEX `idx_appointments_doctor` (`doctor_id`, `appointment_date`),
    INDEX `idx_appointments_chair` (`chair_id`, `appointment_date`),
    CONSTRAINT `fk_appt_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_appt_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_appt_chair` FOREIGN KEY (`chair_id`) REFERENCES `dental_chairs` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_appt_proc` FOREIGN KEY (`procedure_id`) REFERENCES `dental_procedures` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 12. PATIENT PORTAL FOLLOW-UP REQUESTS (Section 6)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `patient_follow_up_requests`;
CREATE TABLE `patient_follow_up_requests` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `preferred_date` DATE NOT NULL,
    `preferred_time_slot` ENUM('morning', 'afternoon', 'evening') NOT NULL COMMENT 'Morning: 10-1, Afternoon: 2-5, Evening: 5-8:30',
    `pain_symptoms` TEXT NULL COMMENT 'Reason for Visit / Any Pain or Symptoms',
    `status` ENUM('pending', 'confirmed', 'rejected', 'cancelled') NOT NULL DEFAULT 'pending',
    `confirmation_channel` ENUM('whatsapp', 'phone_call') NOT NULL DEFAULT 'whatsapp',
    `confirmed_by_user_id` CHAR(36) NULL COMMENT 'Front Desk Coordinator Pooja',
    `created_appointment_id` CHAR(36) NULL,
    `staff_response_notes` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_requests_patient` (`patient_id`, `status`),
    INDEX `idx_requests_date` (`preferred_date`, `status`),
    CONSTRAINT `fk_req_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_req_user` FOREIGN KEY (`confirmed_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_req_appt` FOREIGN KEY (`created_appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 13. 32-TOOTH ODONTOGRAM (FDI 11 to 48, Section 5.5 & 5.6)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `dental_charts`;
CREATE TABLE `dental_charts` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `doctor_id` CHAR(36) NOT NULL,
    `tooth_number` TINYINT UNSIGNED NOT NULL COMMENT 'FDI: 11-18, 21-28, 31-38, 41-48',
    `status` ENUM(
        'healthy',
        'completed_rct',
        'zirconia_ceramic_crown',
        'titanium_implant',
        'caries',
        'composite_filling',
        'porcelain_veneer',
        'extracted_missing'
    ) NOT NULL DEFAULT 'healthy',
    `clinical_notes_material` TEXT NULL COMMENT 'Clinical Notes / Material',
    `updated_at_clinical` DATETIME NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `dental_charts_patient_tooth_unique` (`patient_id`, `tooth_number`),
    INDEX `idx_charts_status` (`patient_id`, `status`),
    CONSTRAINT `fk_charts_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_charts_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 14. TREATMENT PLANS & TIMELINE (Sections 4.1 & 5.5)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `treatment_plans`;
CREATE TABLE `treatment_plans` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `doctor_id` CHAR(36) NOT NULL,
    `title` VARCHAR(200) NOT NULL COMMENT 'RCT, Implants, Aligners',
    `treatment_type` ENUM('rct', 'implants', 'aligners', 'crowns_bridges', 'periodontics', 'general') NOT NULL DEFAULT 'general',
    `status` ENUM('proposed', 'active', 'completed', 'cancelled') NOT NULL DEFAULT 'active',
    `total_estimated_cost` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `start_date` DATE NULL,
    `expected_completion_date` DATE NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_plans_patient` (`patient_id`, `status`),
    CONSTRAINT `fk_plan_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_plan_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `treatment_timelines`;
CREATE TABLE `treatment_timelines` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `doctor_id` CHAR(36) NOT NULL,
    `appointment_id` CHAR(36) NULL,
    `treatment_plan_id` CHAR(36) NULL,
    `procedure_id` CHAR(36) NULL,
    `procedure_name` VARCHAR(200) NOT NULL,
    `tooth_number` VARCHAR(10) NULL,
    `treatment_date` DATE NOT NULL,
    `clinical_notes` TEXT NULL,
    `cost` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_timeline_patient_date` (`patient_id`, `treatment_date`),
    CONSTRAINT `fk_timeline_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_timeline_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_timeline_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_timeline_plan` FOREIGN KEY (`treatment_plan_id`) REFERENCES `treatment_plans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 15. CLINICAL NOTES (EMR Dossier)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `clinical_notes`;
CREATE TABLE `clinical_notes` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `doctor_id` CHAR(36) NOT NULL,
    `appointment_id` CHAR(36) NULL,
    `chief_complaint` TEXT NULL,
    `clinical_findings` TEXT NULL,
    `diagnosis` TEXT NULL,
    `procedure_performed` TEXT NULL,
    `post_op_advice` TEXT NULL,
    `note_date` DATETIME NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_clinical_notes_patient` (`patient_id`, `note_date`),
    CONSTRAINT `fk_cnotes_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_cnotes_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_cnotes_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 16. PRESCRIPTIONS (Rx) & MEDICINES (Section 5.5 & 6)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `prescriptions`;
CREATE TABLE `prescriptions` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `doctor_id` CHAR(36) NOT NULL,
    `appointment_id` CHAR(36) NULL,
    `prescription_number` VARCHAR(50) NOT NULL,
    `prescription_date` DATE NOT NULL,
    `post_op_advice` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `prescriptions_number_unique` (`prescription_number`),
    INDEX `idx_prescriptions_patient` (`patient_id`, `prescription_date`),
    CONSTRAINT `fk_rx_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_rx_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_rx_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `prescription_items`;
CREATE TABLE `prescription_items` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `prescription_id` CHAR(36) NOT NULL,
    `medication_name` VARCHAR(200) NOT NULL,
    `dosage` VARCHAR(100) NOT NULL,
    `frequency` VARCHAR(100) NOT NULL,
    `duration` VARCHAR(100) NOT NULL,
    `instructions` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_rx_items_parent` (`prescription_id`),
    CONSTRAINT `fk_rx_items_parent` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 17. OFFICIAL GST DENTAL TAX INVOICES & PAYMENTS (Section 4.4 & 5.3)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `clinic_id` CHAR(36) NOT NULL,
    `patient_id` CHAR(36) NOT NULL,
    `appointment_id` CHAR(36) NULL,
    `invoice_number` VARCHAR(50) NOT NULL,
    `invoice_date` DATE NOT NULL,
    `standard_rate` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `privilege_discount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'Privilege Discount (₹)',
    `taxable_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `cgst_rate` DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
    `cgst_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `sgst_rate` DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
    `sgst_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `igst_rate` DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
    `igst_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `net_payable` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'Live Net Payable (₹)',
    `paid_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `balance_due` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `payment_mode` ENUM(
        'upi_phonepe_gpay',
        'cash',
        'card',
        'bajaj_finserv_emi',
        'net_banking'
    ) NOT NULL DEFAULT 'upi_phonepe_gpay',
    `status` ENUM('paid', 'partially_paid', 'unpaid', 'void') NOT NULL DEFAULT 'unpaid',
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `invoices_num_unique` (`invoice_number`),
    INDEX `idx_invoices_patient` (`patient_id`, `status`),
    INDEX `idx_invoices_date` (`invoice_date`, `status`),
    CONSTRAINT `fk_inv_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_inv_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_inv_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE `invoice_items` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `invoice_id` CHAR(36) NOT NULL,
    `procedure_id` CHAR(36) NULL,
    `service_name` VARCHAR(255) NOT NULL,
    `tooth_number` VARCHAR(10) NULL,
    `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
    `standard_rate` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `discount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `total` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_inv_items_parent` (`invoice_id`),
    CONSTRAINT `fk_inv_items_parent` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_inv_items_proc` FOREIGN KEY (`procedure_id`) REFERENCES `dental_procedures` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `invoice_id` CHAR(36) NOT NULL,
    `patient_id` CHAR(36) NOT NULL,
    `receipt_number` VARCHAR(50) NOT NULL COMMENT 'Official clinic printable receipt number',
    `amount` DECIMAL(10, 2) NOT NULL,
    `payment_mode` ENUM(
        'upi_phonepe_gpay',
        'cash',
        'card',
        'bajaj_finserv_emi',
        'net_banking'
    ) NOT NULL,
    `transaction_reference` VARCHAR(150) NULL,
    `payment_date` DATETIME NOT NULL,
    `received_by_user_id` CHAR(36) NOT NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `payments_receipt_unique` (`receipt_number`),
    INDEX `idx_pay_invoice` (`invoice_id`, `payment_date`),
    INDEX `idx_pay_patient` (`patient_id`, `payment_date`),
    CONSTRAINT `fk_pay_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pay_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_pay_user` FOREIGN KEY (`received_by_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 18. BULK SMS, WHATSAPP & BROADCAST CENTER (Section 4.7)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `broadcast_templates`;
CREATE TABLE `broadcast_templates` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `name` VARCHAR(150) NOT NULL COMMENT '6-month scaling recall, festive greetings, 20% whitening privilege',
    `channel` ENUM('sms', 'whatsapp', 'in_portal_notice') NOT NULL DEFAULT 'sms',
    `dlt_template_id` VARCHAR(100) NULL,
    `message_template` TEXT NOT NULL COMMENT '{patient_name}, {doctor_name}, {clinic_phone}, {portal_link}',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `broadcast_campaigns`;
CREATE TABLE `broadcast_campaigns` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `clinic_id` CHAR(36) NOT NULL,
    `template_id` CHAR(36) NULL,
    `title` VARCHAR(200) NOT NULL,
    `channel` ENUM('sms', 'whatsapp', 'in_portal_notice') NOT NULL DEFAULT 'sms',
    `audience_segment` ENUM(
        'all_patients',
        'six_month_scaling_recall',
        'active_treatment_plans',
        'rct_follow_up',
        'dental_implant_patients',
        'aligners_smile_patients',
        'custom'
    ) NOT NULL DEFAULT 'all_patients',
    `message_body` TEXT NOT NULL,
    `dlt_sender_id` VARCHAR(20) NOT NULL DEFAULT 'DRRENU',
    `total_recipients` INT UNSIGNED NOT NULL DEFAULT 0,
    `sent_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `delivered_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `failed_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `credits_used` INT UNSIGNED NOT NULL DEFAULT 0,
    `status` ENUM('draft', 'scheduled', 'sending', 'completed', 'failed') NOT NULL DEFAULT 'draft',
    `scheduled_at` DATETIME NULL,
    `sent_at` DATETIME NULL,
    `created_by_user_id` CHAR(36) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_campaigns_channel` (`channel`, `status`),
    INDEX `idx_campaigns_schedule` (`scheduled_at`, `status`),
    CONSTRAINT `fk_camp_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_camp_template` FOREIGN KEY (`template_id`) REFERENCES `broadcast_templates` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_camp_user` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `broadcast_campaign_logs`;
CREATE TABLE `broadcast_campaign_logs` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `campaign_id` CHAR(36) NOT NULL,
    `patient_id` CHAR(36) NOT NULL,
    `mobile_phone` VARCHAR(20) NOT NULL,
    `status` ENUM('queued', 'sent', 'delivered', 'failed') NOT NULL DEFAULT 'queued',
    `gateway_message_id` VARCHAR(150) NULL,
    `error_message` TEXT NULL,
    `delivered_at` DATETIME NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_log_campaign` (`campaign_id`, `status`),
    INDEX `idx_log_patient` (`patient_id`, `campaign_id`),
    CONSTRAINT `fk_log_campaign` FOREIGN KEY (`campaign_id`) REFERENCES `broadcast_campaigns` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_log_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 19. DIGITAL X-RAYS, CBCT & IMAGING (Section 5.5)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `patient_attachments`;
CREATE TABLE `patient_attachments` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `appointment_id` CHAR(36) NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `file_path` VARCHAR(500) NOT NULL,
    `file_type` VARCHAR(50) NOT NULL,
    `file_size_bytes` BIGINT UNSIGNED NOT NULL,
    `category` ENUM(
        'cbct_3d',
        'opg_panoramic',
        'rvg_xray',
        'intraoral_photo',
        'treatment_consent',
        'other'
    ) NOT NULL DEFAULT 'cbct_3d',
    `tooth_number` VARCHAR(10) NULL,
    `notes` TEXT NULL,
    `uploaded_by_user_id` CHAR(36) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_attach_patient` (`patient_id`, `category`),
    CONSTRAINT `fk_attach_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_attach_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_attach_user` FOREIGN KEY (`uploaded_by_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 20. DIGITAL CONSENTS (India DPDP Act Compliance & Clinical Consents)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `patient_consents`;
CREATE TABLE `patient_consents` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `patient_id` CHAR(36) NOT NULL,
    `consent_type` ENUM(
        'dpdp_act_data_privacy',
        'root_canal_treatment',
        'dental_implant_surgery',
        'clear_aligners_orthodontic',
        'tooth_extraction',
        'local_anesthesia'
    ) NOT NULL,
    `is_agreed` TINYINT(1) NOT NULL DEFAULT 1,
    `digital_signature_hash` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `agreed_at` DATETIME NOT NULL,
    `witnessed_by_user_id` CHAR(36) NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_consents_patient` (`patient_id`, `consent_type`),
    CONSTRAINT `fk_consent_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_consent_user` FOREIGN KEY (`witnessed_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 21. HISTORICAL 6,000+ CSV DATA SYNC LOGS (Section 5.4)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `historical_data_sync_logs`;
CREATE TABLE `historical_data_sync_logs` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `clinic_id` CHAR(36) NOT NULL,
    `file_name` VARCHAR(255) NOT NULL DEFAULT 'historical_patients_6000.csv',
    `total_rows_detected` INT UNSIGNED NOT NULL DEFAULT 6428,
    `synced_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `failed_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `status` ENUM('pending', 'in_progress', 'completed', 'failed') NOT NULL DEFAULT 'pending',
    `sync_summary` TEXT NULL,
    `synced_by_user_id` CHAR(36) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_sync_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sync_user` FOREIGN KEY (`synced_by_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 22. DENTAL LABS & PROSTHETICS ORDERS (Section 9)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `dental_labs`;
CREATE TABLE `dental_labs` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `name` VARCHAR(150) NOT NULL,
    `contact_person` VARCHAR(100) NULL,
    `phone` VARCHAR(30) NOT NULL,
    `email` VARCHAR(150) NULL,
    `city` VARCHAR(100) NOT NULL DEFAULT 'Jaipur',
    `average_turnaround_days` INT UNSIGNED NOT NULL DEFAULT 5,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `lab_orders`;
CREATE TABLE `lab_orders` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `lab_id` CHAR(36) NOT NULL,
    `patient_id` CHAR(36) NOT NULL,
    `doctor_id` CHAR(36) NOT NULL,
    `order_number` VARCHAR(50) NOT NULL,
    `restoration_type` ENUM(
        'zirconia_ceramic_crown',
        'porcelain_veneer',
        'clear_aligner_set',
        'implant_abutment_crown',
        'acrylic_denture',
        'cast_partial_denture',
        'other'
    ) NOT NULL,
    `tooth_number` VARCHAR(50) NOT NULL,
    `shade` VARCHAR(50) NULL,
    `order_date` DATE NOT NULL,
    `due_date` DATE NOT NULL,
    `received_date` DATE NULL,
    `status` ENUM('sent', 'in_progress', 'received', 'fitted', 'remake', 'cancelled') NOT NULL DEFAULT 'sent',
    `lab_cost` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `instructions` TEXT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `lab_orders_num_unique` (`order_number`),
    INDEX `idx_lab_orders_lab` (`lab_id`, `status`),
    INDEX `idx_lab_orders_patient` (`patient_id`, `status`),
    CONSTRAINT `fk_lab_orders_lab` FOREIGN KEY (`lab_id`) REFERENCES `dental_labs` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_lab_orders_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_lab_orders_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `dentist_profiles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 23. CLINICAL INVENTORY & CONSUMABLES (Section 9)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `inventory_items`;
CREATE TABLE `inventory_items` (
    `id` CHAR(36) NOT NULL DEFAULT (UUID()),
    `clinic_id` CHAR(36) NOT NULL,
    `item_name` VARCHAR(200) NOT NULL,
    `sku` VARCHAR(100) NOT NULL,
    `category` VARCHAR(100) NOT NULL DEFAULT 'Clinical Consumables',
    `unit` VARCHAR(50) NOT NULL DEFAULT 'box',
    `stock_quantity` INT NOT NULL DEFAULT 0,
    `low_stock_alert_threshold` INT NOT NULL DEFAULT 10,
    `unit_price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `expiry_date` DATE NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `inv_items_sku_unique` (`sku`),
    INDEX `idx_inv_clinic` (`clinic_id`),
    CONSTRAINT `fk_inv_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

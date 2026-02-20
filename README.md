# Hospital Management System

Role-based hospital platform built with Laravel, Blade, Tailwind, and Alpine.js. The system supports end-to-end hospital workflows including appointments, checkups, lab operations, pharmacy, admissions, and cashier billing.

## Core Modules

- Patient registration and profile management
- Appointment scheduling and follow-up
- Pretest and checkup/consultation workflow
- Prescription and pharmacy operations
- Lab Test Ordering & Results Management
- Billing / Cashier module (invoices, payments, insurance claims, reports)
- Role-based dashboards and sidebar navigation

## Roles

- Admin
- Receptionist
- Doctor
- Nurse
- Pharmacist
- Lab Technician (`Lab Technician` / `lab_technician`)
- Cashier
- Patient

## Tech Stack

- PHP 8.2+
- Laravel 10
- MySQL / MariaDB
- Blade Templates
- Tailwind CSS
- Alpine.js

## Quick Setup

1. Install dependencies

```bash
composer install
npm install
```

2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

3. Set DB credentials in `.env`, then run migrations and seeders

```bash
php artisan migrate --seed
```

4. Link storage and run app

```bash
php artisan storage:link
npm run dev
php artisan serve
```

## Billing Module (Cashier)

### Features

- Create invoices with dynamic line items
- Apply discount and tax calculations
- Save invoice as draft or pending
- Record payments with method/reference
- Auto-update invoice payment status (`pending`, `partially_paid`, `paid`)
- Auto-create insurance claim when payment method is `insurance`
- Daily and monthly cashier reports
- Patient billing history
- Printable invoice view
- Admin billing settings and insurance claim management

### Main Data Tables

- `invoices`
- `invoice_items`
- `payments`
- `insurance_claims`
- `billing_settings`

### Key Cashier Routes

- `cashier.billing-dashboard`
- `cashier.billing-queue`
- `cashier.invoices.create`
- `cashier.invoices.store`
- `cashier.invoices.show`
- `cashier.invoices.payment`
- `cashier.invoices.payments`
- `cashier.reports.daily`
- `cashier.reports.monthly`

### Key Admin Billing Routes

- `admin.billing.settings.edit`
- `admin.billing.settings.update`
- `admin.billing.reports.index`
- `admin.billing.insurance-claims.index`
- `admin.billing.insurance-claims.update`

## Lab Module (Doctor / Lab Technician)

### Features

- Doctors create lab orders per patient/checkup
- Lab technicians process pending orders and enter results
- Completed results available in doctor-facing views
- Sidebar badges for pending lab tasks and unread completed results

### Main Data Tables

- `lab_tests`
- `lab_orders`
- `lab_order_items`

## Notes for Development

- Run `php artisan route:list` to inspect role routes.
- Use seeded settings for billing defaults (`BillingSettingSeeder`).
- If reports/files are not accessible, re-run `php artisan storage:link`.

## License

This project follows the Laravel ecosystem conventions and is intended for educational and internal hospital workflow use.

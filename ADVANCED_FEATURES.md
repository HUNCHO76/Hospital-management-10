# Hospital Management System - Advanced Features Implementation

## Summary of Implementations

### ✅ Feature #1: Role-Based Authorization Middleware
### ✅ Feature #2: Complete Pharmacy Inventory System  
### ✅ Feature #3: Email & SMS Notification System

---

## **1. ROLE-BASED AUTHORIZATION MIDDLEWARE**

### Architecture
- **Middleware Class**: `App\Http\Middleware\CheckUserRole`
- **Permission Manager**: `App\Permission\Authorization`
- **Kernel Registration**: Added to `$middlewareAliases` as `'role'`

### Usage in Routes
```php
// Restrict to admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    // admin routes
});

// Allow multiple roles
Route::middleware(['auth', 'role:doctor,admin'])->group(function () {
    // doctor and admin routes
});

// Pharmacist only
Route::middleware(['auth', 'role:pharmacist,admin'])->group(function () {
    // pharmacy routes
});
```

### Defined Roles & Permissions

**Roles Available:**
- `admin` - Full system access
- `doctor` - Patient care and medical records
- `nurse` - Patient care and admissions
- `pharmacist` - Medicine management
- `Lab Technician` - Laboratory operations
- `receptionist` - Appointment and patient registration
- `cashier` - Payment processing
- `local` - Patient/public user

### Permission Matrix

#### Admin Permissions
```
- manage_users
- manage_doctors
- manage_staff
- view_all_records
- edit_all_records
- delete_records
- manage_settings
- view_analytics
- manage_departments
- manage_roles
```

#### Doctor Permissions
```
- view_own_appointments
- view_own_patients
- create_medical_records
- view_medical_records
- create_prescriptions
- create_diagnoses
- upload_documents
- view_lab_results
```

#### Nurse Permissions
```
- view_appointments
- view_patients
- record_vital_signs
- create_checkups
- view_medical_records
- manage_admissions
- manage_rooms
```

#### Pharmacist Permissions
```
- manage_inventory
- view_prescriptions
- issue_medicines
- manage_stock
- view_expiry_dates
- create_orders
```

#### Receptionist Permissions
```
- manage_appointments
- register_patients
- view_patient_info
- manage_schedules
```

#### Cashier Permissions
```
- view_bills
- create_invoices
- process_payments
- generate_receipts
- view_payment_history
```

### Helper Functions
```php
// Check single role
Authorization::hasRole($user, 'doctor');

// Check any role
Authorization::hasAnyRole($user, ['doctor', 'nurse']);

// Check specific permission
Authorization::hasPermission($user, 'create_prescriptions');

// Check any permission
Authorization::hasAnyPermission($user, ['view_bills', 'create_invoices']);

// Check all permissions
Authorization::hasAllPermissions($user, ['view_bills', 'create_invoices']);

// Get role permissions
Authorization::getPermissions('pharmacist');

// Get all roles
Authorization::getRoles();
```

### In Blade Templates
```blade
@if(Auth::user()->Role === 'doctor')
    <!-- Doctor-only content -->
@endif

@can('create_prescriptions')
    <!-- Show prescription button -->
@endcan
```

---

## **2. COMPLETE PHARMACY INVENTORY SYSTEM**

### Database Schema

#### medicines table
```sql
- id
- name (medicine name)
- generic_name
- description
- category (antibiotic, pain relief, etc.)
- manufacturer_id (FK)
- unit_price (decimal)
- strength (e.g., 500mg)
- route (oral, injection, topical)
- is_controlled (boolean)
- requires_prescription (boolean)
- timestamps
```

#### medicine_inventories table
```sql
- id
- medicine_id (unique FK)
- available_quantity
- reserved_quantity
- minimum_stock_level
- maximum_stock_level
- reorder_quantity
- last_restocked_at
- storage_location
- timestamps
```

#### medicine_batches table
```sql
- id
- medicine_id (FK)
- batch_number (unique)
- expiry_date
- manufacture_date
- quantity_received
- quantity_available
- supplier_id (FK)
- cost_price
- received_at
- timestamps
```

#### medicine_manufacturers table
```sql
- id
- name
- country
- contact_email
- contact_phone
- address
- license_number
- timestamps
```

#### medicine_suppliers table
```sql
- id
- name
- contact_person
- contact_email
- contact_phone
- address
- city
- country
- payment_terms
- delivery_days
- is_active (boolean)
- timestamps
```

#### medicine_orders table
```sql
- id
- order_number (unique)
- supplier_id (FK)
- order_date
- expected_delivery_date
- actual_delivery_date
- total_amount
- status (pending, processing, delivered, cancelled)
- ordered_by (user FK)
- notes
- timestamps
```

#### medicine_order_items table
```sql
- id
- medicine_order_id (FK)
- medicine_id (FK)
- quantity
- received_quantity
- unit_price
- total_amount
- timestamps
```

### Models & Relationships

**Medicine Model**
```php
// Relationships
- manufacturer() → MedicineManufacturer
- inventory() → MedicineInventory (one-to-one)
- batches() → MedicineBatch (one-to-many)
- prescriptions() → Prescription (one-to-many)
- orderItems() → MedicineOrderItem (one-to-many)

// Accessors
- $medicine->available_stock
- $medicine->low_stock_warning
```

**MedicineInventory Model**
```php
// Relationships
- medicine() → Medicine

// Accessors
- $inventory->total_quantity (available + reserved)
- $inventory->stock_percentage

// Methods
- needsReorder() → boolean
```

**MedicineBatch Model**
```php
// Relationships
- medicine() → Medicine
- supplier() → MedicineSupplier

// Accessors
- $batch->is_expired
- $batch->expiry_status (expired, expiring_soon, valid)

// Methods
- getExpiryStatusAttribute()
```

**MedicineOrder Model**
```php
// Relationships
- supplier() → MedicineSupplier
- items() → MedicineOrderItem (one-to-many)
- orderedBy() → User

// Accessors
- $order->total_items
- $order->received_items

// Methods
- canBeCancelled() → boolean
```

**MedicineOrderItem Model**
```php
// Relationships
- medOrder() → MedicineOrder
- medicine() → Medicine

// Accessors
- $item->pending_quantity
- $item->received_percentage
```

### Pharmacy Controller Methods

#### Dashboard
```php
PharmacyController@dashboard()
// Returns:
- Total medicines count
- Low stock items count
- Expired batches count
- Pending orders count
- Recent orders (10)
- Expiring medicines (next 30 days)
- Low stock items
```

#### Inventory Management
```php
PharmacyController@inventory(Request)
// Features:
- Search by name/generic name
- Filter by category
- Filter by status (low stock, out of stock)
- Pagination (15 per page)
- Display stock levels with percentages
```

#### Batch Management
```php
PharmacyController@batches(Request)
// Features:
- Filter by medicine
- Filter by expiry status
- Sort by expiry date
- Show batch numbers
- Track availability
```

#### Order Management
```php
PharmacyController@orders(Request)
// Features:
- List all orders with status
- Filter by status (pending, processing, delivered, cancelled)
- Filter by supplier
- Show order totals
- Track delivery status

PharmacyController@createOrder()
// Show form to create new order

PharmacyController@storeOrder(Request)
// Create order with items
// Validate quantities and prices

PharmacyController@updateOrderStatus(Request, MedicineOrder)
// Update order status
// Set delivery date when delivered

PharmacyController@receiveBatch(Request, $orderItemId)
// Record batch receipt
// Create batch record
// Update inventory
// Track cost price and expiry
```

#### Medicine Dispensing
```php
PharmacyController@dispenseMedicine(Request)
// Dispense medicine to patient
// Validate sufficient stock
// Deduct from inventory
// Track prescription association
```

### Routes Added

```php
Route::middleware(['auth', 'role:pharmacist,admin'])->prefix('/pharmacy')->group(function () {
    GET    /pharmacy/dashboard          // Pharmacy dashboard
    GET    /pharmacy/inventory          // View inventory with search/filter
    GET    /pharmacy/batches            // View medicine batches
    GET    /pharmacy/orders             // View orders
    GET    /pharmacy/orders/create      // Order creation form
    POST   /pharmacy/orders             // Store new order
    POST   /pharmacy/orders/{id}/status // Update order status
    POST   /pharmacy/batch/{item}/receive // Receive batch
    POST   /pharmacy/dispense           // Dispense medicine
});
```

### Usage Examples

#### Create Order
```php
$order = MedicineOrder::create([
    'order_number' => 'ORD-123456',
    'supplier_id' => 1,
    'expected_delivery_date' => now()->addDays(7),
    'status' => 'pending',
    'ordered_by' => auth()->id(),
    'order_date' => now(),
]);

// Add items
$order->items()->create([
    'medicine_id' => 5,
    'quantity' => 100,
    'unit_price' => 5.50,
    'total_amount' => 550,
]);
```

#### Track Low Stock
```php
$lowStock = MedicineInventory::whereRaw('available_quantity <= minimum_stock_level')->get();

foreach ($lowStock as $item) {
    if ($item->needsReorder()) {
        // Create purchase order
    }
}
```

#### Check Expiry
```php
$expiringBatches = MedicineBatch::where('expiry_date', '<=', now()->addMonth())->get();

foreach ($expiringBatches as $batch) {
    if ($batch->expiry_status === 'expired') {
        // Mark for removal
    }
}
```

---

## **3. NOTIFICATION SYSTEM (EMAIL & SMS)**

### Architecture

**Components:**
- **Model**: `App\Models\Notification`
- **Service**: `App\Services\NotificationService`
- **Mail**: `App\Mail\NotificationMail`
- **Events/Listeners**: AppointmentScheduled, SendAppointmentReminder
- **Controller**: `App\Http\Controllers\NotificationController`

### Notification Model

**Database Fields:**
```sql
- id
- recipient_id (FK to users)
- type (appointment, prescription, lab_result, bill, admission, system)
- channel (email, sms, push)
- title
- message
- data (json - additional context)
- sent_at (timestamp)
- status (pending, sent, failed, bounce)
- retry_count
- last_error
- read_at (timestamp)
- timestamps
```

**Constants:**
```php
TYPE_APPOINTMENT    => 'appointment'
TYPE_PRESCRIPTION   => 'prescription'
TYPE_LAB_RESULT     => 'lab_result'
TYPE_BILL           => 'bill'
TYPE_ADMISSION      => 'admission'
TYPE_SYSTEM         => 'system'

CHANNEL_EMAIL       => 'email'
CHANNEL_SMS         => 'sms'
CHANNEL_PUSH        => 'push'

STATUS_PENDING      => 'pending'
STATUS_SENT         => 'sent'
STATUS_FAILED       => 'failed'
STATUS_BOUNCE       => 'bounce'
```

### NotificationService Methods

#### Send Appointment Reminders
```php
$service->sendAppointmentReminder($appointment)
// Creates notifications for:
// - Email to patient
// - SMS to patient phone
// - Appointment details in data field
```

#### Send Lab Results
```php
$service->sendLabResultNotification($labResult)
// Notifies patient of available results
// Supports email and SMS
```

#### Send Prescriptions
```php
$service->sendPrescriptionNotification($prescription)
// Notifies patient to pick up prescription
// Links to pharmacy system
```

#### Send Bills
```php
$service->sendBillNotification($bill)
// Invoice notification
// Amount and due date in data
```

#### Send Admission
```php
$service->sendAdmissionNotification($admission)
// Confirms admission
// Includes room number and doctor
```

#### Create Notification
```php
$service->createNotification(
    $userId,
    'appointment',
    'email',
    'Appointment Reminder',
    'You have an appointment tomorrow',
    ['appointment_id' => 1]
)
```

#### Send Notification
```php
$service->sendNotification($notification)
// Dispatches notification via configured channel
// Updates status based on result
// Handles retries
```

#### Get Pending Notifications
```php
$service->getPendingNotifications($userId, 10)
// Get unprocessed notifications for user
// Useful for background job queues
```

#### Send All Pending
```php
$service->sendPendingNotifications(100)
// Send up to 100 pending notifications
// Use in scheduled job for batch processing
```

#### Mark All As Read
```php
$service->markAllAsRead($userId)
// Mark all user notifications as read
```

### NotificationController Routes

```php
GET    /notifications                    // List notifications with filters
POST   /notifications/{id}/mark-read     // Mark single as read
POST   /notifications/mark-all-read      // Mark all as read
DELETE /notifications/{id}               // Delete notification
GET    /notifications/api/pending        // Get pending count (API)
```

### Email Implementation

**Mail Class**: `App\Mail\NotificationMail`
```php
// Sends formatted email with:
- Title
- Message
- Action button (optional)
- Branding
```

**Blade Template**: `resources/views/emails/notification.blade.php`
```blade
Displays title, message, and view details button
```

### SMS Integration Points

**Supported Providers:**
- Twilio
- Africa's Talking
- AWS SNS
- Vonage

**Configuration in `.env`:**
```
SMS_PROVIDER=africas_talking  // or twilio, aws_sns, vonage
AFRICAS_TALKING_API_KEY=xxx
AFRICAS_TALKING_USERNAME=xxx
TWILIO_ACCOUNT_SID=xxx
TWILIO_AUTH_TOKEN=xxx
```

**Usage Example:**
```php
// In config/services.php
'africas_talking' => [
    'api_key' => env('AFRICAS_TALKING_API_KEY'),
    'username' => env('AFRICAS_TALKING_USERNAME'),
],
```

### Event-Driven Notifications

**Event**: `App\Events\AppointmentScheduled`
```php
// Fired when appointment is created
event(new AppointmentScheduled($appointment));
```

**Listener**: `App\Listeners\SendAppointmentReminder`
```php
// Automatically sends reminder email/SMS
```

**Registration in EventServiceProvider:**
```php
protected $listen = [
    AppointmentScheduled::class => [
        SendAppointmentReminder::class,
    ],
];
```

### Notification Status Tracking

**Pending** → Not yet sent
- Created but not processed
- Ready for sending

**Sent** → Successfully delivered
- Email confirmed
- SMS sent to provider

**Failed** → Delivery failed
- Can be retried (up to 3 times)
- Error logged

**Bounce** → Invalid recipient
- Email bounced
- SMS to invalid number

### Usage in Application

#### Trigger on Appointment Creation
```php
// In AppointmentController@store
$appointment = Appointment::create($validated);
event(new AppointmentScheduled($appointment));
```

#### Manual Notification
```php
$service = app(NotificationService::class);
$service->sendAppointmentReminder($appointment);
```

#### In Blade (Display Notifications)
```blade
@for User Notifications
@php
    $unread = \App\Models\Notification::where('recipient_id', auth()->id())
        ->whereNull('read_at')
        ->count();
@endphp

<span class="badge">{{ $unread }}</span>
```

#### Queue Processing
```php
// App/Console/Kernel.php
$schedule->call(function () {
    $service = app(NotificationService::class);
    $service->sendPendingNotifications(100);
})->everyMinute();
```

---

## **INTEGRATION SUMMARY**

### Database Migrations Executed
✅ `2026_02_17_000004_create_pharmacy_system.php`
✅ `2026_02_17_000005_create_notifications_table.php`

### Tables Created
- medicine_manufacturers
- medicine_suppliers
- medicines
- medicine_inventories
- medicine_batches
- medicine_orders
- medicine_order_items
- notifications

### Files Added
- Middleware: `CheckUserRole.php`
- Permission: `Authorization.php`
- Models: `Medicine.php`, `MedicineInventory.php`, `MedicineBatch.php`, `MedicineManufacturer.php`, `MedicineSupplier.php`, `MedicineOrder.php`, `MedicineOrderItem.php`, `Notification.php`
- Services: `NotificationService.php`
- Controllers: `PharmacyController.php`, `NotificationController.php`
- Mail: `NotificationMail.php`
- Events: `AppointmentScheduled.php`
- Listeners: `SendAppointmentReminder.php`
- Views: `emails/notification.blade.php`

### Routes Protected With Roles
- `/pharmacy/*` - Requires `pharmacist` or `admin` role
- All routes require `auth` middleware

---

## **TESTING THE FEATURES**

### Test Role-Based Access
```bash
# Login as pharmacist
# Navigate to /pharmacy/dashboard - Should have access

# Login as doctor
# Navigate to /pharmacy/dashboard - Should get 403 error
```

### Test Pharmacy System
```bash
# Create supply order
POST /pharmacy/orders
- supplier_id: 1
- expected_delivery_date: 2026-02-25
- items: [{medicine_id: 1, quantity: 100, unit_price: 5.50}]

# View inventory
GET /pharmacy/inventory

# Receive batch
POST /pharmacy/batch/1/receive
- batch_number: "BATCH-001"
- quantity_received: 100
- expiry_date: 2027-02-17
- cost_price: 5.50
```

### Test Notifications
```bash
# Get user notifications
GET /notifications

# Mark as read
POST /notifications/1/mark-read

# Get pending count
GET /notifications/api/pending

# Manually trigger
$service = app(NotificationService::class);
$service->sendAppointmentReminder($appointment);
```

---

## **CONFIGURATION NEEDED**

### Mail Configuration (.env)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx
MAIL_FROM_ADDRESS=hospital@example.com
MAIL_FROM_NAME="Hospital Management"
```

### SMS Configuration (.env)
```
SMS_PROVIDER=africas_talking
AFRICAS_TALKING_API_KEY=xxx
AFRICAS_TALKING_USERNAME=xxx
```

---

## **FUTURE ENHANCEMENTS**

1. **Queue System**: Use Laravel queues for batch notification sending
2. **Webhook Support**: Receive delivery confirmations from SMS providers
3. **Template System**: Dynamic notification templates customizable by admin
4. **Audit Logging**: Track all notification activities
5. **Retry Logic**: Improved exponential backoff for failed notifications
6. **Push Notifications**: FCM or OneSignal integration
7. **Notification Preferences**: Let users configure notification channels
8. **Analytics**: Dashboard showing notification delivery rates

---

All three features are fully integrated and production-ready!

# 🔧 AutoShop Manager — Product Requirements Document (PRD)
**Version:** 1.0  
**Stack:** Laravel 11 + Blade + Tailwind CSS + Alpine.js  
**Deployment:** Local (Laravel Herd)  
**Currency:** PKR  
**Language:** English + Urdu (bilingual UI)  
**Auth:** No login required (single-user local app)

---

## 1. PROJECT OVERVIEW

A beautiful, professional digital dashboard to replace paper job cards at a car maintenance and repair shop. The manager can create and manage customers, log every car visit, track all services/parts/costs, generate digital receipts, and monitor the business — all from one screen.

---

## 2. DESIGN DIRECTION

### Visual Style
- **Theme toggle:** Dark mode (default) + Light mode — toggled via a button, saved to `localStorage`.
- **Aesthetic:** Industrial-luxury. Think premium garage meets Swiss grid design. Not a generic admin panel.
- **Font pairing:** `Syne` (headings, bold, geometric) + `IBM Plex Sans` (body, bilingual-friendly). Both from Google Fonts.
- **Color palette (dark mode):**
  - Background: `#0D0D0D`
  - Surface/cards: `#161616`
  - Border: `#2A2A2A`
  - Accent: `#E8C84A` (amber/gold — feels automotive, premium)
  - Text primary: `#F2F2F2`
  - Text muted: `#6B6B6B`
- **Color palette (light mode):**
  - Background: `#F5F4F0`
  - Surface: `#FFFFFF`
  - Border: `#E0DDD5`
  - Accent: `#C4960A`
  - Text primary: `#111111`
  - Text muted: `#888888`
- **Sidebar:** Fixed left sidebar, 240px wide, icon + label nav.
- **Layout:** Content area with generous padding, card-based sections, subtle dividers.
- **Bilingual:** Urdu labels shown as secondary text below English labels in forms and headings. Urdu text uses `font-family: 'Noto Nastaliq Urdu', serif` (Google Fonts) with `direction: rtl` where needed.

---

## 3. PAGES & FEATURES

### 3.1 Dashboard Home (`/`)
**English:** Dashboard | **Urdu:** ڈیش بورڈ

**Stat Cards (top row):**
- Active Jobs (cars currently in shop)
- Today's Revenue (PKR)
- This Month's Revenue (PKR)
- Unpaid Invoices count + total amount

**Sections below:**
- **Active Jobs Table** — car, customer, service type, date in, status badge
- **Recent Receipts** — last 5 job cards with amount + payment status
- **Quick CRUD buttons** — "New Customer", "New Job Card" — prominent CTA buttons
- **Most Frequent Customers** — top 5 by visit count (name, visits, total spent)

---

### 3.2 Customers (`/customers`)
**English:** Customers | **Urdu:** گاہک

**List view:**
- Search by name or phone number
- Filter by car make/model
- Table: Name, Phone, Cars registered, Total visits, Last visit date, Actions (View / Edit / Delete)

**Customer Detail Page (`/customers/{id}`):**
- Customer info card (name, phone, address)
- All cars registered under them
- Full service history table (date, service, cost, status)
- Total amount spent (lifetime)
- "Add New Job Card" button for this customer

**CRUD:**
- Create customer: Name, Phone, Address (optional), Notes (optional)
- Edit / Delete customer

---

### 3.3 Job Cards / Receipts (`/jobs`)
**English:** Job Cards | **Urdu:** جاب کارڈ

This is the core feature — the digital replacement for paper cards.

**List view:**
- Search by customer name, phone, or car plate
- Filter by: Status (active / completed / cancelled), Date range, Payment status
- Table: Job #, Customer, Car, Date In, Date Out, Total Cost, Payment Status, Actions

**Job Card Detail Page (`/jobs/{id}`):**
Full digital job card showing:
- Job number (auto-generated: `JC-2025-0001`)
- Customer info
- Car info
- Mileage at drop-off & pick-up
- Services performed (itemized list)
- Parts used (itemized list with part numbers)
- Labor cost
- Parts cost
- Total cost
- Payment status badge
- Notes / warranty notes
- Print button (browser print, styled receipt layout)

**Create/Edit Job Card:**
- Select existing customer OR create new one inline
- Select existing car OR add new one inline
- Mileage in / out
- Service type (dropdown: Oil Change, Tire Rotation, Brake Service, AC Service, Engine Repair, Transmission, Washing/Detailing, Modification/Upgrade, Other)
- Dynamic services list — add multiple services with description + labor cost each
- Dynamic parts list — add multiple parts with: Part Name, Part Number, Quantity, Unit Price
- Auto-calculated totals
- Notes field (warranty terms, recommendations)
- Payment status: Paid / Unpaid / Partial (with partial amount field)
- Date in / Date out

---

### 3.4 Cars (`/cars`)
**English:** Cars | **Urdu:** گاڑیاں

- Search by plate number, make, model
- Table: Plate Number, Make, Model, Year, Owner (customer), Total visits
- Car Detail: full service history for that specific vehicle
- Cars are linked to a customer

---

### 3.5 Services & Parts Reference (`/services`)
**English:** Services | **Urdu:** خدمات

- Manage a reusable list of common services with default labor price (editable per job)
- Manage a parts inventory/reference list (part name, part number, default price)
- These act as quick-select presets when creating job cards

---

### 3.6 Reports (`/reports`)
**English:** Reports | **Urdu:** رپورٹس

- Revenue by date range (daily / weekly / monthly)
- Unpaid invoices list
- Most frequent customers
- Most common services performed
- Simple bar/line chart using Chart.js (no external API needed)

---

## 4. SUGGESTED EXTRA FEATURES (Recommended Additions)

These were requested as suggestions — include in Phase 1 or Phase 2:

| Feature | Value |
|---|---|
| **Next service reminder** | Store recommended next oil change mileage or date per car |
| **Job status pipeline** | Kanban-style: Received → In Progress → Ready → Delivered |
| **Warranty tracking** | Flag services with warranty period (e.g. 3 months) and show expiry |
| **Car photo notes** | Upload 1–3 photos per job (damage, before/after) stored locally |
| **Customer visit notes** | Sticky notes per customer visible on their profile |
| **Quick search bar** | Global search (top bar) across customers, cars, jobs |
| **Print-friendly receipt** | CSS @media print layout — clean receipt with shop name/logo |
| **Low-stock flag** | Mark parts as "needs reorder" on the parts reference list |

---

## 5. DATABASE SCHEMA

### `customers`
```sql
CREATE TABLE customers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### `cars`
```sql
CREATE TABLE cars (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id BIGINT UNSIGNED NOT NULL,
    plate_number VARCHAR(20) NOT NULL,
    make VARCHAR(50) NOT NULL,        -- Toyota, Honda, Suzuki, etc.
    model VARCHAR(50) NOT NULL,       -- Corolla, Civic, Alto, etc.
    year YEAR NULL,
    color VARCHAR(30) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);
```

### `service_presets` *(reusable service templates)*
```sql
CREATE TABLE service_presets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,           -- "Oil Change", "AC Gas Refill"
    name_urdu VARCHAR(100) NULL,          -- Urdu translation
    category VARCHAR(50) NOT NULL,        -- maintenance, repair, detailing, upgrade
    default_labor_cost DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### `parts_reference` *(reusable parts catalog)*
```sql
CREATE TABLE parts_reference (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    part_number VARCHAR(50) NULL,
    default_price DECIMAL(10,2) DEFAULT 0,
    needs_reorder BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### `jobs` *(the main job card / visit record)*
```sql
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_number VARCHAR(20) NOT NULL UNIQUE,  -- JC-2025-0001
    customer_id BIGINT UNSIGNED NOT NULL,
    car_id BIGINT UNSIGNED NOT NULL,
    status ENUM('received','in_progress','ready','delivered','cancelled') DEFAULT 'received',
    payment_status ENUM('paid','unpaid','partial') DEFAULT 'unpaid',
    amount_paid DECIMAL(10,2) DEFAULT 0,
    mileage_in INT UNSIGNED NULL,
    mileage_out INT UNSIGNED NULL,
    date_in DATE NOT NULL,
    date_out DATE NULL,
    notes TEXT NULL,
    warranty_notes TEXT NULL,
    next_service_date DATE NULL,
    next_service_mileage INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (car_id) REFERENCES cars(id)
);
```

### `job_services` *(services performed in a job)*
```sql
CREATE TABLE job_services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id BIGINT UNSIGNED NOT NULL,
    service_preset_id BIGINT UNSIGNED NULL,   -- nullable: can be custom
    description VARCHAR(255) NOT NULL,
    labor_cost DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (service_preset_id) REFERENCES service_presets(id) ON DELETE SET NULL
);
```

### `job_parts` *(parts used in a job)*
```sql
CREATE TABLE job_parts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id BIGINT UNSIGNED NOT NULL,
    parts_reference_id BIGINT UNSIGNED NULL,  -- nullable: can be custom
    part_name VARCHAR(100) NOT NULL,
    part_number VARCHAR(50) NULL,
    quantity DECIMAL(8,2) DEFAULT 1,
    unit_price DECIMAL(10,2) DEFAULT 0,
    total_price DECIMAL(10,2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (parts_reference_id) REFERENCES parts_reference(id) ON DELETE SET NULL
);
```

### `job_photos` *(optional car photos per job)*
```sql
CREATE TABLE job_photos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id BIGINT UNSIGNED NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    caption VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
);
```

---

## 6. KEY DATABASE QUERIES (for AI agent reference)

### Dashboard — Active Jobs
```sql
SELECT j.id, j.job_number, j.date_in, j.status,
       c.name AS customer_name, c.phone,
       ca.make, ca.model, ca.plate_number
FROM jobs j
JOIN customers c ON j.customer_id = c.id
JOIN cars ca ON j.car_id = ca.id
WHERE j.status IN ('received', 'in_progress', 'ready')
ORDER BY j.date_in ASC;
```

### Dashboard — Today's Revenue
```sql
SELECT COALESCE(SUM(amount_paid), 0) AS today_revenue
FROM jobs
WHERE DATE(updated_at) = CURDATE()
AND payment_status IN ('paid', 'partial');
```

### Dashboard — This Month's Revenue
```sql
SELECT COALESCE(SUM(amount_paid), 0) AS month_revenue
FROM jobs
WHERE MONTH(date_in) = MONTH(CURDATE())
AND YEAR(date_in) = YEAR(CURDATE())
AND payment_status IN ('paid', 'partial');
```

### Dashboard — Unpaid Invoices
```sql
SELECT COUNT(*) AS unpaid_count,
       COALESCE(SUM(
           (SELECT COALESCE(SUM(labor_cost),0) FROM job_services WHERE job_id = j.id) +
           (SELECT COALESCE(SUM(total_price),0) FROM job_parts WHERE job_id = j.id)
           - j.amount_paid
       ), 0) AS unpaid_total
FROM jobs j
WHERE j.payment_status IN ('unpaid', 'partial');
```

### Dashboard — Most Frequent Customers
```sql
SELECT c.id, c.name, c.phone,
       COUNT(j.id) AS total_visits,
       COALESCE(SUM(j.amount_paid), 0) AS total_spent
FROM customers c
LEFT JOIN jobs j ON j.customer_id = c.id
GROUP BY c.id
ORDER BY total_visits DESC
LIMIT 5;
```

### Job Card — Calculate Total Cost
```sql
SELECT
    j.id,
    j.job_number,
    j.payment_status,
    j.amount_paid,
    COALESCE(SUM(js.labor_cost), 0) AS total_labor,
    COALESCE(SUM(jp.total_price), 0) AS total_parts,
    (COALESCE(SUM(js.labor_cost), 0) + COALESCE(SUM(jp.total_price), 0)) AS grand_total,
    ((COALESCE(SUM(js.labor_cost), 0) + COALESCE(SUM(jp.total_price), 0)) - j.amount_paid) AS balance_due
FROM jobs j
LEFT JOIN job_services js ON js.job_id = j.id
LEFT JOIN job_parts jp ON jp.job_id = j.id
WHERE j.id = ?
GROUP BY j.id;
```

### Search Jobs by customer name, phone, or plate
```sql
SELECT j.id, j.job_number, j.date_in, j.status, j.payment_status,
       c.name AS customer_name, c.phone,
       ca.plate_number, ca.make, ca.model
FROM jobs j
JOIN customers c ON j.customer_id = c.id
JOIN cars ca ON j.car_id = ca.id
WHERE c.name LIKE ?
   OR c.phone LIKE ?
   OR ca.plate_number LIKE ?
ORDER BY j.date_in DESC;
```

### Service History for a specific car
```sql
SELECT j.id, j.job_number, j.date_in, j.date_out, j.status,
       j.mileage_in, j.mileage_out,
       GROUP_CONCAT(js.description SEPARATOR ', ') AS services,
       (COALESCE(SUM(js.labor_cost), 0) + COALESCE(SUM(jp.total_price), 0)) AS total_cost,
       j.payment_status
FROM jobs j
LEFT JOIN job_services js ON js.job_id = j.id
LEFT JOIN job_parts jp ON jp.job_id = j.id
WHERE j.car_id = ?
GROUP BY j.id
ORDER BY j.date_in DESC;
```

### Auto-generate Job Number
```sql
-- In Laravel, run this to get the next job number:
SELECT CONCAT('JC-', YEAR(NOW()), '-', LPAD(COUNT(*) + 1, 4, '0')) AS next_job_number
FROM jobs
WHERE YEAR(created_at) = YEAR(NOW());
```

---

## 7. LARAVEL PROJECT STRUCTURE

```
app/
  Models/
    Customer.php
    Car.php
    Job.php
    JobService.php
    JobPart.php
    JobPhoto.php
    ServicePreset.php
    PartsReference.php
  Http/Controllers/
    DashboardController.php
    CustomerController.php
    CarController.php
    JobController.php
    ServicePresetController.php
    PartsReferenceController.php
    ReportController.php

resources/views/
  layouts/
    app.blade.php        ← Main layout with sidebar + topbar + dark/light toggle
  dashboard/
    index.blade.php
  customers/
    index.blade.php
    show.blade.php
    create.blade.php
    edit.blade.php
  jobs/
    index.blade.php
    show.blade.php       ← The digital job card / receipt view
    create.blade.php
    edit.blade.php
  cars/
    index.blade.php
    show.blade.php
  reports/
    index.blade.php
  services/
    index.blade.php

routes/web.php
database/migrations/
database/seeders/
```

---

## 8. ROUTES (web.php)

```php
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('customers', CustomerController::class);
Route::resource('cars', CarController::class);
Route::resource('jobs', JobController::class);
Route::get('jobs/{job}/print', [JobController::class, 'print'])->name('jobs.print');

Route::resource('services', ServicePresetController::class);
Route::resource('parts', PartsReferenceController::class);

Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
```

---

## 9. LARAVEL MIGRATIONS (run order)

```
php artisan make:migration create_customers_table
php artisan make:migration create_cars_table
php artisan make:migration create_service_presets_table
php artisan make:migration create_parts_reference_table
php artisan make:migration create_jobs_table
php artisan make:migration create_job_services_table
php artisan make:migration create_job_parts_table
php artisan make:migration create_job_photos_table
php artisan migrate
```

---

## 10. NPM / FRONTEND DEPENDENCIES

```bash
npm install -D tailwindcss @tailwindcss/forms alpinejs
npm install chart.js
```

Google Fonts to include in layout:
```html
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=IBM+Plex+Sans:wght@300;400;500;600&family=Noto+Nastaliq+Urdu:wght@400;600&display=swap" rel="stylesheet">
```

---

## 11. PHASE PLAN

| Phase | What to build |
|---|---|
| **Phase 1** | DB migrations, models, layout shell, dark/light toggle, dashboard home |
| **Phase 2** | Customers CRUD, Cars CRUD |

SEO & HTML Standards Addendum — Apply to all Blade views
Every page must follow these rules:
1. Dynamic <title> tags
Every view must have a unique, descriptive title using a Blade @section('title'):
@section('title', 'Job Cards | AutoShop Manager')
@section('title', 'Customer: {{ $customer->name }} | AutoShop Manager')
The layout app.blade.php must have <title>@yield('title', 'AutoShop Manager')</title>
2. Meta description per page
Each view pushes a short meta description (max 155 chars):
@section('meta_description', 'View and manage all active job cards for AutoShop Manager.')
Layout renders it as: <meta name="description" content="@yield('meta_description')">
3. Semantic HTML structure

Use <main>, <section>, <article>, <nav>, <header>, <footer> — never just <div> for everything
Tables must have <thead>, <tbody>, <th scope="col"> — never flat <td> rows
Forms must have <label for=""> tied to every input's id
Buttons must never be bare <div> — always <button type=""> or <a href="">

4. Heading hierarchy

One <h1> per page only (the page title)
Subheadings use <h2>, <h3> in logical order — never skip levels

5. Images & icons

Any <img> must have a meaningful alt="" attribute
Decorative SVG icons get aria-hidden="true"
Functional icon buttons get aria-label="Delete customer"

6. Standard meta tags in layout <head> (add once to app.blade.php):
html<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow"> <!-- local app, don't index -->
<meta name="theme-color" content="#0D0D0D">
<link rel="canonical" href="{{ url()->current() }}">
7. Landmark roles for accessibility (also helps SEO)
html<nav role="navigation" aria-label="Main navigation">
<main role="main">

| **Phase 3** | Job Cards CRUD (the core feature), dynamic services + parts rows |
| **Phase 4** | Print receipt view, payment status flow |
| **Phase 5** | Search & filter, service history per car/customer |
| **Phase 6** | Reports page with Chart.js |
| **Phase 7** | Extra features: photos, next-service reminders, warranty tracking |

---

## 12. NOTES FOR AI AGENT (Copilot / Antigravity)

- Always use `DECIMAL(10,2)` for money — never `FLOAT`
- Job number format: `JC-YYYY-XXXX` — auto-generated in the `JobController@store`
- `total_price` in `job_parts` is a **generated column** — do not insert it manually
- Use Laravel's `$casts` in models for `ENUM` fields and dates
- All money values are in **PKR** — display with `number_format()` and "Rs." prefix
- Urdu text should have `dir="rtl"` and use the Noto Nastaliq Urdu font
- Dark/light theme is toggled via a class on `<html>` tag (`class="dark"`) using Alpine.js + localStorage
- No authentication needed — this is a local single-user app via Laravel Herd
- Use Blade components for: stat cards, job status badge, payment status badge, sidebar nav item
- For dynamic rows (adding multiple services/parts in job form), use Alpine.js `x-data` with an array

# AutoShop Manager - Arslan's Workshop

AutoShop Manager is a modern, comprehensive web application built with **Laravel 11** to manage daily operations for an auto repair workshop. It features a clean, card-based UI (powered by Tailwind CSS and Alpine.js) and allows shop owners to easily track customers, vehicles, job cards, parts inventory, and service presets.

## 🚀 Features

- **Dashboard:** Live overview of active jobs, today's revenue, unpaid invoices, and a real-time job pipeline visualization.
- **Customer Management:** Keep track of all customers, their contact details, and their associated vehicles.
- **Vehicle Management:** Log vehicle details (make, model, year, license plate, VIN) linked to customer profiles.
- **Job Cards:** Create and manage repair orders. Track job status (Received, In Progress, Ready, Delivered, Cancelled), add services, assign parts, log mileage, and generate professional print-ready receipts.
- **Parts Inventory Management:** Maintain a catalog of auto parts with stock levels, cost, selling price, and a "needs reorder" tracking system.
- **Service Presets:** Predefined common services (e.g., Oil Change, Brake Pad Replacement) with default labor costs for quick job card creation.
- **Analytics & Reports:** Detailed reports on revenue, outstanding payments, and job status distribution.
- **Modern UI/UX:** Fully responsive design with Light/Dark mode support, unified Blade components, and declarative interactivity with Alpine.js.

## 🛠️ Tech Stack

- **Backend:** Laravel 11 (PHP)
- **Database:** SQLite (default for easy setup, configurable to MySQL/PostgreSQL)
- **Frontend:** Laravel Blade, Tailwind CSS v4, Alpine.js
- **Icons:** SVG-based inline icons (Blade UI Kit compatible structure)

## 📦 Installation & Setup

Follow these steps to set up the project locally for development or testing:

1. **Clone the repository**
   ```bash
   git clone https://github.com/ArslanAli07/AutoShop-Manager.git
   cd AutoShop-Manager
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install NPM Dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   Copy the example environment file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *(By default, Laravel 11 uses SQLite. Ensure you have the SQLite extension enabled in your PHP configuration.)*

5. **Run Migrations & Seeders**
   This will create the database structure and populate it with initial service presets and parts reference data:
   ```bash
   php artisan migrate --seed
   ```

6. **Build Frontend Assets**
   Compile the Tailwind CSS and JavaScript assets:
   ```bash
   npm run build
   # Or for active development: npm run dev
   ```

7. **Start the Development Server**
   ```bash
   php artisan serve
   ```
   *The application will be accessible at `http://localhost:8000`.*

## 🧪 Testing the Application

Once the app is running, you can test the workflow:
1. **Add a Customer:** Go to *Customers* -> *New Customer*.
2. **Add a Vehicle:** In the Customer Profile, click *Add Car*.
3. **Create a Job Card:** Use *Quick Intake* from the Dashboard, or go to *Job Cards* -> *New Job Card*. Select the customer and vehicle.
4. **Manage the Job:** Inside the Job Card, add services (from your seeded presets) and parts. Update the job status to see it reflect on the Dashboard pipeline.
5. **Print Receipt:** Once the job is complete, click *Print Receipt* on the Job Card to view the print-friendly invoice layout.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

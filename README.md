# 🚀 Laravel Mini ERP Assignment

A lightweight ERP system built using **Laravel 11**, **Tailwind CSS**, and **Sanctum**.  
This application demonstrates basic inventory and sales order management with PDF export functionality and RESTful API access.

---

## 🧰 Tech Stack

- **Laravel 11**
- **Tailwind CSS**
- **Laravel Sanctum** (API Authentication)
- **DomPDF** (PDF Invoicing)
- **MySQL** (Database)

---

## ✅ Features

- 🔐 **Role-based access** (`admin` / `sales`)
- 📦 **Product CRUD** (Admin only)
- 📋 **Sales Order creation** with multiple items
- 📉 **Inventory auto-reduction** after order
- 📄 **PDF Export** for sales invoices
- 🌐 **REST API endpoints** with token-based auth

---

## 🧪 Seeded Users

| Role        | Email                  | Password  |
|-------------|------------------------|-----------|
| Admin       | `admin@example.com`     | `password` |
| Salesperson | `salesperson@example.com` | `password` |

Login here: `http://localhost:8000/login`

---

## 🛠️ Setup Instructions

```bash
# 1. Clone the repository
git clone https://github.com/sangcar155/erp-assignment.git
cd erp-assignment

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Create env and generate app key
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seeders
php artisan migrate --seed

# 6. Serve the app
php artisan serve

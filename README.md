 🚀 Laravel Mini ERP Assignment

A lightweight ERP system built using Laravel 11, Tailwind CSS, and Sanctum.  
This application demonstrates basic inventory and sales order management with PDF export functionality and RESTful API access.

---

 🧰 Tech Stack

- Laravel 11
- Tailwind CSS
- Laravel Sanctum (API Authentication)
- DomPDF (PDF Invoicing)
- MySQL (Database)

---

 ✅ Features

- 🔐 Role-based access (`admin` / `sales`)
- 📦 Product CRUD (Admin only)
- 📋 Sales Order creation with multiple items
- 📉 Inventory auto-reduction after order
- 📄 PDF Export for sales invoices
- 🌐 REST API endpoints with token-based auth

---

 🧪 Seeded Users

| Role        | Email                      | Password  |
|-------------|----------------------------|-----------|
| Admin       | `admin@example.com`        | `password` |
| Salesperson | `salesperson@example.com`  | `password` |

Login: [http://localhost:8000/login](http://localhost:8000/login)

---

 🛠️ Setup Instructions

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
Or import the SQL file from public/db/erp_assignment.sql manually into your MySQL database.

# 6. Serve the app
php artisan serve
```

---

 🏗️ Database Structure

- users: Stores user accounts and roles.
- products: Product catalog with inventory quantity.
- sales_orders: Sales order headers.
- sales_items: Line items for each order.

---

 🛒 Sales Order & Inventory Flow

1. Admin creates products and manages inventory.
2. Salesperson creates a new sales order, selecting products and quantities.
3. On order submission:
   - Inventory is automatically reduced.
   - Sales order and items are saved.
4. Sales order can be viewed and exported as a PDF invoice.

📄 PDF Invoice Storage

Each time a Sales Order is downloaded as PDF, the system:

- Saves a copy of the PDF in the `public/pdf/` directory.
- Uses a file name format like `SalesOrder_1.pdf`.

 🛠️ Setup

Make sure the `public/pdf/` directory exists and is writable:

bash
mkdir -p public/pdf
chmod -R 775 public/pdf


 🌐 API Endpoints

- Authentication:  
  `POST /api/login` (returns token)
- Products:  
  `GET /api/products`  
  `POST /api/products` (admin only)
- Sales Orders:  
  `GET /api/orders`  
  `POST /api/orders`
- PDF Invoice:  
  `GET /api/orders/{id}/pdf`

All API routes require Bearer token (Sanctum).

---

 🧑‍💻 Development

- Frontend: Blade + Tailwind CSS
- Backend: Laravel MVC, REST API
- Testing:  
  Run tests with:
  ```bash
  php artisan test
  ```

---
📸 Screenshots
🔐 Login Page

📦 Product List (Admin)

➕ Create Product

✏️ Update Product

📊 Admin Dashboard

📉 Dashboard Before Creating Sales Order

🧾 Sales Orders (Salesperson)

📄 Sales Order Detail Page

👨‍💼 Salesperson Dashboard

🔁 Create Sales Order via API (Postman)



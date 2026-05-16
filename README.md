# E-Commerce Marketplace — Platform Admin (PHP MVC)

A beginner-friendly multi-tier admin dashboard built with **PHP + MySQL + Bootstrap 5**.
Architecture: strict **MVC** with `models/`, `views/`, `controllers/`, `config/`, `includes/`, `assets/`, `uploads/`.

## 🚀 Setup (XAMPP)

1. Copy the `ecommerce_admin` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** in the XAMPP control panel.
3. Open **phpMyAdmin** → http://localhost/phpmyadmin
4. Click **Import**, choose `sql/ecommerce_store.sql`, and press **Go**.
5. Open the app: http://localhost/ecommerce_admin/

## 🔐 Default Login

| Email | Password |
|-------|----------|
| `admin@shop.com` | `admin123` |

(Other seeded accounts use the same password — see the SQL file.)

## ✨ Features Implemented

- **Auth:** secure login/logout, password hashing (bcrypt), session-based auth, role check
- **Dashboard:** 6 stat cards, Chart.js revenue chart, recent activity & orders
- **Sellers:** list/search/filter, **AJAX approve/reject/suspend/reactivate** (no page reload), commission rate
- **Categories:** add/edit/delete, parent-child support, prevent delete if products exist
- **Users:** customers + delivery managers, search, activate/deactivate
- **Products:** search/filter by category & seller, remove/restore
- **Orders:** filter by status, seller, customer, date range
- **Disputes:** view, add admin resolution notes, mark resolved
- **Commissions:** set per-seller commission rate
- **Coupons:** platform-wide, activate/deactivate, validation
- **Reports:** revenue analytics, top sellers, top categories, **printable HTML report**
- **Featured Content:** toggle featured products, upload seller banners (file validation)
- **Announcements:** post platform-wide messages

## 🛡️ Security

- All queries use **mysqli prepared statements**
- `htmlspecialchars()` on all output (XSS protection)
- Session-based auth + `require_admin()` role guard on every controller action
- File upload validation (MIME, extension, size ≤ 2MB)
- `session_regenerate_id` on login
- `.htaccess` blocks PHP execution inside `uploads/`

## ✅ Validation

- **Client (JavaScript):** required fields, email format, password length (login & coupon forms)
- **Server (PHP):** required fields, types, range checks, duplicate code check, file MIME check

## 🔁 AJAX + JSON

Seller approval flow uses `jQuery.ajax` → `controllers/SellersController::ajaxAction` returning JSON.
SweetAlert2 confirms the action and shows the result without reloading.

## 📁 Project Folder Structure

```
ecommerce_admin/
├── index.php              # Front controller / router
├── config/{db,config}.php
├── controllers/
├── models/
├── views/{layouts, auth, dashboard, sellers, ...}
├── includes/{auth, helpers}.php
├── assets/{css,js,img}/
├── uploads/{products,banners}/
└── sql/ecommerce_store.sql
```

## 🧪 Routing

`index.php?url=<controller>/<action>/<param>` (e.g. `index.php?url=sellers/index`).

Enjoy & good luck with your viva! 🎓

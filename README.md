Wire - Minimal Online Store (PHP/MySQL)

Setup (XAMPP):
1. Copy this folder to htdocs (e.g., C:\xampp\htdocs\wire)
2. Start Apache and MySQL
3. In phpMyAdmin, create DB `wire` and import `wire.sql`
4. Visit http://localhost/wire/

Admin login: admin@wire.local / admin123

Edit DB config in `includes/db.php` if needed.

Pages: index.php, catalog.php, product.php, cart.php, order.php, login.php, register.php
Includes: header.php, footer.php, db.php, functions.php, auth.php, cart_api.php
Admin: admin/index.php, admin/products.php, admin/orders.php
Assets: assets/css/style.css, assets/js/main.js



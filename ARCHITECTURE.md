# Wire E-Commerce Application - Architecture & Functionality

## Overview
**Wire** is a PHP-based e-commerce web application for selling computer peripherals (keyboards, mice, headphones, accessories). It uses a traditional server-side rendering architecture with session-based authentication and a MySQL database.

---

## Technology Stack

### Backend
- **PHP 7.4+** - Server-side scripting language
- **MySQL/MariaDB** - Relational database (via XAMPP)
- **Apache HTTP Server** - Web server (via XAMPP)

### Frontend
- **HTML5** - Markup structure
- **CSS3** - Styling (custom stylesheet, no frameworks)
- **JavaScript (ES6 Modules)** - Client-side interactivity
- **Font Awesome** - Icon library

### Development Environment
- **XAMPP** - Local development stack (Apache + MySQL + PHP)

---

## Core Architecture Principles

### 1. **Server-Side Rendering (SSR)**
- All pages are PHP files that generate HTML dynamically
- No client-side routing; each page is a separate PHP file
- Data is fetched from the database and rendered server-side before sending to the browser

### 2. **Session-Based State Management**
- User authentication and shopping cart are stored in PHP sessions (`$_SESSION`)
- Sessions are initialized in `includes/db.php` using `session_start()`
- Cart data persists across page requests within the same browser session

### 3. **Modular Code Organization**
- **Includes Pattern**: Reusable components (header, footer, functions) are included via `require_once`
- **Separation of Concerns**: Database logic, business logic, and presentation are separated into different files
- **DRY Principle**: Common functions are centralized in `includes/functions.php`

### 4. **Security Practices**
- **Prepared Statements**: All database queries use parameterized statements to prevent SQL injection
- **XSS Protection**: User input is escaped using `htmlspecialchars()` via the `e()` helper function
- **Password Hashing**: Passwords are hashed using `password_hash()` with `PASSWORD_DEFAULT`
- **Access Control**: Role-based access control (admin vs. user) enforced via `require_admin()` and `require_login()`

---

## File Structure & Components

```
wire/
├── index.php              # Homepage with featured products
├── catalog.php            # Product listing with filters/search
├── product.php            # Individual product detail page
├── cart.php               # Shopping cart management
├── order.php              # Checkout/order placement
├── login.php              # User authentication
├── register.php           # User registration
├── logout.php             # Session termination
├── account.php            # User profile & order history
├── contact.php            # Contact form page
├── about.php              # About Us page
├── admin/
│   ├── index.php          # Admin dashboard
│   ├── products.php       # Product management (CRUD)
│   └── orders.php         # Order management
├── includes/
│   ├── db.php             # Database connection & session init
│   ├── functions.php      # Core business logic functions
│   ├── auth.php           # Authentication helpers
│   ├── header.php         # Site header/navigation
│   ├── footer.php         # Site footer
│   └── cart_api.php       # AJAX cart API endpoint
└── assets/
    ├── css/style.css      # Main stylesheet
    ├── js/main.js         # JavaScript modules
    └── uploads/           # User-uploaded product images
```

---

## Database Schema

### Tables

1. **users**
   - `id` (INT, PRIMARY KEY)
   - `name` (VARCHAR)
   - `email` (VARCHAR, UNIQUE)
   - `password_hash` (VARCHAR)
   - `role` (ENUM: 'user', 'admin')
   - `created_at` (DATETIME)

2. **products**
   - `id` (INT, PRIMARY KEY)
   - `name` (VARCHAR)
   - `category` (ENUM: 'keyboards', 'mice', 'headphones', 'accessories')
   - `price` (DECIMAL)
   - `image` (VARCHAR) - Comma/newline-separated image paths
   - `description` (TEXT)
   - `specs` (TEXT)
   - `sold` (INT) - Sales counter
   - `created_at` (DATETIME)

3. **orders**
   - `id` (INT, PRIMARY KEY)
   - `user_id` (INT, FOREIGN KEY, nullable)
   - `customer_name` (VARCHAR)
   - `address` (TEXT)
   - `phone` (VARCHAR)
   - `payment_method` (VARCHAR)
   - `total` (DECIMAL)
   - `status` (ENUM: 'new', 'confirmed', 'rejected')
   - `created_at` (DATETIME)

4. **order_items**
   - `id` (INT, PRIMARY KEY)
   - `order_id` (INT, FOREIGN KEY)
   - `product_id` (INT, FOREIGN KEY)
   - `price` (DECIMAL) - Snapshot at time of order
   - `quantity` (INT)

---

## Request Flow & Component Interaction

### 1. **Page Request Flow**

```
Browser Request
    ↓
Apache Server
    ↓
PHP Interpreter
    ↓
includes/db.php (Database connection + session_start)
    ↓
includes/header.php (Loads functions.php, renders header)
    ↓
Page-specific PHP logic (e.g., catalog.php)
    ↓
Database queries (via functions.php helpers)
    ↓
HTML generation with embedded PHP
    ↓
includes/footer.php (Renders footer)
    ↓
Response sent to browser
```

### 2. **Authentication Flow**

**Login Process:**
1. User submits credentials via `login.php` form (POST)
2. PHP validates email format and password presence
3. Database query fetches user by email
4. `password_verify()` checks password hash
5. On success: `$_SESSION['user']` is populated with user data
6. Redirect based on role: admins → `admin/index.php`, users → `index.php`

**Session Management:**
- Session started automatically in `includes/db.php`
- User data stored in `$_SESSION['user']` array
- `get_user()` function retrieves current user from session
- `require_login()` redirects unauthenticated users
- `require_admin()` restricts access to admin-only pages

### 3. **Shopping Cart System**

**Cart Storage:**
- Cart data stored in `$_SESSION['cart']` as associative array: `[product_id => quantity]`
- No database storage until checkout (session-only)

**Adding to Cart:**
1. User clicks "Add to Cart" button
2. JavaScript (`assets/js/main.js`) calls `addToCart(productId, quantity)`
3. AJAX POST request to `includes/cart_api.php`
4. `cart_api.php` calls `cart_add()` from `functions.php`
5. `cart_add()` updates `$_SESSION['cart'][id]` with quantity
6. Response returns updated cart count
7. JavaScript updates cart counter in header

**Cart Functions:**
- `cart_init()` - Initializes empty cart if not exists
- `cart_add(id, qty)` - Adds/increments product quantity
- `cart_set(id, qty)` - Sets specific quantity (used for updates)
- `cart_remove(id)` - Removes product from cart
- `cart_count()` - Returns total item count
- `products_from_cart()` - Fetches full product details for cart items

### 4. **Product Management**

**Product Display:**
- `fetch_products()` - Retrieves products with optional search/category/sort filters
- `fetch_product(id)` - Gets single product by ID
- Products support multiple images (comma/newline-separated in `image` field)
- First image used for catalog thumbnails
- Product page shows image gallery with navigation

**Admin Product Management:**
- `admin/products.php` provides CRUD operations
- Supports multiple image uploads (saved to `assets/uploads/`)
- Images can be URLs or file paths
- Image deletion removes path from database (not file deletion)

### 5. **Order Processing**

**Checkout Flow:**
1. User views cart at `cart.php`
2. Clicks "Checkout" → redirects to `order.php`
3. User fills shipping form (name, address, phone, payment method)
4. Form submission (POST) validates input
5. **Transaction begins** (database transaction for data integrity)
6. Order record inserted into `orders` table
7. Order items inserted into `order_items` table (one per cart item)
8. **Transaction commits** on success
9. Cart cleared: `$_SESSION['cart'] = []`
10. Success message displayed

**Order Management:**
- Admins view all orders at `admin/orders.php`
- Order status can be updated: 'new', 'confirmed', 'rejected'
- Users view their own orders at `account.php`

---

## Key Functions & Their Roles

### Database & Session (`includes/db.php`)
- `$mysqli` - Global database connection object
- `session_start()` - Initializes PHP session
- `is_post()` - Checks if request is POST method
- `e($string)` - Escapes HTML special characters (XSS protection)
- `base_url($path)` - Generates relative URLs (XAMPP-compatible)

### Business Logic (`includes/functions.php`)
- `get_user()` - Returns current logged-in user or null
- `require_admin()` - Redirects non-admins to login
- `cart_*()` - Cart manipulation functions
- `fetch_products()` - Product listing with filters
- `fetch_product()` - Single product retrieval
- `products_from_cart()` - Cart items with full product data

### Authentication (`includes/auth.php`)
- `require_login()` - Redirects unauthenticated users to login

---

## Client-Side Interactivity

### JavaScript Modules (`assets/js/main.js`)
- **ES6 Module System**: Functions exported for dynamic imports
- `addToCart()` - AJAX cart addition with toast notifications
- `showToast()` - User feedback system
- `validateForm()` - Client-side form validation

### AJAX Communication
- Cart operations use `fetch()` API with `credentials: 'same-origin'` to maintain session
- Endpoint: `includes/cart_api.php` returns JSON responses
- Cart counter updates dynamically without page reload

---

## Security Features

1. **SQL Injection Prevention**
   - All queries use prepared statements with parameter binding
   - Example: `$stmt->bind_param('i', $id)`

2. **XSS Prevention**
   - All user-generated content escaped via `e()` function
   - Uses `htmlspecialchars()` with `ENT_QUOTES` flag

3. **Password Security**
   - Passwords hashed with `password_hash()` (bcrypt)
   - Never stored in plain text
   - Verified with `password_verify()`

4. **Access Control**
   - Role-based permissions (admin vs. user)
   - Protected routes check authentication before rendering

5. **File Upload Security**
   - File extensions sanitized
   - Unique filenames generated to prevent overwrites
   - Uploads restricted to `assets/uploads/` directory

---

## URL Routing & Path Handling

### Relative Path System
- All internal links use `base_url()` helper function
- Ensures compatibility with XAMPP subfolder installations
- Example: If app is at `http://localhost/wire/`, `base_url('catalog.php')` returns `/wire/catalog.php`

### Page Structure
- Each page is a standalone PHP file
- No URL rewriting; direct file access
- Query parameters used for filtering (e.g., `catalog.php?category=keyboards`)

---

## Image Handling

### Multi-Image Support
- Product images stored as comma/newline-separated paths in `image` column
- Supports both URLs (http://) and relative paths (assets/uploads/file.jpg)
- First image used for catalog thumbnails
- Product page displays image gallery with prev/next navigation

### Image Upload
- Admin can upload multiple files via form
- Files saved to `assets/uploads/` with unique names
- Uploaded paths automatically appended to product's image field

---

## Session Lifecycle

1. **Session Start**: Automatically in `includes/db.php` (called by all pages)
2. **Session Data**: Stored in `$_SESSION` superglobal
   - `$_SESSION['user']` - Current user data
   - `$_SESSION['cart']` - Shopping cart items
3. **Session Persistence**: Maintained via session cookie (PHPSESSID)
4. **Session End**: Destroyed on logout via `session_destroy()`

---

## Error Handling

- **Database Errors**: Connection failures return HTTP 500
- **Form Validation**: Errors displayed inline on forms
- **Missing Data**: Graceful fallbacks (e.g., "No Image Available" placeholder)
- **Transaction Rollback**: Order placement failures roll back database changes

---

## Design Principles

1. **Minimalist UI**: Clean, white-and-blue color scheme
2. **Responsive Design**: Works on desktop and mobile (media queries)
3. **Progressive Enhancement**: Core functionality works without JavaScript
4. **Accessibility**: Semantic HTML, ARIA labels where needed

---

## Deployment Considerations

### XAMPP Compatibility
- All paths relative (no absolute `/` paths)
- `base_url()` handles subfolder installations
- Session storage in default PHP temp directory

### Production Readiness
- Database credentials should be moved to environment variables
- Error reporting should be disabled in production
- File upload limits may need adjustment in `php.ini`
- HTTPS should be enforced for login/checkout pages

---

## Data Flow Examples

### Example 1: Adding Product to Cart
```
User clicks "Add to Cart"
    ↓
JavaScript: addToCart(5, 1)
    ↓
AJAX POST to includes/cart_api.php
    ↓
cart_api.php: cart_add(5, 1)
    ↓
functions.php: $_SESSION['cart'][5] += 1
    ↓
Response: {success: true, count: 3}
    ↓
JavaScript updates cart counter in header
```

### Example 2: Viewing Product Catalog
```
User visits catalog.php
    ↓
includes/header.php loads (session, cart count)
    ↓
catalog.php calls fetch_products(null, 'keyboards', 'price_asc')
    ↓
functions.php executes SQL: SELECT * FROM products WHERE category='keyboards' ORDER BY price ASC
    ↓
Results rendered as HTML cards
    ↓
includes/footer.php renders
    ↓
Complete HTML sent to browser
```

### Example 3: Placing an Order
```
User submits checkout form
    ↓
order.php validates input
    ↓
Database transaction begins
    ↓
INSERT INTO orders (user_id, customer_name, ...)
    ↓
For each cart item: INSERT INTO order_items (order_id, product_id, ...)
    ↓
Transaction commits
    ↓
$_SESSION['cart'] = [] (cart cleared)
    ↓
Success message displayed
```

---

## Summary

**Wire** is a traditional PHP e-commerce application that:
- Uses server-side rendering for all pages
- Stores user state and cart in PHP sessions
- Interacts with MySQL database via prepared statements
- Provides role-based access control (admin/user)
- Supports AJAX for dynamic cart updates
- Handles file uploads for product images
- Uses transactions for order integrity
- Implements security best practices (XSS, SQL injection prevention)

The application is designed to be simple, maintainable, and suitable for small-to-medium e-commerce needs, with a focus on code clarity and security.


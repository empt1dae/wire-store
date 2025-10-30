-- Create database (run in phpMyAdmin):
-- CREATE DATABASE wire CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE wire;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  category ENUM('keyboards','mice','headphones','accessories') NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  image VARCHAR(500) DEFAULT '',
  description TEXT,
  specs TEXT,
  sold INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  customer_name VARCHAR(200) NOT NULL,
  address TEXT NOT NULL,
  phone VARCHAR(64) NOT NULL,
  payment_method VARCHAR(32) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  status ENUM('new','confirmed','rejected') NOT NULL DEFAULT 'new',
  created_at DATETIME NOT NULL,
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  CONSTRAINT fk_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  CONSTRAINT fk_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed admin user (change password later)
INSERT INTO users (name, email, password_hash, role, created_at)
VALUES ('Admin', 'admin@wire.local', '$2y$10$wXoN0o4h5eZ6V8h5I2m6me8i0w0bq2Qm3i7mZ2mK8l7x7P9RzjG0K', 'admin', NOW());
-- password: admin123

-- Seed sample products
INSERT INTO products (name, category, price, image, description, specs, sold, created_at) VALUES
('Wire MK1 Mechanical Keyboard', 'keyboards', 119.00, 'https://picsum.photos/seed/kb1/640/480', 'Compact 75% layout with hot-swappable switches.', 'Switches: Hot-swap\nLayout: 75%\nConnectivity: USB-C', 42, NOW()),
('Wire Glide Mouse', 'mice', 49.00, 'https://picsum.photos/seed/mouse1/640/480', 'Ergonomic lightweight mouse with precision sensor.', 'Sensor: 26K DPI\nWeight: 65g\nConnection: Wired', 85, NOW()),
('Wire Wave Headphones', 'headphones', 159.00, 'https://picsum.photos/seed/head1/640/480', 'Balanced soundstage with soft ear cushions.', 'Drivers: 45mm\nImpedance: 32Ω\nCable: Detachable', 33, NOW()),
('Wire Desk Mat', 'accessories', 19.00, 'https://picsum.photos/seed/mat1/640/480', 'Soft-touch desk mat for precise tracking.', 'Size: 900x400mm\nMaterial: Microfiber', 120, NOW());



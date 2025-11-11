-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 30 2025 г., 19:56
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `wire`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(64) NOT NULL,
  `payment_method` varchar(32) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('new','confirmed','rejected') NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `address`, `phone`, `payment_method`, `total`, `status`, `created_at`) VALUES
(1, 2, 'Роман', 'г. Самара', '9371850590', 'card', 119.00, 'rejected', '2025-10-30 12:52:00');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 1, 119.00, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` enum('keyboards','mice','headphones','accessories') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(500) DEFAULT '',
  `description` text DEFAULT NULL,
  `specs` text DEFAULT NULL,
  `sold` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`, `description`, `specs`, `sold`, `created_at`) VALUES
(1, 'Wire MK1 Mechanical Keyboard', 'keyboards', 119.00, 'assets/uploads/compact_small_mechanical_keyboard_with_61_keys_on_a_white_background_minimalistic_design_clear_refl_vybc3ui1nbs7qlxilipw_2-69037d9444f36.png', 'Compact 75% layout with hot-swappable switches.', 'Switches: Hot-swap\r\nLayout: 75%\r\nConnectivity: USB-C', 42, '2025-10-29 23:40:31'),
(2, 'WirePulse MX', 'mice', 49.00, 'assets/uploads/aa973bba85fe86c82a20c2343c3dd8fc2a4754c11d9184fc44ab6550fb9f9d2f_jpg-690377e6a4353.webp', 'Ergonomic lightweight mouse with precision sensor.', 'Sensor: 26K DPI\r\nWeight: 65g\r\nConnection: Wired', 85, '2025-10-29 23:40:31'),
(3, 'Wire Wave Headphones', 'headphones', 159.00, 'https://picsum.photos/seed/head1/640/480', 'Balanced soundstage with soft ear cushions.', 'Drivers: 45mm\nImpedance: 32Ω\nCable: Detachable', 33, '2025-10-29 23:40:31'),
(4, 'Wire Desk Mat', 'accessories', 19.00, 'https://picsum.photos/seed/mat1/640/480', 'Soft-touch desk mat for precise tracking.', 'Size: 900x400mm\nMaterial: Microfiber', 120, '2025-10-29 23:40:31');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@wire.local', '$2y$10$wXoN0o4h5eZ6V8h5I2m6me8i0w0bq2Qm3i7mZ2mK8l7x7P9RzjG0K', 'admin', '2025-10-29 23:40:31'),
(2, 'Роман', 'user1@gmail.com', '$2y$10$23KzyMsrRgh817pYQBAb..YmgsRznJ3g2c5qpfyoGw0h9BFiRR8US', 'user', '2025-10-29 23:49:46'),
(4, 'admin1', 'admin1@wire.com', '$2y$10$kHqRO3O9kukgMjsPIwLPUOFyfkjqSFLxL0qpBQejylAkCCc3e9rRK', 'admin', '2025-10-29 21:16:30');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_order` (`order_id`),
  ADD KEY `fk_items_product` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

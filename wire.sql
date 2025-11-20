-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 20 2025 г., 08:02
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
(1, 2, 'Роман', 'г. Самара', '9371850590', 'card', 119.00, 'confirmed', '2025-10-30 12:52:00'),
(2, 2, 'Роман', 'adsadasd', 'dadsa', 'card', 119.00, 'new', '2025-11-18 08:33:43');

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
(1, 1, 1, 119.00, 1),
(2, 2, 1, 119.00, 1);

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
(1, 'Wire MK1 Mechanical Keyboard', 'keyboards', 119.00, 'assets/uploads/compact_small_mechanical_keyboard_with_61_keys_on_a_white_background_minimalistic_design_clear_refl_13d3r6cwp6kc99dvjz0f_3-69047121754c9.png', 'Компактная механическая клавиатура формата 75% с горячей заменой переключателей и яркой RGB-подсветкой. Создана для тех, кто хочет баланс между компактностью и функциональностью.', 'Тип: механическая\r\nФорм-фактор: 75%\r\nПодключение: USB-C\r\nПереключатели: Hot-Swap (совместимость MX)\r\nПодсветка: полноцветная RGB\r\nКорпус: алюминиевая верхняя панель\r\nОсобенности: двойные PBT keycaps, стабилизаторы с смазкой', 42, '2025-10-29 23:40:31'),
(2, 'Wire AeroMouse X2 Wireless', 'mice', 49.00, 'assets/uploads/aa973bba85fe86c82a20c2343c3dd8fc2a4754c11d9184fc44ab6550fb9f9d2f_jpg-690377e6a4353.webp', 'Лёгкая беспроводная игровая мышь с высокой точностью сенсора и режимом энергосбережения. Отлично подходит для динамичных игр.', 'Тип: беспроводная (2.4 ГГц + Bluetooth)\r\nСенсор: 18 000 DPI\r\nВес: 45 г\r\nАккумулятор: до 60 часов работы\r\nУскорение: 40G\r\nОсобенности: симметричная форма, зарядка USB-C', 85, '2025-10-29 23:40:31'),
(3, 'WireSound VX1', 'headphones', 149.00, 'assets/uploads/8925c23ebcbd51f57036553c483640614425fbf7de77dc29de713e64f55dcb97_jpg-691e3b9975309.webp', 'Гибридная модель IEM с мощным басовым драйвером и арматурным модулем для детальной середины. Удобная анатомическая форма обеспечивает комфорт при длительном ношении.', 'Тип: проводные гибридные IEM\r\nДрайверы: 1 динамический + 1 арматурный\r\nЧастотный диапазон: 10–40 000 Гц\r\nИмпеданс: 16 Ω\r\nКабель: серебряно-посеребренный, 1.3 м\r\nРазъём: 3.5 мм\r\nОсобенности: металлические звуковод, сменные насадки', 33, '2025-10-29 23:40:31'),
(4, 'Wire Echo-IEM Pro', 'headphones', 59.00, 'assets/uploads/afb0ff78b8fb2626fc2d3a0242a420e646e908905ff98f0e519aa03b2bab986a_jpg-691eaeb0bf1b8.webp', 'Профессиональные внутриканальные наушники, разработанные для точного мониторинга и глубокого прослушивания. Двойные драйверы обеспечивают чистые высокие частоты и мощный бас без искажений. Идеальны как для игр, так и для студийной работы.', 'Тип: проводные IEM\r\nДрайверы: 2 динамических\r\nИмпеданс: 18 Ω\r\nЧастотный диапазон: 15–24 000 Гц\r\nКабель: 1.2 м, съемный, MMCX\r\nКоннектор: 3.5 мм\r\nОсобенности: алюминиевый корпус, шумоизоляция до 26 dB', 120, '2025-10-29 23:40:31'),
(5, 'Wire TitanBoard 80%', 'keyboards', 89.00, 'assets/uploads/713699d6f449aa18a88946ca4c8479eacbe061e3349ba0899f965686739529b7_jpg-691eb1a2db239.webp', 'Минималистичная 80% клавиатура для максимального пространства на столе. Идеальна для киберспортсменов и любителей компактных решений.', 'Тип: механическая\r\nФорм-фактор: 80%\r\nКабель: съемный USB-C\r\nПереключатели: линейные (красные)\r\nКорпус: матовый ABS + усиленная плата\r\nОсобенности: режимы подсветки, режим игры, макросы', 0, '2025-11-20 10:13:54'),
(6, 'Wire PhantomGrip Wireless', 'mice', 69.00, 'assets/uploads/f676c1fd8717339c7ec5c9d5da08d69aa8a615c9b1eb43b25e7ada619773755d_png-691eb551a27fb.webp', 'Ультра-лёгкая беспроводная мышь, разработанная для тех, кто ценит максимальную подвижность и точность. Благодаря симметричной эргономической форме и продвинутому сенсору, она идеально подходит и для игр, и для офисной работы. Модель сочетает в себе стильный минималистичный дизайн и высокую производительность без компромиссов.', 'Тип подключения: беспроводной (2.4 ГГц и Bluetooth)\r\nСенсор: оптический, до 16 000 DPI\r\nЧастота опроса: 8000 Гц\r\nВес: около 40 г\r\nАккумулятор: до 80 часов автономной работы\r\nФорма: симметричная\r\nКорпус: матовый пластик, легкая конструкция\r\nОсобенности: RGB-индикатор заряда, переключение DPI , PTFE-ножки', 0, '2025-11-20 10:29:37'),
(7, 'Wire GlidePad XL', 'accessories', 49.00, 'assets/uploads/Screenshot_2025-11-20_103119-691eb5f23ff55.png', 'Большой игровой ковёр с быстрым скольжением, идеально подходящий для FPS-игр. Поверхность оптимизирована для точных микродвижений мышью.', 'Размер: 500×500×3 мм\r\nМатериал: текстиль + резиновая основа\r\nКрай: прошивка по периметру\r\nОсобенности:  антискольжение', 0, '2025-11-20 10:32:18'),
(8, 'Wire VelocityPad Pro', 'accessories', 39.00, 'assets/uploads/968be13064207cc9e487b7cb9e8a59a9ffd852a1a1f67b2e0981af65f9bc07b0_jpg-691eb6c626a8b.webp', 'Игровой ковёр Wire VelocityPad Pro создан для тех, кто стремится сочетать скорость и контроль. Его поверхность обеспечивает минимальное сопротивление при движении мыши, а усиленный габаритный размер даёт максимальную свободу в больших игровых пространствах или на низких сенсах. Ковёр также обладает прочной основой и плотной текстурой, устойчивой к истиранию.', 'Размер: 500 × 500 мм\r\nМатериал поверхности: высококачественный текстиль с низким трением\r\nОснова: плотная резина высокой плотности\r\nТолщина: 4 мм\r\nКрай: усиленная прошивка по периметру\r\nДополнительные особенности: водоотталкивающее покрытие, устойчивость к скручиванию, нескользящая резиновая подложка', 0, '2025-11-20 10:35:50');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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

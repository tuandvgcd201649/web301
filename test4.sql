-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 03, 2022 lúc 07:20 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test4`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Samsung', 'Smartphone'),
(2, 'Xiaomi', 'Smartphone'),
(8, 'Nokia', 'Smartphone'),
(9, 'Iphone', 'Apple'),
(10, 'LG', 'Smartphone');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221005073035', '2022-10-05 09:31:16', 113),
('DoctrineMigrations\\Version20221019064107', '2022-10-19 08:42:20', 33),
('DoctrineMigrations\\Version20221022022401', '2022-10-22 04:24:32', 135),
('DoctrineMigrations\\Version20221022192517', '2022-10-22 21:25:29', 135),
('DoctrineMigrations\\Version20221022193931', '2022-10-22 21:39:39', 83),
('DoctrineMigrations\\Version20221026071146', '2022-10-26 09:12:19', 592),
('DoctrineMigrations\\Version20221026092533', '2022-10-26 11:25:50', 304),
('DoctrineMigrations\\Version20221026093015', '2022-10-26 11:33:05', 132),
('DoctrineMigrations\\Version20221029080335', '2022-10-29 10:04:08', 185),
('DoctrineMigrations\\Version20221101031715', '2022-11-01 04:17:26', 128);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oder`
--

CREATE TABLE `oder` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `totalprice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `price`, `image`, `publisher_id`, `description`) VALUES
(13, 9, 'Iphone 11', 599, 'Iphone 11.jpg', NULL, NULL),
(14, 9, 'Iphone 13', 500, 'Iphone 13.jpg', NULL, NULL),
(15, 9, 'Iphone SE 64gb', 205, 'Iphone SE 64gb.jpg', NULL, NULL),
(16, 1, 'SamSung S22 Ultra 258GB', 450, 'SamSung S22 Ultra 258GB.jpg', NULL, NULL),
(17, 2, 'Xiaomi Redmi Note 11 258gb', 99, 'Xiaomi Redmi Note 11 258gb.jpg', NULL, NULL),
(18, 2, 'Xiaomi 11T Pro 5G 128gb', 130, 'Xiaomi 11T Pro 5G 128gb.jpg', NULL, NULL),
(19, 1, 'Galaxy Z - Fold 3 258gb', 320, 'Galaxy Z - Fold 3 258gb.jpg', NULL, NULL),
(20, 1, 'SamSung Galaxy Z - Flip 5G 128GB', 300, 'SamSung Galaxy Z - Flip 5G 128GB.jpg', NULL, NULL),
(21, 1, 'SamSung S22 Plus 258GB', 180, 'SamSung S22 Plus 258GB.jpg', NULL, NULL),
(22, 1, 'Galaxy S21 FE 258gb', 160, 'Galaxy S21 FE 258gb.jpg', NULL, NULL),
(23, 1, 'Galaxy A13 64gb', 85, 'Galaxy A13 64gb.jpg', NULL, NULL),
(24, 1, 'Galaxy A23 64gb', 95, 'Galaxy A23 64gb.jpg', NULL, NULL),
(25, 10, 'LG V70 5G 512GB', 410, 'LG V70 5G 512GB.jpg', NULL, NULL),
(26, 10, 'LG V40 512GB', 120, 'LG V40 512GB.jpg', NULL, NULL),
(27, 10, 'LG G8 128GB', 122, 'LG G8 128GB.jpg', NULL, NULL),
(28, 10, 'LG G7 ThingQ 512GB', 102, 'LG G7 ThingQ 512GB.jpg', NULL, NULL),
(29, 8, 'Nokia 6.1 Plus 64Gb', 55, 'Nokia 6.1 Plus 64Gb.jpg', NULL, NULL),
(30, 8, 'Nokia 8.3 Pro 128Gb', 75, 'Nokia 8.3 Pro 128Gb.jpg', NULL, NULL),
(32, 8, 'Nokia Maze Max Vip Pro Siêu Cấp 512gb', 456, 'Nokia Maze Max Vip Pro Siêu Cấp 512gb.jpg', NULL, NULL),
(39, 1, 'test', 15000, 'test.png', NULL, 'mô tả sp'),
(40, 2, 'Xiaomi K20 Pro Exclusive Edittion', 999, 'Xiaomi K20 Pro Exclusive Edittion.jpg', 3, 'Snap Dragon 855+ Ram 12/512');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`) VALUES
(1, 'tuan@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$q8NMYk4HNUuDHpJKDEfuc.CiWj4xhN5dG34nSA4812rwYL/uGVoWC', 'tuan'),
(2, 'user@gmail.com', '[\"ROLE_USER\"]', '$2y$13$JjwlKj8KHR97qFNGeHxCROf2jYo5BBTHd8MbwsQNB.xvoEuvva3Fu', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Chỉ mục cho bảng `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Chỉ mục cho bảng `oder`
--
ALTER TABLE `oder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AB5ED447A76ED395` (`user_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ED896F464584665A` (`product_id`),
  ADD KEY `IDX_ED896F468D9F6D38` (`order_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `oder`
--
ALTER TABLE `oder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `oder`
--
ALTER TABLE `oder`
  ADD CONSTRAINT `FK_AB5ED447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `FK_ED896F464584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_ED896F46FCDAEAAA` FOREIGN KEY (`order_id`) REFERENCES `oder` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD40C86FCE` FOREIGN KEY (`publisher_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

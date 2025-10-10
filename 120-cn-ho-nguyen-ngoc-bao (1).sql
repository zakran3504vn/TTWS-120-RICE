-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 10, 2025 lúc 05:14 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `120-cn-ho-nguyen-ngoc-bao`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banking`
--

CREATE TABLE `banking` (
  `bank_id` int(11) NOT NULL,
  `bankName` varchar(50) DEFAULT NULL,
  `bankNumber` varchar(30) DEFAULT NULL,
  `accountHolder` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billing`
--

CREATE TABLE `billing` (
  `bill_id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bill_amount` decimal(15,2) DEFAULT NULL,
  `bill_des` varchar(255) DEFAULT NULL,
  `user_bank_name` varchar(50) DEFAULT NULL,
  `user_bank_number` varchar(20) DEFAULT NULL,
  `user_account_holder` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `brandID` int(11) NOT NULL,
  `brandName` varchar(255) NOT NULL,
  `brandDescription` text DEFAULT NULL,
  `brandImg` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`brandID`, `brandName`, `brandDescription`, `brandImg`, `createdAt`) VALUES
(1, 'okokko', '<p>dvregvvedf</p>', NULL, '2025-08-27 17:28:10'),
(2, 'thanhn strb rs', 'df zdrv', NULL, '2025-08-27 17:28:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) NOT NULL,
  `CategoryImg` varchar(255) DEFAULT NULL,
  `isTop` enum('true','false') NOT NULL DEFAULT 'false',
  `description` text DEFAULT NULL COMMENT 'mô tả về danh mục ',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `CategoryImg`, `isTop`, `description`, `CreatedAt`) VALUES
(55, 'Gạo Trắng', '68b8ff395fc16.jpg', 'false', '<p>Dòng gạo chuyên dùng cho bếp ăn công nghiệp – Giải pháp tối ưu cho suất ăn số lượng lớn</p>', '2025-08-30 07:49:54'),
(56, 'Gạo ST25', '68b8155161bf0.jpg', 'false', '<p>Dòng gạo cao cấp cho những bữa ăn chất lượng vượt trội</p>', '2025-08-30 08:17:25'),
(57, 'Gạo từ thiện', '68b81580dcc9d.jpg', 'false', '<p>Chia sẻ yêu thương từ những hạt gạo nghĩa tình</p>', '2025-09-03 04:03:21'),
(58, 'Gạo Đài Thơm 8', '68b8feaa4ec28.png', 'false', '<p>Mềm dẻo thơm ngon, phù hợp mọi bữa ăn gia đình và công nghiệp</p>', '2025-09-04 02:51:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_customer`
--

CREATE TABLE `contact_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_customer`
--

INSERT INTO `contact_customer` (`id`, `name`, `address`, `email`, `phone`, `subject`, `content`, `created_at`) VALUES
(5, 'VÁy dài', NULL, 'hoanghoadht@gmail.com', '0982635622', 'order', '1', '2025-08-26 10:11:35'),
(6, 'VÁy dài 1', NULL, 'hoanghoa1dht@gmail.com', '0982635621', 'product', '12223sdfsf', '2025-08-26 10:12:09'),
(11, '', NULL, 'hoanghoadht@gmail.com', '04550787178', '', '', '2025-08-30 07:06:58'),
(12, '', NULL, 'kimthanh0345380237@gmail.com', '04550787178', '', '', '2025-08-30 07:08:00'),
(13, '', NULL, 'ht@gmail.com', '0698453078', '', '', '2025-08-30 07:10:57'),
(14, '', NULL, 'kimthanh0345380237@gmail.com', '0698453020', '', '', '2025-08-30 07:19:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `create_at`) VALUES
(4, '', '', '', '', '2025-08-29 02:22:27'),
(5, '', '', '', '', '2025-08-29 02:31:34'),
(6, '', '', '', '', '2025-08-29 02:53:24'),
(7, '', '', '', '', '2025-08-29 02:55:38'),
(8, '', '', '', '', '2025-08-29 08:32:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `discount_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `discount_type` enum('fixed','percentage') NOT NULL DEFAULT 'fixed',
  `min_order_value` decimal(10,2) DEFAULT 0.00,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `managermeta`
--

CREATE TABLE `managermeta` (
  `MetaID` int(11) NOT NULL,
  `Meta_Type` enum('description','opengraphic-description','keywords') NOT NULL,
  `MetaContent` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `website_title` text NOT NULL DEFAULT 'Web Giới Thiệu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_name` varchar(255) DEFAULT NULL,
  `news_content` text DEFAULT NULL,
  `new_summary` text NOT NULL,
  `news_author` varchar(255) DEFAULT NULL,
  `news_img` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `outstanding` enum('true','false') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`news_id`, `news_name`, `news_content`, `new_summary`, `news_author`, `news_img`, `slug`, `outstanding`, `create_time`, `update_time`) VALUES
(29, 'kakakaaa', '<p>ậbjajjbababajbjaiaoaooa</p>', 'ahaaa', 'zzz', '/admin/assets/img//68b48f4e6261c.png', 'no-ọaab', NULL, '2025-08-31 18:06:09', '2025-08-31 18:07:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL COMMENT 'Tổng tiền trước giảm giá',
  `discount_amount` decimal(10,2) DEFAULT 0.00 COMMENT 'Số tiền giảm giá',
  `final_amount` decimal(10,2) NOT NULL COMMENT 'Tổng tiền sau giảm giá',
  `coupon_code` varchar(50) DEFAULT NULL COMMENT 'Mã giảm giá đã áp dụng',
  `status` varchar(50) NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái đơn hàng (pending, completed, cancelled,...)',
  `billing_first_name` varchar(100) NOT NULL COMMENT 'Họ người nhận',
  `billing_last_name` varchar(100) NOT NULL COMMENT 'Tên người nhận',
  `billing_company` varchar(100) DEFAULT NULL COMMENT 'Tên công ty (không bắt buộc)',
  `billing_address_1` varchar(255) NOT NULL COMMENT 'Địa chỉ đường phố',
  `billing_address_2` varchar(255) DEFAULT NULL COMMENT 'Địa chỉ bổ sung (không bắt buộc)',
  `billing_province` varchar(50) NOT NULL COMMENT 'Mã tỉnh/thành phố',
  `billing_district` varchar(50) NOT NULL COMMENT 'Mã quận/huyện',
  `billing_ward` varchar(50) NOT NULL COMMENT 'Mã phường/xã',
  `billing_postcode` varchar(20) NOT NULL COMMENT 'Mã bưu điện',
  `billing_phone` varchar(20) NOT NULL COMMENT 'Số điện thoại',
  `billing_email` varchar(100) NOT NULL COMMENT 'Email',
  `order_comments` text DEFAULT NULL COMMENT 'Ghi chú đơn hàng',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo đơn hàng',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật đơn hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `product_rate` int(11) DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_album` text DEFAULT NULL,
  `product_pricesales` int(11) DEFAULT NULL,
  `product_features` tinyint(1) NOT NULL DEFAULT 0,
  `product_parameters` text DEFAULT NULL,
  `product_comment` text DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_services` text DEFAULT NULL,
  `outstanding_products` enum('true','false') DEFAULT 'false',
  `brandID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `CategoryID`, `product_description`, `product_price`, `stock_quantity`, `product_rate`, `product_img`, `product_album`, `product_pricesales`, `product_features`, `product_parameters`, `product_comment`, `create_at`, `update_at`, `product_services`, `outstanding_products`, `brandID`) VALUES
(242, 'Gạo', 55, '<p>GẠO SẠCH 3 MIỀN cung cấp dòng gạo chất lượng ổn định, được tuyển chọn kỹ lưỡng, đặc biệt phù hợp cho các bếp ăn công nghiệp như nhà máy, khu chế xuất, trường học, bệnh viện và doanh nghiệp dịch vụ suất ăn</p>', 62000, 1, NULL, '68b8f80962f69.jpg', '68b8f8096327d.jpg,68b8f80963524.jpg', 55000, 1, '<p>Nhập Thông Số Kỹ Thuật</p>', NULL, '2025-08-31 17:55:54', '2025-09-08 16:11:33', '', 'false', 1),
(243, 'Gạo 2', 56, '<p>Gạo có đặc tính nở đều, cơm mềm nhưng không nhão, giữ được độ ngon sau thời gian dài bảo quản trong nhiệt độ phòng, đáp ứng yêu cầu về khẩu phần lớn và thời gian phục vụ kéo dài.</p>', 85555, 2, NULL, '68b8f850a2ad0.jpg', '68b8f850a2e51.jpg,68b8f850a30d4.jpg', 56000, 1, '<p>Nhập Thông Số Kỹ Thuật</p>', NULL, '2025-09-04 02:24:16', '2025-09-08 16:11:58', '', 'false', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_summary` varchar(255) DEFAULT NULL,
  `project_content` varchar(255) DEFAULT NULL,
  `project_tag` varchar(255) DEFAULT NULL,
  `project_img` text DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `outstanding_project` enum('true','false') DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rate`
--

CREATE TABLE `rate` (
  `RateID` int(11) NOT NULL,
  `news_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Comment` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_summary` varchar(255) DEFAULT NULL,
  `service_content` varchar(255) DEFAULT NULL,
  `service_tag` varchar(255) DEFAULT NULL,
  `service_img` text DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tag_service`
--

CREATE TABLE `tag_service` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Customer','Employee','Admin') NOT NULL DEFAULT 'Customer',
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_bank_name` varchar(100) DEFAULT NULL,
  `user_bank_number` varchar(50) DEFAULT NULL,
  `user_account_holder` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `full_name`, `created_at`, `updated_at`, `phone`, `address`, `user_bank_name`, `user_bank_number`, `user_account_holder`) VALUES
(37, 'admin', '123', 'Admin', 'admin@ad.com', 'Quản trị viên', '2025-08-29 03:40:44', '2025-08-29 03:41:54', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wallet`
--

CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `youtube_videos`
--

CREATE TABLE `youtube_videos` (
  `id` int(11) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banking`
--
ALTER TABLE `banking`
  ADD PRIMARY KEY (`bank_id`);

--
-- Chỉ mục cho bảng `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brandID`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `contact_customer`
--
ALTER TABLE `contact_customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `managermeta`
--
ALTER TABLE `managermeta`
  ADD PRIMARY KEY (`MetaID`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `fk_products_brands` (`brandID`);

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Chỉ mục cho bảng `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`RateID`),
  ADD KEY `news_id` (`news_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Chỉ mục cho bảng `tag_service`
--
ALTER TABLE `tag_service`
  ADD PRIMARY KEY (`tag_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `youtube_videos`
--
ALTER TABLE `youtube_videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banking`
--
ALTER TABLE `banking`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `billing`
--
ALTER TABLE `billing`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `brandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `contact_customer`
--
ALTER TABLE `contact_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `managermeta`
--
ALTER TABLE `managermeta`
  MODIFY `MetaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `rate`
--
ALTER TABLE `rate`
  MODIFY `RateID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tag_service`
--
ALTER TABLE `tag_service`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `youtube_videos`
--
ALTER TABLE `youtube_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `banking` (`bank_id`);

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_brands` FOREIGN KEY (`brandID`) REFERENCES `brands` (`brandID`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Các ràng buộc cho bảng `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`news_id`);

--
-- Các ràng buộc cho bảng `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `fk_wallet_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

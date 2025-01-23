-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 23, 2025 at 02:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pkk_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int NOT NULL,
  `id_product` int DEFAULT NULL,
  `nama_product` varchar(255) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `nama_gambar` varchar(255) DEFAULT NULL,
  `quantity_total` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `drinks`
--

CREATE TABLE `drinks` (
  `drinks_id` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `ukuran` enum('Kecil','Sedang','Besar') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Sedang',
  `suhu` enum('Dingin','Panas') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Dingin',
  `rasa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tersedia` tinyint(1) DEFAULT '1',
  `url_gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drinks`
--

INSERT INTO `drinks` (`drinks_id`, `nama`, `deskripsi`, `harga`, `ukuran`, `suhu`, `rasa`, `tersedia`, `url_gambar`) VALUES
(1, 'Soda Gembira', 'Minuman soda dengan susu dan sirup segar.', 10000.00, 'Sedang', 'Dingin', 'Strawberry', 1, 'images/soda_gembira.jpg'),
(2, 'Teh Manis Panas', 'Teh manis hangat.', 5000.00, 'Kecil', 'Panas', NULL, 1, 'images/teh_manis.jpg'),
(3, 'Kopi Latte', 'Kopi dengan susu yang lembut.', 15000.00, 'Besar', 'Panas', 'Vanilla', 1, 'images/kopi_latte.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `foods_id` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `harga` decimal(10,2) NOT NULL,
  `quantity` int DEFAULT NULL,
  `gambar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nama_gambar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`foods_id`, `nama`, `deskripsi`, `harga`, `quantity`, `gambar`, `nama_gambar`) VALUES
(1, 'Mie Roll', NULL, 12000.00, 20, 'assets/images-product/Mie Roll.jpg', 'Mie Roll.jpg'),
(2, 'Sawi Gulung', NULL, 10000.00, 20, 'assets/images-product/Sawi Gulung.jpg', 'Sawi Gulung.jpg'),
(3, 'Keripik Pisang Lumer', NULL, 5000.00, 12, 'assets/images-product/Keripik Pisang Lumer.jpg', 'Keripik Pisang Lumer.jpg'),
(4, 'Sushi', NULL, 7000.00, 20, 'assets/images-product/sushi.jpg', 'sushi.jpg'),
(5, 'Donat Coklat', NULL, 4000.00, 20, 'assets/images-product/Donat.jpg', 'Donat.jpg'),
(6, 'Salad Buah', NULL, 15000.00, 12, 'assets/images-product/Salad Buah.jpg', 'Salad Buah.jpg'),
(7, 'Snack Kriukkk-Basreng Pedas', NULL, 5000.00, 15, 'assets/images-product/Basreng.jpg', 'Basreng.jpg'),
(8, 'Snack Kriukkk-Seblak Kering', NULL, 5000.00, 15, 'assets/images-product/Seblak Kering.jpg', 'Seblak Kering.jpg'),
(9, 'Baso Mercon', NULL, 10000.00, 25, 'assets/images-product/Baso Mercon.jpg', 'Baso Mercon.jpg'),
(10, 'Risol', NULL, 2500.00, 40, 'assets/images-product/Risol.jpg', 'Risol.jpg'),
(11, 'Banana Roll', NULL, 7000.00, 10, 'assets/images-product/Banana Roll.jpg', 'Banana Roll.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pre_orders`
--

CREATE TABLE `pre_orders` (
  `id_pre_order` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending',
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int NOT NULL,
  `total_price` float DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pre_orders`
--

INSERT INTO `pre_orders` (`id_pre_order`, `username`, `nama_product`, `status`, `order_date`, `quantity`, `total_price`, `kelas`, `user_id`) VALUES
(1, 'Kenzie', 'Mie Roll', 'pending', '2025-01-23 12:32:06', 1, 12000, NULL, NULL),
(2, 'Kenzie', 'Mie Roll', 'pending', '2025-01-23 12:38:04', 1, 12000, NULL, NULL),
(3, 'Kenzie', 'Sawi Gulung, Mie Roll', 'pending', '2025-01-23 13:14:39', 2, 22000, NULL, NULL),
(4, 'Kenzie', 'Mie Roll', 'pending', '2025-01-23 13:19:33', 1, 12000, NULL, NULL),
(5, 'Kenzie', 'Sawi Gulung', 'pending', '2025-01-23 13:25:17', 1, 10000, NULL, NULL),
(6, 'Kenzie', 'Mie Roll', 'pending', '2025-01-23 13:39:09', 1, 12000, NULL, NULL),
(7, 'Kenzie', 'Mie Roll', 'pending', '2025-01-23 13:41:16', 1, 12000, NULL, NULL),
(8, 'Kenzie', 'Sushi, Donat Coklat', 'pending', '2025-01-23 13:50:34', 2, 11000, NULL, NULL),
(9, 'Kenzie', 'Donat Coklat', 'pending', '2025-01-23 14:06:17', 1, 4000, NULL, NULL),
(10, 'Kenzie', 'Donat Coklat', 'pending', '2025-01-23 14:08:05', 1, 4000, 'XI RPL B', NULL),
(11, 'Kenzie', 'Mie Roll', 'pending', '2025-01-23 14:13:38', 1, 12000, 'XI RPL B', NULL),
(12, 'Kenzie', 'Mie Roll', 'pending', '2025-01-23 14:35:26', 1, 12000, 'XI RPL B', NULL),
(13, 'Kenzie', 'Sawi Gulung, Mie Roll', 'pending', '2025-01-23 14:43:14', 2, 22000, 'XI RPL B', NULL),
(14, 'Kenzie', 'Snack Kriukkk-Seblak Kering', 'pending', '2025-01-23 14:43:39', 1, 5000, 'XI RPL B', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `kelas`, `created_at`, `updated_at`) VALUES
(1, 'Hirto Eveen Tamamekeng', '$2y$10$GhizpNm/mwBnEdR3g.N3xOz.muBbKYrGgrp.AmdPjK7tBBLyoMosS', 'hirtoetamamekeng@smkn1kotabekasi.sch.id', '11 RPL B', '2025-01-14 13:29:38', '2025-01-14 13:29:38'),
(2, 'Ruan Mei', 'hirtoetamamekeng@smkn1kotabekasi.sch.id', '$2y$10$u6IUYStW0gIi4/g56Wr0bOtOuGz9x/F6lX.evUgpGXdbmVnjgJwcW', '11 IPA C', '2025-01-14 13:43:06', '2025-01-14 13:43:06'),
(3, 'aaa', 'akaka@g.com', '$2y$10$OUdEIobP5sjraWcUn.gbeOyaV9VCF72Mfs2VnLxW/tDc6z.C5b6Yi', '11 IPA C', '2025-01-22 00:21:27', '2025-01-22 00:21:27'),
(4, 'Ruan Meia', 'a@g.com', '$2y$10$lPGdAllfhfr0spAe/rAlauEt/4AK5wgeW.WjtUBTLinZq6Ii6vf06', 'aaaa', '2025-01-22 00:23:29', '2025-01-22 00:23:29'),
(5, 'Mupdi', 'nmufidibrahim@gmail.com', '$2y$10$.XEezWBOR6oekclgo2V70O1SQjZk58yuTZJgojwvHoZBSm9VLbap2', 'XI PPLG B', '2025-01-22 00:30:55', '2025-01-22 00:30:55'),
(6, 'Handikach', 'handika@k.com', '$2y$10$QsUWLRuvz55P2om/dFfs5.D.E/rpPH65h6Gp9WQDZE.ppNdijxVz6', 'XI PPLG B', '2025-01-22 00:35:53', '2025-01-22 00:35:53'),
(7, 'michael', 'carlosimbolon23@gmail.com', '$2y$10$lhgMsg.4vzK5H2icb5ZdfeCr4VxplsZf6bNaU1kBzmL5QeF7XHNnC', 'XI RPL B', '2025-01-22 00:38:17', '2025-01-22 00:38:17'),
(8, 'Kenzie', 'yasirkenzie@gmail.com', '$2y$10$j3Zk1LQv9voyFlpe5x4t5e3qxKy0Zb3/9I6lZxTouWxhMCys/fkl.', 'XI RPL B', '2025-01-22 12:18:08', '2025-01-22 12:18:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `drinks`
--
ALTER TABLE `drinks`
  ADD PRIMARY KEY (`drinks_id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`foods_id`);

--
-- Indexes for table `pre_orders`
--
ALTER TABLE `pre_orders`
  ADD PRIMARY KEY (`id_pre_order`),
  ADD KEY `username` (`username`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `foods_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pre_orders`
--
ALTER TABLE `pre_orders`
  MODIFY `id_pre_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `foods` (`foods_id`);

--
-- Constraints for table `pre_orders`
--
ALTER TABLE `pre_orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pre_orders_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

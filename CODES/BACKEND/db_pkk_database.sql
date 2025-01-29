-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jan 2025 pada 11.07
-- Versi server: 8.0.30
-- Versi PHP: 8.3.12

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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username_admin`, `password_admin`) VALUES
(1, 'admin', '$2y$10$aV.iHGnKbjpbasy2ugVoMusv3MMkEMkCMmmYuWnmcs4tlxHoIQhPW');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id_cart` int NOT NULL,
  `id_product` int DEFAULT NULL,
  `nama_product` varchar(255) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `nama_gambar` varchar(255) DEFAULT NULL,
  `quantity_total` int DEFAULT '1',
  `product_type` enum('food','drink') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Struktur dari tabel `foods`
--

CREATE TABLE `foods` (
  `foods_id` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `harga` decimal(10,2) NOT NULL,
  `quantity` int DEFAULT NULL,
  `gambar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nama_gambar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `product_type` enum('food','drink') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `foods`
--

INSERT INTO `foods` (`foods_id`, `nama`, `deskripsi`, `harga`, `quantity`, `gambar`, `nama_gambar`, `product_type`) VALUES
(1, 'Mie Roll', 'Mie yang digulung dengan ricepaper', 12000.00, 20, 'assets/images-product/mie_roll.jpg', 'mie_roll.jpg', 'food'),
(2, 'Sawi Gulung', 'Sawi gulung sehat', 13000.00, 20, 'assets/images-product/sawi_gulung.jpg', 'sawi_gulung.jpg', 'food'),
(3, 'Keripik Pisang Lumer', 'Kripik dengan coklat lumer', 5000.00, 12, 'assets/images-product/keripik_pisang_lumer.jpg', 'keripik_pisang_lumer.jpg', 'food'),
(4, 'Sushi', 'Sushi khas jepang ala nusantara', 7000.00, 20, 'assets/images-product/sushi.jpg', 'sushi.jpg', 'food'),
(5, 'Donat Coklat', 'Donut dengan topping coklat', 4000.00, 20, 'assets/images-product/donat.jpg', 'donat.jpg', 'food'),
(6, 'Salad Buah', 'Salad dengan campuran buah', 15000.00, 12, 'assets/images-product/salad_buah.jpg', 'salad_buah.jpg', 'food'),
(7, 'Snack Kriukkk-Basreng Pedas', 'Basreng yang kriuk dan membara di mulut', 5000.00, 15, 'assets/images-product/basreng.jpg', 'basreng.jpg', 'food'),
(8, 'Snack Kriukkk-Seblak Kering', 'Seblak yang crunchy dan pedas', 5000.00, 15, 'assets/images-product/seblak_kering.jpg', 'seblak_kering.jpg', 'food'),
(9, 'Baso Mercon', 'Bakso dengan sensasi berapi-api di mulut', 10000.00, 25, 'assets/images-product/bakso_mercon.jpg', 'bakso_mercon.jpg', 'food'),
(10, 'Risol', 'Jajanan populer kalangan anak muda', 2500.00, 20, 'assets/images-product/risol.jpg', 'risol.jpg', 'food'),
(11, 'Banana Roll', 'Banana Roll yang lumer', 7000.00, 10, 'assets/images-product/banana_roll.jpg', 'banana_roll.jpg', 'food'),
(12, 'Molen', 'Molen berisi pisang dengan rasa coklat.', 5000.00, 12, 'assets/images-product/molen.jpg', 'molen.jpg', 'food'),
(13, 'Piscok', 'Kombinasi pisang dengan coklat yang nikmat.', 3000.00, 20, 'assets/images-product/piscok.jpg', 'piscok.jpg', 'food'),
(14, 'Es Pink', 'Campuran sirup dan susu yang segar.', 5000.00, 10, 'assets/images-product/es_pink.jpg', 'es_pink.jpg', 'drink'),
(15, 'Thai Tea', 'Teh yang segar khas negeri siam.', 7000.00, 19, 'assets/images-product/thai_tea.jpg', 'thai_tea.jpg', 'drink'),
(16, 'Soda Gembira', 'Minuman segar dengan campuran soda dan susu.', 5000.00, 10, 'assets/images-product/soda_gembira.jpg', 'soda_gembira.jpg', 'drink');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pre_orders`
--

CREATE TABLE `pre_orders` (
  `id_pre_order` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `status` enum('pending','confirmed','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int NOT NULL,
  `total_price` float DEFAULT NULL,
  `kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `kelas`, `created_at`, `updated_at`) VALUES
(1, 'tes', '$2y$10$9HJtllVE9cvo4kr2/TxJiO22uAchK3LJTLgCuRbMYLKwTHuMT4WQm', 'admin', '2025-01-24 03:06:43', '2025-01-24 03:10:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`foods_id`);

--
-- Indeks untuk tabel `pre_orders`
--
ALTER TABLE `pre_orders`
  ADD PRIMARY KEY (`id_pre_order`),
  ADD KEY `username` (`username`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `foods`
--
ALTER TABLE `foods`
  MODIFY `foods_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `pre_orders`
--
ALTER TABLE `pre_orders`
  MODIFY `id_pre_order` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `foods` (`foods_id`);

--
-- Ketidakleluasaan untuk tabel `pre_orders`
--
ALTER TABLE `pre_orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pre_orders_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

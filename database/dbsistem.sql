-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2025 at 07:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsistem`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahanbaku`
--

CREATE TABLE `bahanbaku` (
  `idBahanBaku` varchar(11) NOT NULL,
  `namaBahan` varchar(100) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahanbaku`
--

INSERT INTO `bahanbaku` (`idBahanBaku`, `namaBahan`, `stok`, `satuan`) VALUES
('BHN01', 'Cotton Combed 30s', 0, 'Rol'),
('BHN02', 'Cotton Spandex', 45, 'Pcs'),
('BHN03', 'Flannel Fabric', 150, 'Meter'),
('BHN04', 'Denim Fabric', 30, 'Meter'),
('BHN05', 'Polyester', 100, 'Meter'),
('BHN06', 'Nylon Thread', 5, 'Pcs Rol'),
('BHN07', 'Cotton Fleece', 80, 'Meter'),
('BHN08', 'Linen Fabric', 10, 'Meter'),
('BHN09', 'Leather', 0, 'Pcs'),
('BHN15', 'Polyester Blend', 40, 'Meter'),
('BHN16', 'Silk', 0, 'Rol'),
('BHN17', 'Microfiber', 90, 'Meter');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `idInvoice` varchar(15) NOT NULL,
  `tanggal_invoice` date NOT NULL,
  `idSuratJalan` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `size_s` int(11) DEFAULT 0,
  `size_m` int(11) DEFAULT 0,
  `size_l` int(11) DEFAULT 0,
  `size_xl` int(11) DEFAULT 0,
  `size_xxl` int(11) DEFAULT 0,
  `harga_s` decimal(10,2) DEFAULT 0.00,
  `harga_m` decimal(10,2) DEFAULT 0.00,
  `harga_l` decimal(10,2) DEFAULT 0.00,
  `harga_xl` decimal(10,2) DEFAULT 0.00,
  `harga_xxl` decimal(10,2) DEFAULT 0.00,
  `total_s` decimal(15,2) DEFAULT 0.00,
  `total_m` decimal(15,2) DEFAULT 0.00,
  `total_l` decimal(15,2) DEFAULT 0.00,
  `total_xl` decimal(15,2) DEFAULT 0.00,
  `total_xxl` decimal(15,2) DEFAULT 0.00,
  `total_bayar` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`idInvoice`, `tanggal_invoice`, `idSuratJalan`, `nama_pelanggan`, `nama_barang`, `size_s`, `size_m`, `size_l`, `size_xl`, `size_xxl`, `harga_s`, `harga_m`, `harga_l`, `harga_xl`, `harga_xxl`, `total_s`, `total_m`, `total_l`, `total_xl`, `total_xxl`, `total_bayar`) VALUES
('INV01', '2025-06-07', 'SJ01', 'Silvia Nur Baiti', 'Kaos Polos Warna Hitam', 10, 10, 10, 10, 10, 45000.00, 45000.00, 45000.00, 45000.00, 45000.00, 450000.00, 450000.00, 450000.00, 450000.00, 450000.00, 2250000.00),
('INV02', '2025-06-08', 'SJ02', 'Andi Setiawan', 'Kaos Grafis Warna Biru', 15, 10, 10, 0, 0, 60000.00, 60000.00, 60000.00, 60000.00, 0.00, 900000.00, 600000.00, 600000.00, 0.00, 0.00, 2100000.00),
('INV03', '2025-06-10', 'SJ03', 'Dika Handika', 'Kaos Trendy', 35, 10, 35, 0, 0, 35000.00, 35000.00, 35000.00, 35000.00, 35000.00, 1225000.00, 350000.00, 1225000.00, 0.00, 0.00, 2800000.00),
('INV04', '2025-07-11', 'SJ04', 'Andi Setiawan', 'Kaos Grafis Warna Biru', 3, 2, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
('INV05', '2025-07-24', 'SJ05', 'Arkana Gaza', 'Celana rumbe tag hourisko', 50, 50, 0, 0, 0, 90000.00, 90000.00, 0.00, 0.00, 0.00, 4500000.00, 4500000.00, 0.00, 0.00, 0.00, 9000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idpelanggan` varchar(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kontak` int(20) NOT NULL,
  `no_rekening` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idpelanggan`, `nama`, `alamat`, `kontak`, `no_rekening`) VALUES
('PEL01', 'Silvia Nur Baiti', 'Jl. Kopo Cirangrang GG Melati 2', 2147483647, '901640080798 - Seabank'),
('PEL02', 'Andi Setiawan', 'Jl. Raya Cikole No.5', 2147483647, '123456789012 - BCA'),
('PEL03', 'Budi Santoso', 'Jl. Karang Satria', 2147483647, '987654321098 - BRI'),
('PEL04', 'Ardiansyah Fadhil', 'Jl. Pahlawan No.20', 2147483647, '567890123456 - Mandiri'),
('PEL05', 'Hanaya Nur', 'Jl. Bunga Anggrek No.8', 2147483647, '234567890123 - BCA'),
('PEL06', 'Dika Handika', 'Jl. Karang Satria', 2147483647, '345678901234 - BRI'),
('PEL07', 'Xaviera Nadayati', 'Jl. Bunga Anggrek No.8', 2147483647, '456789012345 - Mandiri'),
('PEL08', 'Karmila Nala', 'Jl. Kopo Cirangrang', 2147483647, 'bca-6578492');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `idOrder` varchar(50) NOT NULL,
  `namaPelanggan` varchar(100) NOT NULL,
  `tanggalPesanan` date NOT NULL DEFAULT current_timestamp(),
  `namaBarang` varchar(150) NOT NULL,
  `sizeS` int(11) DEFAULT 0,
  `sizeM` int(11) DEFAULT 0,
  `sizeL` int(11) DEFAULT 0,
  `sizeXL` int(11) DEFAULT 0,
  `sizeXXL` int(11) NOT NULL,
  `bahan` varchar(150) DEFAULT NULL,
  `sisaKirim` int(11) DEFAULT 0,
  `status` enum('Pending','Diproses','Dikirim','Selesai') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`idOrder`, `namaPelanggan`, `tanggalPesanan`, `namaBarang`, `sizeS`, `sizeM`, `sizeL`, `sizeXL`, `sizeXXL`, `bahan`, `sisaKirim`, `status`) VALUES
('ORD01', 'Silvia Nur Baiti', '2025-06-01', 'Kaos Polos Warna Hitam', 15, 10, 20, 30, 0, 'Cotton Combed 30s', 75, 'Dikirim'),
('ORD02', 'Andi Setiawan', '2025-06-01', 'Kaos Grafis Warna Biru', 12, 18, 20, 30, 20, 'Cotton Combed 24s', 100, 'Pending'),
('ORD03', 'Budi Santoso', '2025-06-01', 'Kaos Motif Band', 15, 15, 15, 20, 20, 'Cotton Fleece', 85, 'Dikirim'),
('ORD04', 'Ardiansyah Fadhil', '2025-06-01', 'Kaos Warna Merah', 50, 50, 50, 50, 35, 'Cotton Spandex', 235, 'Selesai'),
('ORD05', 'Dika Handika', '2025-06-01', 'Kaos Trendy', 35, 60, 35, 50, 50, 'Cotton Combed 30s', 230, 'Pending'),
('ORD06', 'Xaviera Nadayati', '2025-06-01', 'Celana Biru Putih List Kuning', 50, 50, 50, 50, 50, 'Jersey', 250, 'Pending'),
('ORD07', 'Ardiansyah Fadhil', '2025-07-16', 'Kaos Polos Warna Hitam', 50, 50, 50, 50, 50, 'Katun ', 250, 'Diproses'),
('ORD08', 'Arkana Gaza', '2025-07-16', 'Celana rumbe tag hourisko', 50, 50, 100, 100, 100, 'Jeans', 400, 'Diproses');

-- --------------------------------------------------------

--
-- Table structure for table `suratjalan`
--

CREATE TABLE `suratjalan` (
  `idsuratjalan` varchar(100) NOT NULL,
  `idorder` varchar(100) NOT NULL,
  `tanggal_surat_jalan` date DEFAULT current_timestamp(),
  `nama_pelanggan` varchar(150) NOT NULL,
  `alamat_pelanggan` text NOT NULL,
  `nama_barang` text NOT NULL,
  `size_s_kirim` int(11) DEFAULT 0,
  `size_m_kirim` int(11) DEFAULT 0,
  `size_l_kirim` int(11) DEFAULT 0,
  `size_xl_kirim` int(11) DEFAULT 0,
  `size_xxl_kirim` int(11) DEFAULT 0,
  `status_pengiriman` varchar(30) DEFAULT 'Dikirim',
  `file_surat_jalan` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suratjalan`
--

INSERT INTO `suratjalan` (`idsuratjalan`, `idorder`, `tanggal_surat_jalan`, `nama_pelanggan`, `alamat_pelanggan`, `nama_barang`, `size_s_kirim`, `size_m_kirim`, `size_l_kirim`, `size_xl_kirim`, `size_xxl_kirim`, `status_pengiriman`, `file_surat_jalan`) VALUES
('SJ01', 'ORD01', '2025-06-05', 'Silvia Nur Baiti', 'Jl. Kopo Cirangrang GG Melati 2', 'Kaos Polos Warna Hitam', 10, 10, 10, 10, 10, 'Dikirim', NULL),
('SJ02', 'ORD02', '2025-06-07', 'Andi Setiawan', 'Jl. Raya Cikole No.5', 'Kaos Grafis Warna Biru', 15, 10, 10, 0, 0, 'Dikirim', NULL),
('SJ03', 'ORD05', '2025-06-10', 'Dika Handika', 'Jl. Karang Satria', 'Kaos Trendy', 35, 10, 35, 0, 0, 'Dikirim', NULL),
('SJ04', 'ORD02', '2025-07-18', 'Andi Setiawan', 'aaaa', 'Kaos Grafis Warna Biru', 3, 2, 0, 0, 0, 'Terkirim', NULL),
('SJ05', 'ORD08', '2025-07-18', 'Arkana Gaza', 'Jalan Cempaka', 'Celana rumbe tag hourisko', 50, 50, 0, 0, 0, 'Terkirim', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `username` varchar(150) NOT NULL,
  `namaUser` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `namaUser`, `password`, `role`, `created_at`) VALUES
('USR01', 'Silvia', 'Silvia Nur Baiti', '$2y$10$FJFf9OK27tCPj27qLCuJL.JYdCrEbInyBfii9xeve/zHWUcFSDHhe', 'admin', '2025-05-20 03:25:20'),
('USR02', 'Rifa', 'Rifa Firdaus', '$2y$10$7NpGBI3ifgpQxxubsNTfIuqpZOSZcDna1WWNOO/PXtffHYTUFNULu', 'admin', '2025-07-16 11:02:16'),
('USR03', 'Endar', 'Endar Maulana', '$2y$10$va10cGEGpGvmhSqKz/JzCOVrRr6T39t4flXDE6tgs1DP9kttnxh/m', 'petugas', '2025-07-16 11:03:20'),
('USR04', 'Wahyu', 'Wahyu Nur Sigit', '$2y$10$S0WLu6FipcF5PNuN6YGw3.SKOoa79oDpUx8eH7Tahk33nRrfHaJd2', 'manajer', '2025-07-16 11:04:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahanbaku`
--
ALTER TABLE `bahanbaku`
  ADD PRIMARY KEY (`idBahanBaku`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`idInvoice`),
  ADD KEY `idSuratJalan` (`idSuratJalan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idpelanggan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idOrder`);

--
-- Indexes for table `suratjalan`
--
ALTER TABLE `suratjalan`
  ADD PRIMARY KEY (`idsuratjalan`),
  ADD KEY `idorder` (`idorder`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`namaUser`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`idSuratJalan`) REFERENCES `suratjalan` (`idsuratjalan`);

--
-- Constraints for table `suratjalan`
--
ALTER TABLE `suratjalan`
  ADD CONSTRAINT `suratjalan_ibfk_1` FOREIGN KEY (`idorder`) REFERENCES `pesanan` (`idOrder`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

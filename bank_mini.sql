-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 05:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_mini`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama`) VALUES
(3, 'Manajemen Perkantoran Layanan Bisnis'),
(4, 'Bisnis Daring dan Pemasaran'),
(5, 'Teknik Logistik'),
(6, 'Desain Komunikasi Visual'),
(7, 'Teknik Otomotif'),
(8, 'Akuntansi dan Keuangan Lembaga'),
(9, 'Teknik Pemesinan'),
(10, 'Kuliner'),
(14, 'Teknik Komputer Jaringan'),
(15, 'Rekayasa Perangkat Lunak');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama`) VALUES
(2, 'X'),
(3, 'XI'),
(4, 'XII'),
(6, 'XIII');

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_rekening` varchar(20) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_pembuatan` date NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`id`, `nama`, `no_rekening`, `jenis_kelamin`, `tanggal_pembuatan`, `saldo`, `status`, `kelas_id`, `jurusan_id`, `nisn`, `password`) VALUES
(25, 'Ahmad Zulkarnain', 'REK0001', 'L', '2023-01-15', 21000.00, 'active', 2, 3, '1234567890', '$2y$10$aFxdJ4PiWkOWLj8.7GxeA.xq3Q5DhlOKP3B6t3va1NEIYGO8iHFzi'),
(26, 'Siti Nurhaliza', 'REK0002', 'P', '2023-02-20', 102500.00, 'inactive', 3, 4, '0987654321', '$2y$10$giDNHOpW47kte77HDjaoM.5K7xP4hKkne8gA5t8PbhLqYnh7JNeLq'),
(27, 'Budi Santoso', 'REK0003', 'L', '2023-03-10', 243000.00, 'active', 4, 5, '1234567892', '$2y$10$kOWBkelt0oA39Jh6Zr4YvuYK0MFiBXk9TPL3PHDL4CEO8weNMW5zq'),
(28, 'Dewi Lestari', 'REK0004', 'P', '2023-04-05', 2500.00, 'active', 6, 6, '1234567895', '$2y$10$ND7HB85x9WXK5oCLW/7Xjegp0xxm2DyAD6B7P3sMMahkHCI71kKsi'),
(29, 'Rudi Hartono', 'REK0005', 'L', '2023-05-25', 1800.00, 'inactive', 2, 7, '0987654329', NULL),
(30, 'Yulia Rahmawati', 'REK0006', 'P', '2023-06-30', 5200.00, 'active', 3, 8, '3000000001', '12345'),
(31, 'Joko Widodo', 'REK0007', 'L', '2023-07-10', 1600.00, 'inactive', 4, 9, '3000000002', '12345'),
(32, 'Maya Sari', 'REK0008', 'P', '2023-08-15', 2900.00, 'active', 6, 10, '3000000003', '12345'),
(33, 'Andi Setiawan', 'REK0009', 'L', '2023-09-20', 2100.00, 'active', 2, 14, '3000000004', '12345'),
(34, 'Rina Maulani', 'REK0010', 'P', '2023-10-05', 2500.00, 'inactive', 3, 15, '3000000005', '12345'),
(35, 'Eko Prasetyo', 'REK0011', 'L', '2023-11-15', 2700.00, 'active', 4, 3, '3000000006', '12345'),
(36, 'Nina Agustina', 'REK0012', 'P', '2023-12-25', 2400.00, 'inactive', 6, 4, '3000000007', '12345'),
(37, 'Fikri Alamsyah', 'REK0013', 'L', '2024-01-10', 2800.00, 'active', 2, 5, '3000000008', '12345'),
(38, 'Lina Sari', 'REK0014', 'P', '2024-02-20', 2200.00, 'active', 3, 6, '3000000009', '12345'),
(39, 'Asep Hidayat', 'REK0015', 'L', '2024-03-15', 102500.00, 'inactive', 4, 7, '3000000010', '12345'),
(40, 'Tari Maulida', 'REK0016', 'P', '2024-04-05', 2600.00, 'active', 6, 8, '3000000011', '12345'),
(41, 'Iwan Kurniawan', 'REK0017', 'L', '2024-05-25', 3000.00, 'active', 2, 9, '3000000012', '12345'),
(42, 'Wina Kusuma', 'REK0018', 'P', '2024-06-30', 2300.00, 'inactive', 3, 10, '3000000013', '12345'),
(43, 'Rizal Mulyadi', 'REK0019', 'L', '2024-07-10', 2100.00, 'active', 4, 14, '3000000014', '12345'),
(44, 'Tina Amelia', 'REK0020', 'P', '2024-08-15', 2400.00, 'inactive', 6, 15, '3000000015', '12345'),
(45, 'Beni Prabowo', 'REK0021', 'L', '2024-09-20', 2500.00, 'active', 2, 3, '3000000016', '12345'),
(46, 'Reni Lestari', 'REK0022', 'P', '2024-10-05', 2700.00, 'inactive', 3, 4, '3000000017', '12345'),
(47, 'Deni Setiawan', 'REK0023', 'L', '2024-11-15', 2000.00, 'active', 4, 5, '3000000018', '12345'),
(48, 'Mira Wulandari', 'REK0024', 'P', '2024-12-25', 2300.00, 'inactive', 6, 6, '3000000019', '12345'),
(49, 'Hadi Wijaya', 'REK0025', 'L', '2025-01-10', 2900.00, 'active', 2, 7, '3000000020', '12345'),
(50, 'Rina Hapsari', 'REK0026', 'P', '2025-02-20', 2200.00, 'inactive', 3, 8, '3000000021', '12345'),
(51, 'Arief Rahman', 'REK0027', 'L', '2025-03-15', 2400.00, 'active', 4, 9, '3000000022', '12345'),
(52, 'Dina Permata', 'REK0028', 'P', '2025-04-05', 2700.00, 'inactive', 6, 10, '3000000023', '12345'),
(53, 'Junaedi Putra', 'REK0029', 'L', '2025-05-25', 2600.00, 'active', 2, 14, '3000000024', '12345'),
(54, 'Nia Amalia', 'REK0030', 'P', '2025-06-30', 2500.00, 'inactive', 3, 15, '3000000025', '12345'),
(55, 'Bobby Santoso', 'REK0031', 'L', '2025-07-10', 2000.00, 'active', 4, 3, '3000000026', '12345'),
(56, 'Lusiwati', 'REK0032', 'P', '2025-08-15', 2200.00, 'inactive', 6, 4, '3000000027', '12345'),
(57, 'Agus Salim', 'REK0033', 'L', '2025-09-20', 2800.00, 'active', 2, 5, '3000000028', '12345'),
(58, 'Riska Nabila', 'REK0034', 'P', '2025-10-05', 2300.00, 'inactive', 3, 6, '3000000029', '12345'),
(59, 'Taufik Hidayat', 'REK0035', 'L', '2025-11-15', 2500.00, 'active', 4, 7, '3000000030', '12345'),
(60, 'Cindy Fadila', 'REK0036', 'P', '2025-12-25', 2700.00, 'inactive', 6, 8, '3000000031', '12345'),
(61, 'Rizky Pratama', 'REK0037', 'L', '2026-01-10', 2200.00, 'active', 2, 9, '3000000032', '12345'),
(62, 'Sari Wulandari', 'REK0038', 'P', '2026-02-20', 2900.00, 'inactive', 3, 10, '3000000033', '12345'),
(63, 'Dani Setiawan', 'REK0039', 'L', '2026-03-15', 2500.00, 'active', 4, 14, '3000000034', '12345'),
(64, 'Ayu Lestari', 'REK0040', 'P', '2026-04-05', 2700.00, 'inactive', 6, 15, '3000000035', '12345'),
(65, 'Fahrul Razi', 'REK0041', 'L', '2026-05-25', 2000.00, 'active', 2, 3, '3000000036', '12345'),
(66, 'Nia Sari', 'REK0042', 'P', '2026-06-30', 2300.00, 'inactive', 3, 4, '3000000037', '12345'),
(67, 'Dewi Puspita', 'REK0043', 'P', '2026-07-10', 2500.00, 'active', 4, 5, '3000000038', '12345'),
(68, 'Ricky Andi', 'REK0044', 'L', '2026-08-15', 2900.00, 'inactive', 6, 6, '3000000039', '12345'),
(69, 'Indah Purnama', 'REK0045', 'P', '2026-09-20', 2400.00, 'active', 2, 7, '3000000040', '12345'),
(70, 'Reza Gunawan', 'REK0046', 'L', '2026-10-05', 2200.00, 'inactive', 3, 8, '3000000041', '12345'),
(71, 'Lia Amalia', 'REK0047', 'P', '2026-11-15', 2700.00, 'active', 4, 9, '3000000042', '12345'),
(72, 'Agung Rahmat', 'REK0048', 'L', '2026-12-25', 2000.00, 'inactive', 6, 10, '3000000043', '12345'),
(73, 'Dini Nurlita', 'REK0049', 'P', '2027-01-10', 2800.00, 'active', 2, 14, '3000000044', '12345'),
(74, 'Hendra Wirawan', 'REK0050', 'L', '2027-02-20', 2500.00, 'inactive', 3, 15, '3000000045', '12345'),
(75, 'Siti Nur', 'REK0051', 'P', '2027-03-15', 2200.00, 'active', 4, 3, '3000000046', '12345'),
(492, 'Faisal Hadi', 'REK0052', 'L', '2027-04-01', 2600.00, 'active', 2, 8, '4000000001', '12345'),
(493, 'Marlina Setiawati', 'REK0053', 'P', '2027-05-15', 2300.00, 'inactive', 3, 9, '4000000002', '12345'),
(494, 'Nadia Kurnia', 'REK0054', 'P', '2027-06-10', 2500.00, 'active', 4, 10, '4000000003', '12345'),
(495, 'Seno Prasetyo', 'REK0055', 'L', '2027-07-25', 2700.00, 'inactive', 6, 14, '4000000004', '12345'),
(496, 'Hilda Putri', 'REK0056', 'P', '2027-08-30', 2200.00, 'active', 2, 15, '4000000005', '12345'),
(497, 'Rizki Fadila', 'REK0057', 'L', '2027-09-15', 2800.00, 'inactive', 3, 3, '4000000006', '12345'),
(498, 'Kiki Wijaya', 'REK0058', 'P', '2027-10-20', 2400.00, 'active', 4, 4, '4000000007', '12345'),
(499, 'Eka Rudi', 'REK0059', 'L', '2027-11-10', 2300.00, 'inactive', 6, 5, '4000000008', '12345'),
(500, 'Dina Aulia', 'REK0060', 'P', '2027-12-15', 2600.00, 'active', 2, 6, '4000000009', '12345'),
(501, 'Fajar Adi', 'REK0061', 'L', '2028-01-20', 2500.00, 'inactive', 3, 7, '4000000010', '12345'),
(502, 'Gita Sari', 'REK0062', 'P', '2028-02-14', 2900.00, 'active', 4, 8, '4000000011', '12345'),
(503, 'Rudi Prasetya', 'REK0063', 'L', '2028-03-22', 3100.00, 'inactive', 2, 9, '4000000012', '12345'),
(504, 'Sari Dewi', 'REK0064', 'P', '2028-04-18', 2700.00, 'active', 3, 10, '4000000013', '12345'),
(505, 'Arief Ramadhan', 'REK0065', 'L', '2028-05-25', 2500.00, 'inactive', 4, 14, '4000000014', '12345'),
(506, 'Lina Wati', 'REK0066', 'P', '2028-06-30', 3000.00, 'active', 2, 15, '4000000015', '12345'),
(507, 'Budi Setiawan', 'REK0067', 'L', '2028-07-15', 2800.00, 'inactive', 3, 3, '4000000016', '12345'),
(508, 'Maya Kurniawati', 'REK0068', 'P', '2028-08-20', 3200.00, 'active', 4, 4, '4000000017', '12345'),
(509, 'Joko Santoso', 'REK0069', 'L', '2028-09-10', 2900.00, 'inactive', 6, 5, '4000000018', '12345'),
(510, 'Nina Pratiwi', 'REK0070', 'P', '2028-10-15', 3100.00, 'active', 2, 6, '4000000019', '12345'),
(511, 'Eko Wibowo', 'REK0071', 'L', '2028-11-20', 2700.00, 'inactive', 3, 7, '4000000020', '12345'),
(512, 'Ayu Lestari', 'REK0072', 'P', '2028-12-01', 2600.00, 'active', 2, 8, '4000000021', '12345'),
(513, 'Bambang Hartono', 'REK0073', 'L', '2029-01-15', 2800.00, 'inactive', 3, 9, '4000000022', '12345'),
(514, 'Citra Dewi', 'REK0074', 'P', '2029-02-10', 2900.00, 'active', 4, 10, '4000000023', '12345'),
(515, 'Dewi Sartika', 'REK0075', 'P', '2029-03-25', 2700.00, 'inactive', 6, 14, '4000000024', '12345'),
(516, 'Erik Wijaya', 'REK0076', 'L', '2029-04-30', 3000.00, 'active', 2, 15, '4000000025', '12345'),
(517, 'Fani Rahayu', 'REK0077', 'P', '2029-05-15', 2500.00, 'inactive', 3, 3, '4000000026', '12345'),
(518, 'Gino Saputra', 'REK0078', 'L', '2029-06-20', 3200.00, 'active', 4, 4, '4000000027', '12345'),
(519, 'Hani Setiawati', 'REK0079', 'P', '2029-07-10', 2900.00, 'inactive', 6, 5, '4000000028', '12345'),
(520, 'Ilham Maulana', 'REK0080', 'L', '2029-08-15', 3100.00, 'active', 2, 6, '4000000029', '12345'),
(521, 'Jamilah Aminah', 'REK0081', 'P', '2029-09-20', 2700.00, 'inactive', 3, 7, '4000000030', '12345'),
(522, 'Khalid Alamsyah', 'REK0082', 'L', '2029-10-05', 3000.00, 'active', 4, 8, '4000000031', '12345'),
(523, 'Larasati Putri', 'REK0083', 'P', '2029-11-25', 2800.00, 'inactive', 2, 9, '4000000032', '12345'),
(524, 'Mia Pramudita', 'REK0084', 'P', '2029-12-10', 2500.00, 'active', 3, 10, '4000000033', '12345'),
(525, 'Nino Santosa', 'REK0085', 'L', '2030-01-20', 2900.00, 'inactive', 4, 14, '4000000034', '12345'),
(526, 'Oka Wijaya', 'REK0086', 'L', '2030-02-15', 3200.00, 'active', 2, 15, '4000000035', '12345'),
(527, 'Putri Ayu', 'REK0087', 'P', '2030-03-10', 2700.00, 'inactive', 3, 3, '4000000036', '12345'),
(528, 'Ria Nurul', 'REK0088', 'P', '2030-04-25', 3000.00, 'active', 4, 4, '4000000037', '12345'),
(529, 'Satria Hadi', 'REK0089', 'L', '2030-05-15', 2800.00, 'inactive', 6, 5, '4000000038', '12345'),
(530, 'Tari Purnama', 'REK0090', 'P', '2030-06-20', 3100.00, 'active', 2, 6, '4000000039', '12345'),
(531, 'Umar Fadli', 'REK0091', 'L', '2030-07-15', 2700.00, 'inactive', 3, 7, '4000000040', '12345'),
(532, 'Vera Setyaningsih', 'REK0092', 'P', '2030-08-25', 2900.00, 'active', 4, 8, '4000000041', '12345'),
(533, 'Wahyu Pratama', 'REK0093', 'L', '2030-09-10', 3200.00, 'inactive', 2, 9, '4000000042', '12345'),
(534, 'Xena Rahmawati', 'REK0094', 'P', '2030-10-05', 2500.00, 'active', 3, 10, '4000000043', '12345'),
(535, 'Yudi Santoso', 'REK0095', 'L', '2030-11-20', 2900.00, 'inactive', 4, 14, '4000000044', '12345'),
(536, 'Zahra Putri', 'REK0096', 'P', '2030-12-15', 2700.00, 'active', 2, 15, '4000000045', '12345'),
(537, 'Asep Hidayat', 'REK0097', 'L', '2031-01-10', 3000.00, 'inactive', 3, 3, '4000000046', '12345'),
(538, 'Bunga Setia', 'REK0098', 'P', '2031-02-20', 2800.00, 'active', 4, 4, '4000000047', '12345'),
(539, 'Cesar Firmansyah', 'REK0099', 'L', '2031-03-15', 3100.00, 'inactive', 6, 5, '4000000048', '12345'),
(540, 'Dina Handayani', 'REK0100', 'P', '2031-04-30', 2700.00, 'active', 2, 6, '4000000049', '12345'),
(541, 'Arga Pratama', '1223309', 'L', '2024-08-26', 12700000.00, 'active', 4, 15, '0078099', '1234'),
(542, 'Haidar Daffa', '124090909', 'L', '2024-08-26', 10000000.00, 'active', 4, 15, '0098789', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_rekening` varchar(20) NOT NULL,
  `tipe` enum('setor','tarik') NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `nama`, `no_rekening`, `tipe`, `jumlah`, `tanggal`) VALUES
(2, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-07 03:07:56'),
(4, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:06:18'),
(5, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 500.00, '2024-08-11 09:08:51'),
(6, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 500.00, '2024-08-11 09:11:08'),
(7, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:14:15'),
(8, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:16:08'),
(9, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:16:58'),
(10, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:19:35'),
(11, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 500.00, '2024-08-11 09:20:58'),
(12, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:33:42'),
(13, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:34:19'),
(14, 'Ahmad Zulkarnain', 'REK0001', 'setor', 500.00, '2024-08-11 09:41:12'),
(15, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 1000.00, '2024-08-11 09:41:56'),
(16, 'Yulia Rahmawati', 'REK0006', 'setor', 1000.00, '2024-08-11 13:49:45'),
(17, 'Yulia Rahmawati', 'REK0006', 'setor', 2000.00, '2024-08-11 13:56:38'),
(18, 'Asep Hidayat', 'REK0015', 'setor', 100000.00, '2024-08-11 13:58:10'),
(19, 'Siti Nurhaliza', 'REK0002', 'setor', 100000.00, '2024-08-11 13:58:29'),
(20, 'Ahmad Zulkarnain', 'REK0001', 'setor', 50000.00, '2024-08-11 15:07:44'),
(21, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 60000.00, '2024-08-11 15:07:59'),
(22, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 60000.00, '2024-08-11 15:09:29'),
(23, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 60000.00, '2024-08-11 15:09:40'),
(24, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 600000.00, '2024-08-11 15:12:40'),
(25, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 53500.00, '2024-08-11 15:13:15'),
(26, 'Ahmad Zulkarnain', 'REK0001', 'setor', 1000000.00, '2024-08-11 15:19:47'),
(27, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 10000.00, '2024-08-11 15:20:01'),
(28, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 2000000.00, '2024-08-11 15:20:13'),
(29, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 1000000.00, '2024-08-11 15:20:30'),
(30, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 1000000.00, '2024-08-11 15:24:26'),
(31, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 900000.00, '2024-08-11 15:24:42'),
(32, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 900000.00, '2024-08-11 15:24:55'),
(33, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 900000.00, '2024-08-11 15:25:07'),
(34, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 90000.00, '2024-08-11 15:25:21'),
(35, 'Ahmad Zulkarnain', 'REK0001', 'setor', 1000000.00, '2024-08-11 15:25:50'),
(36, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 10000.00, '2024-08-11 15:26:01'),
(37, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 50000.00, '2024-08-11 15:26:29'),
(38, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 10000.00, '2024-08-11 15:28:32'),
(39, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 960000.00, '2024-08-11 15:28:45'),
(40, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 950000.00, '2024-08-11 15:29:09'),
(41, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 10000.00, '2024-08-11 15:29:28'),
(42, 'Ahmad Zulkarnain', 'REK0001', 'setor', 10000.00, '2024-08-13 13:40:25'),
(43, 'Ahmad Zulkarnain', 'REK0001', 'setor', 1000.00, '2024-08-13 13:40:41'),
(44, 'Ahmad Zulkarnain', 'REK0001', 'tarik', 21000.00, '2024-08-13 13:41:00'),
(45, 'Budi Santoso', 'REK0003', 'setor', 1000000.00, '2024-08-14 04:49:04'),
(46, 'Budi Santoso', 'REK0003', 'tarik', 3000.00, '2024-08-14 04:49:13'),
(47, 'Budi Santoso', 'REK0003', 'tarik', 300000.00, '2024-08-14 04:49:23'),
(48, 'Budi Santoso', 'REK0003', 'setor', 100000.00, '2024-08-26 01:47:58'),
(49, 'Budi Santoso', 'REK0003', 'tarik', 560000.00, '2024-08-26 01:48:14'),
(50, 'Arga Pratama', '1223309', 'setor', 10000000.00, '2024-08-26 01:52:33'),
(51, 'Arga Pratama', '1223309', 'tarik', 20000.00, '2024-08-26 01:52:44'),
(52, 'Arga Pratama', '1223309', 'setor', 2000000.00, '2024-08-26 01:52:54'),
(53, 'Arga Pratama', '1223309', 'tarik', 300000.00, '2024-08-26 01:53:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_rekening` (`no_rekening`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `fk_kelas` (`kelas_id`),
  ADD KEY `fk_jurusan` (`jurusan_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_rekening` (`no_rekening`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=544;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `fk_jurusan` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`),
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`no_rekening`) REFERENCES `nasabah` (`no_rekening`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

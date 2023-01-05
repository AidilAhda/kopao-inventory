-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2023 at 05:17 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kopao`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `satuan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `kategori_id`, `satuan`) VALUES
('B000001', 'Mie Bihun', 5, 'kilogram'),
('B000002', 'Alpukat', 11, 'Kilogram'),
('B000003', 'Sendok', 3, 'Lusin'),
('B000004', 'Gelas', 3, 'Pack');

-- --------------------------------------------------------

--
-- Table structure for table `barangcabang`
--

CREATE TABLE `barangcabang` (
  `id` int(11) NOT NULL,
  `barang_id` varchar(7) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama_cabang` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `satuan` varchar(128) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangcabang`
--

INSERT INTO `barangcabang` (`id`, `barang_id`, `kategori_id`, `nama_cabang`, `total`, `satuan`, `id_user`) VALUES
(1, 'B000002', 11, 'CABANG PAUS', 1, 'Kilogram', 7),
(21, 'B000004', 3, 'CABANG ARIFIN', 1, 'Pack', 14),
(31, 'B000003', 3, 'CABANG PAUS', 1, 'Lusin', 7),
(32, 'B000002', 11, 'CABANG ARIFIN', 0, 'Kilogram', 14),
(33, 'B000003', 3, 'CABANG ARIFIN', 0, 'Lusin', 14),
(34, 'B000002', 11, 'CABANG PANAM', 1, 'Kilogram', 25),
(35, 'B000003', 3, 'CABANG PANAM', 0, 'Lusin', 25),
(37, 'B000004', 3, 'CABANG PAUS', 10, 'Lusin', 7),
(39, 'B000004', 3, 'CABANG PANAM', 0, 'Lusin', 25);

-- --------------------------------------------------------

--
-- Table structure for table `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `id_barang_keluar` varchar(16) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `barang_id` varchar(7) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `nama_cabang` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangkeluar`
--

INSERT INTO `barangkeluar` (`id_barang_keluar`, `kategori_id`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`, `nama_cabang`, `satuan`, `id_user`, `keterangan`) VALUES
('BK2212130001', 11, 'B000002', 2, '2022-12-13', 'CABANG PAUS', 'Kilogram', 7, ''),
('BK2212170002', 3, 'B000003', 12, '2022-12-17', 'CABANG ARIFIN', 'Pcs', 0, ''),
('BK2212170003', 3, 'B000003', 2, '2022-12-17', 'CABANG ARIFIN', 'Unit', 14, ''),
('BK2212170004', 3, 'B000004', 1, '2022-12-17', 'CABANG ARIFIN', 'Pack', 14, ''),
('BK2212170005', 11, 'B000002', 1, '2022-12-17', 'CABANG PANAM', 'Kilogram', 25, ''),
('BK2212200006', 11, 'B000002', 1, '2022-12-20', 'CABANG PAUS', 'Kilogram', 7, ''),
('BK2212220007', 11, 'B000002', 1, '2022-11-23', 'CABANG PAUS', 'Kilogram', 7, ''),
('BK2212300008', 3, 'B000003', 1, '2022-12-30', 'CABANG PAUS', 'Lusin', 7, ''),
('BK2301010009', 3, 'B000004', 4, '2023-01-01', 'CABANG PAUS', 'Lusin', 7, ''),
('BK2301030010', 3, 'B000004', 2, '2023-01-03', 'CABANG PAUS', 'Lusin', 7, '');

--
-- Triggers `barangkeluar`
--
DELIMITER $$
CREATE TRIGGER `updateStokCabang` BEFORE INSERT ON `barangkeluar` FOR EACH ROW UPDATE `barangcabang` SET `barangcabang`.`total` = `barangcabang`.`total` - NEW.jumlah_keluar WHERE `barangcabang`.`barang_id` = NEW.barang_id AND `barangcabang`.`nama_cabang`= NEW.`nama_cabang`
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `id_barang_masuk` varchar(16) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `barang_id` varchar(7) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `nama_cabang` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangmasuk`
--

INSERT INTO `barangmasuk` (`id_barang_masuk`, `kategori_id`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`, `nama_cabang`, `satuan`, `keterangan`, `id_user`) VALUES
('BM2212120001', 1, 'B000002', 12, '2022-12-12', 'CABANG PAUS', 'Kiologram', '', 7),
('BM2212170002', 3, 'B000003', 13, '2022-12-17', 'CABANG ARIFIN', 'Pack', '', 14),
('BM2212170003', 3, 'B000003', 13, '2022-12-17', 'CABANG ARIFIN', 'Unit', '', 14),
('BM2212170004', 11, 'B000002', 2, '2022-12-17', 'CABANG PAUS', 'Kilogram', '', 7),
('BM2212170005', 3, 'B000004', 2, '2022-12-17', 'CABANG ARIFIN', 'Pack', '', 14),
('BM2212170006', 11, 'B000002', 2, '2022-12-17', 'CABANG PANAM', 'Kilogram', '1 kg ada yang busuk\n', 25),
('BM2212180007', 11, 'B000002', 2, '2022-12-18', 'CABANG PAUS', 'Kilogram', '', 7),
('BM2212220008', 11, 'B000002', 1, '2022-11-23', 'CABANG PAUS', 'Kilogram', '', 7),
('BM2212250009', 3, 'B000003', 2, '2022-12-25', 'CABANG PAUS', 'Lusin', '', 7),
('BM2212300010', 3, 'B000004', 1, '2022-12-30', 'CABANG PAUS', 'Lusin', '', 7),
('BM2301010011', 3, 'B000004', 13, '2023-01-01', 'CABANG PAUS', 'Lusin', '', 7),
('BM2301030012', 3, 'B000004', 2, '2023-01-03', 'CABANG PAUS', 'Lusin', '', 7);

--
-- Triggers `barangmasuk`
--
DELIMITER $$
CREATE TRIGGER `updateStok` BEFORE INSERT ON `barangmasuk` FOR EACH ROW UPDATE `barangcabang` SET `barangcabang`.`total` = `barangcabang`.`total` + NEW.jumlah_masuk WHERE `barangcabang`.`barang_id` = NEW.barang_id AND `barangcabang`.`nama_cabang`= NEW.`nama_cabang`
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id_cabang` int(11) NOT NULL,
  `nama_cabang` varchar(50) NOT NULL,
  `alamat_cabang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id_cabang`, `nama_cabang`, `alamat_cabang`) VALUES
(1, 'CABANG PAUS', 'Jl. Paus No 22, Wonorejo,Kec.Marpoyan Damai,kota Pekanbaru,Riau 28124'),
(2, 'CABANG ARIFIN', 'Jl. Arifin Ahmad No.8a, Sidomulyo Tim., Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28289'),
(3, 'CABANG PANAM', 'Depan New Planet Swalayan Garuda Sakti, Jl. Garuda Sakti Ruko No.KM, Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan Ringan'),
(2, 'Minuman'),
(3, 'Alat-Alat'),
(11, 'Buah'),
(12, 'Makanan'),
(14, 'Sayuran'),
(17, 'Dekorasi');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` varchar(12) NOT NULL,
  `satuan` varchar(128) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `nama_cabang` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `barang_id` varchar(7) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `satuan`, `kategori_id`, `jumlah_barang`, `tanggal_pesanan`, `nama_cabang`, `status`, `barang_id`, `id_user`) VALUES
('PC2212100001', 'Kilogram', 5, 12, '2022-12-12', 'Alpukat', 'Pending', 'B000002', 7),
('PC2212120002', 'Unit', 3, 13, '2022-12-12', 'CABANG PAUS', 'Ditolak', 'B000003', 7),
('PC2212120003', 'Unit', 1, 2, '2022-12-12', 'CABANG PAUS', 'Ditolak', 'B000003', 7),
('PC2212120004', 'Kilogram', 11, 13, '2022-12-12', 'CABANG PAUS', 'Ditolak', 'B000002', 7),
('PC2212120005', 'Unit', 3, 13, '2022-12-12', 'CABANG PAUS', 'Ditolak', 'B000003', 7),
('PC2212130006', 'Kilogram', 11, 12, '2022-12-13', 'CABANG PAUS', 'Disetujui', 'B000002', 7),
('PC2212130007', 'Unit', 11, 14, '2022-12-13', 'CABANG ARIFIN', 'Disetujui', 'B000002', 14),
('PC2212160008', 'Kilogram', 11, 14, '2022-12-16', 'CABANG ARIFIN', 'Disetujui', 'B000002', 14),
('PC2212170009', 'Lusin', 3, 2, '2022-12-17', 'CABANG PAUS', 'Disetujui', 'B000003', 7),
('PC2212170010', 'Kilogram', 11, 2, '2022-12-17', 'CABANG ARIFIN', 'Ditolak', 'B000002', 14),
('PC2212170011', 'Pack', 3, 2, '2022-12-17', 'CABANG ARIFIN', 'Disetujui', 'B000004', 14),
('PC2212170012', 'Kilogram', 11, 5, '2022-12-17', 'CABANG PANAM', 'Ditolak', 'B000002', 25),
('PC2212300013', 'Lusin', 3, 2, '2022-12-01', 'CABANG ARIFIN', 'Ditolak', 'B000004', 14),
('PC2212300014', 'Lusin', 3, 3, '2022-12-30', 'CABANG ARIFIN', 'Disetujui', 'B000004', 14),
('PC2212300015', 'Lusin', 3, 4, '2022-12-30', 'CABANG ARIFIN', 'Disetujui', 'B000003', 14),
('PC2301010016', 'Lusin', 3, 13, '2023-01-01', 'CABANG PAUS', 'Disetujui', 'B000004', 7),
('PC2301030017', 'Lusin', 3, 22, '2023-01-03', 'CABANG PAUS', 'Pending', 'B000004', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `no_telp` int(15) NOT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `no_telp`, `role_id`, `password`, `created_at`, `is_active`) VALUES
(6, 'ADMINISTRATOR', 'AdminPusat', 892614352, 1, '$2y$10$.ntpiOqaZ6fHlw3r9JIC0uF77yB38YO2Br5PBQUZJw.6BTNsQ.5pS', 1669470122, 1),
(7, 'CABANG PAUS', 'CabangPaus', 2147483647, 2, '$2y$10$2N33wL79onPf4DRjEXOi2eRSlp3K6/SfAj.UFvVPXzptaYN4e/246', 1669470245, 1),
(8, 'HASAN', 'owner', 2147483647, 3, '$2y$10$TZTK2XJEfiROhEsLg3WjcuAncVkUnYpuV7aJkKnfcAaT9yxX.vGYW', 1669552542, 1),
(14, 'CABANG ARIFIN', 'CabangArifin', 899122234, 2, '$2y$10$odUtqDvCcRC12zJBFX9Zw.3tBeV/U2pyQUHBFZuEDndlRzwr2QNCG', 1670826123, 1),
(25, 'CABANG PANAM', 'CabangPanam', 899122234, 2, '$2y$10$ZeUFFDB.R9.93uLgZW/AcONrJOWzD5L6nYC2Kxb6OEkvj83qeBzOG', 1671281109, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barangcabang`
--
ALTER TABLE `barangcabang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`,`kategori_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indexes for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id_cabang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangcabang`
--
ALTER TABLE `barangcabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

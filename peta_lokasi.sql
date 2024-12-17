-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2024 at 07:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peta_lokasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`) VALUES
(5, 'nicolas', 'niko', 'niko123');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lokasi`
--

CREATE TABLE `tbl_lokasi` (
  `id_lokasi` int(5) NOT NULL,
  `namalokasi` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `lat` varchar(10) NOT NULL,
  `lng` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_lokasi`
--

INSERT INTO `tbl_lokasi` (`id_lokasi`, `namalokasi`, `alamat`, `lat`, `lng`) VALUES
(3, 'SPBU COCO Pertamina 41.552.01 Laksda Adisucipto', 'Jl. Laksda Adisucipto Km. 6, Caturtunggal, Kec. Sleman, Caturtunggal, Kecamatan Depok, Ngentak, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55282', '-7.7830495', '110.408039'),
(2, 'Budi Jaya Press Body Motor', 'Jl. Raya Janti No.5b, Gowok, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281', '-7.7839992', '110.410635'),
(4, 'SPBU KASAM Babarsari', '6CG6+C44, Jl. Babarsari, Kledokan, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281', '-7.7764728', '110.415323'),
(6, 'BENGKEL MOBIL RRYS', 'Jl. Pura Jl. Sorowajan, Jomblangan, Banguntapan, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55198', '-7.7930126', '110.401422'),
(7, 'SPBU COCO 41.551.01', '695J+R37, Jl. Lempuyangan Jl. Kompol Bambang Suprapto, Baciro, Kec. Gondokusuman, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55225', '-7.786509', '110.373522');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_lokasi`
--
ALTER TABLE `tbl_lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_lokasi`
--
ALTER TABLE `tbl_lokasi`
  MODIFY `id_lokasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

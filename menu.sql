-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 05:48 PM
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
-- Database: `liucha`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `MenuID` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`MenuID`, `name`, `price`, `image`) VALUES
('M01', 'ชานมไต้หวัน', 19, 'taiwanmilktea.png'),
('M02', 'ชาเขียว', 19, 'matcha.png'),
('M03', 'ชาไทย', 19, 'thaitea.png'),
('M04', 'ชานมไวท์มอลต์', 24, 'whitemaltmilktea.png'),
('M05', 'ชานมคาราเมล', 24, 'caramelmilktea.png'),
('M06', 'ชานมเมล่อน', 19, 'melonmilktea.png'),
('M07', 'ชานมโอวัลติน', 19, 'ovaltinemilktea.png'),
('M08', 'ชานมน้ำผึ้ง', 24, 'honeymilktea.png'),
('M09', 'ชานมชมพู', 19, 'pinkmilktea.png'),
('M10', 'ชานมบราวน์ชูการ์', 24, 'brownshugarmilktea.png'),
('M11', 'ชานมโกโก้', 24, 'cocaomilktea.png'),
('M12', 'ชานมแอปเปิ้ล', 19, 'applemilktea.png'),
('M13', 'ชานมสตอเบอร์รี่', 19, 'strawmilktea.png'),
('M14', 'ชานมมันม่วง', 19, 'purplemilktea.png'),
('M15', 'ชานมอัญชัน', 24, 'milkteabutterfly.png'),
('M16', 'ชาไทยอัญชัน', 29, 'thaiteabutterfly.png'),
('M17', 'ชานมกาแฟ', 24, 'coffeemilktea.png'),
('M18', 'ชาเขียวมะลิ', 19, 'jasminegreentea.png'),
('M19', 'ชานมสด', 49, 'frershmilktea.png'),
('M20', 'นมโอวัลติน', 49, 'milkovaltine.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MenuID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

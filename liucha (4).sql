-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 12:58 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` varchar(5) NOT NULL,
  `name` varchar(40) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `name`, `Password`, `Email`) VALUES
('A01', 'AdminTony', 'Tony12', 'Tony@gmail.com'),
('A02', 'AdminEarn', 'Earn12', 'Earn@gmail.com'),
('A03', 'AdminFah', 'Fah12', 'Fah@gmail.com'),
('A04', 'AdminPoy', 'Poy12', 'Poy@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` varchar(5) NOT NULL,
  `AdminID` varchar(5) DEFAULT NULL,
  `Name` varchar(40) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `AdminID`, `Name`, `Password`, `Phone`, `Email`) VALUES
('C001', NULL, 'Mu', 'Mu12', '0911111111', 'Mu@gmaill.com'),
('C002', NULL, 'nan', 'nan12', '0952952241', 'nan@gmail.com'),
('C003', NULL, 'nu', 'nu12', '0952952241', 'nu@gmail.com');

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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ordersID` varchar(5) NOT NULL,
  `CustomerID` varchar(5) NOT NULL,
  `ordersname` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment_method` enum('QR Promptpay','เงินสด') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `slip_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ordersID`, `CustomerID`, `ordersname`, `tel`, `address`, `payment_method`, `total_price`, `order_date`, `slip_image`) VALUES
('1', 'C003', 'nu', '0969999999', '11/1 ปราจีน ห้อง', 'เงินสด', 54.00, '2025-03-09 11:57:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `topping`
--

CREATE TABLE `topping` (
  `ToppingID` varchar(5) NOT NULL,
  `MenuID` varchar(5) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Price` varchar(100) NOT NULL,
  `imageTopping` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topping`
--

INSERT INTO `topping` (`ToppingID`, `MenuID`, `Name`, `Price`, `imageTopping`) VALUES
('T01', '', 'Bubble', '5', 'bubble.png'),
('T02', '', 'Black Grass Jelly', '5', 'backjelly.png'),
('T03', '', 'Fruity Jelly', '5', 'fruit.png'),
('T04', '', 'Konjac', '5', 'konjac.png'),
('T05', '', 'Brown Sugar Jelly', '5', 'bown.png'),
('T06', '', 'Egg Pudding', '5', 'puddingegg.png'),
('T07', '', 'Chocolate Pudding', '5', 'puddingchoc.png'),
('T08', '', 'Daimond Konjac Jelly', '10', 'daimon.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `CustomerID` (`CustomerID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `AdminID_2` (`AdminID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MenuID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ordersID`),
  ADD KEY `fk_customer` (`CustomerID`);

--
-- Indexes for table `topping`
--
ALTER TABLE `topping`
  ADD PRIMARY KEY (`ToppingID`),
  ADD KEY `MenuID` (`MenuID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2024 at 11:00 AM
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
-- Database: `isp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` bigint DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phone`, `password`) VALUES
('ad24091223064600011', 'Abdullah Md Jahid Hassan', 'abdullahmdjahidhassan@gmail.com', 1756254873, 'p');

--
-- Triggers `admin`
--
DELIMITER $$
CREATE TRIGGER `before_insert_admin` BEFORE INSERT ON `admin` FOR EACH ROW BEGIN
    SET NEW.id = CONCAT(
        'ad', 
        DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), 
        LPAD(MICROSECOND(NOW()) DIV 1000, 2, '0'),
        SUBSTRING(MD5(RAND()), 1, 3)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `customer_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `plan_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `state` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `connections`
--
DELIMITER $$
CREATE TRIGGER `before_insert_connections` BEFORE INSERT ON `connections` FOR EACH ROW BEGIN
    SET NEW.id = CONCAT(
        'co', 
        DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), 
        LPAD(MICROSECOND(NOW()) DIV 1000, 2, '0'),
        SUBSTRING(MD5(RAND()), 1, 3)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` bigint DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `customer`
--
DELIMITER $$
CREATE TRIGGER `before_insert_customer` BEFORE INSERT ON `customer` FOR EACH ROW BEGIN
    SET NEW.id = CONCAT(
        'cu', 
        DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), 
        LPAD(MICROSECOND(NOW()) DIV 1000, 2, '0'),
        SUBSTRING(MD5(RAND()), 1, 3)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `post` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` bigint DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gender` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `salary` int DEFAULT NULL,
  `nid` bigint DEFAULT NULL,
  `nid_file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `certificate_file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `resume_file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `photo_file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `post`, `phone`, `email`, `password`, `address`, `gender`, `salary`, `nid`, `nid_file`, `certificate_file`, `resume_file`, `photo_file`) VALUES
('em24092820023400c5a', 'Abdullah Md Jahid Hassan', 'Manager', 1756254873, 'abdullahmdjahidhassan@gmail.com', 'em1', 'Uttara, Dhaka', 'male', 50000, 1234567890, 'files/employee/nid_file/em24092820023400c5a_nid.pdf', 'files/employee/certificate_file/em24092820023400c5a_certificate.pdf', 'files/employee/resume_file/em24092820023400c5a_resume.pdf', 'files/employee/profile_pic_file/em24092820023400c5a_photo.jpg');

--
-- Triggers `employee`
--
DELIMITER $$
CREATE TRIGGER `before_insert_employee` BEFORE INSERT ON `employee` FOR EACH ROW BEGIN
    SET NEW.id = CONCAT(
        'em', 
        DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), 
        LPAD(MICROSECOND(NOW()) DIV 1000, 2, '0'),
        SUBSTRING(MD5(RAND()), 1, 3)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `organizational_plans`
--

CREATE TABLE `organizational_plans` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `realip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `organizational_plans`
--

INSERT INTO `organizational_plans` (`id`, `name`, `speed`, `realip`, `price`) VALUES
('op24092815583300d0d', 'Startup Plan', 20, 'Yes', 5000),
('op2409281600090065f', 'Speed: Keep your Limit Up', 100, 'Yes', 20000),
('op241008140936008aa', 'Advance', 30, 'Yes', 12000);

--
-- Triggers `organizational_plans`
--
DELIMITER $$
CREATE TRIGGER `before_insert_organizational_plans` BEFORE INSERT ON `organizational_plans` FOR EACH ROW BEGIN
    SET NEW.id = CONCAT(
        'op', 
        DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), 
        LPAD(MICROSECOND(NOW()) DIV 1000, 2, '0'),
        SUBSTRING(MD5(RAND()), 1, 3)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `residential_plans`
--

CREATE TABLE `residential_plans` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `realip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `residential_plans`
--

INSERT INTO `residential_plans` (`id`, `name`, `speed`, `realip`, `price`) VALUES
('rp240927193332001c1', 'Basic plan', 5, 'No', 500),
('rp240927193356002f4', 'Intermediate: A bit of batter life', 10, 'Yes', 700);

--
-- Triggers `residential_plans`
--
DELIMITER $$
CREATE TRIGGER `before_insert_residential_plans` BEFORE INSERT ON `residential_plans` FOR EACH ROW BEGIN
    SET NEW.id = CONCAT(
        'rp', 
        DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), 
        LPAD(MICROSECOND(NOW()) DIV 1000, 2, '0'),
        SUBSTRING(MD5(RAND()), 1, 3)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `state` text,
  `employee_id` varchar(50) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `task_ref` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `address`, `start`, `end`, `state`, `employee_id`, `details`, `task_ref`) VALUES
('ta24101023002400709', 'tast task', 'dhaka', '2024-10-01', '2024-10-05', 'pending', 'em24092820023400c5a', 'do it', NULL),
('ta24101023011400071', 'Task 2', 'Kuakata', '2024-10-03', '2024-10-18', 'late', 'em24092820023400c5a', 'jddgfs gsxfv dgf', NULL),
('ta24101610032300006', 'Tast 3', 'Office', '2024-10-17', '2024-10-25', 'Pending', 'em24092820023400c5a', 'Connect the line', ''),
('ta2410161650520095f', 'Tast 4', 'Office', '2024-10-25', '2024-11-02', 'Pending', 'em24092820023400c5a', 'kldjjflzdncifzcnnzzjcfolzfsffjsipf', '');

--
-- Triggers `task`
--
DELIMITER $$
CREATE TRIGGER `before_insert_task` BEFORE INSERT ON `task` FOR EACH ROW BEGIN
    SET NEW.id = CONCAT(
        'ta', 
        DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), 
        LPAD(MICROSECOND(NOW()) DIV 1000, 2, '0'),
        SUBSTRING(MD5(RAND()), 1, 3)
    );
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `organizational_plans`
--
ALTER TABLE `organizational_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residential_plans`
--
ALTER TABLE `residential_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

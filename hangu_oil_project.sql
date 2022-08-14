-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2022 at 10:31 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hangu_oil_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `selling` int(11) DEFAULT NULL,
  `buying` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `selling`, `buying`, `quantity`, `date`) VALUES
(2, 'Samsung microphone', 150, 100, 3, '2021-08-28'),
(3, 'Battery Infix note 10', 220, 200, 2, '2021-08-28'),
(4, 'Infix Hot 9 Battery', 350, 300, 0, '2021-08-29');

-- --------------------------------------------------------

--
-- Table structure for table `accessories_account`
--

CREATE TABLE `accessories_account` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `accessID` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '0 pending & 1 approve',
  `sellID` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '0 = shopkeeper & 1 = sub admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessories_account`
--

INSERT INTO `accessories_account` (`id`, `amount`, `date`, `accessID`, `status`, `sellID`, `type`) VALUES
(1, 150, '2021-11-09', 2, 1, 4, 1),
(2, 220, '2021-11-09', 3, 1, 2, 0),
(3, 350, '2021-11-09', 4, 0, 4, 1),
(4, 220, '2021-11-09', 3, 1, 4, 1),
(5, 150, '2021-11-09', 2, 1, 4, 1),
(6, 220, '2021-11-09', 3, 1, 2, 0),
(7, 350, '2021-11-09', 4, 0, 2, 0),
(8, 150, '2021-11-09', 2, 0, 2, 0),
(9, 150, '2021-11-09', 2, 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `accessories_transaction`
--

CREATE TABLE `accessories_transaction` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `sell_price` int(11) DEFAULT NULL,
  `buy_price` int(11) DEFAULT NULL,
  `accessID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessories_transaction`
--

INSERT INTO `accessories_transaction` (`id`, `date`, `sell_price`, `buy_price`, `accessID`, `quantity`) VALUES
(1, '2021-09-01', 220, 200, 3, 1),
(2, '2021-08-11', 220, 200, 3, 1),
(3, '2021-09-15', 150, 100, 2, 1),
(4, '2021-09-08', 350, 300, 4, 1),
(5, '2021-09-18', 220, 200, 3, 1),
(6, '2021-09-30', 350, 300, 4, 1),
(7, '2021-09-05', 150, 100, 2, 1),
(8, '2021-09-30', 350, 300, 4, 1),
(9, '2021-09-30', 350, 300, 4, 1),
(10, '2021-09-30', 350, 300, 4, 1),
(11, '2021-09-30', 150, 100, 2, 1),
(12, '2021-09-30', 300, 300, 4, 1),
(13, '2021-09-30', 250, 300, 4, 1),
(14, '2021-11-09', 150, 100, 2, 1),
(15, '2021-11-09', 220, 200, 3, 1),
(16, '2021-11-09', 350, 300, 4, 1),
(17, '2021-11-09', 220, 200, 3, 1),
(18, '2021-11-09', 150, 100, 2, 1),
(19, '2021-11-09', 220, 200, 3, 1),
(20, '2021-11-09', 220, 200, 3, 1),
(21, '2021-11-09', 350, 300, 4, 1),
(22, '2021-11-09', 150, 100, 2, 1),
(23, '2021-11-09', 150, 100, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `cnic` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `type` int(2) NOT NULL COMMENT '1 for super admin and 2 for sub admin',
  `date` date NOT NULL DEFAULT current_timestamp(),
  `account_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 allow && 1 block'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `mobile`, `email`, `pass`, `image`, `cnic`, `address`, `type`, `date`, `account_status`) VALUES
(2, 'Abdul Basit', '03322388002', 'basit@gmail.com', '/3q0Hg==', 'admin_03059235079CtH7kzTB19l0i3a.jpeg', '223020399292', 'Kohat', 1, '2021-06-01', 0),
(4, 'Sub Admin', '09834098234', 'sb@gmail.com', '/3q0Hg==', 'admin_098340982347A5gDUdeUmu4R4s.jpeg', '098234098234', 'Hangu', 2, '2021-07-29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `amount`, `adminID`) VALUES
(3, 0, 2),
(4, 498000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `admin_transaction`
--

CREATE TABLE `admin_transaction` (
  `id` int(11) NOT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT '0 add investor account || 1 for subtract investor account || 2 customer installment payment || 3 expence || 4 dsb_shop',
  `type` enum('investor','customer','expence','dbs_shop') DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL,
  `paymentStatus` int(2) NOT NULL DEFAULT 0 COMMENT '0 pending || 1 viewed by super admin',
  `appID` int(11) NOT NULL DEFAULT 0,
  `exp_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for dbs shop expence and 0 for other'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_transaction`
--

INSERT INTO `admin_transaction` (`id`, `amount`, `date`, `status`, `type`, `adminID`, `paymentStatus`, `appID`, `exp_type`) VALUES
(70, 100000, '2021-10-09', 0, 'investor', 2, 1, 0, 0),
(71, 4000, '2021-10-09', 2, 'customer', 2, 1, 12, 0),
(72, 50000, '2021-10-09', 0, 'investor', 2, 1, 0, 0),
(73, 4000, '2021-10-09', 2, 'customer', 2, 1, 13, 0),
(74, 1000, '2021-10-10', 0, 'investor', 2, 1, 0, 0),
(75, 1000, '2021-10-10', 1, 'investor', 2, 1, 0, 0),
(76, 2000, '2021-11-21', 0, 'investor', 4, 0, 0, 0),
(77, 4000, '2021-11-21', 1, 'investor', 4, 0, 0, 0),
(78, 90000, '2021-11-21', 0, 'investor', 4, 0, 0, 0),
(79, 25000, '2021-11-21', 4, 'dbs_shop', 4, 0, 0, 0),
(80, 25000, '2021-11-21', 4, 'dbs_shop', 4, 0, 0, 0),
(81, 2000, '2021-11-21', 2, 'customer', 4, 0, 12, 0),
(82, 2000, '2021-11-21', 2, 'customer', 4, 1, 12, 0),
(83, 200, '2021-11-21', 3, 'expence', 4, 1, 0, 0),
(84, 300, '2021-11-21', 3, 'expence', 4, 1, 0, 1),
(85, 2000, '2021-11-25', 2, 'customer', 2, 1, 14, 0),
(86, 15600, '2021-11-25', 2, 'customer', 2, 1, 12, 0),
(87, 2000, '2021-11-27', 2, 'customer', 4, 1, 13, 0),
(88, 16000, '2021-11-27', 2, 'customer', 4, 1, 13, 0),
(89, 500, '2021-11-27', 2, 'customer', 4, 1, 13, 0),
(90, 20000, '2021-11-27', 2, 'customer', 2, 1, 15, 0),
(91, 200000, '2021-11-27', 2, 'customer', 2, 1, 16, 0),
(92, 80000, '2021-11-27', 2, 'customer', 2, 1, 20, 0),
(93, 5000, '2021-11-28', 0, 'investor', 2, 1, 0, 0),
(94, 1000, '2021-11-28', 0, 'investor', 2, 1, 0, 0),
(95, 1000, '2021-11-28', 0, 'investor', 2, 1, 0, 0),
(96, 2000, '2021-11-28', 1, 'investor', 2, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` int(11) NOT NULL,
  `cusID` int(11) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `monthly_income` bigint(20) NOT NULL,
  `business_type` varchar(150) NOT NULL,
  `business_address` varchar(255) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `model_no` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `product_orginal_price` bigint(20) NOT NULL,
  `percentage_on_prod` int(11) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  `installment_months` int(11) NOT NULL,
  `monthly_payment` int(11) NOT NULL,
  `advance_payment` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 pending & 1 accepted & 2 delivered & 3 active & 4 completed',
  `ref_by` varchar(100) NOT NULL,
  `delivery_image` varchar(150) DEFAULT NULL,
  `investorID` int(11) NOT NULL DEFAULT 0 COMMENT '0 investor is not assign yet',
  `discount_amount` int(11) NOT NULL DEFAULT 0,
  `item_des` text DEFAULT NULL,
  `rej_des` text DEFAULT NULL,
  `advance_payment_status` tinyint(4) DEFAULT NULL COMMENT '0:pending - 1:paid',
  `advance_payment_paid` int(11) DEFAULT NULL,
  `active_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `cusID`, `age`, `monthly_income`, `business_type`, `business_address`, `date`, `model_no`, `companyID`, `product_name`, `item_type_id`, `product_orginal_price`, `percentage_on_prod`, `total_price`, `installment_months`, `monthly_payment`, `advance_payment`, `status`, `ref_by`, `delivery_image`, `investorID`, `discount_amount`, `item_des`, `rej_des`, `advance_payment_status`, `advance_payment_paid`, `active_date`) VALUES
(12, 2, 22, 20000, 'Shop owner', 'Hangu', '2021-10-09 01:52:10', 2020, 1, 'S-20', 1, 20000, 20, 23600, 10, 2000, 4000, 4, 'Salman', 'app_12_VA2J5JAuEs8qomBIEhb4GXo0sNnbm1.jpeg', 2, 400, 'Nothing', NULL, 1, 4000, '2021-10-09'),
(13, 1, 44, 30000, 'Anything', 'Something', '2021-10-09 02:36:02', 0, 1, 'Mobile S3', 1, 20000, 20, 22500, 10, 2000, 4000, 3, '', 'app_13_i4kaMzKPdk3N9LjpWYEHQPvQxzdYJg.jpeg', 1, 500, 'lksjdf', NULL, 1, 4000, '2021-10-09'),
(14, 2, 20, 30000, 'Engineer', 'DAK', '2021-11-25 01:05:25', 2021, 2, 'Mobilie s-20', 1, 20000, 10, 22000, 10, 2000, 2000, 3, 'Abdul Basit', 'app_14_kvGePqlr6O1ytPulZsK1gSTgdMxgnt.png', 2, 0, 'Testing', NULL, 1, 2000, '2021-11-25'),
(15, 2, 22, 40000, 'Shop', 'Peshawar', '2021-11-25 01:06:30', 2021, 9, 'Honda 70', 3, 100000, 20, 120000, 10, 10000, 20000, 3, '', 'app_15_KEiom566wjkPvqpCVZAGIMWvZ9JD7v.jpeg', 2, 0, 'Testing', NULL, 1, 20000, '2021-11-25'),
(16, 2, 35, 70000, 'Software Engineer', 'Lahore', '2021-11-25 01:08:33', 2022, 10, 'Fruge', 4, 1000000, 20, 1200000, 20, 50000, 200000, 3, '', 'app_16_XJFowFV7xH3qaMdh7Vvd3Yj7UWRTDZ.jpeg', 1, 0, 'Testing des', NULL, 1, 200000, '2021-11-25'),
(17, 2, 33, 60000, 'Computer', 'Punjab', '2021-11-25 01:09:28', 2018, 10, 'Bike', 1, 50000, 15, 57500, 10, 5000, 7500, 5, '', NULL, 0, 0, 'Honda bike', 'The application is reject because of not providing enough information', NULL, NULL, NULL),
(19, 2, 35, 450000, 'Lab ', 'Mardan', '2021-11-25 01:11:39', 0, 1, 'Mobile S3', 1, 40000, 30, 52000, 20, 2000, 12000, 5, '', NULL, 0, 0, 'Testing', 'incomplete information provided', NULL, NULL, NULL),
(20, 2, 34, 50000, 'Testing', 'Testing', '2021-11-25 01:12:19', 0, 1, 'S-22', 1, 400000, 20, 480000, 30, 13334, 80000, 3, '', 'app_20_x4QsZIWsEj9Hq7VbKVkRENvOyhn5k0.jpeg', 3, 0, 'Testing', NULL, 1, 80000, '2021-11-27'),
(21, 2, 34, 50000, 'Computer Engineer', 'Testing', '2021-11-25 01:13:14', 0, 3, 'Laptop', 1, 200000, 10, 220000, 20, 10000, 20000, 1, '', NULL, 0, 0, 'Testing', NULL, 1, 20000, '2021-11-27'),
(22, 2, 23, 400000, 'Computer Engineer', 'Lahore', '2021-11-25 01:14:05', 2021, 4, 'Hair Frug', 1, 500000, 10, 550000, 10, 50000, 50000, 0, '', NULL, 0, 0, 'Testing', NULL, NULL, NULL, NULL),
(23, 2, 34, 100000, 'Testing', 'Testing', '2021-11-25 01:14:56', 0, 10, 'Testing', 1, 20000, 10, 22000, 20, 1000, 2000, 0, '', NULL, 0, 0, 'Testing', NULL, NULL, NULL, NULL),
(24, 2, 20, 200000, 'Testing', 'Testing', '2021-11-25 01:15:37', 0, 1, 'Testing', 1, 30000, 30, 39000, 10, 3000, 9000, 0, 'Testing', NULL, 0, 0, 'Testing', NULL, NULL, NULL, NULL),
(25, 2, 35, 5000, 'Testing 1', 'Testing 1', '2021-11-25 01:16:14', 0, 1, 'Testing 1', 1, 700000, 10, 770000, 10, 70000, 70000, 0, 'Testing 1', NULL, 0, 0, 'Testing 1', NULL, NULL, NULL, NULL),
(26, 2, 35, 500000, 'Testing 2', 'Testing 2', '2021-11-25 01:17:12', 0, 1, 'Testing 2', 1, 50000, 30, 65000, 20, 2500, 15000, 0, 'Testing 2', NULL, 0, 0, 'Testing 2', NULL, NULL, NULL, NULL),
(27, 2, 35, 50000, 'Testing 3', 'Testing 3', '2021-11-25 01:17:44', 0, 1, 'Testing 3', 1, 50000, 50, 75000, 3000, 17, 25000, 0, 'Testing 3', NULL, 0, 0, 'Testing 3', NULL, NULL, NULL, NULL),
(28, 1, 22, 20000, 'computer', 'darra adam khel', '2021-11-30 00:39:27', 2020, 3, 's200', 1, 50000, 20, 60000, 12, 4166, 10000, 0, 'salman', NULL, 0, 0, 'testing', NULL, NULL, NULL, NULL),
(29, 1, 22, 20000, 'computer', 'darra adam khel', '2021-11-30 00:41:41', 2020, 3, 's200', 1, 50000, 20, 60000, 12, 4166, 10000, 0, 'salman', NULL, 0, 0, 'testing', NULL, NULL, NULL, NULL),
(30, 2, 55, 55588, 'fghh', 'ftyu', '2021-11-30 00:56:57', 556, 7, 'ttyu', 4, 5566, 55, 8591, 2, 2783, 3025, 0, '', NULL, 0, 0, 'tty', NULL, NULL, NULL, NULL),
(31, 2, 22, 555, 'tyy', 'tyy', '2021-11-30 00:58:42', 0, 7, 'tyy', 4, 555, 55, 830, 55, 10, 275, 0, '', NULL, 0, 0, 'tty', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `application_installment`
--

CREATE TABLE `application_installment` (
  `id` int(11) NOT NULL,
  `appID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `type` enum('A','I') DEFAULT NULL COMMENT 'A = advance payment, I = app installment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_installment`
--

INSERT INTO `application_installment` (`id`, `appID`, `date`, `amount`, `type`) VALUES
(26, 12, '2021-10-09', 4000, 'A'),
(27, 13, '2021-10-09', 4000, 'A'),
(28, 12, '2021-11-21', 2000, 'I'),
(29, 12, '2021-11-21', 2000, 'I'),
(30, 14, '2021-11-25', 2000, 'A'),
(31, 12, '2021-11-25', 15600, 'I'),
(35, 15, '2021-11-27', 20000, 'A'),
(36, 16, '2021-11-27', 200000, 'A'),
(37, 20, '2021-11-27', 80000, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `application_investor_pending_payment`
--

CREATE TABLE `application_investor_pending_payment` (
  `id` int(11) NOT NULL,
  `invest_amount` bigint(20) DEFAULT NULL,
  `appID` int(11) DEFAULT NULL,
  `investorID` int(11) DEFAULT NULL,
  `cusID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 for pending 1 for approve',
  `profit` int(11) NOT NULL,
  `total_amount` bigint(20) NOT NULL,
  `paid` bigint(20) NOT NULL DEFAULT 0,
  `payable` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_investor_pending_payment`
--

INSERT INTO `application_investor_pending_payment` (`id`, `invest_amount`, `appID`, `investorID`, `cusID`, `date`, `status`, `profit`, `total_amount`, `paid`, `payable`) VALUES
(14, 20000, 12, 2, 2, '2021-10-09', 0, 3000, 23000, 4000, 19000),
(15, 20000, 13, 1, 1, '2021-10-09', 0, 3000, 23000, 0, 23000),
(16, 20000, 14, 2, 2, '2021-11-25', 0, 1500, 21500, 0, 21500),
(17, 100000, 15, 2, 2, '2021-11-27', 0, 15000, 115000, 6000, 109000),
(19, 1000000, 16, 1, 2, '2021-11-27', 0, 150000, 1150000, 50000, 1100000),
(20, 400000, 20, 3, 2, '2021-11-27', 0, 60000, 460000, 0, 460000);

-- --------------------------------------------------------

--
-- Table structure for table `application_mobile_number`
--

CREATE TABLE `application_mobile_number` (
  `id` int(11) NOT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `appID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_mobile_number`
--

INSERT INTO `application_mobile_number` (`id`, `mobile`, `appID`) VALUES
(21, '0893489348', 12),
(22, '9083049834', 13),
(23, '03039235079', 14),
(24, '03039235079', 15),
(25, '03039235079', 16),
(26, '03039235079', 17),
(28, '03039235079', 19),
(29, '03039235079', 20),
(30, '03039235079', 21),
(31, '03039235079', 22),
(32, '03039235079', 23),
(33, '03039235079', 24),
(34, '03039235079', 25),
(35, '03039235079', 26),
(36, '03039235079', 27),
(37, '00000000000', 28),
(38, '00000000000', 28),
(39, '00000000000', 28),
(40, '00000000000', 28),
(41, '00000000000', 29),
(42, '00000000000', 29),
(43, '00000000000', 29),
(44, '00000000000', 29),
(45, '555996666', 30),
(46, '886666', 31);

-- --------------------------------------------------------

--
-- Table structure for table `application_proof_person`
--

CREATE TABLE `application_proof_person` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `cnic_no` varchar(15) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `business_type` varchar(100) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `cnic_image` varchar(150) DEFAULT NULL,
  `business_card_image` varchar(150) DEFAULT NULL,
  `appID` int(11) DEFAULT NULL,
  `fname` varchar(80) DEFAULT NULL,
  `org_address` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_proof_person`
--

INSERT INTO `application_proof_person` (`id`, `name`, `cnic_no`, `mobile`, `business_type`, `address`, `image`, `cnic_image`, `business_card_image`, `appID`, `fname`, `org_address`) VALUES
(7, 'Salaman', '09834098349', '0983409834', 'kljsdfklj', 'lksjdflk', 'null', 'null', 'null', 12, 'Adnan', 'Kohat'),
(8, 'Abdullah', '0983409834908', '03498034980', 'Computer', 'DAK', 'proof_person_profile_14_03498034980oUasWtLtPTIJoXISkpQYSJwi66EpYVRcQfVoB3Fk_.jpeg', 'null', 'null', 14, 'Islam ud din', 'DAK'),
(9, 'Kamran', '987234987', '98732897234', 'Testing', 'computer', 'proof_person_profile_16_98732897234pWnrZKy3yLmJ3cJ8cA9nZy9DYGcLW2jyJggCc6iC_.jpeg', 'proof_person_cnic_16_98732897234iMCKAYg4nHMDpjQm8HQU7kvSz7UrCcSKaYcgxArs_.png', 'proof_business_card_16_98732897234T3NkCEQm8UGUo056GvrECGhLDf7Y003nNyhLg0c7_.png', 16, 'Abdullah', 'Lahore'),
(10, 'Abdul Basit', '2589866898698', '03059235079', 'Daaaaa', 'Daaaaaa', 'proof_person_profile_28_03059235079dc9n3QpUD48oUTMUMxR8rrUDigCITxmWwxQkWhF5_.CreateApplication', 'proof_person_cnic_28_03059235079f4J7UeMby4SrIavCy4UDCMs2QMGMRONl5WKs3JIv_.CreateApplication', 'null', 28, 'Abdul Basit Fath', 'Daaaaa'),
(11, 'Abdul Basit', '2589866898698', '03059235079', 'Daaaaa', 'Daaaaaa', 'proof_person_profile_29_030592350792FnrVlIhQInS6YiE8yBXWr4LQu7ChOuJfjlS2xtJ_.CreateApplication', 'proof_person_cnic_29_03059235079rxOjdMN7vOTuIdd1HwoQ7FhxtOoqbWszH8PbWbOW_.CreateApplication', 'null', 29, 'Abdul Basit Fath', 'Daaaaa'),
(12, 'ttyu', '555666', '556', 'fgyu', 'tgy', 'proof_person_profile_31_556UKfuJggi68pgfybhQdZOzQFeipTRpPW1cGdshSuq_.CreateApplication', 'null', 'null', 31, 'cfgh', 'tyy');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(7, 'change'),
(4, 'dell'),
(11, 'Hair'),
(2, 'infinix'),
(3, 'iphone'),
(10, 'q mobile'),
(1, 'samsungs'),
(9, 'vevo');

-- --------------------------------------------------------

--
-- Table structure for table `company_account`
--

CREATE TABLE `company_account` (
  `id` int(11) NOT NULL,
  `amount` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_account`
--

INSERT INTO `company_account` (`id`, `amount`) VALUES
(1, 438425);

-- --------------------------------------------------------

--
-- Table structure for table `company_expense`
--

CREATE TABLE `company_expense` (
  `id` int(11) NOT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 company && 1 dbs shop'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_expense`
--

INSERT INTO `company_expense` (`id`, `amount`, `date`, `comment`, `adminID`, `status`) VALUES
(19, 200, '2021-11-21', 'Food', 4, 0),
(20, 300, '2021-11-21', 'Dinner', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `facebook` varchar(150) DEFAULT NULL,
  `whatsapp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `name`, `mobile`, `email`, `address`, `facebook`, `whatsapp`) VALUES
(1, 'DBS Instalment', '0339499494', 'dbs_info@gmail.com', 'Zalazak Road Zakira hostel near to City University Peshawar', 'dbs_facebook/profile', '00394939393');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `cnic` varchar(13) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `fname` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `cnic`, `mobile`, `address`, `image`, `fname`) VALUES
(1, 'Adnan Ali', '2240112757222', '03059235079', 'Lahore', 'customer_2240112757261V6h2BXqwSTxfZDP.png', 'Sami Ullah'),
(2, 'Abdul Basit', '9080349834', '90823490823', 'Darra Adam Khel', 'customer_9080349834KrRUtd2EMY73GLW.png', 'Islam Ud DIn'),
(3, 'Ali Khan', '908340934', '908390834', 'Lahore', 'customer_908390834_908340934_ESrH55uMHB3whg7.jpeg', 'Kamran Khan'),
(4, 'Kamali', '0934098324098', '9083409834', 'Punjab', 'customer_9083409834_0934098324098_hlrH0kmfFZem8Ab.jpeg', 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `dbs_shop_account`
--

CREATE TABLE `dbs_shop_account` (
  `id` int(11) NOT NULL,
  `balance` bigint(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 for total balance ** 1 for stock balance'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dbs_shop_account`
--

INSERT INTO `dbs_shop_account` (`id`, `balance`, `status`) VALUES
(1, 880, 0),
(2, -1160, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dbs_shop_stock`
--

CREATE TABLE `dbs_shop_stock` (
  `id` int(11) NOT NULL,
  `companyID` int(11) DEFAULT NULL,
  `ram` int(11) DEFAULT NULL,
  `memory` int(11) DEFAULT NULL,
  `sim` varchar(30) DEFAULT NULL,
  `network` varchar(10) DEFAULT NULL,
  `fringerprint` int(11) DEFAULT NULL COMMENT '0 yes &&& 1 no',
  `font_camera` varchar(20) DEFAULT NULL,
  `back_camera` varchar(20) DEFAULT NULL,
  `buy_price` int(11) DEFAULT NULL,
  `selling_price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dbs_shop_stock`
--

INSERT INTO `dbs_shop_stock` (`id`, `companyID`, `ram`, `memory`, `sim`, `network`, `fringerprint`, `font_camera`, `back_camera`, `buy_price`, `selling_price`, `quantity`, `date`) VALUES
(13, 3, 4, 16, 'Single sim', '2G', 0, '12', '32', 20000, 25000, 0, '2021-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `db_shop_buy_request`
--

CREATE TABLE `db_shop_buy_request` (
  `id` int(11) NOT NULL,
  `cus_name` varchar(1000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `cus_mobile` varchar(15) DEFAULT NULL,
  `stockID` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - pending  1-completed',
  `sell_price` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `db_shop_buy_request`
--

INSERT INTO `db_shop_buy_request` (`id`, `cus_name`, `date`, `cus_mobile`, `stockID`, `status`, `sell_price`) VALUES
(10, 'Salman Khan', '2021-11-09', '0983490834', 13, 1, 25000),
(11, 'Abdul Basit', '2021-11-09', '094949494', 13, 0, 0),
(12, 'Kamran Khan', '2021-11-09', '908908908000', 13, 1, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `investor`
--

CREATE TABLE `investor` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `cnic` varchar(14) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `investor`
--

INSERT INTO `investor` (`id`, `name`, `cnic`, `mobile`, `address`, `image`) VALUES
(1, 'Salman Khan', '224011275711', '03059235079', 'Lahore', 'xogIWkqaA7Hdbco7GNIilRc6N2zDBXB14IxhzuJixuStZyvV20.png'),
(2, 'Samiullah', '224011244567', '03400834803', 'Darra Adam Khel', 'xogIWkqaA7Hdbco7GNIilRc6N2zDBXB14IxhzuJixuStZyvV20.png'),
(3, 'Kamran Khan', '0983204983', '098324083', 'Testing', 'customer_098324083_0983204983_jFw94MHB4OI8sXL.jpeg'),
(4, 'Tufaiq', '224011275899', '03322388002', 'Punjab', 'customer_03322388002_224011275899_o05tJ1LaI4icjrf.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `investor_account`
--

CREATE TABLE `investor_account` (
  `id` int(11) NOT NULL,
  `balance` bigint(20) DEFAULT 0,
  `investorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `investor_account`
--

INSERT INTO `investor_account` (`id`, `balance`, `investorID`) VALUES
(3, 906000, 2),
(4, 50000, 1),
(5, 600000, 3),
(6, 5000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `investor_transaction`
--

CREATE TABLE `investor_transaction` (
  `id` int(11) NOT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '0 added || 1 subtract',
  `date` date DEFAULT NULL,
  `investorID` int(11) DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL COMMENT 'only for investor transaction'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `investor_transaction`
--

INSERT INTO `investor_transaction` (`id`, `amount`, `type`, `date`, `investorID`, `adminID`, `des`) VALUES
(20, 100000, 0, '2021-10-09', 2, 2, NULL),
(21, 50000, 0, '2021-10-09', 1, 2, NULL),
(22, 1000, 0, '2021-10-10', 1, 2, 'Some testing comment'),
(23, 1000, 1, '2021-10-10', 1, 2, 'Amount sub investor account'),
(24, 2000, 0, '2021-11-21', 2, 4, 'Testing'),
(25, 4000, 1, '2021-11-21', 2, 4, 'Collected by investor'),
(26, 90000, 0, '2021-11-21', 2, 4, 'Testing'),
(27, 2000, 1, '2021-11-28', 4, 2, 'rffg');

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE `item_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`id`, `name`) VALUES
(4, 'ac'),
(3, 'bike'),
(2, 'car'),
(1, 'mobile'),
(5, 'tv');

-- --------------------------------------------------------

--
-- Table structure for table `mobile_company_dbs`
--

CREATE TABLE `mobile_company_dbs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mobile_company_dbs`
--

INSERT INTO `mobile_company_dbs` (`id`, `name`) VALUES
(1, 'apple'),
(2, 'honor'),
(3, 'huawei'),
(5, 'infinix'),
(6, 'lenovo'),
(8, 'nokia'),
(4, 'oppo'),
(9, 'q mobile'),
(7, 'samsung'),
(10, 'sony'),
(12, 'tecno');

-- --------------------------------------------------------

--
-- Table structure for table `shopkeeper`
--

CREATE TABLE `shopkeeper` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(13) DEFAULT NULL,
  `cnic` varchar(14) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `image` varchar(150) DEFAULT 'null',
  `join_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = active & 1 = blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shopkeeper`
--

INSERT INTO `shopkeeper` (`id`, `name`, `mobile`, `cnic`, `address`, `salary`, `pass`, `image`, `join_date`, `status`) VALUES
(2, 'عبدالحمید', '1234', '2203003039283', 'ڈی 136 جوہر ٹاؤن لاہور۔', 14000, '/3q0Hg==', 'shopkeeper_03322388002_86sVtr4uyVGJnFK_1628450929.jpeg', '2021-08-08', 0),
(3, 'کامران خان۔', '12345', '9802349089', 'درہ آدم خیل شہر کوہاٹ۔', 15000, '/3q0Hg==', 'shopkeeper_03322388002_86sVtr4uyVGJnFK_1628450929.jpeg', '2021-08-10', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accessories_account`
--
ALTER TABLE `accessories_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accessID` (`accessID`);

--
-- Indexes for table `accessories_transaction`
--
ALTER TABLE `accessories_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accessID` (`accessID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adminID` (`adminID`);

--
-- Indexes for table `admin_transaction`
--
ALTER TABLE `admin_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cusID` (`cusID`);

--
-- Indexes for table `application_installment`
--
ALTER TABLE `application_installment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appID` (`appID`);

--
-- Indexes for table `application_investor_pending_payment`
--
ALTER TABLE `application_investor_pending_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appID` (`appID`),
  ADD UNIQUE KEY `appID_2` (`appID`),
  ADD KEY `investorID` (`investorID`),
  ADD KEY `cusID` (`cusID`);

--
-- Indexes for table `application_mobile_number`
--
ALTER TABLE `application_mobile_number`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appID` (`appID`);

--
-- Indexes for table `application_proof_person`
--
ALTER TABLE `application_proof_person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appID` (`appID`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `company_account`
--
ALTER TABLE `company_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_expense`
--
ALTER TABLE `company_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnic` (`cnic`),
  ADD UNIQUE KEY `cnic_2` (`cnic`);

--
-- Indexes for table `dbs_shop_account`
--
ALTER TABLE `dbs_shop_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbs_shop_stock`
--
ALTER TABLE `dbs_shop_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companyID` (`companyID`);

--
-- Indexes for table `db_shop_buy_request`
--
ALTER TABLE `db_shop_buy_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stockID` (`stockID`);

--
-- Indexes for table `investor`
--
ALTER TABLE `investor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnic` (`cnic`);

--
-- Indexes for table `investor_account`
--
ALTER TABLE `investor_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `investorID` (`investorID`);

--
-- Indexes for table `investor_transaction`
--
ALTER TABLE `investor_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investorID` (`investorID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `item_type`
--
ALTER TABLE `item_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `mobile_company_dbs`
--
ALTER TABLE `mobile_company_dbs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `shopkeeper`
--
ALTER TABLE `shopkeeper`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `cnic` (`cnic`),
  ADD UNIQUE KEY `mobile_2` (`mobile`),
  ADD UNIQUE KEY `cnic_2` (`cnic`),
  ADD UNIQUE KEY `mobile_3` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `accessories_account`
--
ALTER TABLE `accessories_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `accessories_transaction`
--
ALTER TABLE `accessories_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_transaction`
--
ALTER TABLE `admin_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `application_installment`
--
ALTER TABLE `application_installment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `application_investor_pending_payment`
--
ALTER TABLE `application_investor_pending_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `application_mobile_number`
--
ALTER TABLE `application_mobile_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `application_proof_person`
--
ALTER TABLE `application_proof_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `company_expense`
--
ALTER TABLE `company_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dbs_shop_account`
--
ALTER TABLE `dbs_shop_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dbs_shop_stock`
--
ALTER TABLE `dbs_shop_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `db_shop_buy_request`
--
ALTER TABLE `db_shop_buy_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `investor`
--
ALTER TABLE `investor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `investor_account`
--
ALTER TABLE `investor_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `investor_transaction`
--
ALTER TABLE `investor_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `item_type`
--
ALTER TABLE `item_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mobile_company_dbs`
--
ALTER TABLE `mobile_company_dbs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shopkeeper`
--
ALTER TABLE `shopkeeper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessories_account`
--
ALTER TABLE `accessories_account`
  ADD CONSTRAINT `accessories_account_ibfk_1` FOREIGN KEY (`accessID`) REFERENCES `accessories` (`id`);

--
-- Constraints for table `accessories_transaction`
--
ALTER TABLE `accessories_transaction`
  ADD CONSTRAINT `accessories_transaction_ibfk_1` FOREIGN KEY (`accessID`) REFERENCES `accessories` (`id`);

--
-- Constraints for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD CONSTRAINT `admin_account_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`id`);

--
-- Constraints for table `admin_transaction`
--
ALTER TABLE `admin_transaction`
  ADD CONSTRAINT `admin_transaction_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`id`);

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`cusID`) REFERENCES `customer` (`id`);

--
-- Constraints for table `application_installment`
--
ALTER TABLE `application_installment`
  ADD CONSTRAINT `application_installment_ibfk_1` FOREIGN KEY (`appID`) REFERENCES `application` (`id`);

--
-- Constraints for table `application_investor_pending_payment`
--
ALTER TABLE `application_investor_pending_payment`
  ADD CONSTRAINT `application_investor_pending_payment_ibfk_1` FOREIGN KEY (`appID`) REFERENCES `application` (`id`),
  ADD CONSTRAINT `application_investor_pending_payment_ibfk_2` FOREIGN KEY (`investorID`) REFERENCES `investor` (`id`),
  ADD CONSTRAINT `application_investor_pending_payment_ibfk_3` FOREIGN KEY (`cusID`) REFERENCES `customer` (`id`);

--
-- Constraints for table `application_mobile_number`
--
ALTER TABLE `application_mobile_number`
  ADD CONSTRAINT `application_mobile_number_ibfk_1` FOREIGN KEY (`appID`) REFERENCES `application` (`id`);

--
-- Constraints for table `application_proof_person`
--
ALTER TABLE `application_proof_person`
  ADD CONSTRAINT `application_proof_person_ibfk_1` FOREIGN KEY (`appID`) REFERENCES `application` (`id`);

--
-- Constraints for table `company_expense`
--
ALTER TABLE `company_expense`
  ADD CONSTRAINT `company_expense_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`id`);

--
-- Constraints for table `dbs_shop_stock`
--
ALTER TABLE `dbs_shop_stock`
  ADD CONSTRAINT `dbs_shop_stock_ibfk_1` FOREIGN KEY (`companyID`) REFERENCES `mobile_company_dbs` (`id`);

--
-- Constraints for table `db_shop_buy_request`
--
ALTER TABLE `db_shop_buy_request`
  ADD CONSTRAINT `db_shop_buy_request_ibfk_1` FOREIGN KEY (`stockID`) REFERENCES `dbs_shop_stock` (`id`);

--
-- Constraints for table `investor_account`
--
ALTER TABLE `investor_account`
  ADD CONSTRAINT `investor_account_ibfk_1` FOREIGN KEY (`investorID`) REFERENCES `investor` (`id`);

--
-- Constraints for table `investor_transaction`
--
ALTER TABLE `investor_transaction`
  ADD CONSTRAINT `investor_transaction_ibfk_1` FOREIGN KEY (`investorID`) REFERENCES `investor` (`id`),
  ADD CONSTRAINT `investor_transaction_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

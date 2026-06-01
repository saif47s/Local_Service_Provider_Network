-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 04:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hs`
--
CREATE DATABASE IF NOT EXISTS `hs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hs`;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `area_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `city_id`, `area_name`) VALUES
(17, 9, 'Chakwal Tehsil'),
(18, 9, 'Choa Saidan Shah Tehsil'),
(19, 9, 'Kallar Kahar Tehsil'),
(20, 9, 'Lawa Tehsil'),
(21, 9, 'Talagang Tehsil'),
(22, 9, 'Bhaun'),
(23, 9, 'Bhagwal'),
(24, 9, 'Bhon'),
(25, 9, 'Bilalabad'),
(26, 9, 'Budhial'),
(27, 9, 'Danda Shah Bilawal'),
(28, 9, 'Dharyala Kahoon'),
(29, 9, 'Dhoda Town'),
(30, 9, 'Dhudial'),
(31, 9, 'Dulla'),
(32, 9, 'Dulmial'),
(33, 9, 'Jand Awan'),
(34, 9, 'Kallar Kahar'),
(35, 9, 'Khanpur'),
(36, 9, 'Lawa'),
(37, 9, 'Mulhal Mughlan'),
(38, 9, 'Mureed'),
(39, 9, 'Neela Dullah'),
(40, 9, 'Ratta Sharif'),
(41, 9, 'Sarkal kassar'),
(42, 9, 'Sohawa'),
(43, 9, 'Surhali'),
(44, 9, 'Tamman'),
(45, 9, 'Thaneel Kamal'),
(46, 9, 'Ara'),
(47, 9, 'Basharat'),
(48, 9, 'Bheen'),
(49, 9, 'Bhekarl Kalan'),
(50, 9, 'Bigal'),
(51, 9, 'Blokassar'),
(52, 9, 'Chak Malook'),
(53, 9, 'Chak Umra'),
(54, 9, 'Choa Ganj Ali Shah'),
(55, 9, 'Dab'),
(56, 9, 'Dalwal Mah Badshah Pur'),
(57, 9, 'Dandot'),
(58, 9, 'Dhoular'),
(59, 9, 'Dhumman'),
(60, 9, 'Jabirpur'),
(61, 9, 'Jand'),
(62, 9, 'Karsal'),
(63, 9, 'Karyala'),
(64, 9, 'Khal'),
(65, 9, 'Khair Pur'),
(66, 9, 'Khotian'),
(67, 9, 'Kot Chaudhrian'),
(68, 9, 'Lehr Sultan Pur'),
(69, 9, 'Mengan'),
(70, 9, 'Mogla'),
(71, 9, 'Odherwal'),
(72, 9, 'Padshahan'),
(73, 9, 'Salol'),
(74, 9, 'Saral'),
(75, 9, 'Warwal');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(5) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(84, 'Cleaning'),
(85, 'Hair Services for Women'),
(86, 'Salon for Men'),
(87, 'Electricians'),
(88, 'Plumbers'),
(89, 'Carpenters');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(5) NOT NULL,
  `city_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `city_name`) VALUES
(1, 'Karachi'),
(2, 'Lahore'),
(3, 'Islamabad'),
(4, 'Rawalpindi'),
(5, 'Faisalabad'),
(6, 'Multan'),
(7, 'Peshawar'),
(8, 'Quetta'),
(9, 'Chakwal');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(5) NOT NULL,
  `login_id` int(5) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `city_id` int(5) DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `pincode` varchar(6) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `login_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city_id`, `area`, `pincode`, `area_id`) VALUES
(6, 355, 'Bilal', 'Khan', 'bilal.khan@gmail.com', '8574587458', 'House 123, Street 4, F-10, Islamabad', 1, '', '589658', NULL),
(14, 371, 'Muhammad', 'Saif', 'labpc4472@gmail.com', '03192171693', 'mohallah baba chala walay', 4, 'Balkassar', '48800', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_reviews`
--

CREATE TABLE `customer_reviews` (
  `review_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_reviews`
--

INSERT INTO `customer_reviews` (`review_id`, `sp_id`, `customer_id`, `order_id`, `rating`, `review_text`, `created_at`, `is_read`) VALUES
(1, 66, 14, 30, 5, 'Hhhhhhh', '2026-01-30 05:06:28', 1),
(2, 66, 14, 30, 5, 'Yyhh', '2026-01-30 05:06:43', 1),
(3, 66, 14, 30, 2, 'Yyyy', '2026-01-30 05:07:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--

CREATE TABLE `demo` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demo`
--

INSERT INTO `demo` (`id`, `name`, `date`) VALUES
(1, 'deep', '0000-00-00 00:00:00'),
(2, 'deep', '2023-02-26 03:33:40'),
(3, 'deep', '2023-02-26 03:33:54');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(5) NOT NULL,
  `role_id` int(5) DEFAULT NULL,
  `is_verified` int(11) DEFAULT 0,
  `verification_code` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `account_status` varchar(20) DEFAULT 'active',
  `activation_request` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `role_id`, `is_verified`, `verification_code`, `username`, `password`, `email`, `otp`, `account_status`, `activation_request`) VALUES
(333, 3, 0, '', 'sahil', '$2y$10$hZDAvmYRcGnL48FWoHH37O0Ey99EnX..Ce9ETd2yWxAum30Knb9o.', NULL, NULL, 'active', 0),
(335, 1, 0, '', 'admin', '$2y$10$pWIokr/4Rgvn3TFcuut5COx7ESOllbuLGdor/MLqCpmWqGF1srERy', 'labpc4472@gmail.com', NULL, 'active', 0),
(344, 2, 0, '', 'zain', '$2y$10$KDhIPRf5qIYTmFJY2pVfYe/XF.DX8Cypctp4Q.qJeXgNwiamfaNAm', NULL, NULL, 'active', 0),
(345, 2, 0, '', 'hamza', '$2y$10$V7DsxOd9.mDjp9AEkGEtteL3QLojStmFFwmqo.l1RmSDbRuph8Amq', NULL, NULL, 'active', 0),
(347, 2, 0, '', 'ali', '$2y$10$Mu7fItaeU.Q1aMWek1LvjOEEL1Q/rFXnjkTL//uXMoreKFXJoExSi', NULL, NULL, 'active', 0),
(351, 2, 0, '', 'omer', '$2y$10$Se74K2TO57ZGEN79HFNy4e7qUJ/v1ePImeRLj9/E5sgPSQs7uwG6m', NULL, NULL, 'active', 0),
(352, 3, 0, '', 'amit', '$2y$10$LImF6t3d5pQMRTE8a3kyX.0XPqTK9L.8FTDIS4Z9BUwX75Hzss0DW', NULL, NULL, 'active', 0),
(354, 2, 0, '', 'hassan', '$2y$10$nQCTknPw7Y0ViSMNuWdwHORpdNcm5a9iLsIUyHDwGofxUG2p6.8mG', NULL, NULL, 'active', 0),
(355, 3, 0, '', 'bilal', '$2y$10$wXEeA6MNy13EsgQlF8G3w.fhZC4NCH2kEi0amMj9CdtTvU.ZiUsMO', NULL, NULL, 'active', 0),
(362, 2, 0, '', 'ali_75', '$2y$10$p/s2yCY9yUWMyetz5AF5VuMGMX89cUgvemGT4P.LmJNB8wAF7e7k.', NULL, NULL, 'active', 0),
(366, 3, 0, '423220', 'test_12', '$2y$10$hOI/4AkTsuaWztFbNt.J8u6d3MSnFjqMdaxHqafe68WApq6XPJiw2', NULL, NULL, 'active', 0),
(371, 3, 1, '234943', 'test_1', '$2y$10$AlYLhw2TJO812g3SQNYoMOZOrDWxTNG/e5jUC87FDN0PsZdaaiWQy', NULL, NULL, 'active', 0),
(372, 2, 1, '928410', 'test_145', '$2y$10$mmbn1keqgwij58Y9FBAKDOhQTGjQoEzN6.uJFV5PysUCTAKBQ/96q', NULL, NULL, 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

CREATE TABLE `order_master` (
  `order_id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(300) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `pay_mode` varchar(20) NOT NULL,
  `total` int(20) NOT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`order_id`, `customer_id`, `full_name`, `phone`, `address`, `pincode`, `pay_mode`, `total`, `commission`, `order_date`, `due_date`) VALUES
(8, 6, 'Bilal Khan', '1234567890', '23, swetapartk , pasodra, surat', '123468', 'COD', 1851, 0.00, '2023-02-26 06:01:05', '2023-03-08 18:01:00'),
(23, 6, 'Bilal Khan', '1234567890', 'C, 393, SHIVADHARA SOCIETY, MOTAVARACHHA, SURAT, GUJARAT', '123456', 'COD', 7276, 0.00, '2023-03-01 11:44:12', '2023-04-07 11:44:00'),
(24, 6, 'Bilal Khan', '8798767656', 'fndm', '123456', 'COD', 13604, 0.00, '2023-03-01 01:32:50', '2023-03-03 13:32:00'),
(25, 6, 'Bilal Khan', '8767675654', 'C-304, shivdhara camput, mahidharpura, ahmedabad.', '123456', 'COD', 748, 0.00, '2023-03-28 12:25:02', '2023-04-07 12:25:00'),
(30, 14, 'Muhammad Saif', '03192171693', 'mohallah baba chala wala', '488000', 'COD', 5250, 525.00, '2026-01-23 02:03:36', '2026-01-30 15:32:00'),
(31, 14, 'Muhammad Saif', '03192171693', 'mohallah baba chala wala', '948800', 'COD', 5250, 525.00, '2026-01-23 02:36:55', '2026-01-24 14:06:00'),
(32, 14, 'Muhammad Saif', '03192171693', 'mohallah baba chala wala', '488009', 'COD', 374, 17.80, '2026-01-23 02:46:08', '2026-01-31 14:16:00'),
(33, 14, 'Muhammad Saif', '03192171693', 'mohallah baba chala wala', '488090', 'COD', 0, 0.00, '2026-01-23 02:46:18', '2026-01-31 14:16:00'),
(34, 14, 'Muhammad Saif', '03192171693', 'Yyuuh', '48800', 'COD', 374, 17.80, '2026-01-25 10:28:49', '2026-01-24 09:44:00'),
(35, 14, 'Muhammad Saif', '03192171693', 'Jj', '48800', 'COD', 374, 17.80, '2026-01-25 10:30:35', '2026-01-28 10:05:00'),
(36, 14, 'Muhammad Saif ', '03192171693', 'Tyyu', '48800', 'COD', 748, 35.60, '2026-01-25 12:51:57', '2026-01-29 12:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `sp_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL,
  `rating` int(1) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(5) NOT NULL,
  `role_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'serviceprovider'),
(3, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(5) NOT NULL,
  `category_id` int(5) DEFAULT NULL,
  `service_name` varchar(50) DEFAULT NULL,
  `service_availibility` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `category_id`, `service_name`, `service_availibility`) VALUES
(9, 87, 'Nal', 0),
(10, 86, 'Spice', 1),
(12, 84, 'Full Home Cleaning', 1),
(13, 84, 'Sofa & Carpet Cleaning', 1),
(14, 85, 'Trim & Style', 1),
(15, 85, 'Blowdry & Styling', 1),
(16, 85, 'Fashion Color', 1),
(18, 85, 'Cut & Style', 1),
(20, 86, 'Hair colour', 0),
(21, 86, 'Relaxing Head Massage', 1),
(22, 86, 'Beard Shaping & Styling', 0),
(23, 87, 'Switch & Socket', 0),
(25, 87, 'Fan repairing', 1),
(26, 89, 'Furniture', 1),
(27, 84, 'sofa cleaning', 1),
(28, 88, 'Basin & sink', 1),
(29, 88, 'Grouting', 1),
(30, 88, 'Bath fitting', 1),
(31, 88, 'Drainage pipes', 1),
(32, 88, 'Tap & Mixer', 1),
(33, 88, 'Water tank', 1),
(34, 88, 'Toilet', 1),
(35, 84, 'Funished apartment', 1),
(36, 84, 'Unfunished apartment', 1),
(37, 84, 'Mini Services', 1),
(38, 89, 'Table design', 1),
(39, 84, 'Room cleaning', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sp`
--

CREATE TABLE `sp` (
  `sp_id` int(5) NOT NULL,
  `login_id` int(5) NOT NULL,
  `sp_name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `city_id` int(5) NOT NULL,
  `area` varchar(255) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `status` varchar(20) NOT NULL,
  `wallet_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sp`
--

INSERT INTO `sp` (`sp_id`, `login_id`, `sp_name`, `email`, `phone`, `transaction_id`, `city_id`, `area`, `pincode`, `status`, `wallet_balance`, `area_id`) VALUES
(49, 344, 'Zain Malik', 'zain@gmail.com', '8574857474', '', 16, '', '857485', 'active', 0.00, NULL),
(50, 345, 'Hamza Ali', 'hamza@gmail.com', '8574859655', '', 10, '', '523652', 'active', 0.00, NULL),
(52, 347, 'Ali Ahmed', 'ali@gmail.com', '9685741425', '', 15, '', '541254', 'active', 0.00, NULL),
(56, 351, 'Omer Farooq', 'omer@gmail.com', '9023964267', '', 1, '', '382350', 'deactive', 0.00, NULL),
(57, 354, 'Hassan Raza', 'hassan@gmail.com', '9687480417', '', 2, '', '365006', 'active', 2000.00, NULL),
(66, 372, 'Muhammad Saif', '0samsung7865@gmail.com', '03192171693', '222222222222', 9, 'Balkassar', '48800', 'active', 9996850.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sp_service`
--

CREATE TABLE `sp_service` (
  `sp_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `service_title` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `availability` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sp_service`
--

INSERT INTO `sp_service` (`sp_id`, `service_id`, `category_id`, `service_title`, `price`, `description`, `availability`) VALUES
(49, 21, 86, 'Body massage & Face detan', '600', 'I provide body massage and also i have co-opperative staff', 1),
(49, 29, 88, 'Kitchen type gap filling', '1000', '• Grouting or tile gap filling of 1 kitchen\r\n• Materials like epoxy and grouting powder will be procured at additional cost.\r\n', 1),
(50, 20, 86, 'Salon for men great', '2000', 'i provide salon for men with style ', 1),
(50, 28, 88, 'Basin - Quick & Reliable', '3000', 'A clogged or leaky basin or sink can be a major inconvenience, but not with our quick and reliable plumbing service! Our team of experienced plumbers is equipped with the latest tools and techniques to fix any basin or sink problem efficiently and effectively. From unclogging drains to fixing leaks, we offer a range of plumbing services that are tailored to meet your specific needs. With our prompt and affordable service, you can get back to your routine in no time. Book your Basin & Sink Fix se', 1),
(50, 30, 88, 'Balcony drain & blockage removal', '309', 'Cleaning of drain & floor trap to removal blockage', 1),
(50, 31, 88, 'Pipline', '699', 'pipline clean & remove stuff from pipe', 1),
(52, 12, 84, 'Kitching cleaning', '356', 'dsbkajcd', 1),
(52, 14, 85, 'Trim & Style - Glamorous Look', '350', 'we offer a range of hair services that cater to your needs. Our salon uses only the best hair care products and tools to ensure that you leave looking and feeling your best. Book your Trim & Style service today and get ready to rock a glamorous look!', 1),
(52, 18, 85, 'professional and stylish haircut', '250', 'Short title: \"Trim & Style - Glamorous Look\"\r\n\r\nGig description:\r\nLooking for a professional and stylish haircut? Look no further than our Trim & Style service! Our experienced hairstylists will work with you to create a customized look that complements your features and suits your style.', 1),
(52, 27, 84, 'dfvdf', '36', 'ergvfx', 1),
(52, 31, 88, 'pipeline solution ', '520', 'ill try if ii found any pipeline mistake then a solve it', 1),
(52, 35, 84, 'Bedroom Cleaning', '799', 'Floor cleaning with single disc machine & vacuuming of mattress and curtains.', 1),
(52, 37, 84, 'Occupied Kitchen cleaning', '1398', 'Tough oil & grease removal from tiles, stove, slab, sink, exhaust, window, etc.', 1),
(56, 12, 84, 'I Provide Full cleaning', '5000', 'I provide full home cleaning with fully gerrenty', 1),
(56, 23, 87, 'switch repairing', '150', 'dsih  jiuozkspsueofreivjkdsv ioniuhkdkfoavAEPISUVhnqwpoeqouf,mzxnpsjfew', 1),
(57, 12, 84, 'Complete Home Cleaning - Professional & Thorough', '2000', 'Looking for a reliable and professional cleaning service that can give your entire home a thorough cleaning? Look no further than our Complete Home Cleaning service! Our experienced and skilled cleaners will deep clean every room in your home, leaving it spotless and fresh-smelling. We use only the best cleaning products and equipment to ensure that your home is not only clean but also safe and healthy. Book your cleaning today and enjoy a clean and comfortable home!', 1),
(57, 13, 84, 'Fresh Home Cleaning', '1500', 'Say goodbye to dirt and stains on your sofas and carpets with our professional cleaning service! Our team of experienced cleaners is equipped with state-of-the-art equipment and eco-friendly cleaning solutions to give your furniture and carpets a deep and refreshing clean.', 1),
(57, 35, 84, 'Apartment Cleaning - Hassle-free', '5000', 'Keeping a furnished apartment clean can be a daunting task, but not with our hassle-free cleaning service! We offer a thorough cleaning of every corner of your furnished apartment, ensuring that it remains clean and inviting for your guests.', 1),
(57, 39, 84, 'Full Room cleaning', '900', 'I am offering professional room cleaning. Whether you need your bedroom, living room, kitchen, or any other room in your home cleaned, I am here to help. My services include dusting, vacuuming, mopping, wiping surfaces, and removing trash. I pay attention to detail and ensure that every nook and corner is thoroughly cleaned. With my services, you can have a sparkling clean room that will leave you feeling refreshed and satisfied. Contact me to book your cleaning appointment today!', 1),
(66, 25, 87, 'test_145', '5000', 'test_1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `updatetry`
--

CREATE TABLE `updatetry` (
  `id` int(5) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `updatetry`
--

INSERT INTO `updatetry` (`id`, `fname`, `lname`, `email`) VALUES
(1, 'Deep', 'Korat', 'deepkorat13@gmail.com'),
(2, 'jay', 'gabani', 'jaygabani@gmail.com'),
(3, 'sahil', 'patoliya', 'sahil@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `order_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `sp_id` int(5) NOT NULL,
  `service_title` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `qty` int(3) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_order`
--

INSERT INTO `user_order` (`order_id`, `service_id`, `sp_id`, `service_title`, `price`, `qty`, `status`) VALUES
(8, 12, 52, 'Kitching cleaning', '356', 1, 'pending'),
(8, 23, 56, 'switch repairing', '150', 1, 'pending'),
(8, 27, 52, 'dfvdf', '36', 1, 'pending'),
(8, 29, 49, 'Kitchen type gap filling', '1000', 1, 'pending'),
(8, 30, 50, 'Balcony drain & blockage removal', '309', 1, 'completed'),
(23, 12, 52, 'Kitching cleaning', '356', 5, 'pending'),
(23, 12, 57, 'Complete Home Cleaning - Professional & Thorough', '2000', 1, 'completed'),
(23, 14, 52, 'Trim & Style - Glamorous Look', '350', 2, 'pending'),
(23, 37, 52, 'Occupied Kitchen cleaning', '1398', 2, 'pending'),
(24, 12, 52, 'Kitching cleaning', '356', 3, 'pending'),
(24, 12, 57, 'Complete Home Cleaning - Professional & Thorough', '2000', 3, 'completed'),
(24, 13, 57, 'Fresh Home Cleaning', '1500', 1, 'rejected'),
(24, 27, 52, 'dfvdf', '36', 1, 'pending'),
(25, 12, 52, 'Kitching cleaning', '356', 2, 'pending'),
(25, 27, 52, 'dfvdf', '36', 1, 'pending'),
(30, 25, 66, 'test_145', '5000', 1, 'completed'),
(31, 25, 66, 'test_145', '5000', 1, 'completed'),
(32, 12, 52, 'Kitching cleaning', '356', 1, 'pending'),
(34, 12, 52, 'Kitching cleaning', '356', 1, 'pending'),
(35, 12, 52, 'Kitching cleaning', '356', 1, 'pending'),
(36, 12, 52, 'Kitching cleaning', '356', 2, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `transaction_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `manual_txn_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`transaction_id`, `sp_id`, `amount`, `type`, `status`, `manual_txn_id`, `created_at`) VALUES
(1, 66, 10000000.00, 'credit', 'approved', '111111111111111', '2026-01-23 08:25:35'),
(2, 66, 10000000.00, 'credit', 'rejected', '111111111111111', '2026-01-23 08:30:29'),
(3, 66, 10000000.00, 'credit', 'rejected', '111111111111111', '2026-01-23 08:30:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `login_id` (`login_id`),
  ADD KEY `customer_area_fk` (`area_id`);

--
-- Indexes for table `customer_reviews`
--
ALTER TABLE `customer_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `sp_id` (`sp_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `demo`
--
ALTER TABLE `demo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `order_master`
--
ALTER TABLE `order_master`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `sp_id` (`sp_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sp`
--
ALTER TABLE `sp`
  ADD PRIMARY KEY (`sp_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `login_id` (`login_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `sp_area_fk` (`area_id`);

--
-- Indexes for table `sp_service`
--
ALTER TABLE `sp_service`
  ADD PRIMARY KEY (`sp_id`,`service_id`),
  ADD KEY `sevice_id` (`service_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `updatetry`
--
ALTER TABLE `updatetry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD UNIQUE KEY `order_id` (`order_id`,`service_id`,`sp_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customer_reviews`
--
ALTER TABLE `customer_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `demo`
--
ALTER TABLE `demo`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=375;

--
-- AUTO_INCREMENT for table `order_master`
--
ALTER TABLE `order_master`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sp`
--
ALTER TABLE `sp`
  MODIFY `sp_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `updatetry`
--
ALTER TABLE `updatetry`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_city_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_area_fk` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`),
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`login_id`);

--
-- Constraints for table `customer_reviews`
--
ALTER TABLE `customer_reviews`
  ADD CONSTRAINT `customer_reviews_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `order_master`
--
ALTER TABLE `order_master`
  ADD CONSTRAINT `order_master_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `sp`
--
ALTER TABLE `sp`
  ADD CONSTRAINT `sp_area_fk` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`),
  ADD CONSTRAINT `sp_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`login_id`),
  ADD CONSTRAINT `sp_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`);

--
-- Constraints for table `sp_service`
--
ALTER TABLE `sp_service`
  ADD CONSTRAINT `sp_service_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`),
  ADD CONSTRAINT `sp_service_ibfk_2` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`),
  ADD CONSTRAINT `sp_service_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `user_order`
--
ALTER TABLE `user_order`
  ADD CONSTRAINT `user_order_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_master` (`order_id`),
  ADD CONSTRAINT `user_order_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`),
  ADD CONSTRAINT `user_order_ibfk_3` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`);

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"hs\",\"table\":\"city\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-01-16 02:48:53', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"en_GB\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

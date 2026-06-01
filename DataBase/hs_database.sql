-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hs
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB
--
-- CANONICAL SCHEMA: Use this file only for database setup and schema changes.
-- Fresh install: import this entire file into MySQL/MariaDB (database name: hs).
-- Do not rely on older SQL files in this folder (hs.sql, migrations, etc.).

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  PRIMARY KEY (`area_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `area_city_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (17,9,'Chakwal Tehsil'),(18,9,'Choa Saidan Shah Tehsil'),(19,9,'Kallar Kahar Tehsil'),(20,9,'Lawa Tehsil'),(21,9,'Talagang Tehsil'),(22,9,'Bhaun'),(23,9,'Bhagwal'),(24,9,'Bhon'),(25,9,'Bilalabad'),(26,9,'Budhial'),(27,9,'Danda Shah Bilawal'),(28,9,'Dharyala Kahoon'),(29,9,'Dhoda Town'),(30,9,'Dhudial'),(31,9,'Dulla'),(32,9,'Dulmial'),(33,9,'Jand Awan'),(34,9,'Kallar Kahar'),(35,9,'Khanpur'),(36,9,'Lawa'),(37,9,'Mulhal Mughlan'),(38,9,'Mureed'),(39,9,'Neela Dullah'),(40,9,'Ratta Sharif'),(41,9,'Sarkal kassar'),(42,9,'Sohawa'),(43,9,'Surhali'),(44,9,'Tamman'),(45,9,'Thaneel Kamal'),(46,9,'Ara'),(47,9,'Basharat'),(48,9,'Bheen'),(49,9,'Bhekarl Kalan'),(50,9,'Bigal'),(51,9,'Blokassar'),(52,9,'Chak Malook'),(53,9,'Chak Umra'),(54,9,'Choa Ganj Ali Shah'),(55,9,'Dab'),(56,9,'Dalwal Mah Badshah Pur'),(57,9,'Dandot'),(58,9,'Dhoular'),(59,9,'Dhumman'),(60,9,'Jabirpur'),(61,9,'Jand'),(62,9,'Karsal'),(63,9,'Karyala'),(64,9,'Khal'),(65,9,'Khair Pur'),(66,9,'Khotian'),(67,9,'Kot Chaudhrian'),(68,9,'Lehr Sultan Pur'),(69,9,'Mengan'),(70,9,'Mogla'),(71,9,'Odherwal'),(72,9,'Padshahan'),(73,9,'Salol'),(74,9,'Saral'),(75,9,'Warwal');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `category_id` int(5) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (84,'Cleaning'),(85,'Hair Services for Women'),(86,'Salon for Men'),(87,'Electricians'),(88,'Plumbers'),(89,'Carpenters');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `city_id` int(5) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,'Karachi'),(2,'Lahore'),(3,'Islamabad'),(4,'Rawalpindi'),(5,'Faisalabad'),(6,'Multan'),(7,'Peshawar'),(8,'Quetta'),(9,'Chakwal');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `customer_id` int(5) NOT NULL AUTO_INCREMENT,
  `login_id` int(5) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `city_id` int(5) DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `pincode` varchar(6) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  KEY `city_id` (`city_id`),
  KEY `login_id` (`login_id`),
  KEY `customer_area_fk` (`area_id`),
  CONSTRAINT `customer_area_fk` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (6,355,'Bilal','Khan','bilal.khan@gmail.com','8574587458','House 123, Street 4, F-10, Islamabad',1,'','589658',NULL),(14,371,'Muhammad','Saif','labpc4472@gmail.com','03192171693','mohallah baba chala walay',4,'Balkassar','48800',NULL);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_reviews`
--

DROP TABLE IF EXISTS `customer_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`review_id`),
  KEY `sp_id` (`sp_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_reviews_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`) ON DELETE CASCADE,
  CONSTRAINT `customer_reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_reviews`
--

LOCK TABLES `customer_reviews` WRITE;
/*!40000 ALTER TABLE `customer_reviews` DISABLE KEYS */;
INSERT INTO `customer_reviews` VALUES (1,66,14,30,5,'Hhhhhhh','2026-01-30 05:06:28',1),(2,66,14,30,5,'Yyhh','2026-01-30 05:06:43',1),(3,66,14,30,2,'Yyyy','2026-01-30 05:07:28',1);
/*!40000 ALTER TABLE `customer_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platform_reviews`
--

DROP TABLE IF EXISTS `platform_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platform_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`review_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `platform_reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platform_reviews`
--

LOCK TABLES `platform_reviews` WRITE;
/*!40000 ALTER TABLE `platform_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `platform_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo`
--

DROP TABLE IF EXISTS `demo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demo` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo`
--

LOCK TABLES `demo` WRITE;
/*!40000 ALTER TABLE `demo` DISABLE KEYS */;
INSERT INTO `demo` VALUES (1,'deep','0000-00-00 00:00:00'),(2,'deep','2023-02-26 03:33:40'),(3,'deep','2023-02-26 03:33:54');
/*!40000 ALTER TABLE `demo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `login_id` int(5) NOT NULL AUTO_INCREMENT,
  `role_id` int(5) DEFAULT NULL,
  `is_verified` int(11) DEFAULT 0,
  `verification_code` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `account_status` varchar(20) DEFAULT 'active',
  `activation_request` int(11) NOT NULL DEFAULT 0,
  `deletion_request` int(11) NOT NULL DEFAULT 0 COMMENT '1 = user requested account deletion, pending admin action',
  PRIMARY KEY (`login_id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `login_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=376 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (333,3,0,'','sahil','$2y$10$hZDAvmYRcGnL48FWoHH37O0Ey99EnX..Ce9ETd2yWxAum30Knb9o.',NULL,NULL,'active',0,0),(335,1,0,'','admin','$2y$10$pWIokr/4Rgvn3TFcuut5COx7ESOllbuLGdor/MLqCpmWqGF1srERy','0samsung7865@gmail.com',NULL,'active',0,0),(344,2,0,'','zain','$2y$10$KDhIPRf5qIYTmFJY2pVfYe/XF.DX8Cypctp4Q.qJeXgNwiamfaNAm',NULL,NULL,'active',0,0),(345,2,0,'','hamza','$2y$10$V7DsxOd9.mDjp9AEkGEtteL3QLojStmFFwmqo.l1RmSDbRuph8Amq',NULL,NULL,'active',0,0),(347,2,0,'','ali','$2y$10$Mu7fItaeU.Q1aMWek1LvjOEEL1Q/rFXnjkTL//uXMoreKFXJoExSi',NULL,NULL,'active',0,0),(351,2,0,'','omer','$2y$10$Se74K2TO57ZGEN79HFNy4e7qUJ/v1ePImeRLj9/E5sgPSQs7uwG6m',NULL,NULL,'active',0,0),(352,3,0,'','amit','$2y$10$LImF6t3d5pQMRTE8a3kyX.0XPqTK9L.8FTDIS4Z9BUwX75Hzss0DW',NULL,NULL,'active',0,0),(354,2,0,'','hassan','$2y$10$nQCTknPw7Y0ViSMNuWdwHORpdNcm5a9iLsIUyHDwGofxUG2p6.8mG',NULL,NULL,'active',0,0),(355,3,0,'','bilal','$2y$10$wXEeA6MNy13EsgQlF8G3w.fhZC4NCH2kEi0amMj9CdtTvU.ZiUsMO',NULL,NULL,'active',0,0),(362,2,0,'','ali_75','$2y$10$p/s2yCY9yUWMyetz5AF5VuMGMX89cUgvemGT4P.LmJNB8wAF7e7k.',NULL,NULL,'active',0,0),(366,3,0,'423220','test_12','$2y$10$hOI/4AkTsuaWztFbNt.J8u6d3MSnFjqMdaxHqafe68WApq6XPJiw2',NULL,NULL,'active',0,0),(371,3,1,'234943','test_1','$2y$10$AlYLhw2TJO812g3SQNYoMOZOrDWxTNG/e5jUC87FDN0PsZdaaiWQy',NULL,NULL,'active',0,0),(372,2,1,'928410','test_145','$2y$10$mmbn1keqgwij58Y9FBAKDOhQTGjQoEzN6.uJFV5PysUCTAKBQ/96q',NULL,NULL,'active',0,0);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_master`
--

DROP TABLE IF EXISTS `order_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_master` (
  `order_id` int(5) NOT NULL AUTO_INCREMENT,
  `customer_id` int(5) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(300) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `pay_mode` varchar(20) NOT NULL,
  `urgency_level` enum('normal','urgent','emergency') NOT NULL DEFAULT 'normal',
  `total` int(20) NOT NULL,
  `base_total` decimal(10,2) DEFAULT NULL,
  `dynamic_multiplier_total` decimal(8,4) DEFAULT NULL,
  `dynamic_breakdown` longtext DEFAULT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  KEY `fk_order_master_area` (`area_id`),
  CONSTRAINT `fk_order_master_area` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`) ON DELETE SET NULL,
  CONSTRAINT `order_master_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_master`
--

LOCK TABLES `order_master` WRITE;
/*!40000 ALTER TABLE `order_master` DISABLE KEYS */;
INSERT INTO `order_master` VALUES (8,6,'Bilal Khan','1234567890','23, swetapartk , pasodra, surat','123468',NULL,'COD','normal',1851,NULL,NULL,NULL,0.00,'2023-02-26 06:01:05','2023-03-08 18:01:00'),(23,6,'Bilal Khan','1234567890','C, 393, SHIVADHARA SOCIETY, MOTAVARACHHA, SURAT, GUJARAT','123456',NULL,'COD','normal',7276,NULL,NULL,NULL,0.00,'2023-03-01 11:44:12','2023-04-07 11:44:00'),(24,6,'Bilal Khan','8798767656','fndm','123456',NULL,'COD','normal',13604,NULL,NULL,NULL,0.00,'2023-03-01 01:32:50','2023-03-03 13:32:00'),(25,6,'Bilal Khan','8767675654','C-304, shivdhara camput, mahidharpura, ahmedabad.','123456',NULL,'COD','normal',748,NULL,NULL,NULL,0.00,'2023-03-28 12:25:02','2023-04-07 12:25:00'),(30,14,'Muhammad Saif','03192171693','mohallah baba chala wala','488000',NULL,'COD','normal',5250,NULL,NULL,NULL,525.00,'2026-01-23 02:03:36','2026-01-30 15:32:00'),(31,14,'Muhammad Saif','03192171693','mohallah baba chala wala','948800',NULL,'COD','normal',5250,NULL,NULL,NULL,525.00,'2026-01-23 02:36:55','2026-01-24 14:06:00'),(32,14,'Muhammad Saif','03192171693','mohallah baba chala wala','488009',NULL,'COD','normal',374,NULL,NULL,NULL,17.80,'2026-01-23 02:46:08','2026-01-31 14:16:00'),(33,14,'Muhammad Saif','03192171693','mohallah baba chala wala','488090',NULL,'COD','normal',0,NULL,NULL,NULL,0.00,'2026-01-23 02:46:18','2026-01-31 14:16:00'),(34,14,'Muhammad Saif','03192171693','Yyuuh','48800',NULL,'COD','normal',374,NULL,NULL,NULL,17.80,'2026-01-25 10:28:49','2026-01-24 09:44:00'),(35,14,'Muhammad Saif','03192171693','Jj','48800',NULL,'COD','normal',374,NULL,NULL,NULL,17.80,'2026-01-25 10:30:35','2026-01-28 10:05:00'),(36,14,'Muhammad Saif ','03192171693','Tyyu','48800',NULL,'COD','normal',748,NULL,NULL,NULL,35.60,'2026-01-25 12:51:57','2026-01-29 12:21:00');
/*!40000 ALTER TABLE `order_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricing_rules`
--

DROP TABLE IF EXISTS `pricing_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricing_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) DEFAULT NULL,
  `area_id` int(11) NOT NULL,
  `rule_type` enum('zone','time','demand','urgency','availability') NOT NULL DEFAULT 'zone',
  `multiplier` decimal(5,2) NOT NULL DEFAULT 1.00,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_pricing_rules_lookup` (`status`,`rule_type`,`area_id`,`service_id`),
  KEY `fk_pricing_rules_service` (`service_id`),
  KEY `fk_pricing_rules_area` (`area_id`),
  CONSTRAINT `fk_pricing_rules_area` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pricing_rules_service` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricing_rules`
--

LOCK TABLES `pricing_rules` WRITE;
/*!40000 ALTER TABLE `pricing_rules` DISABLE KEYS */;
INSERT INTO `pricing_rules` VALUES (1,NULL,17,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(2,NULL,18,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(3,NULL,19,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(4,NULL,20,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(5,NULL,21,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(6,NULL,22,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(7,NULL,23,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(8,NULL,24,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(9,NULL,25,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(10,NULL,26,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(11,NULL,27,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(12,NULL,28,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(13,NULL,29,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(14,NULL,30,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(15,NULL,31,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(16,NULL,32,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(17,NULL,33,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(18,NULL,34,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(19,NULL,35,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(20,NULL,36,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(21,NULL,37,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(22,NULL,38,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(23,NULL,39,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(24,NULL,40,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(25,NULL,41,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(26,NULL,42,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(27,NULL,43,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(28,NULL,44,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(29,NULL,45,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(30,NULL,46,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(31,NULL,47,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(32,NULL,48,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(33,NULL,49,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(34,NULL,50,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(35,NULL,51,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(36,NULL,52,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(37,NULL,53,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(38,NULL,54,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(39,NULL,55,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(40,NULL,56,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(41,NULL,57,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(42,NULL,58,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(43,NULL,59,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(44,NULL,60,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(45,NULL,61,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(46,NULL,62,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(47,NULL,63,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(48,NULL,64,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(49,NULL,65,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(50,NULL,66,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(51,NULL,67,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(52,NULL,68,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(53,NULL,69,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(54,NULL,70,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(55,NULL,71,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(56,NULL,72,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(57,NULL,73,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(58,NULL,74,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10'),(59,NULL,75,'zone',1.00,'active','Default zone multiplier','2026-05-08 15:07:10','2026-05-08 15:07:10');
/*!40000 ALTER TABLE `pricing_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(5) NOT NULL,
  `sp_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL,
  `rating` int(1) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`review_id`),
  KEY `customer_id` (`customer_id`),
  KEY `sp_id` (`sp_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`),
  CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(5) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'admin'),(2,'serviceprovider'),(3,'customer');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `service_id` int(5) NOT NULL AUTO_INCREMENT,
  `category_id` int(5) DEFAULT NULL,
  `service_name` varchar(50) DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `service_availibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`service_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `service_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (9,87,'Nal',0.00,0),(10,86,'Spice',0.00,1),(12,84,'Full Home Cleaning',2452.00,1),(13,84,'Sofa & Carpet Cleaning',1500.00,1),(14,85,'Trim & Style',350.00,1),(15,85,'Blowdry & Styling',0.00,1),(16,85,'Fashion Color',0.00,1),(18,85,'Cut & Style',250.00,1),(20,86,'Hair colour',2000.00,0),(21,86,'Relaxing Head Massage',600.00,1),(22,86,'Beard Shaping & Styling',0.00,0),(23,87,'Switch & Socket',150.00,0),(25,87,'Fan repairing',5000.00,1),(26,89,'Furniture',0.00,1),(27,84,'sofa cleaning',36.00,1),(28,88,'Basin & sink',3000.00,1),(29,88,'Grouting',1000.00,1),(30,88,'Bath fitting',309.00,1),(31,88,'Drainage pipes',609.50,1),(32,88,'Tap & Mixer',0.00,1),(33,88,'Water tank',0.00,1),(34,88,'Toilet',0.00,1),(35,84,'Funished apartment',2899.50,1),(36,84,'Unfunished apartment',0.00,1),(37,84,'Mini Services',1398.00,1),(38,89,'Table design',0.00,1),(39,84,'Room cleaning',900.00,1);
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'fuel_price','17');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp`
--

DROP TABLE IF EXISTS `sp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp` (
  `sp_id` int(5) NOT NULL AUTO_INCREMENT,
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
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sp_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  KEY `login_id` (`login_id`),
  KEY `city_id` (`city_id`),
  KEY `sp_area_fk` (`area_id`),
  CONSTRAINT `sp_area_fk` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`),
  CONSTRAINT `sp_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`login_id`),
  CONSTRAINT `sp_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp`
--

LOCK TABLES `sp` WRITE;
/*!40000 ALTER TABLE `sp` DISABLE KEYS */;
INSERT INTO `sp` VALUES (49,344,'Zain Malik','zain@gmail.com','8574857474','',16,'','857485','active',0.00,18),(50,345,'Hamza Ali','hamza@gmail.com','8574859655','',10,'','523652','active',0.00,18),(52,347,'Ali Ahmed','ali@gmail.com','9685741425','',15,'','541254','active',0.00,18),(56,351,'Omer Farooq','omer@gmail.com','9023964267','',1,'','382350','deactive',0.00,18),(57,354,'Hassan Raza','hassan@gmail.com','9687480417','',2,'','365006','active',2000.00,18),(66,372,'Muhammad Saif','0samsung7865@gmail.com','03192171693','222222222222',9,'Balkassar','48800','active',9996850.00,18);
/*!40000 ALTER TABLE `sp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_service`
--

DROP TABLE IF EXISTS `sp_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_service` (
  `sp_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `service_title` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `availability` tinyint(1) NOT NULL,
  PRIMARY KEY (`sp_id`,`service_id`),
  KEY `sevice_id` (`service_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `sp_service_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`),
  CONSTRAINT `sp_service_ibfk_2` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`),
  CONSTRAINT `sp_service_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_service`
--

LOCK TABLES `sp_service` WRITE;
/*!40000 ALTER TABLE `sp_service` DISABLE KEYS */;
INSERT INTO `sp_service` VALUES (49,21,86,'Body massage & Face detan','600','I provide body massage and also i have co-opperative staff',1),(49,29,88,'Kitchen type gap filling','1000','ΓÇó Grouting or tile gap filling of 1 kitchen\r\nΓÇó Materials like epoxy and grouting powder will be procured at additional cost.\r\n',1),(50,20,86,'Salon for men great','2000','i provide salon for men with style ',1),(50,28,88,'Basin - Quick & Reliable','3000','A clogged or leaky basin or sink can be a major inconvenience, but not with our quick and reliable plumbing service! Our team of experienced plumbers is equipped with the latest tools and techniques to fix any basin or sink problem efficiently and effectively. From unclogging drains to fixing leaks, we offer a range of plumbing services that are tailored to meet your specific needs. With our prompt and affordable service, you can get back to your routine in no time. Book your Basin & Sink Fix se',1),(50,30,88,'Balcony drain & blockage removal','309','Cleaning of drain & floor trap to removal blockage',1),(50,31,88,'Pipline','699','pipline clean & remove stuff from pipe',1),(52,12,84,'Kitching cleaning','356','dsbkajcd',1),(52,14,85,'Trim & Style - Glamorous Look','350','we offer a range of hair services that cater to your needs. Our salon uses only the best hair care products and tools to ensure that you leave looking and feeling your best. Book your Trim & Style service today and get ready to rock a glamorous look!',1),(52,18,85,'professional and stylish haircut','250','Short title: \"Trim & Style - Glamorous Look\"\r\n\r\nGig description:\r\nLooking for a professional and stylish haircut? Look no further than our Trim & Style service! Our experienced hairstylists will work with you to create a customized look that complements your features and suits your style.',1),(52,27,84,'dfvdf','36','ergvfx',1),(52,31,88,'pipeline solution ','520','ill try if ii found any pipeline mistake then a solve it',1),(52,35,84,'Bedroom Cleaning','799','Floor cleaning with single disc machine & vacuuming of mattress and curtains.',1),(52,37,84,'Occupied Kitchen cleaning','1398','Tough oil & grease removal from tiles, stove, slab, sink, exhaust, window, etc.',1),(56,12,84,'I Provide Full cleaning','5000','I provide full home cleaning with fully gerrenty',1),(56,23,87,'switch repairing','150','dsih  jiuozkspsueofreivjkdsv ioniuhkdkfoavAEPISUVhnqwpoeqouf,mzxnpsjfew',1),(57,12,84,'Complete Home Cleaning - Professional & Thorough','2000','Looking for a reliable and professional cleaning service that can give your entire home a thorough cleaning? Look no further than our Complete Home Cleaning service! Our experienced and skilled cleaners will deep clean every room in your home, leaving it spotless and fresh-smelling. We use only the best cleaning products and equipment to ensure that your home is not only clean but also safe and healthy. Book your cleaning today and enjoy a clean and comfortable home!',1),(57,13,84,'Fresh Home Cleaning','1500','Say goodbye to dirt and stains on your sofas and carpets with our professional cleaning service! Our team of experienced cleaners is equipped with state-of-the-art equipment and eco-friendly cleaning solutions to give your furniture and carpets a deep and refreshing clean.',1),(57,35,84,'Apartment Cleaning - Hassle-free','5000','Keeping a furnished apartment clean can be a daunting task, but not with our hassle-free cleaning service! We offer a thorough cleaning of every corner of your furnished apartment, ensuring that it remains clean and inviting for your guests.',1),(57,39,84,'Full Room cleaning','900','I am offering professional room cleaning. Whether you need your bedroom, living room, kitchen, or any other room in your home cleaned, I am here to help. My services include dusting, vacuuming, mopping, wiping surfaces, and removing trash. I pay attention to detail and ensure that every nook and corner is thoroughly cleaned. With my services, you can have a sparkling clean room that will leave you feeling refreshed and satisfied. Contact me to book your cleaning appointment today!',1),(66,25,87,'test_145','5000','test_1',1);
/*!40000 ALTER TABLE `sp_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `updatetry`
--

DROP TABLE IF EXISTS `updatetry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `updatetry` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `updatetry`
--

LOCK TABLES `updatetry` WRITE;
/*!40000 ALTER TABLE `updatetry` DISABLE KEYS */;
INSERT INTO `updatetry` VALUES (1,'Deep','Korat','deepkorat13@gmail.com'),(2,'jay','gabani','jaygabani@gmail.com'),(3,'sahil','patoliya','sahil@gmail.com');
/*!40000 ALTER TABLE `updatetry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_order`
--

DROP TABLE IF EXISTS `user_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_order` (
  `order_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `sp_id` int(5) NOT NULL,
  `service_title` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `final_price` decimal(10,2) DEFAULT NULL,
  `price_breakdown` longtext DEFAULT NULL,
  `qty` int(3) NOT NULL,
  `status` varchar(20) NOT NULL,
  UNIQUE KEY `order_id` (`order_id`,`service_id`,`sp_id`),
  KEY `service_id` (`service_id`),
  KEY `sp_id` (`sp_id`),
  CONSTRAINT `user_order_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_master` (`order_id`),
  CONSTRAINT `user_order_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`),
  CONSTRAINT `user_order_ibfk_3` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_order`
--

LOCK TABLES `user_order` WRITE;
/*!40000 ALTER TABLE `user_order` DISABLE KEYS */;
INSERT INTO `user_order` VALUES (8,12,52,'Kitching cleaning','356',NULL,NULL,NULL,1,'pending'),(8,23,56,'switch repairing','150',NULL,NULL,NULL,1,'pending'),(8,27,52,'dfvdf','36',NULL,NULL,NULL,1,'pending'),(8,29,49,'Kitchen type gap filling','1000',NULL,NULL,NULL,1,'pending'),(8,30,50,'Balcony drain & blockage removal','309',NULL,NULL,NULL,1,'completed'),(23,12,52,'Kitching cleaning','356',NULL,NULL,NULL,5,'pending'),(23,12,57,'Complete Home Cleaning - Professional & Thorough','2000',NULL,NULL,NULL,1,'completed'),(23,14,52,'Trim & Style - Glamorous Look','350',NULL,NULL,NULL,2,'pending'),(23,37,52,'Occupied Kitchen cleaning','1398',NULL,NULL,NULL,2,'pending'),(24,12,52,'Kitching cleaning','356',NULL,NULL,NULL,3,'pending'),(24,12,57,'Complete Home Cleaning - Professional & Thorough','2000',NULL,NULL,NULL,3,'completed'),(24,13,57,'Fresh Home Cleaning','1500',NULL,NULL,NULL,1,'rejected'),(24,27,52,'dfvdf','36',NULL,NULL,NULL,1,'pending'),(25,12,52,'Kitching cleaning','356',NULL,NULL,NULL,2,'pending'),(25,27,52,'dfvdf','36',NULL,NULL,NULL,1,'pending'),(30,25,66,'test_145','5000',NULL,NULL,NULL,1,'completed'),(31,25,66,'test_145','5000',NULL,NULL,NULL,1,'completed'),(32,12,52,'Kitching cleaning','356',NULL,NULL,NULL,1,'pending'),(34,12,52,'Kitching cleaning','356',NULL,NULL,NULL,1,'pending'),(35,12,52,'Kitching cleaning','356',NULL,NULL,NULL,1,'pending'),(36,12,52,'Kitching cleaning','356',NULL,NULL,NULL,2,'pending');
/*!40000 ALTER TABLE `user_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallet_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `manual_txn_id` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`transaction_id`),
  KEY `sp_id` (`sp_id`),
  CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
INSERT INTO `wallet_transactions` VALUES (1,66,10000000.00,'credit','approved','111111111111111',NULL,'2026-01-23 08:25:35'),(2,66,10000000.00,'credit','rejected','111111111111111',NULL,'2026-01-23 08:30:29'),(3,66,10000000.00,'credit','rejected','111111111111111',NULL,'2026-01-23 08:30:40');
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-08 18:22:10
--
-- ---------------------------------------------------------------------------
-- OPTIONAL: Upgrade an existing `hs` database (without full re-import)
-- Run only the lines you need if a column/table is already present.
-- ---------------------------------------------------------------------------
-- ALTER TABLE `login` ADD COLUMN `deletion_request` INT NOT NULL DEFAULT 0 AFTER `activation_request`;
-- ALTER TABLE `wallet_transactions` ADD COLUMN `description` VARCHAR(255) NULL AFTER `manual_txn_id`;
--
-- CREATE TABLE `platform_reviews` (
--   `review_id` int(11) NOT NULL AUTO_INCREMENT,
--   `customer_id` int(11) NOT NULL,
--   `rating` int(1) NOT NULL,
--   `review_text` text NOT NULL,
--   `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
--   PRIMARY KEY (`review_id`),
--   KEY `customer_id` (`customer_id`),
--   CONSTRAINT `platform_reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- ALTER TABLE `platform_reviews` ADD COLUMN `is_read` tinyint(1) NOT NULL DEFAULT 0;

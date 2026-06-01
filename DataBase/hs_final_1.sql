-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hs
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (6,355,'Bilal','Khan','bilal.khan@gmail.com','8574587458','House 123, Street 4, F-10, Islamabad',1,'','589658',NULL),(7,359,'Usman','Ahmed','usman.ahmed@gmail.com','9658741524','Flat 4, Clifton, Karachi',2,'','395225',NULL),(8,361,'Test','User','testuser@example.com','1234567890','Test House',1,'Test Area','123456',NULL);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
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
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`login_id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `login_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=362 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (333,3,'sahil','$2y$10$hZDAvmYRcGnL48FWoHH37O0Ey99EnX..Ce9ETd2yWxAum30Knb9o.'),(335,1,'admin','$2y$10$cN3ZSgu544VbF0U/Xk/96eEHlf.txlokPij7Qn5oe/dBAh2DrUwvO'),(344,2,'zain','$2y$10$KDhIPRf5qIYTmFJY2pVfYe/XF.DX8Cypctp4Q.qJeXgNwiamfaNAm'),(345,2,'hamza','$2y$10$V7DsxOd9.mDjp9AEkGEtteL3QLojStmFFwmqo.l1RmSDbRuph8Amq'),(347,2,'ali','$2y$10$Mu7fItaeU.Q1aMWek1LvjOEEL1Q/rFXnjkTL//uXMoreKFXJoExSi'),(351,2,'omer','$2y$10$Se74K2TO57ZGEN79HFNy4e7qUJ/v1ePImeRLj9/E5sgPSQs7uwG6m'),(352,3,'amit','$2y$10$LImF6t3d5pQMRTE8a3kyX.0XPqTK9L.8FTDIS4Z9BUwX75Hzss0DW'),(354,2,'hassan','$2y$10$nQCTknPw7Y0ViSMNuWdwHORpdNcm5a9iLsIUyHDwGofxUG2p6.8mG'),(355,3,'bilal','$2y$10$wXEeA6MNy13EsgQlF8G3w.fhZC4NCH2kEi0amMj9CdtTvU.ZiUsMO'),(358,2,'bilal_s','$2y$10$40EBg/w9DlFItbzn9X5a3uj44gZg8Xf2BTSeZD2YENvdRkeHzGxMO'),(359,3,'usman','$2y$10$DWwYtA3iYk.aOGW2z9oVEOp6XNJXWLWQ2fUvHKYtfAwKzWmzAVkJO'),(360,2,'msaif.47','$2y$10$tKNIxziV8nRv6i7J0nHScOOnCq57Ha3ULf6qIKsLMZg3eAMACBZ..'),(361,3,'testuser123','$2y$10$1F7kWUY6u3LqNbHkz0ybA.oj5oXEvnYef.CE9edUNZ2pizbs1UNv.');
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
  `pay_mode` varchar(20) NOT NULL,
  `total` int(20) NOT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `order_master_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_master`
--

LOCK TABLES `order_master` WRITE;
/*!40000 ALTER TABLE `order_master` DISABLE KEYS */;
INSERT INTO `order_master` VALUES (8,6,'Bilal Khan','1234567890','23, swetapartk , pasodra, surat','123468','COD',1851,0.00,'2023-02-26 06:01:05','2023-03-08 18:01:00'),(23,6,'Bilal Khan','1234567890','C, 393, SHIVADHARA SOCIETY, MOTAVARACHHA, SURAT, GUJARAT','123456','COD',7276,0.00,'2023-03-01 11:44:12','2023-04-07 11:44:00'),(24,6,'Bilal Khan','8798767656','fndm','123456','COD',13604,0.00,'2023-03-01 01:32:50','2023-03-03 13:32:00'),(25,6,'Bilal Khan','8767675654','C-304, shivdhara camput, mahidharpura, ahmedabad.','123456','COD',748,0.00,'2023-03-28 12:25:02','2023-04-07 12:25:00'),(26,7,'Usman Ahmed','9685748574','D-303, blackberry, apart. adajan, surat','852741','COD',5000,0.00,'2023-03-30 08:31:33','2023-04-01 20:31:00'),(27,7,'Usman Ahmed','1234567890','d-303, blackberry ,aprt, surat','123456','COD',5000,0.00,'2023-03-30 08:33:29','2023-04-07 20:33:00'),(28,7,'Usman Ahmed','1234567890','D-blackberry, apart, surat','123456','COD',5000,0.00,'2023-03-30 08:36:49','2023-04-08 20:36:00'),(29,8,'Test User','1234567890','Test Address House','123456','COD',2474,117.80,'2026-01-16 12:22:03','2024-12-25 10:30:00');
/*!40000 ALTER TABLE `order_master` ENABLE KEYS */;
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
INSERT INTO `service` VALUES (9,87,'Nal',0),(10,86,'Spice',1),(12,84,'Full Home Cleaning',1),(13,84,'Sofa & Carpet Cleaning',1),(14,85,'Trim & Style',1),(15,85,'Blowdry & Styling',1),(16,85,'Fashion Color',1),(18,85,'Cut & Style',1),(20,86,'Hair colour',0),(21,86,'Relaxing Head Massage',1),(22,86,'Beard Shaping & Styling',0),(23,87,'Switch & Socket',0),(25,87,'Fan repairing',1),(26,89,'Furniture',1),(27,84,'sofa cleaning',1),(28,88,'Basin & sink',1),(29,88,'Grouting',1),(30,88,'Bath fitting',1),(31,88,'Drainage pipes',1),(32,88,'Tap & Mixer',1),(33,88,'Water tank',1),(34,88,'Toilet',1),(35,84,'Funished apartment',1),(36,84,'Unfunished apartment',1),(37,84,'Mini Services',1),(38,89,'Table design',1),(39,84,'Room cleaning',1);
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
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
  `city_id` int(5) NOT NULL,
  `area` varchar(255) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `status` varchar(20) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp`
--

LOCK TABLES `sp` WRITE;
/*!40000 ALTER TABLE `sp` DISABLE KEYS */;
INSERT INTO `sp` VALUES (49,344,'Zain Malik','zain@gmail.com','8574857474',16,'','857485','active',NULL),(50,345,'Hamza Ali','hamza@gmail.com','8574859655',10,'','523652','active',NULL),(52,347,'Ali Ahmed','ali@gmail.com','9685741425',15,'','541254','active',NULL),(56,351,'Omer Farooq','omer@gmail.com','9023964267',1,'','382350','deactive',NULL),(57,354,'Hassan Raza','hassan@gmail.com','9687480417',2,'','365006','active',NULL),(60,358,'Bilal Siddiqui','bilal.s@gmail.com','1234567890',1,'','123456','deactive',NULL),(61,360,'Muhammad Saif','0samsung7865@gmail.com','03192171693',9,'Balkassar','48800','active',NULL);
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
INSERT INTO `sp_service` VALUES (49,21,86,'Body massage & Face detan','600','I provide body massage and also i have co-opperative staff',1),(49,29,88,'Kitchen type gap filling','1000','• Grouting or tile gap filling of 1 kitchen\r\n• Materials like epoxy and grouting powder will be procured at additional cost.\r\n',1),(50,20,86,'Salon for men great','2000','i provide salon for men with style ',1),(50,28,88,'Basin - Quick & Reliable','3000','A clogged or leaky basin or sink can be a major inconvenience, but not with our quick and reliable plumbing service! Our team of experienced plumbers is equipped with the latest tools and techniques to fix any basin or sink problem efficiently and effectively. From unclogging drains to fixing leaks, we offer a range of plumbing services that are tailored to meet your specific needs. With our prompt and affordable service, you can get back to your routine in no time. Book your Basin & Sink Fix se',1),(50,30,88,'Balcony drain & blockage removal','309','Cleaning of drain & floor trap to removal blockage',1),(50,31,88,'Pipline','699','pipline clean & remove stuff from pipe',1),(52,12,84,'Kitching cleaning','356','dsbkajcd',1),(52,14,85,'Trim & Style - Glamorous Look','350','we offer a range of hair services that cater to your needs. Our salon uses only the best hair care products and tools to ensure that you leave looking and feeling your best. Book your Trim & Style service today and get ready to rock a glamorous look!',1),(52,18,85,'professional and stylish haircut','250','Short title: \"Trim & Style - Glamorous Look\"\r\n\r\nGig description:\r\nLooking for a professional and stylish haircut? Look no further than our Trim & Style service! Our experienced hairstylists will work with you to create a customized look that complements your features and suits your style.',1),(52,27,84,'dfvdf','36','ergvfx',1),(52,31,88,'pipeline solution ','520','ill try if ii found any pipeline mistake then a solve it',1),(52,35,84,'Bedroom Cleaning','799','Floor cleaning with single disc machine & vacuuming of mattress and curtains.',1),(52,37,84,'Occupied Kitchen cleaning','1398','Tough oil & grease removal from tiles, stove, slab, sink, exhaust, window, etc.',1),(56,12,84,'I Provide Full cleaning','5000','I provide full home cleaning with fully gerrenty',1),(56,23,87,'switch repairing','150','dsih  jiuozkspsueofreivjkdsv ioniuhkdkfoavAEPISUVhnqwpoeqouf,mzxnpsjfew',1),(57,12,84,'Complete Home Cleaning - Professional & Thorough','2000','Looking for a reliable and professional cleaning service that can give your entire home a thorough cleaning? Look no further than our Complete Home Cleaning service! Our experienced and skilled cleaners will deep clean every room in your home, leaving it spotless and fresh-smelling. We use only the best cleaning products and equipment to ensure that your home is not only clean but also safe and healthy. Book your cleaning today and enjoy a clean and comfortable home!',1),(57,13,84,'Fresh Home Cleaning','1500','Say goodbye to dirt and stains on your sofas and carpets with our professional cleaning service! Our team of experienced cleaners is equipped with state-of-the-art equipment and eco-friendly cleaning solutions to give your furniture and carpets a deep and refreshing clean.',1),(57,35,84,'Apartment Cleaning - Hassle-free','5000','Keeping a furnished apartment clean can be a daunting task, but not with our hassle-free cleaning service! We offer a thorough cleaning of every corner of your furnished apartment, ensuring that it remains clean and inviting for your guests.',1),(57,39,84,'Full Room cleaning','900','I am offering professional room cleaning. Whether you need your bedroom, living room, kitchen, or any other room in your home cleaned, I am here to help. My services include dusting, vacuuming, mopping, wiping surfaces, and removing trash. I pay attention to detail and ensure that every nook and corner is thoroughly cleaned. With my services, you can have a sparkling clean room that will leave you feeling refreshed and satisfied. Contact me to book your cleaning appointment today!',1);
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
INSERT INTO `user_order` VALUES (8,12,52,'Kitching cleaning','356',1,'pending'),(8,23,56,'switch repairing','150',1,'pending'),(8,27,52,'dfvdf','36',1,'pending'),(8,29,49,'Kitchen type gap filling','1000',1,'pending'),(8,30,50,'Balcony drain & blockage removal','309',1,'completed'),(23,12,52,'Kitching cleaning','356',5,'pending'),(23,12,57,'Complete Home Cleaning - Professional & Thorough','2000',1,'completed'),(23,14,52,'Trim & Style - Glamorous Look','350',2,'pending'),(23,37,52,'Occupied Kitchen cleaning','1398',2,'pending'),(24,12,52,'Kitching cleaning','356',3,'pending'),(24,12,57,'Complete Home Cleaning - Professional & Thorough','2000',3,'completed'),(24,13,57,'Fresh Home Cleaning','1500',1,'rejected'),(24,27,52,'dfvdf','36',1,'pending'),(25,12,52,'Kitching cleaning','356',2,'pending'),(25,27,52,'dfvdf','36',1,'pending'),(26,35,57,'Apartment Cleaning - Hassle-free','5000',1,'pending'),(27,35,57,'Apartment Cleaning - Hassle-free','5000',1,'completed'),(28,35,57,'Apartment Cleaning - Hassle-free','5000',1,'pending'),(29,12,52,'Kitching cleaning','356',1,'pending'),(29,29,49,'Kitchen type gap filling','1000',2,'pending');
/*!40000 ALTER TABLE `user_order` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-16 12:02:21

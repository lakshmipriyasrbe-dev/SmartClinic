-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: smart_clinic_07052026
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
-- Table structure for table `sc_appointment`
--

DROP TABLE IF EXISTS `sc_appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `appointment_id` mediumtext DEFAULT NULL,
  `consultant_id` mediumtext DEFAULT NULL,
  `consultan_name` mediumtext DEFAULT NULL,
  `consultant_fees` int(11) NOT NULL DEFAULT 0,
  `appointment_date` datetime DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `patient_name` mediumtext DEFAULT NULL,
  `patient_number` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `status` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_appointment`
--

LOCK TABLES `sc_appointment` WRITE;
/*!40000 ALTER TABLE `sc_appointment` DISABLE KEYS */;
INSERT INTO `sc_appointment` VALUES (1,'2026-05-07 17:38:57','2026-05-07 17:38:57','c0hJY0NzNXFMeE5VZWJ3RUtJc3RzMUdtYzlkR0xPQlVnM292ZU1weGNWQT0=','SFRZTnNwZE1rV3dsZlRUSkM3UFBNN3hBZlNoZmhQZFQ0ckcwKzVvRzZKUT0=','Dr Aswanth',500,'2026-05-07 21:00:00',NULL,'Kumar','',NULL,0,'Confirmed'),(2,'2026-05-07 17:39:46','2026-05-07 17:39:46','RE53ejhnamRDQ2N5QldCTVMreEwzbzhKNUw2aWdZUUZvYVNYakFWOElIST0=','SFRZTnNwZE1rV3dsZlRUSkM3UFBNN3hBZlNoZmhQZFQ0ckcwKzVvRzZKUT0=','Dr Aswanth',500,'2026-05-07 17:40:00',NULL,'test','',NULL,0,'Confirmed'),(3,'2026-05-07 17:40:07','2026-05-07 17:40:07','cTlwR09EKzA2b3E0enlJdmJ1YVY5dEkvek90bnJRSVFmSERYZkJhempaQT0=','WVdRTUpjMnFJTnJicENqUlNGM1ZPZklmTEZnUVIvQUdUTW10RlVBYUdhcz0=','Dr Atchaya',800,'2026-05-14 12:00:00',NULL,'check','',NULL,0,'Confirmed'),(4,'2026-05-07 17:40:43','2026-05-07 17:40:52','VEEwNzQyMG5HODRZdTNpWHFXeUxtOFpEeENrYVBmYXhXSzlIRWtYUHFHND0=','SFRZTnNwZE1rV3dsZlRUSkM3UFBNN3hBZlNoZmhQZFQ0ckcwKzVvRzZKUT0=','Dr Aswanth',500,'2026-05-07 17:45:00',NULL,'priya','',NULL,0,'Attended');
/*!40000 ALTER TABLE `sc_appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_company`
--

DROP TABLE IF EXISTS `sc_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` mediumtext DEFAULT NULL,
  `company_name` mediumtext DEFAULT NULL,
  `company_email` mediumtext DEFAULT NULL,
  `company_address` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_date_time` mediumtext DEFAULT NULL,
  `updated_date_time` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_company`
--

LOCK TABLES `sc_company` WRITE;
/*!40000 ALTER TABLE `sc_company` DISABLE KEYS */;
INSERT INTO `sc_company` VALUES (1,'SUIrdEx2TXBFSnhheW1iNzZQcHN4VE5NWkdhbVc1NkxPUTI1UHR2Z3FMWT0=','Smart Clinic','contact@smartclinic.com','234, Chellam mall, Sivakasi - 626332',0,'2026-05-07 17:35:51','2026-05-07 17:36:00');
/*!40000 ALTER TABLE `sc_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_consultant`
--

DROP TABLE IF EXISTS `sc_consultant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_consultant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `consultant_id` mediumtext DEFAULT NULL,
  `consultan_name` mediumtext DEFAULT NULL,
  `consultant_fees` int(11) NOT NULL DEFAULT 0,
  `consultant_specification` mediumtext DEFAULT NULL,
  `consultant_number` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_consultant`
--

LOCK TABLES `sc_consultant` WRITE;
/*!40000 ALTER TABLE `sc_consultant` DISABLE KEYS */;
INSERT INTO `sc_consultant` VALUES (1,'2026-05-07 17:36:59','2026-05-07 17:37:51','SFRZTnNwZE1rV3dsZlRUSkM3UFBNN3hBZlNoZmhQZFQ0ckcwKzVvRzZKUT0=','Dr Aswanth',500,'Cardiology','8787878787',0),(2,'2026-05-07 17:37:41','2026-05-07 17:37:41','WVdRTUpjMnFJTnJicENqUlNGM1ZPZklmTEZnUVIvQUdUTW10RlVBYUdhcz0=','Dr Atchaya',800,'Neurology ','8787878787',0),(3,'2026-05-07 17:38:07','2026-05-07 17:38:10','bjI3MjU3S09zRVdGSFJ0czBERFJaNk8wZDFFWnk4QWo4Mnl3bXRKVlIzZz0=','test',444,'cxmvnmcxv','7958938579',1);
/*!40000 ALTER TABLE `sc_consultant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_login`
--

DROP TABLE IF EXISTS `sc_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_date_time` datetime DEFAULT NULL,
  `logout_date_time` datetime DEFAULT NULL,
  `user_id` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_login`
--

LOCK TABLES `sc_login` WRITE;
/*!40000 ALTER TABLE `sc_login` DISABLE KEYS */;
INSERT INTO `sc_login` VALUES (1,'2026-05-07 17:35:09',NULL,'1',0);
/*!40000 ALTER TABLE `sc_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_user`
--

DROP TABLE IF EXISTS `sc_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `user_id` mediumtext DEFAULT NULL,
  `loginer_name` mediumtext DEFAULT NULL,
  `user_mobile` mediumtext DEFAULT NULL,
  `username` mediumtext DEFAULT NULL,
  `password` mediumtext DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_user`
--

LOCK TABLES `sc_user` WRITE;
/*!40000 ALTER TABLE `sc_user` DISABLE KEYS */;
INSERT INTO `sc_user` VALUES (1,'2026-05-07 17:34:40','2026-05-07 17:34:40','YjFPYmwyYmppWkJZeHlzc2s3b2hiMEZUeHd2bXZCS1RiOVVweTczV2VQdz0=','Aswanth','9834758784','Aswanth','eC9QaHBrdFdvSXBGWVh3bHZZRmhxdz09',1,0);
/*!40000 ALTER TABLE `sc_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-07 17:58:41

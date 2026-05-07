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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_appointment`
--

LOCK TABLES `sc_appointment` WRITE;
/*!40000 ALTER TABLE `sc_appointment` DISABLE KEYS */;
INSERT INTO `sc_appointment` VALUES (1,'2026-05-07 16:28:30','2026-05-07 16:28:30','NUs5ZThmcThUMjNYREN1aVVSTE1pZnhPczlBRE05dXdITmVyK0ZkazBOZz0=','RHBESnhwVGpURGlkQmZyRmIra0lnd0p0SzI0TlYwK1JYWklSQitad2R4ST0=','Kumar',500,'2026-05-08 16:00:00',NULL,'Lakshmi','',NULL,0,'Confirmed'),(2,'2026-05-07 16:31:26','2026-05-07 16:50:14','MWM5UEV6bGx4YTBqR2s2bWUxRFlJenpzWUhxRjdieVNXNTB4Ni8vT21rOD0=','RHBESnhwVGpURGlkQmZyRmIra0lnd0p0SzI0TlYwK1JYWklSQitad2R4ST0=','Kumar',500,'2026-05-08 18:00:00',NULL,'Selvi','',NULL,0,'Attended'),(3,'2026-05-07 16:41:59','2026-05-07 16:42:07','R3J6K2JxNThydEpiNmMyRWozcXhYVEtOdjRMQ0VmcmFmT2dBZ0NFQ3p3Zz0=','a2p2OUxTdC8raldIUVphNkt0Sno3ZE1wUUczQ1EyRW00TmdwVytXajZZdz0=','Priya',600,'2026-05-21 12:00:00',NULL,'zxczxc','',NULL,1,'Confirmed');
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
INSERT INTO `sc_company` VALUES (1,'UXJsazN1UTB3R3BXOVpSSUYyaWN6ckdMSFBTdEszaHBPQ0czTEYzR1NaZz0=','Smart Clinic','contact@smartclinic.com','224, Chellammal mall, Sivakasi - 626130',0,'2026-05-07 17:18:07','2026-05-07 17:19:02');
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
INSERT INTO `sc_consultant` VALUES (1,'2026-05-07 15:57:01','2026-05-07 16:03:08','RHBESnhwVGpURGlkQmZyRmIra0lnd0p0SzI0TlYwK1JYWklSQitad2R4ST0=','Kumar',500,'Heart Specialist','9898989877',0),(2,'2026-05-07 16:03:49','2026-05-07 16:03:59','a2p2OUxTdC8raldIUVphNkt0Sno3ZE1wUUczQ1EyRW00TmdwVytXajZZdz0=','Priya',600,'Nuerology','8989898989',0),(3,'2026-05-07 17:01:29','2026-05-07 17:01:34','amFLZk1GTWxvNVlCSGE2RGtzZUptaEJzZXlBRk5rditDN2ZzRG5CMms0RT0=','test',700,'sdfjdsfjkds','9876654321',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_login`
--

LOCK TABLES `sc_login` WRITE;
/*!40000 ALTER TABLE `sc_login` DISABLE KEYS */;
INSERT INTO `sc_login` VALUES (1,'2026-05-07 15:15:19',NULL,'1',0),(2,'2026-05-07 17:07:06',NULL,'1',0),(3,'2026-05-07 17:10:03',NULL,'1',0);
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
INSERT INTO `sc_user` VALUES (1,'2026-05-07 15:15:09','2026-05-07 15:15:09','Q3hTRUltaGdYdFBJeUlPZkpocU45S3JvNWprZUhHYStkNmZFTS9rc3FQQT0=','Lakshmi','9790552539','Lakshmi','REE1S0FoVVVWY2tGYTNYZCtSV3VNQT09',1,0);
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

-- Dump completed on 2026-05-07 17:21:35

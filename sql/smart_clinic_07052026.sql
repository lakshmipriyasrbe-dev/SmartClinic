-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 07:47 AM
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
-- Database: `smart_clinic_07052026`
--

-- --------------------------------------------------------

--
-- Table structure for table `sc_appointment`
--

CREATE TABLE `sc_appointment` (
  `id` int(11) NOT NULL,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `appointment_id` mediumtext DEFAULT NULL,
  `consultant_id` mediumtext DEFAULT NULL,
  `consultan_name` mediumtext DEFAULT NULL,
  `consultant_fees` int(11) NOT NULL DEFAULT 0,
  `appointment_date` datetime DEFAULT NULL,
  `patient_name` mediumtext DEFAULT NULL,
  `patient_number` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sc_company`
--

CREATE TABLE `sc_company` (
  `id` int(11) NOT NULL,
  `company_name` mediumtext DEFAULT NULL,
  `company_email` mediumtext DEFAULT NULL,
  `company_address` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_date_time` mediumtext DEFAULT NULL,
  `updated_date_time` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sc_consultant`
--

CREATE TABLE `sc_consultant` (
  `id` int(11) NOT NULL,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `consultant_id` mediumtext DEFAULT NULL,
  `consultan_name` mediumtext DEFAULT NULL,
  `consultant_fees` int(11) NOT NULL DEFAULT 0,
  `consultant_specification` mediumtext DEFAULT NULL,
  `consultant_number` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sc_login`
--

CREATE TABLE `sc_login` (
  `id` int(11) NOT NULL,
  `login_date_time` datetime DEFAULT NULL,
  `logout_date_time` datetime DEFAULT NULL,
  `user_id` mediumtext DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sc_user`
--

CREATE TABLE `sc_user` (
  `id` int(11) NOT NULL,
  `created_date_time` int(11) DEFAULT NULL,
  `updated_date_time` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `loginer_name` int(11) DEFAULT NULL,
  `user_mobile` int(11) DEFAULT NULL,
  `username` int(11) DEFAULT NULL,
  `password` int(11) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sc_company`
--
ALTER TABLE `sc_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sc_login`
--
ALTER TABLE `sc_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sc_user`
--
ALTER TABLE `sc_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sc_company`
--
ALTER TABLE `sc_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sc_login`
--
ALTER TABLE `sc_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sc_user`
--
ALTER TABLE `sc_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

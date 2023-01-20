-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: db5010816561.hosting-data.io
-- Generation Time: Jan 20, 2023 at 07:38 AM
-- Server version: 8.0.26
-- PHP Version: 7.0.33-0+deb9u12

--SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
--SET AUTOCOMMIT = 0;
--START TRANSACTION;
--SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbs9150826`
--

-- --------------------------------------------------------

--
-- Table structure for table `win_ten`
--

--CREATE TABLE `win_ten` (
--  `id` int NOT NULL,
--  `item` varchar(10000) COLLATE utf8mb4_general_ci NOT NULL
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `win_ten`
--

INSERT INTO `win_ten` (`item`) VALUES
('Enable hidden files and file extensions in file system view options <a href=\"#filesystem\">File System</a>'),
('Enable the firewall <a href=\"#network\">Network Security</a>'),
('Enable/verify antivirus is running <a href=\"#gpo\">Global Domain Policy</a>'),
('Enable/verify that Windows Event Log service is running (services.msc) <a href=\"#services\">Services & Processes</a>'),
('Enable/verify Windows Update service/Software Updates are running.  (START SYSTEM UPDATES) <a href=\"#software\">System Updates &amp; Software</a>'),
('EVALUATE THE FORENSIC QUESTIONS\r\n        Forensic question generally asks for a directory where an unauthorized file or user was found. Check FORENSICS before removing anything!\r\n        DON\'T get bogged down in the forensics, but be careful not to delete evidence!'),
('SAVE EVIDENCE. If a file, immediately make a copy of the forensic file and place on the host system so we don\'t forget'),
('create a text file containing authorized users from the README'),
('Remove unauthorized users <a href=\"#lusrmgr\">Local User Management</a>'),
('Add any missing authorized users <a href=\"#lusrmgr\">Local User Management</a>'),
('Remove non-admins from admin group/set them to standard user <a href=\"#lusrmgr\">Local User Management</a>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `win_ten`
--

--ALTER TABLE `win_ten`
--  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `win_ten`
--

--ALTER TABLE `win_ten`
--  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
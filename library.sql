-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 03, 2024 at 08:07 AM
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
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(200) NOT NULL,
  `publication_year` int(4) NOT NULL,
  `book_cover` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publication_year`, `book_cover`, `created_at`) VALUES
(1, 'Under The Whispering Door', 'TJ klune', 2021, 'underthewhisperingDoor.jpeg', '2024-07-03 05:40:21'),
(2, 'MRS.Dalloway', 'Virginia Woolf', 1925, 'mrsdollway.jpeg', '2024-07-03 05:45:16'),
(3, 'Manjuveyil Maranagal', 'Benyamin', 2011, 'mannuveyilmananagal.jpeg', '2024-07-03 05:47:53'),
(4, 'Looking For Alaska', 'John Green', 2005, 'lookingforalaska.jpeg', '2024-07-03 05:50:25'),
(5, 'Neermathalam Pootha Kaalam', 'Madavikutty', 1993, 'madavikutty.jpeg', '2024-07-03 05:53:34'),
(6, 'The Great Gatsby', 'F.Scott Fitzgeraild', 1925, 'thegreatgatsby.jpeg', '2024-07-03 06:03:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

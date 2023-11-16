-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 03:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ws_leaderboard`
--
CREATE DATABASE IF NOT EXISTS `ws_leaderboard` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ws_leaderboard`;

-- --------------------------------------------------------

--
-- Table structure for table `all_time_lb`
--

CREATE TABLE `all_time_lb` (
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Player` varchar(15) NOT NULL,
  `Score` int(11) NOT NULL,
  `theme` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_time_lb`
--

INSERT INTO `all_time_lb` (`time_stamp`, `Player`, `Score`, `theme`) VALUES
('2023-11-03 17:38:47', 'Cameron', 1000, 'animals'),
('2023-11-03 17:38:47', 'Zoe', 800, 'animals'),
('2023-11-03 17:38:47', 'Mel', 600, 'animals'),
('2023-11-03 17:38:47', 'Cruz', 400, 'animals'),
('2023-11-03 17:38:47', 'Ethan', 200, 'animals');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

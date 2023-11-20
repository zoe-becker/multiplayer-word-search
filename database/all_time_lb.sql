-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 06:39 AM
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
  `theme` char(255) DEFAULT NULL,
  `mode` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_time_lb`
--

INSERT INTO `all_time_lb` (`time_stamp`, `Player`, `Score`, `theme`, `mode`) VALUES
('2023-11-03 17:38:47', 'Cameron', 1000, 'animals', 'multiplayer'),
('2023-11-03 17:38:47', 'Zoe', 800, 'animals', 'multiplayer'),
('2023-11-03 17:38:47', 'Mel', 600, 'animals', 'multiplayer'),
('2023-11-03 17:38:47', 'Cruz', 400, 'animals', 'multiplayer'),
('2023-11-03 17:38:47', 'Ethan', 200, 'animals', 'multiplayer'),
('2023-11-03 17:38:47', 'Cruz', 1200, 'christmas', 'multiplayer'),
('2023-11-03 17:38:47', 'Ethan', 800, 'christmas', 'multiplayer'),
('2023-11-03 17:38:47', 'Mel', 750, 'christmas', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 550, 'christmas', 'multiplayer'),
('2023-11-03 17:38:47', 'Zoe', 400, 'christmas', 'multiplayer'),
('2023-11-03 17:38:47', 'Ethan', 9999, 'nicki', 'multiplayer'),
('2023-11-03 17:38:47', 'Mel', 4500, 'nicki', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 1600, 'nicki', 'multiplayer'),
('2023-11-03 17:38:47', 'Zoe', 800, 'nicki', 'multiplayer'),
('2023-11-03 17:38:47', 'Cruz', 350, 'nicki', 'multiplayer'),
('2023-11-03 17:38:47', 'Zoe', 3600, 'halloween', 'multiplayer'),
('2023-11-03 17:38:47', 'Mel', 800, 'halloween', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 1450, 'halloween', 'multiplayer'),
('2023-11-03 17:38:47', 'Ethan', 750, 'halloween', 'multiplayer'),
('2023-11-03 17:38:47', 'Cruz', 200, 'halloween', 'multiplayer'),
('2023-11-03 17:38:47', 'Mel', 2000, 'thanksgiving', 'multiplayer'),
('2023-11-03 17:38:47', 'Zoe', 1995, 'thanksgiving', 'multiplayer'),
('2023-11-03 17:38:47', 'Ethan', 1005, 'thanksgiving', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 1989, 'thanksgiving', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 500, 'thanksgiving', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 900, 'valentine', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 850, 'valentine', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 1005, 'valentine', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 1337, 'valentine', 'multiplayer'),
('2023-11-03 17:38:47', 'Cameron', 260, 'valentine', 'multiplayer'),
('2023-11-19 23:47:56', 'cruz', 2534, NULL, 'multiplayer'),
('2023-11-19 23:47:56', 'Alice', 8973, 'valentine', 'timeattack'),
('2023-11-19 23:47:56', 'Bob', 6543, 'valentine', 'timeattack'),
('2023-11-19 23:47:56', 'Charlie', 7254, 'valentine', 'timeattack'),
('2023-11-19 23:47:56', 'Diana', 8032, 'valentine', 'timeattack'),
('2023-11-19 23:47:56', 'Ethan', 9120, 'valentine', 'timeattack'),
('2023-11-19 23:47:56', 'Fiona', 8675, 'thanksgiving', 'timeattack'),
('2023-11-19 23:47:56', 'George', 7821, 'thanksgiving', 'timeattack'),
('2023-11-19 23:47:56', 'Hannah', 6432, 'thanksgiving', 'timeattack'),
('2023-11-19 23:47:56', 'Ian', 7598, 'thanksgiving', 'timeattack'),
('2023-11-19 23:47:56', 'Julia', 8210, 'thanksgiving', 'timeattack'),
('2023-11-19 23:47:56', 'Kevin', 6882, 'halloween', 'timeattack'),
('2023-11-19 23:47:56', 'Laura', 7256, 'halloween', 'timeattack'),
('2023-11-19 23:47:56', 'Mike', 8004, 'halloween', 'timeattack'),
('2023-11-19 23:47:56', 'Nina', 6987, 'halloween', 'timeattack'),
('2023-11-19 23:47:56', 'Oscar', 8312, 'halloween', 'timeattack'),
('2023-11-19 23:47:56', 'Patricia', 9124, 'nicki', 'timeattack'),
('2023-11-19 23:47:56', 'Quincy', 7651, 'nicki', 'timeattack'),
('2023-11-19 23:47:56', 'Rachel', 6823, 'nicki', 'timeattack'),
('2023-11-19 23:47:56', 'Sam', 8094, 'nicki', 'timeattack'),
('2023-11-19 23:47:56', 'Tina', 7378, 'nicki', 'timeattack'),
('2023-11-19 23:47:56', 'Uma', 8532, 'christmas', 'timeattack'),
('2023-11-19 23:47:56', 'Victor', 6914, 'christmas', 'timeattack'),
('2023-11-19 23:47:56', 'Wendy', 7205, 'christmas', 'timeattack'),
('2023-11-19 23:47:56', 'Xavier', 8842, 'christmas', 'timeattack'),
('2023-11-19 23:47:56', 'Yolanda', 7603, 'christmas', 'timeattack'),
('2023-11-19 23:47:56', 'Zach', 6987, 'animals', 'timeattack'),
('2023-11-19 23:47:56', 'Amelia', 8123, 'animals', 'timeattack'),
('2023-11-19 23:47:56', 'Brad', 7645, 'animals', 'timeattack'),
('2023-11-19 23:47:56', 'Cindy', 6874, 'animals', 'timeattack'),
('2023-11-19 23:47:56', 'David', 8531, 'animals', 'timeattack'),
('2023-11-20 03:56:50', 'cruz', 5738, NULL, NULL),
('2023-11-12 23:47:56', 'WRONG', 15000, 'animals', 'timeattack'), /* These values should never show up.*/
('2023-11-12 23:47:56', 'WRONG', 16000, 'animals', 'timeattack'),
('2023-11-12 23:47:56', 'WRONG', 17000, 'animals', 'timeattack'),
('2023-11-12 23:47:56', 'WRONG', 18000, 'animals', 'timeattack'),
('2023-11-12 23:47:56', 'WRONG', 19000, 'animals', 'timeattack');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

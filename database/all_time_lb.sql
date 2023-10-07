-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2023 at 01:06 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `all_time_lb`
--

CREATE TABLE `all_time_lb` (
  `Player` varchar(15) NOT NULL,
  `Score` int(11) NOT NULL,
  `Date` date NOT NULL,
  `game_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_time_lb`
--

INSERT INTO `all_time_lb` (`Player`, `Score`, `Date`, `game_time`) VALUES
('Cameron', 1000, '2023-06-10', '00:12:00'),
('Zoe', 800, '2023-06-10', '00:12:00'),
('Mel', 600, '2023-06-10', '00:12:00'),
('Cruz', 400, '2023-06-10', '00:12:00'),
('Ethan', 200, '2023-06-10', '00:12:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

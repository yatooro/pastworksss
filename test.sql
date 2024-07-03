-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2023 at 02:19 AM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `incoming` decimal(10,2) NOT NULL,
  `outgoing` decimal(10,2) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `fundsource` varchar(50) DEFAULT NULL,
  `total_balance` decimal(10,2) NOT NULL,
  `petty_cash` decimal(10,2) NOT NULL,
  `revolving_fund` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `description`, `incoming`, `outgoing`, `category`, `fundsource`, `total_balance`, `petty_cash`, `revolving_fund`) VALUES
(125, '2023-07-24', 'a4 paper', 0.00, 120.00, 'office/supplies', 'pettycash', 10880.00, 7000.00, 4000.00),
(126, '2023-07-24', 'pen', 0.00, 50.00, 'office/supplies', 'pettycash', 10950.00, 7000.00, 4000.00),
(127, '2023-07-24', 'a4 paper', 0.00, 120.00, 'office/supplies', 'pettycash', 10880.00, 7000.00, 4000.00),
(128, '2023-07-24', 'a4 paper', 0.00, 120.00, 'office/supplies', 'pettycash', 11000.00, 7000.00, 4000.00),
(129, '2023-07-24', 'pen', 0.00, 50.00, 'office/supplies', 'pettycash', 10950.00, 6950.00, 4000.00),
(130, '2023-07-24', 'replenishment', 5000.00, 0.00, 'replenishment', 'revolvingfunds', 15950.00, 6950.00, 9000.00),
(131, '2023-07-24', 'PLDT BILL', 0.00, 3000.00, 'bills', 'pettycash', 12950.00, 3950.00, 9000.00),
(132, '2023-07-24', 'a4 paper', 0.00, 120.00, 'office/supplies', 'pettycash', 13880.00, 4880.00, 9000.00),
(133, '2023-07-24', 'pen', 0.00, 100.00, 'office/supplies', 'pettycash', 13780.00, 4780.00, 9000.00),
(134, '2023-07-25', 'a4 paper', 0.00, 120.00, 'office/supplies', 'pettycash', 4880.00, 2880.00, 2000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

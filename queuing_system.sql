-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2023 at 12:15 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `queuing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `queue_data`
--

CREATE TABLE `queue_data` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_type` varchar(255) NOT NULL,
  `choose_service` varchar(255) DEFAULT NULL,
  `payment_for` varchar(255) DEFAULT NULL,
  `mode_of_payment` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Waiting',
  `arrival_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_data`
--

INSERT INTO `queue_data` (`id`, `customer_name`, `customer_type`, `choose_service`, `payment_for`, `mode_of_payment`, `email`, `status`, `arrival_time`) VALUES
(59, 'Employee Kurt', 'Regular', 'Payment', 'Tuition', 'Card/QR Scan', 'kabbs2701@gmail.com', 'Served', '2023-11-01 09:45:45'),
(60, 'kabbs', 'Priority', 'Payment', 'Tuition', 'Card/QR Scan', 'kabbs2701@gmail.com', 'Served', '2023-11-01 09:48:02'),
(61, 'ticala', 'Regular', 'Payment', 'Tuition', 'Cash', 'kurtcabbs@gmail.com', 'Served', '2023-11-01 09:48:30'),
(62, 'shyan', 'Regular', 'Claiming of Receipt', 'Other School Activities and Fees', 'Card/QR Scan', 'kurtcabbs@gmail.com', 'Served', '2023-11-01 09:49:05'),
(63, 'KabbCess', 'Priority', 'Claiming of Receipt', 'Books and Uniforms', 'Card/QR Scan', 'kabbs2701@gmail.com', 'Served', '2023-11-01 09:50:09'),
(64, 'Employee Kurt', 'Regular', 'Payment', 'Books and Uniforms', 'Card/QR Scan', 'audreycabral1221@gmail.com', 'Served', '2023-11-01 09:50:22'),
(65, 'ticala', 'Regular', 'Claiming of Receipt', 'Tuition', 'Online Fund Transfer', 'kabbs2701@gmail.com', 'Served', '2023-11-01 09:51:18'),
(66, 'ticala', 'Regular', 'Payment', 'Books and Uniforms', 'Cash', 'kabbs2701@gmail.com', 'Served', '2023-11-01 09:51:26'),
(67, 'kabbs', 'Priority', 'Payment', 'Tuition', 'Card/QR Scan', 'kurtcabbs@gmail.com', 'Served', '2023-11-01 09:51:41'),
(68, 'kabbs', 'Regular', 'Payment', 'Books and Uniforms', 'Online Fund Transfer', 'kurtcabbs@gmail.com', 'Served', '2023-11-01 09:52:20'),
(69, 'kabbs', 'Priority', 'Claiming of Receipt', 'Tuition', 'Online Fund Transfer', 'kurtcabbs@gmail.com', 'Served', '2023-11-01 09:52:28'),
(70, 'fdsdfsdfs', 'Priority', 'Payment', 'Other School Activities and Fees', 'Card/QR Scan', 'audreycabral1221@gmail.com', 'Served', '2023-11-01 09:52:45'),
(71, 'Employee Kurt', 'Regular', 'Payment', 'Books and Uniforms', 'Card/QR Scan', '', 'Served', '2023-11-01 09:52:59'),
(72, 'ticala', 'Regular', 'Payment', 'Books and Uniforms', 'Card/QR Scan', 'audreycabral1221@gmail.com', 'Served', '2023-11-01 09:53:48'),
(73, 'kabbs', 'Regular', 'Claiming of Receipt', 'Books and Uniforms', 'Card/QR Scan', '', 'Served', '2023-11-01 09:54:01'),
(74, 'Employee Kurt', 'Priority', 'Claiming of Receipt', 'Tuition', 'Online Fund Transfer', 'kabbs2701@gmail.com', 'Served', '2023-11-01 09:54:11'),
(75, 'Employee Kurt', 'Priority', 'Claiming of Receipt', 'Books and Uniforms', 'Online Fund Transfer', 'kabbs2701@gmail.com', 'Served', '2023-11-01 09:57:46'),
(76, 'KabbCess', 'Priority', 'Claiming of Receipt', 'Books and Uniforms', 'Card/QR Scan', '', 'Served', '2023-11-01 09:58:00'),
(77, 'Employee Kurt', 'Regular', 'Payment', 'Books and Uniforms', 'Online Fund Transfer', 'jose.cabral@sdca.edu.ph', 'Served', '2023-11-01 09:58:11'),
(78, 'KabbCess', 'Regular', 'Payment', 'Tuition', 'Online Fund Transfer', 'kabbs2701@gmail.com', 'Served', '2023-11-01 10:49:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('Online','Offline') DEFAULT 'Offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `status`) VALUES
(12, 'admin', '$2y$10$JlcWP5uqwrSuYCWJc2u7teBqYBrhB3ZMDv/XzMCdhZOwZJyymX8m2', 'kabbs2701@gmail.com', 'admin', 'Online'),
(16, 'cashier', '$2y$10$oB02b.pYhuLBWQIfFxI0X.CK6c5EEX6MF0Vn2DYYYzUrMc.67kBl.', 'kabbs2701@gmail.com', 'user', 'Online'),
(17, 'staff1', '$2y$10$h5TPaowWkQ9cuE4gecOZ7ObV.UQx5VYovbPu.ivavJ0XRajwjpEeq', 'kabbiecabbs@gmail.com', 'user', 'Online'),
(18, 'staff2', '$2y$10$8ObfMI3VS9V8/BYGvRG18eHThU13Q61U/v9saUOznGcOY2GZ9TpPO', 'kurtcabbs@gmail.com', 'user', 'Online');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `queue_data`
--
ALTER TABLE `queue_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `queue_data`
--
ALTER TABLE `queue_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

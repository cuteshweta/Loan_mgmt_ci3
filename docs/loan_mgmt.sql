-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 04:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loan_mgmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `tenure` int(11) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `applied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `amount`, `tenure`, `purpose`, `status`, `applied_at`) VALUES
(1, 2, 50000.00, 12, 'bussiness Purpose', 'approved', '2025-02-28 12:18:21'),
(2, 2, 1000.00, 3, 'mhjgfjm', 'rejected', '2025-03-29 12:18:51'),
(3, 2, 2000.00, 6, 'bgtyryg', 'approved', '2025-03-29 16:10:52');

-- --------------------------------------------------------

--
-- Table structure for table `repayments`
--

CREATE TABLE `repayments` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `status` enum('pending','paid') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repayments`
--

INSERT INTO `repayments` (`id`, `loan_id`, `amount`, `due_date`, `paid_at`, `status`) VALUES
(85, 1, 4166.67, '2025-04-29', '2025-03-29 18:42:24', 'paid'),
(86, 1, 4166.67, '2025-05-29', '2025-03-29 14:13:54', 'paid'),
(87, 1, 4166.67, '2025-06-29', '2025-03-29 16:12:43', 'paid'),
(88, 1, 4166.67, '2025-07-29', NULL, 'pending'),
(89, 1, 4166.67, '2025-08-29', NULL, 'pending'),
(90, 1, 4166.67, '2025-09-29', NULL, 'pending'),
(91, 1, 4166.67, '2025-10-29', NULL, 'pending'),
(92, 1, 4166.67, '2025-11-29', NULL, 'pending'),
(93, 1, 4166.67, '2025-12-29', NULL, 'pending'),
(94, 1, 4166.67, '2026-01-29', NULL, 'pending'),
(95, 1, 4166.67, '2026-03-01', NULL, 'pending'),
(96, 1, 4166.67, '2026-04-01', NULL, 'pending'),
(97, 3, 333.33, '2025-04-29', '2025-03-29 16:14:37', 'paid'),
(98, 3, 333.33, '2025-05-29', NULL, 'pending'),
(99, 3, 333.33, '2025-06-29', NULL, 'pending'),
(100, 3, 333.33, '2025-07-29', NULL, 'pending'),
(101, 3, 333.33, '2025-08-29', NULL, 'pending'),
(102, 3, 333.33, '2025-09-29', NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$gEjGRMWcK5TfpJybloN2P.veT9LLkWZ/8c1PvJJ7cpZySTBC1CnrO', 'admin', '2025-03-29 12:53:41'),
(2, 'shweta', '$2y$10$3FnpOb8.FSoadYvQXJTyE.zUQL90RyvhabfSpTkrEE4esJbf3Ib/K', 'customer', '2025-03-29 11:29:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `repayments`
--
ALTER TABLE `repayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`);

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
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `repayments`
--
ALTER TABLE `repayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `repayments`
--
ALTER TABLE `repayments`
  ADD CONSTRAINT `repayments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

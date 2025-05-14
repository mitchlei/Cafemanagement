-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 03:24 PM
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
-- Database: `brewlane`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$8SkOZyBmusbaM0nTpzxT3u8MNqw9x0r.6pSZOn5NgGBpsarT5T5rG');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `price`, `category`, `size`, `type`, `created_at`) VALUES
(5, 'matcha', 150.00, 'Beverages', 'Small', 'Iced', '2025-05-12 18:57:18'),
(6, 'Carbonara', 115.00, 'Pasta', 'Not applicable', 'Not applicable', '2025-05-12 19:14:32'),
(7, 'Lasagna', 155.00, 'Pasta', 'Not applicable', 'Not applicable', '2025-05-12 19:15:02'),
(8, 'Cinnamon Roll', 65.00, 'Pastry', 'Not applicable', 'Not applicable', '2025-05-12 19:15:30'),
(9, 'Carrot Cake', 120.00, 'Pastry', 'Not applicable', 'Not applicable', '2025-05-12 19:16:20'),
(10, 'Ube Moist', 145.00, 'Pastry', 'Not applicable', 'Not applicable', '2025-05-12 19:16:45'),
(11, 'Salty Caramel Cheese Cake', 160.00, 'Pastry', 'Not applicable', 'Not applicable', '2025-05-12 19:17:20'),
(12, 'Blueberry Cheesecake', 195.00, 'Pastry', 'Not applicable', 'Not applicable', '2025-05-12 19:17:53'),
(13, 'Double Chocolate Muffin', 65.00, 'Pastry', 'Not applicable', 'Not applicable', '2025-05-12 19:18:22'),
(14, 'Strawberry Cake', 165.00, 'Pastry', 'Not applicable', 'Not applicable', '2025-05-12 19:18:55'),
(15, 'Americano', 70.00, 'Beverages', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:19:43'),
(16, 'Latte', 90.00, 'Beverages', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:20:07'),
(17, 'Cappuccino', 90.00, 'Beverages', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:20:29'),
(18, 'Hazelnut', 85.00, 'Pasta', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:20:51'),
(19, 'Vanilla Latte', 95.00, 'Beverages', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:21:20'),
(20, 'Green tea', 55.00, 'Beverages', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:22:04'),
(21, 'Black Tea', 55.00, 'Beverages', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:22:23'),
(22, 'Matcha Latte', 90.00, 'Beverages', 'Small/Medium/Large', 'Hot/Iced', '2025-05-12 19:22:42');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `tpayment_method` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_name`, `price`, `quantity`, `total`, `customer_name`, `customer_email`, `order_status`, `order_date`, `total_amount`, `tpayment_method`, `payment_method`) VALUES
(4, '', 0.00, 0, 0.00, '', '', 'Pending', '2025-05-12 08:24:40', 210.00, '', 'Cash'),
(5, '', 0.00, 0, 0.00, '', '', 'Pending', '2025-05-12 08:37:06', 110.00, '', 'GCash'),
(11, '', 0.00, 0, 0.00, '', '', 'Pending', '2025-05-12 20:56:08', 70.00, '', 'GCash');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `item_name`, `quantity`, `price`, `total`) VALUES
(1, 4, 'chocolate', 1, 100.00, 100.00),
(2, 4, 'chocolate', 1, 110.00, 110.00),
(3, 5, 'chocolate', 1, 110.00, 110.00),
(10, 11, 'Americano', 1, 70.00, 70.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`) VALUES
(9, 'vernon', 'minghao@gmail.com', '$2y$10$sc6SGE3BI9kV7vcSQv80aOOnke.DtVhJtGcQWu25rutGvSpT3kSSi', 'approved'),
(12, 'ciara mae padillo', 'ciarapadillo@gmail.com', '$2y$10$b8KtbrOZQkQsAY.Ok2SeU.E0AokBvC6uNnKcdDuDTDs7.shDFm8M6', 'approved'),
(13, 'S.COUPS MONSTER', 'avila12@gmail.com', '$2y$10$tvO/3ObTZUNrr5vCgQ6O.OZTcMl/jtRK5Kdsp89VuEo6aoaDqo/0y', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 03:46 PM
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
-- Database: `food_ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `food_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `restaurant_id`, `name`, `description`, `price`, `image`) VALUES
(12, 6, 'burger guu', 'gfhhfjrntntn ejjgf fdgh', 390.00, 'Screenshot (1).png'),
(13, 6, 'burger guu', 'gfhhfjrntntn ejjgf fdgh', 390.00, 'Screenshot (1).png'),
(14, 1, 'Opshadow ', 'qwertghyjuhygfd', 600.00, 'Screenshot (10).png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `food_id`, `quantity`, `total_price`, `order_date`, `status`) VALUES
(7, 2, 12, 1, 1180.00, '2025-01-27 06:52:17', 'Pending'),
(8, 2, 13, 1, 1180.00, '2025-01-27 06:52:17', 'Pending'),
(9, 2, 14, 1, 1980.00, '2025-01-27 07:12:36', 'Pending'),
(11, 2, 13, 1, 1980.00, '2025-01-27 07:12:36', 'Pending'),
(12, 2, 12, 1, 1980.00, '2025-01-27 07:12:36', 'Pending'),
(13, 2, 12, 1, 990.00, '2025-01-28 10:52:33', 'Pending'),
(15, 2, 12, 1, 780.00, '2025-01-28 15:43:19', 'Pending'),
(16, 2, 13, 1, 780.00, '2025-01-28 15:43:19', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` enum('user','restaurant') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`) VALUES
(1, 'Opshadow restaurant ', 'dsfsd@gmail.com', '$2y$10$4hALSHywbsnlGllPgfyHAOC.HPCMIYzbrFMbU/PwHwiz0jKMrFfoq', 'restaurant'),
(2, 'Opshadow ', 'sssfsd@gmail.com', '$2y$10$.IRf2gsKvkO.X7IQA16AGOuoxcS3jTDf.F1eJQdt7uFzeRIVZ9b0y', 'user'),
(3, 'brook burger', 'brook@gmail.com', '$2y$10$Y0ADzIgQ6sGs7Y3fwVFnmui25Bt0ORv7kyaIKqYkh4uOQCSq9sSpG', 'restaurant'),
(4, 'Op restaurant ', 'br@gmail.com', '$2y$10$0ItB9MvBQcDscprbJWxJHeM2x2y6oEdpI7UioQGFXEalxP7ihLUNW', 'restaurant'),
(5, 'burger', 'burger@gmail.com', '$2y$10$zziNi5a4DRW//4OzXXDZyORZiZff5p57N/2CgqKB6dB3ez2McG3AO', 'user'),
(6, 'Dandy Site', 'Dandy@gmail.com', '$2y$10$tmPBkhHf7kO.1Ss.7swI6elNf9WF.W5WTOupunggCF7pKs09Ar6SG', 'restaurant'),
(7, 'burger', 'Dandsdfsy@gmail.com', '$2y$10$HBIlOqYWIyooRIHvNZvPf.rcSWlBbNjRLrj3mKG9nEWhB0LRAIA.W', 'user'),
(8, 'Brookfest', 'brookgfhd@gmail.com', '$2y$10$f5uOaM6x37f5NOJoHPZqSOJKyjIFRkGMKwI7ESg3OXcsX9QBWcvj6', 'restaurant'),
(9, 'Opshadow restaurant ', 'dsfsdwefssg@gmail.com', '$2y$10$X9gsNGE4RGCjT3ctmnUECOA/.3RvdSbhckQ.Vwt3X1TfH6O0FuZQO', 'user'),
(11, 'burgerdesfdghjg', 'ssasdfgdsfsd@gmail.com', '$2y$10$RRhlJFG0fJ4/XJLIc03RUeR.furTKt0yeups2k2duN.fEH9SWyrD.', 'user'),
(13, 'burgerdesfdssfgdthghjg', 'ssasdfsdsfggdsfsd@gmail.com', '$2y$10$sdG9AvXSk1o4a7D/Nmnkau9jbpYVfAa/fQEjmEsWI7Up1Tqw8O.vy', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_ibfk_1` (`food_id`),
  ADD KEY `cart_ibfk_2` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `customers_ibfk_1` (`id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`),
  ADD KEY `restaurants_ibfk_1` (`id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`);

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `restaurants_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

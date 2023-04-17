-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 09:16 PM
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
-- Database: `310_pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `time_ordered` datetime NOT NULL DEFAULT current_timestamp(),
  `time_fufilled` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `order_type` text NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`order_id`, `customer_id`, `employee_id`, `payment_id`, `order_status`, `time_ordered`, `time_fufilled`, `order_type`, `total_price`) VALUES
(5, 13, 24, 1, 1, '2023-04-10 03:02:01', '2023-04-17 13:20:06', 'delivery', 30.76),
(6, 13, NULL, 1, 0, '2023-04-10 03:03:28', NULL, 'delivery', 30.76),
(7, 13, NULL, 1, 0, '2023-04-10 03:03:59', NULL, 'pickup', 30.76),
(8, 13, NULL, 1, 0, '2023-04-10 03:06:55', NULL, 'pickup', 30.76),
(9, 13, NULL, 1, 0, '2023-04-10 11:37:22', NULL, 'delivery', 30.76),
(10, 13, NULL, 1, 0, '2023-04-10 11:44:16', NULL, 'pickup', 30.76),
(12, 13, NULL, 1, 0, '2023-04-10 13:10:34', NULL, 'delivery', 53.63),
(13, 13, NULL, 1, 0, '2023-04-10 18:10:42', NULL, 'pickup', 45.14),
(14, 13, NULL, 1, 0, '2023-04-10 18:23:46', NULL, 'delivery', 15.38),
(15, 13, NULL, 1, 0, '2023-04-10 18:27:27', NULL, 'pickup', 7.69),
(20, 13, 24, 3, 1, '2023-04-17 14:13:25', '2023-04-17 14:13:53', 'delivery', 75.9);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `phone`, `street`, `city`, `zip_code`) VALUES
(13, '742-528-2710', 'Random Street', 'Random City', 77840),
(22, '2666738282', 'shf', 'city name', 72587),
(23, '725-257-2792', 'shf', 'sjf', 72587);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`order_id`, `address`, `city`, `zip_code`) VALUES
(5, 'jlhlh', 'sjf', 72587),
(6, 'jlhlh', 'sjf', 72587),
(9, 'shf', 'sjf', 72587),
(12, 'Test Address', 'Test City', 77840),
(14, 'Random Street 3', 'Random City 3', 77840),
(20, 'Random Street Test', 'Random City', 77840);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `admin`) VALUES
(24, 0),
(25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`ingredient_id`, `ingredient_name`) VALUES
(1, 'Pepperoni'),
(2, 'Cheese');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `price`, `description`) VALUES
(1, 'pepperoni pizza', 7.69, 'Pizza with pepperoni pizza and cheese. Nutritious and healthy.'),
(2, 'cheese pizza', 7.49, 'Pizza with cheese.');

-- --------------------------------------------------------

--
-- Table structure for table `itemingredient`
--

CREATE TABLE `itemingredient` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itemingredient`
--

INSERT INTO `itemingredient` (`item_id`, `ingredient_id`, `amount`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`order_id`, `item_id`, `amount`) VALUES
(5, 1, 4),
(6, 1, 4),
(7, 1, 4),
(8, 1, 4),
(9, 1, 4),
(10, 1, 4),
(12, 1, 6),
(12, 2, 1),
(13, 1, 1),
(13, 2, 5),
(14, 1, 2),
(15, 1, 1),
(20, 1, 5),
(20, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cc_number` bigint(16) NOT NULL,
  `expiration` date NOT NULL,
  `security_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`customer_id`, `payment_id`, `name`, `cc_number`, `expiration`, `security_code`) VALUES
(13, 1, 'Arjun Grover', 982292847, '2023-04-05', 287),
(13, 3, 'Dien Chau', 5297924298, '2023-12-01', 283),
(23, 4, 'Dien Chau', 33333333333, '2023-02-01', 98);

-- --------------------------------------------------------

--
-- Table structure for table `takeout`
--

CREATE TABLE `takeout` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `pickupTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `takeout`
--

INSERT INTO `takeout` (`order_id`, `pickupTime`) VALUES
(7, '0000-00-00 00:00:00'),
(8, '2023-04-10 14:59:00'),
(10, '2023-04-10 11:47:00'),
(13, '2023-04-11 06:10:00'),
(15, '2023-04-11 18:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `user_type`) VALUES
(13, 'fs', 'hd', 'Arjun', 'Grover', 'dienkchau@gmail.com', 0),
(22, 'syed12', 'Abdullah', 'Syed', 'Asad', 'syedbasdphjsdj@gmail.com', 0),
(23, 'syed', 'asad', 'syed', 'asad', 'syedbasdphjsdj@gmail.com', 0),
(24, 'employee1', 'pass', 'firstname', 'lastname', 'firstlast@yahoo.com', 1),
(25, 'admin1', 'pass', 'fname', 'lname', 'admin@hotmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD UNIQUE KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_id` (`item_id`);

--
-- Indexes for table `itemingredient`
--
ALTER TABLE `itemingredient`
  ADD PRIMARY KEY (`item_id`,`ingredient_id`),
  ADD KEY `item_id` (`item_id`,`ingredient_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`order_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`customer_id`,`payment_id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`);

--
-- Indexes for table `takeout`
--
ALTER TABLE `takeout`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `username` (`username`,`email`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`),
  ADD CONSTRAINT `checkout_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `checkout` (`order_id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `itemingredient`
--
ALTER TABLE `itemingredient`
  ADD CONSTRAINT `itemingredient_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `itemingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`);

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `checkout` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `takeout`
--
ALTER TABLE `takeout`
  ADD CONSTRAINT `takeout_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `checkout` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

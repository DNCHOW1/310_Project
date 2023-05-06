-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2023 at 02:11 AM
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
(8, 13, NULL, 1, 0, '2023-04-10 03:06:55', NULL, 'pickup', 30.76),
(9, 13, NULL, 1, 0, '2023-04-10 11:37:22', NULL, 'delivery', 30.76),
(10, 13, NULL, 1, 0, '2023-04-10 11:44:16', NULL, 'pickup', 30.76),
(12, 13, NULL, 1, 0, '2023-04-10 13:10:34', NULL, 'delivery', 53.63),
(13, 13, 25, 1, 1, '2023-04-10 18:10:42', '2023-04-26 11:49:51', 'pickup', 45.14),
(14, 13, NULL, 1, 0, '2023-04-10 18:23:46', NULL, 'delivery', 15.38),
(15, 13, NULL, 1, 0, '2023-04-10 18:27:27', NULL, 'pickup', 7.69),
(20, 13, 24, 3, 1, '2023-04-17 14:13:25', '2023-04-17 14:13:53', 'delivery', 75.9),
(26, 23, NULL, 8, 0, '2023-05-02 19:43:49', '2023-05-02 19:43:49', 'pickup', 30.67),
(27, 13, NULL, 3, 0, '2023-05-03 02:22:59', '2023-05-03 02:22:59', 'pickup', 23.18),
(36, 13, NULL, 9, 0, '2023-05-03 21:17:42', '2023-05-03 21:17:42', 'pickup', 60.49),
(41, 54, NULL, 25, 0, '2023-05-05 19:05:45', '2023-05-05 19:05:45', 'pickup', 187.63),
(42, 54, NULL, 25, 0, '2023-05-05 19:07:21', '2023-05-05 19:07:21', 'delivery', 52.8);

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
(13, '742-528-2713', 'Random Street', 'Random City', 77840),
(22, '2666738282', 'shf', 'city name', 72587),
(23, '725-257-2792', 'shf', 'sjf', 72587),
(34, '795828725728', 'Bonnie Holland', 'Katy', 77494),
(54, '82274823842', 'street1', 'city1', 72800);

-- --------------------------------------------------------

--
-- Stand-in structure for view `customer_view`
-- (See below for the actual view)
--
CREATE TABLE `customer_view` (
`customer_id` bigint(20) unsigned
,`phone` varchar(255)
,`street` varchar(255)
,`city` varchar(255)
,`zip_code` int(11)
,`user_id` bigint(20) unsigned
,`username` varchar(255)
,`password` varchar(255)
,`first_name` varchar(255)
,`last_name` varchar(255)
,`email` varchar(255)
,`user_type` int(11)
);

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
(20, 'Random Street Test', 'Random City', 77840),
(42, 'street1', 'city1', 72800);

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
(25, 1),
(33, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employeecomment`
--

CREATE TABLE `employeecomment` (
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeecomment`
--

INSERT INTO `employeecomment` (`customer_id`, `item_id`, `employee_id`, `comment`, `datetime`) VALUES
(13, 1, 25, 'eh....', '2023-05-06 00:09:49'),
(54, 4, 25, 'Actually theyre bad', '2023-05-06 00:09:36');

-- --------------------------------------------------------

--
-- Stand-in structure for view `employee_view`
-- (See below for the actual view)
--
CREATE TABLE `employee_view` (
`employee_id` bigint(20) unsigned
,`admin` int(11)
,`user_id` bigint(20) unsigned
,`username` varchar(255)
,`password` varchar(255)
,`first_name` varchar(255)
,`last_name` varchar(255)
,`email` varchar(255)
,`user_type` int(11)
);

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
(2, 'Cheese'),
(4, 'Sausage'),
(5, 'Dough'),
(8, 'Pineapple'),
(9, 'Bacon'),
(11, 'Spinach'),
(12, 'Mushroom'),
(13, 'Chicken');

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
(1, 'Pepperoni Pizza', 7.69, 'Pizza with pepperoni pizza and cheese. Nutritious and healthy.'),
(2, 'Cheese Pizza', 7.49, 'Pizza with cheese.'),
(4, 'Sausage and Pepperoni Pizza', 15.49, 'This pizza has sausage AND pepperoni!'),
(6, 'Pineapple Pizza', 4.39, 'This pizza has pineapple, yucky!'),
(7, 'Bacon Pizza', 6.92, 'This pizza has bacon made from hog rider (the person).'),
(8, 'Veggie Pizza', 18.51, 'This pizza has vegetarian ingredients.'),
(16, 'Dough Pizza', 1.29, 'Dough...');

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
(1, 5, 1),
(2, 2, 1),
(4, 1, 1),
(4, 2, 1),
(4, 4, 1),
(4, 5, 1),
(6, 2, 1),
(6, 5, 1),
(6, 8, 1),
(7, 2, 1),
(7, 5, 1),
(7, 9, 1),
(8, 2, 1),
(8, 5, 1),
(8, 11, 1),
(8, 12, 1),
(16, 5, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `item_ingredient_view`
-- (See below for the actual view)
--
CREATE TABLE `item_ingredient_view` (
`item_id` bigint(20) unsigned
,`item_name` varchar(255)
,`price` float
,`description` text
,`ingredient_id` bigint(20) unsigned
,`ingredient_name` varchar(255)
);

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
(20, 2, 5),
(26, 1, 1),
(26, 2, 1),
(26, 4, 1),
(27, 1, 1),
(27, 4, 1),
(36, 1, 1),
(36, 2, 1),
(36, 4, 1),
(36, 6, 1),
(36, 7, 1),
(36, 8, 1),
(41, 1, 2),
(41, 4, 5),
(41, 7, 3),
(41, 8, 4),
(42, 2, 1),
(42, 4, 1),
(42, 6, 1),
(42, 7, 1),
(42, 8, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_item_view`
-- (See below for the actual view)
--
CREATE TABLE `order_item_view` (
`order_id` bigint(20) unsigned
,`customer_id` bigint(20) unsigned
,`order_status` int(11)
,`time_ordered` datetime
,`time_fufilled` datetime
,`order_type` text
,`total_price` float
,`address` text
,`city` text
,`zip_code` int(11)
,`pickupTime` datetime
,`amount` int(11)
,`item_id` bigint(20) unsigned
,`item_name` varchar(255)
,`description` text
,`order_item_price` double(19,2)
);

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
(13, 9, 'Pablo Frausto', 82945728582, '2023-10-01', 923),
(23, 4, 'Dien Chau', 33333333333, '2023-02-01', 98),
(23, 8, 'syed asad', 1233445556454324, '2023-06-01', 123),
(54, 25, 'customer1', 7777777777, '2025-03-01', 925);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`customer_id`, `item_id`, `review`, `rating`, `datetime`) VALUES
(13, 1, 'pepperoni is decent', 3, '2023-05-03 15:05:31'),
(13, 2, 'I like how much cheese there is', 5, '2023-05-03 15:05:39'),
(13, 6, 'I LOVE PINEAPPLE!', 4, '2023-05-03 21:23:37'),
(13, 7, 'Bacon tastes bad but pizza is good...', 2, '2023-05-03 21:23:52'),
(54, 4, 'I like sausages!', 4, '2023-05-05 19:07:34');

-- --------------------------------------------------------

--
-- Stand-in structure for view `review_and_comment_view`
-- (See below for the actual view)
--
CREATE TABLE `review_and_comment_view` (
`item_id` bigint(20) unsigned
,`customer_id` bigint(20) unsigned
,`employee_id` bigint(20) unsigned
,`review` text
,`rating` int(11)
,`review_date` datetime
,`comment` text
,`comment_date` timestamp
);

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
(8, '2023-04-10 14:59:00'),
(10, '2023-04-10 11:47:00'),
(13, '2023-04-11 06:10:00'),
(15, '2023-04-11 18:31:00'),
(26, '2023-05-03 17:10:00'),
(27, '2023-05-03 02:25:00'),
(36, '2023-05-04 21:20:00'),
(41, '2023-05-06 23:00:00');

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
(24, 'employee1', 'pass', 'firstname', 'lastname2', 'firstlast@yahoo.com', 1),
(25, 'admin1', 'pass', 'fname', 'lname', 'admin@hotmail.com', 1),
(33, 'employee2', 'pass', 'chris', 'lanky', 'chrislanks@tamu.edu', 0),
(34, 'pp', '123', 'pryce', 'poole', 'pp@yahoo.com', 0),
(54, 'customer1', 'pass', 'customer1', 'last1', 'customer1@yahoo.com', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_item_view`
-- (See below for the actual view)
--
CREATE TABLE `user_item_view` (
`customer_id` bigint(20) unsigned
,`item_id` bigint(20) unsigned
,`item_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `customer_view`
--
DROP TABLE IF EXISTS `customer_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customer_view`  AS SELECT `customer`.`customer_id` AS `customer_id`, `customer`.`phone` AS `phone`, `customer`.`street` AS `street`, `customer`.`city` AS `city`, `customer`.`zip_code` AS `zip_code`, `user`.`user_id` AS `user_id`, `user`.`username` AS `username`, `user`.`password` AS `password`, `user`.`first_name` AS `first_name`, `user`.`last_name` AS `last_name`, `user`.`email` AS `email`, `user`.`user_type` AS `user_type` FROM (`customer` left join `user` on(`customer`.`customer_id` = `user`.`user_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `employee_view`
--
DROP TABLE IF EXISTS `employee_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employee_view`  AS SELECT `employee`.`employee_id` AS `employee_id`, `employee`.`admin` AS `admin`, `user`.`user_id` AS `user_id`, `user`.`username` AS `username`, `user`.`password` AS `password`, `user`.`first_name` AS `first_name`, `user`.`last_name` AS `last_name`, `user`.`email` AS `email`, `user`.`user_type` AS `user_type` FROM (`employee` left join `user` on(`employee`.`employee_id` = `user`.`user_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `item_ingredient_view`
--
DROP TABLE IF EXISTS `item_ingredient_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `item_ingredient_view`  AS SELECT `i`.`item_id` AS `item_id`, `i`.`item_name` AS `item_name`, `i`.`price` AS `price`, `i`.`description` AS `description`, `ing`.`ingredient_id` AS `ingredient_id`, `ing`.`ingredient_name` AS `ingredient_name` FROM ((`item` `i` left join `itemingredient` on(`i`.`item_id` = `itemingredient`.`item_id`)) left join `ingredient` `ing` on(`itemingredient`.`ingredient_id` = `ing`.`ingredient_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `order_item_view`
--
DROP TABLE IF EXISTS `order_item_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_item_view`  AS SELECT `c`.`order_id` AS `order_id`, `c`.`customer_id` AS `customer_id`, `c`.`order_status` AS `order_status`, `c`.`time_ordered` AS `time_ordered`, `c`.`time_fufilled` AS `time_fufilled`, `c`.`order_type` AS `order_type`, `c`.`total_price` AS `total_price`, `d`.`address` AS `address`, `d`.`city` AS `city`, `d`.`zip_code` AS `zip_code`, `t`.`pickupTime` AS `pickupTime`, `oi`.`amount` AS `amount`, `i`.`item_id` AS `item_id`, `i`.`item_name` AS `item_name`, `i`.`description` AS `description`, round(`i`.`price` * `oi`.`amount`,2) AS `order_item_price` FROM ((((`checkout` `c` left join `delivery` `d` on(`c`.`order_id` = `d`.`order_id`)) left join `takeout` `t` on(`c`.`order_id` = `t`.`order_id`)) left join `orderitem` `oi` on(`c`.`order_id` = `oi`.`order_id`)) left join `item` `i` on(`oi`.`item_id` = `i`.`item_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `review_and_comment_view`
--
DROP TABLE IF EXISTS `review_and_comment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `review_and_comment_view`  AS SELECT `r`.`item_id` AS `item_id`, `r`.`customer_id` AS `customer_id`, `ec`.`employee_id` AS `employee_id`, `r`.`review` AS `review`, `r`.`rating` AS `rating`, `r`.`datetime` AS `review_date`, `ec`.`comment` AS `comment`, `ec`.`datetime` AS `comment_date` FROM (`review` `r` left join `employeecomment` `ec` on(`r`.`item_id` = `ec`.`item_id` and `r`.`customer_id` = `ec`.`customer_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `user_item_view`
--
DROP TABLE IF EXISTS `user_item_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_item_view`  AS SELECT DISTINCT `oiv`.`customer_id` AS `customer_id`, `oiv`.`item_id` AS `item_id`, `oiv`.`item_name` AS `item_name` FROM `order_item_view` AS `oiv`  ;

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
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `ORDER_STATUS` (`order_status`);

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
-- Indexes for table `employeecomment`
--
ALTER TABLE `employeecomment`
  ADD PRIMARY KEY (`customer_id`,`item_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `item_id` (`item_id`);

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
  ADD UNIQUE KEY `item_id` (`item_id`),
  ADD KEY `ITEM_NAME` (`item_name`);

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
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`customer_id`,`item_id`),
  ADD KEY `RATING` (`rating`),
  ADD KEY `review_ibfk_2` (`item_id`);

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
  ADD KEY `username_2` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkout_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `checkout` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `employeecomment`
--
ALTER TABLE `employeecomment`
  ADD CONSTRAINT `employeecomment_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviewpk_ibfk_1` FOREIGN KEY (`customer_id`,`item_id`) REFERENCES `review` (`customer_id`, `item_id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `takeout`
--
ALTER TABLE `takeout`
  ADD CONSTRAINT `takeout_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `checkout` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

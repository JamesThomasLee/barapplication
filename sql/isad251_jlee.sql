-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: proj-mysql.uopnet.plymouth.ac.uk
-- Generation Time: Jan 24, 2020 at 02:08 AM
-- Server version: 8.0.16
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isad251_jlee`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `changeItemState` (IN `prod_id` INT(3), IN `sale_status` VARCHAR(7))  BEGIN
UPDATE menu_coursework
SET sale_status = sale_status
WHERE product_id = prod_id;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `checkCustomer` (IN `email` VARCHAR(50))  BEGIN
SELECT customers_coursework.customer_id from customers_coursework
WHERE customers_coursework.email = email;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `getItem` (IN `prod_id` INT(3))  BEGIN
SELECT * FROM menu_coursework
WHERE product_id = prod_id;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `getItemState` (IN `prod_id` INT(3))  BEGIN
SELECT sale_status FROM menu_coursework
WHERE product_id = prod_id;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `getLastOrder` (IN `time` DATETIME)  BEGIN
SELECT order_id from orders_coursework
WHERE date_time = time;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `getproductcat` (IN `prod_id` INT(3))  SELECT m.category_id, c.category
FROM menu_coursework m
INNER JOIN categories_coursework c
ON c.category_id = m.category_id
AND m.product_id = prod_id$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `insertCustomer` (IN `firstname` VARCHAR(30), IN `surname` VARCHAR(40), IN `email` VARCHAR(60))  BEGIN
INSERT INTO customers_coursework
(first_name, surname, email)
VALUES (firstname, surname, email);
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `insertDrink` (IN `product_name` VARCHAR(40), IN `product_supplier` VARCHAR(50), IN `category_id` INT(2), IN `percentage` DECIMAL(4,2), IN `cost` DECIMAL(4,2), IN `sale_status` VARCHAR(7))  BEGIN
INSERT INTO menu_coursework
(product_name, product_supplier, category_id, percentage, cost, sale_status)
VALUES
(product_name, product_supplier, category_id, percentage, cost, sale_status);
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `insertOrder` (IN `customer_id` INT(5), IN `table_number` INT(3), IN `date_time` DATETIME)  BEGIN
INSERT INTO orders_coursework
(customer_id, table_number, date_time)
VALUES
(customer_id, table_number, date_time);
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `insertOrderDetail` (IN `order_id` INT(10), IN `product_id` INT(3), IN `quantity` INT(2))  BEGIN
INSERT INTO orderdetails_coursework
(order_id, product_id, quantity)
VALUES
(order_id, product_id, quantity);
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `insertSnack` (IN `product_name` VARCHAR(40), IN `product_supplier` VARCHAR(50), IN `category_id` INT(2), IN `cost` DECIMAL(4,2), IN `sale_status` VARCHAR(7))  BEGIN
INSERT INTO menu_coursework
(product_name, product_supplier, category_id, cost, sale_status)
VALUES
(product_name, product_supplier, category_id, cost, sale_status);
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `moveOrder` (IN `orderId` INT(10))  BEGIN
INSERT INTO archivedorders_coursework (order_id, customer_id, table_number, date_time)
SELECT * FROM orders_coursework
WHERE order_id = orderId;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `moveOrderDetails` (IN `orderId` INT(10))  BEGIN
INSERT INTO archivedorderdetails_coursework (order_id, product_id, quantity)
SELECT * FROM orderdetails_coursework
WHERE order_id = orderId;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `OrderDetailsRetrieve` (IN `OrderID` INT(16))  SELECT m.product_name, m.cost, o.quantity
FROM menu_coursework m
INNER JOIN orderdetails_coursework o
ON m.product_id = o.product_id
WHERE o.order_id = OrderID$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `OrderRetrieve` (IN `OrderID` INT(1))  BEGIN
SELECT orders_coursework.order_id, orders_coursework.table_number
FROM orders_coursework
WHERE orders_coursework.order_id = OrderID;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `updateDrinkItem` (IN `prod_id` INT(3), IN `prod_name` VARCHAR(40), IN `prod_sup` VARCHAR(50), IN `pct` DECIMAL(4,2), IN `cst` DECIMAL(4,2))  BEGIN
UPDATE menu_coursework
SET product_name = prod_name, product_supplier = prod_sup, percentage = pct, cost = cst
WHERE product_id = prod_id;
END$$

CREATE DEFINER=`ISAD251_JLee`@`%` PROCEDURE `updateSnackItem` (IN `prod_id` INT(3), IN `prod_name` VARCHAR(40), IN `prod_sup` VARCHAR(50), IN `cst` DECIMAL(4,2))  BEGIN
UPDATE menu_coursework
SET product_name = prod_name, product_supplier = prod_sup, cost = cst
WHERE product_id = prod_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `admindrinks_view`
-- (See below for the actual view)
--
CREATE TABLE `admindrinks_view` (
`category` varchar(20)
,`cost` decimal(4,2)
,`percentage` decimal(4,2)
,`product_id` int(11)
,`product_name` varchar(40)
,`product_supplier` varchar(50)
,`sale_status` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `adminorders`
-- (See below for the actual view)
--
CREATE TABLE `adminorders` (
`customer_id` int(5)
,`date_time` datetime
,`order_id` int(10)
,`table_number` int(3)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `adminsnacks_view`
-- (See below for the actual view)
--
CREATE TABLE `adminsnacks_view` (
`category` varchar(20)
,`cost` decimal(4,2)
,`product_id` int(11)
,`product_name` varchar(40)
,`product_supplier` varchar(50)
,`sale_status` varchar(7)
);

-- --------------------------------------------------------

--
-- Table structure for table `archivedorderdetails_coursework`
--

CREATE TABLE `archivedorderdetails_coursework` (
  `order_id` int(10) NOT NULL,
  `product_id` int(3) NOT NULL,
  `quantity` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `archivedorderdetails_coursework`
--

INSERT INTO `archivedorderdetails_coursework` (`order_id`, `product_id`, `quantity`) VALUES
(15, 42, 1),
(15, 51, 1),
(18, 46, 1),
(19, 59, 1),
(20, 55, 1),
(20, 58, 1),
(20, 43, 1),
(21, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `archivedorders_coursework`
--

CREATE TABLE `archivedorders_coursework` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `table_number` int(3) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `archivedorders_coursework`
--

INSERT INTO `archivedorders_coursework` (`order_id`, `customer_id`, `table_number`, `date_time`) VALUES
(15, 22, 8, '2020-01-21 12:22:10'),
(18, 22, 1, '2020-01-21 13:20:20'),
(19, 22, 15, '2020-01-21 13:21:33'),
(20, 22, 4, '2020-01-21 15:26:35'),
(21, 23, 1, '2020-01-21 15:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `categories_coursework`
--

CREATE TABLE `categories_coursework` (
  `category_id` int(2) NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories_coursework`
--

INSERT INTO `categories_coursework` (`category_id`, `category`) VALUES
(1, 'Beer'),
(2, 'Cider'),
(3, 'Wine'),
(4, 'Vodka'),
(5, 'Gin'),
(6, 'Whiskey'),
(7, 'Rum'),
(8, 'Cocktail'),
(9, 'Other Spirit'),
(10, 'Bar Snacks');

-- --------------------------------------------------------

--
-- Table structure for table `customers_coursework`
--

CREATE TABLE `customers_coursework` (
  `customer_id` int(6) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers_coursework`
--

INSERT INTO `customers_coursework` (`customer_id`, `first_name`, `surname`, `email`) VALUES
(22, 'Jamie', 'Lee', 'jamesthomaslee@virginmedia.com'),
(23, 'Bob', 'Hefford', 'bob@bob.com'),
(42, 'Adam', 'Johns', 'adamjohns@hotmail.com'),
(43, 'Amelia', 'Lee', 'milly@live.co.uk'),
(44, 'Jamie', 'Lee', 'jamietlee@virginmedia.com');

-- --------------------------------------------------------

--
-- Stand-in structure for view `drinks_view`
-- (See below for the actual view)
--
CREATE TABLE `drinks_view` (
`category` varchar(20)
,`cost` decimal(4,2)
,`percentage` decimal(4,2)
,`product_id` int(11)
,`product_name` varchar(40)
,`product_supplier` varchar(50)
,`sale_status` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `getcategories`
-- (See below for the actual view)
--
CREATE TABLE `getcategories` (
`category` varchar(20)
,`category_id` int(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `menusnack_view`
-- (See below for the actual view)
--
CREATE TABLE `menusnack_view` (
`category` varchar(20)
,`cost` decimal(4,2)
,`product_id` int(11)
,`product_name` varchar(40)
,`product_supplier` varchar(50)
,`sale_status` varchar(7)
);

-- --------------------------------------------------------

--
-- Table structure for table `menu_coursework`
--

CREATE TABLE `menu_coursework` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(40) NOT NULL,
  `product_supplier` varchar(50) NOT NULL,
  `category_id` int(2) NOT NULL,
  `percentage` decimal(4,2) DEFAULT NULL,
  `cost` decimal(4,2) NOT NULL,
  `sale_status` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu_coursework`
--

INSERT INTO `menu_coursework` (`product_id`, `product_name`, `product_supplier`, `category_id`, `percentage`, `cost`, `sale_status`) VALUES
(38, 'Stowford Press', 'Herefordshire Farms', 2, '4.00', '3.00', 'ONSALE'),
(39, 'Bowl of Cheesy Chips', 'Tesco', 10, NULL, '5.00', 'ONSALE'),
(40, 'Thatchers Gold', 'Thatchers Cider Farm', 2, '4.00', '3.00', 'ONSALE'),
(41, 'Thatchers Haze', 'Thatchers Cider Farm', 2, '4.00', '3.20', 'ONSALE'),
(42, 'Rattler', 'Healey\'s Farm', 2, '6.00', '3.80', 'ONSALE'),
(43, 'Bowl of Chips', 'Tesco', 10, NULL, '4.00', 'ONSALE'),
(45, 'Carlsberg', 'Carlsberg Brewing', 1, '4.00', '2.90', 'ONSALE'),
(46, 'Coors Light', 'Coors Brewing', 1, '4.00', '3.00', 'ONSALE'),
(47, 'Proper Twelve', 'Conor Mcgregor', 6, '40.00', '3.90', 'ONSALE'),
(48, 'Jack Daniels', 'Jacks Brewing', 6, '41.00', '3.75', 'ONSALE'),
(49, 'Jim Beam', 'Jim\'s Brewing', 6, '38.00', '3.60', 'ONSALE'),
(50, 'Gordon\'s Gin', 'Gordon\'s', 5, '37.50', '4.10', 'ONSALE'),
(51, 'Plymouth Gin', 'Plymouth Gin', 5, '39.00', '4.00', 'ONSALE'),
(52, 'Whitley\'s Rhubard Gin', 'Whitley\'s', 5, '39.00', '4.20', 'ONSALE'),
(53, 'Captain Morgan\'s Rum', 'Captain Morgan\'s', 7, '44.00', '3.80', 'ONSALE'),
(54, 'Captain Morgan\'s Spiced Rum', 'Captain Morgan\'s', 7, '44.00', '3.90', 'ONSALE'),
(55, 'Smirnoff Red', 'Smirnoff', 4, '38.00', '3.60', 'ONSALE'),
(56, 'Absolut Raspberry', 'Absolut', 4, '38.00', '3.60', 'ONSALE'),
(57, 'Absolut Apple', 'Absolut', 4, '38.00', '3.60', 'ONSALE'),
(58, 'Jagermeister', 'Jagermeister', 9, '45.00', '3.70', 'ONSALE'),
(59, 'Fosters', 'Fosters London', 1, '3.80', '2.55', 'ONSALE'),
(60, 'Nachos', 'Tesco', 10, NULL, '6.00', 'ONSALE'),
(61, 'Margherita Pizza', 'Ridgeway Pizza', 10, NULL, '7.50', 'ONSALE'),
(62, 'Pepperoni Pizza', 'Ridgeway Pizza', 10, NULL, '7.50', 'ONSALE'),
(63, 'Hawaiian Pizza', 'Ridgeway Pizza', 10, NULL, '7.50', 'ONSALE'),
(64, 'Garlic Bread', 'Tesco', 10, NULL, '5.00', 'ONSALE'),
(65, 'Cheese and Tomato Toastie', 'Tesco', 10, NULL, '5.00', 'ONSALE'),
(66, 'Cheese and Tomato Panini', 'Tesco', 10, NULL, '6.00', 'ONSALE'),
(67, 'Cheese and Ham Toastie', 'Tesco', 10, NULL, '5.00', 'ONSALE'),
(68, 'Cheese and Ham Panini', 'Tesco', 10, NULL, '6.00', 'ONSALE'),
(70, 'Symmons Cider', 'Symmons', 2, '3.90', '3.35', 'ONSALE');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails_coursework`
--

CREATE TABLE `orderdetails_coursework` (
  `order_id` int(10) NOT NULL,
  `product_id` int(3) NOT NULL,
  `quantity` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orderdetails_coursework`
--

INSERT INTO `orderdetails_coursework` (`order_id`, `product_id`, `quantity`) VALUES
(42, 41, 1),
(43, 47, 1),
(43, 49, 1),
(43, 58, 1),
(44, 59, 1),
(45, 46, 1),
(45, 59, 1),
(46, 46, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_coursework`
--

CREATE TABLE `orders_coursework` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `table_number` int(3) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders_coursework`
--

INSERT INTO `orders_coursework` (`order_id`, `customer_id`, `table_number`, `date_time`) VALUES
(42, 42, 18, '2020-01-23 14:02:54'),
(43, 22, 17, '2020-01-23 14:04:07'),
(44, 43, 18, '2020-01-23 14:20:06'),
(45, 44, 13, '2020-01-23 17:14:11'),
(46, 44, 1, '2020-01-23 17:17:38');

-- --------------------------------------------------------

--
-- Structure for view `admindrinks_view`
--
DROP TABLE IF EXISTS `admindrinks_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ISAD251_JLee`@`%` SQL SECURITY DEFINER VIEW `admindrinks_view`  AS  select `m`.`product_id` AS `product_id`,`m`.`product_name` AS `product_name`,`m`.`product_supplier` AS `product_supplier`,`c`.`category` AS `category`,`m`.`percentage` AS `percentage`,`m`.`cost` AS `cost`,`m`.`sale_status` AS `sale_status` from (`menu_coursework` `m` join `categories_coursework` `c` on(((`c`.`category_id` = `m`.`category_id`) and (`m`.`category_id` <> 10)))) order by `m`.`category_id` ;

-- --------------------------------------------------------

--
-- Structure for view `adminorders`
--
DROP TABLE IF EXISTS `adminorders`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ISAD251_JLee`@`%` SQL SECURITY DEFINER VIEW `adminorders`  AS  select `orders_coursework`.`order_id` AS `order_id`,`orders_coursework`.`date_time` AS `date_time`,`orders_coursework`.`customer_id` AS `customer_id`,`orders_coursework`.`table_number` AS `table_number` from `orders_coursework` order by `orders_coursework`.`date_time` ;

-- --------------------------------------------------------

--
-- Structure for view `adminsnacks_view`
--
DROP TABLE IF EXISTS `adminsnacks_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ISAD251_JLee`@`%` SQL SECURITY DEFINER VIEW `adminsnacks_view`  AS  select `m`.`product_id` AS `product_id`,`m`.`product_name` AS `product_name`,`m`.`product_supplier` AS `product_supplier`,`c`.`category` AS `category`,`m`.`cost` AS `cost`,`m`.`sale_status` AS `sale_status` from (`menu_coursework` `m` join `categories_coursework` `c` on(((`c`.`category_id` = `m`.`category_id`) and (`m`.`category_id` = 10)))) order by `m`.`category_id` ;

-- --------------------------------------------------------

--
-- Structure for view `drinks_view`
--
DROP TABLE IF EXISTS `drinks_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ISAD251_JLee`@`%` SQL SECURITY DEFINER VIEW `drinks_view`  AS  select `m`.`product_id` AS `product_id`,`m`.`product_name` AS `product_name`,`m`.`product_supplier` AS `product_supplier`,`c`.`category` AS `category`,`m`.`percentage` AS `percentage`,`m`.`cost` AS `cost`,`m`.`sale_status` AS `sale_status` from (`menu_coursework` `m` join `categories_coursework` `c` on(((`c`.`category_id` = `m`.`category_id`) and (`m`.`category_id` <> 10) and (`m`.`sale_status` <> 'OFFSALE')))) order by `m`.`category_id` ;

-- --------------------------------------------------------

--
-- Structure for view `getcategories`
--
DROP TABLE IF EXISTS `getcategories`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ISAD251_JLee`@`%` SQL SECURITY DEFINER VIEW `getcategories`  AS  select `categories_coursework`.`category_id` AS `category_id`,`categories_coursework`.`category` AS `category` from `categories_coursework` ;

-- --------------------------------------------------------

--
-- Structure for view `menusnack_view`
--
DROP TABLE IF EXISTS `menusnack_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ISAD251_JLee`@`%` SQL SECURITY DEFINER VIEW `menusnack_view`  AS  select `m`.`product_id` AS `product_id`,`m`.`product_name` AS `product_name`,`m`.`product_supplier` AS `product_supplier`,`c`.`category` AS `category`,`m`.`cost` AS `cost`,`m`.`sale_status` AS `sale_status` from (`menu_coursework` `m` join `categories_coursework` `c` on(((`c`.`category_id` = `m`.`category_id`) and (`m`.`category_id` = 10) and (`m`.`sale_status` <> 'OFFSALE')))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archivedorderdetails_coursework`
--
ALTER TABLE `archivedorderdetails_coursework`
  ADD KEY `FK_itemID` (`product_id`),
  ADD KEY `FK_orderID` (`order_id`);

--
-- Indexes for table `archivedorders_coursework`
--
ALTER TABLE `archivedorders_coursework`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_customer_id` (`customer_id`);

--
-- Indexes for table `categories_coursework`
--
ALTER TABLE `categories_coursework`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers_coursework`
--
ALTER TABLE `customers_coursework`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `menu_coursework`
--
ALTER TABLE `menu_coursework`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `FK_category` (`category_id`);

--
-- Indexes for table `orderdetails_coursework`
--
ALTER TABLE `orderdetails_coursework`
  ADD KEY `ItemId_OrderDetails` (`product_id`),
  ADD KEY `OrderId_OrderDetails` (`order_id`);

--
-- Indexes for table `orders_coursework`
--
ALTER TABLE `orders_coursework`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories_coursework`
--
ALTER TABLE `categories_coursework`
  MODIFY `category_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers_coursework`
--
ALTER TABLE `customers_coursework`
  MODIFY `customer_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `menu_coursework`
--
ALTER TABLE `menu_coursework`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `orders_coursework`
--
ALTER TABLE `orders_coursework`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archivedorderdetails_coursework`
--
ALTER TABLE `archivedorderdetails_coursework`
  ADD CONSTRAINT `FK_itemID` FOREIGN KEY (`product_id`) REFERENCES `menu_coursework` (`product_id`),
  ADD CONSTRAINT `FK_orderID` FOREIGN KEY (`order_id`) REFERENCES `archivedorders_coursework` (`order_id`);

--
-- Constraints for table `archivedorders_coursework`
--
ALTER TABLE `archivedorders_coursework`
  ADD CONSTRAINT `FK_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers_coursework` (`customer_id`);

--
-- Constraints for table `menu_coursework`
--
ALTER TABLE `menu_coursework`
  ADD CONSTRAINT `FK_category` FOREIGN KEY (`category_id`) REFERENCES `categories_coursework` (`category_id`);

--
-- Constraints for table `orderdetails_coursework`
--
ALTER TABLE `orderdetails_coursework`
  ADD CONSTRAINT `ItemId_OrderDetails` FOREIGN KEY (`product_id`) REFERENCES `menu_coursework` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `OrderId_OrderDetails` FOREIGN KEY (`order_id`) REFERENCES `orders_coursework` (`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `orders_coursework`
--
ALTER TABLE `orders_coursework`
  ADD CONSTRAINT `orders_coursework_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers_coursework` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

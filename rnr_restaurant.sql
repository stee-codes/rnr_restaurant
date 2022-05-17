-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 17, 2022 at 05:32 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rnr_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `foodID` int(11) NOT NULL,
  `foodName` varchar(128) NOT NULL,
  `foodDescription` varchar(255) NOT NULL,
  `foodPrice` decimal(10,2) NOT NULL,
  `foodImage` varchar(255) DEFAULT NULL,
  `foodStatus` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`foodID`, `foodName`, `foodDescription`, `foodPrice`, `foodImage`, `foodStatus`) VALUES
(1, 'MUSHROOM SOUP', 'CREAMY MUSHROOM SOUP SERVED WITH CROUTONS', '5.99', 'assets/img/8c460f2c75494f31cd576e3d111a3545.jpg', 1),
(2, 'TRUFFLE FRIES', 'HOMEMADE TRUFFLE FRIES SPRINKLED WITH EXTRA CHEESE', '6.99', 'assets/img/fb3fcc6f13a5d3b5967124a3cbd72026.jpg', 1),
(3, 'SALAD', 'GARDEN GREENS TOSSED IN THOUSAND-ISLAND SAUCE', '5.99', 'assets/img/9dff8063048e031ab6266398230f824d.jpg', 1),
(4, 'TUNA TATARE', 'RAW PIECES OF TUNA CUT INTO SMALL PIECES', '8.99', 'assets/img/fad35ebe5fd3f60e4a68639f869e312c.jpeg', 1),
(5, 'DUCK CONFIT', 'SLOW ROASTED DUCK LEGS, THE FRENCH WAY', '19.99', 'assets/img/8e55dba5368b7e3c609b7d1d397ed4c2.jpg', 1),
(6, 'SQUID INK PASTA', 'SQUID INK LINGUINI COOKED WITH GARLIC AND SCALLOPS', '19.99', 'assets/img/007082723656e63014191ed3098ef97d.jpg', 1),
(7, 'LASAGNA', 'PARMESAN CHEESE, WHITE SAUCE AND RAGU.', '15.99', 'assets/img/843090d0c78f9f5e95b0c0263cf70137.jpg', 1),
(8, 'LAMB CHOP', 'GRILLED LAMB CHOPS GENTLY SEARED TO PERFECTION', '29.99', 'assets/img/c91d6cbc7dfb97ae7239b479ec70e71c.jpeg', 1),
(9, 'TIRAMISU', 'COFFEE-FLAVOURED ITALIAN DESSERT, FLAVOURED WITH COCOA. DELIGHTFUL!', '11.99', 'assets/img/ff9c62569758dc0a7326e0264620c3ed.jpg', 1),
(10, 'CHEESECAKE', 'DELICIOUS CHEESECAKE MADE IN-HOUSE, SERVED WITH WILD BERRIES', '6.99', 'assets/img/623dc5a842297148c11303f4873e81e0.jpg', 1),
(11, 'CHOCOLATE MOUSSE', 'RICH AND CREAMY, YET LIGHT AND FLUFFY. MMM...', '7.99', 'assets/img/960f4dc76787d3887172302f720c54bb.jpg', 1),
(12, 'MANGO SORBET', 'MADE WITH FRESH INGREDIENTS, INTENSE FLAVOURS TO TANTALIZE YOUR TASTEBUDS', '9.99', 'assets/img/32f8592d3c7b3c6f4d15dbe93f0b28c8.jpg', 1),
(19, 'FRUITS', 'BASKET OF FRUITS', '4.99', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `foodorder`
--

CREATE TABLE `foodorder` (
  `foodorderID` int(11) NOT NULL,
  `foodorderName` varchar(255) NOT NULL,
  `foodorderNum` varchar(128) NOT NULL,
  `foodorderQuantity` int(11) NOT NULL,
  `foodorderDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userID` int(11) NOT NULL,
  `foodID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `foodorder`
--

INSERT INTO `foodorder` (`foodorderID`, `foodorderName`, `foodorderNum`, `foodorderQuantity`, `foodorderDateTime`, `userID`, `foodID`) VALUES
(1, 'CREAMY MUSHROOM SOUP', '109093655499', 4, '2022-04-07 09:58:43', 1, 1),
(2, 'LAMB CHOP', '109093655499', 3, '2022-04-07 09:58:43', 1, 8),
(3, 'CHOCOLATE MOUSSE', '109093655499', 2, '2022-04-07 09:58:43', 1, 11),
(4, 'CHEESECAKE', '109093655499', 1, '2022-04-07 09:58:43', 1, 10),
(5, 'TRUFFLE FRIES', '714952578165', 2, '2022-04-07 10:19:38', 1, 2),
(6, 'DUCK CONFIT', '714952578165', 2, '2022-04-07 10:19:38', 1, 5),
(7, 'MANGO SORBET', '714952578165', 1, '2022-04-07 10:19:38', 1, 12),
(8, 'TIRAMISU', '714952578165', 1, '2022-04-07 10:19:38', 1, 9),
(9, 'TUNA TATARE', '712181723978', 1, '2022-04-07 10:49:00', 4, 4),
(10, 'LASAGNA', '712181723978', 1, '2022-04-07 10:49:00', 4, 7),
(11, 'LAMB CHOP', '712181723978', 2, '2022-04-07 10:49:00', 4, 8),
(12, 'TIRAMISU', '712181723978', 1, '2022-04-07 10:49:00', 4, 9),
(13, 'CHOCOLATE MOUSSE', '712181723978', 1, '2022-04-07 10:49:00', 4, 11),
(14, 'CREAMY MUSHROOM SOUP', '868770925624', 2, '2022-04-07 13:05:06', 3, 1),
(15, 'LASAGNA', '868770925624', 2, '2022-04-07 13:05:06', 3, 7),
(16, 'MANGO SORBET', '868770925624', 3, '2022-04-07 13:05:06', 3, 12),
(17, 'TRUFFLE FRIES', '842992242376', 1, '2022-04-08 03:44:05', 6, 2),
(18, 'CHEESECAKE', '842992242376', 1, '2022-04-08 03:44:05', 6, 10),
(19, 'TUNA TATARE', '842992242376', 1, '2022-04-08 03:44:05', 6, 4),
(20, 'TUNA TATARE', '824761729562', 2, '2022-04-08 06:35:41', 2, 4),
(21, 'DUCK CONFIT', '824761729562', 1, '2022-04-08 06:35:41', 2, 5),
(22, 'LASAGNA', '824761729562', 1, '2022-04-08 06:35:41', 2, 7),
(23, 'MANGO SORBET', '824761729562', 2, '2022-04-08 06:35:41', 2, 12),
(24, 'LASAGNA', '679126971196', 2, '2022-04-09 03:05:30', 8, 7),
(25, 'TUNA TATARE', '679126971196', 1, '2022-04-09 03:05:30', 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userPhoneNum` varchar(10) NOT NULL,
  `userAddress` varchar(128) NOT NULL,
  `userImage` text,
  `userPermission` smallint(6) NOT NULL DEFAULT '0',
  `userStatus` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userEmail`, `userPassword`, `userPhoneNum`, `userAddress`, `userImage`, `userPermission`, `userStatus`) VALUES
(1, 'TOM', 'TOM@EMAIL.COM', '$2y$10$IOfE/Bjr3j7TSEeBC5Ct.e85A9GHGwGlkap8nRm4LYyn8jlS92AW2', '91234567', 'BLOCK 123 ABC ROAD #01-01 S132456', 'assets/img/8ac299d87b7d6541194418841ab0f6fb.jpg', 1, 1),
(2, 'HARRY', 'HARRY@EMAIL.COM', '$2y$10$0nJ0yODecrP3KnwUf6/Hk.P6p9H8lxcZut2LJD0yb/gU6EbAfVmvq', '91112111', 'BLOCK 111 AAA ROAD #11-11 S222111', 'assets/img/35f107132666cf0d1652c17b2da5d072.jpg', 0, 1),
(3, 'SAM', 'SAM@EMAIL.COM', '$2y$10$H3/k7y0gXYnbPrNMtNGzze3sDu3BUOcy4lHz1qews2lLD7xrMr/ei', '98008900', '100 MANROOK ROAD #10-10 S123321', 'assets/img/f6e44c4e53282d1f62e6d3c38fbfd726.jpg', 1, 1),
(4, 'JOSH', 'JOSH@EMAIL.COM', '$2y$10$vW4XQ9X8gZlwVTzYv3EHxuKvvLqaLbF8XVe/1acflJzb8.UJmdnjy', '81119111', '12 YEWKOK ROAD #21-12 S321123', 'assets/img/6833f24f90f690c6edc2bdc733bd73ab.jpg', 0, 1),
(6, 'TROY', 'TROY@EMAIL.COM', '$2y$10$e2RZ2OiA/7fJ5.h0aE967ucKILVqze8qFWSVx8NVApiMWuarHnv6W', '98228622', 'BLOCK 23 MMM ROAD #08-09 S811911', 'assets/img/092363118743b20699fd5b1c6909acf5.jpg', 0, 1),
(7, 'ABIGAIL', 'ABIGAIL@EMAIL.COM', '$2y$10$xllVQbs2hjsNLQvJGzbCBOpwFs/kpaTOUMUjPYhy8iN8LfB6.0o8a', '81239123', 'BLOCK 105 MOUNTAIN ST #04-04 S233433', 'assets/img/6b2395911b82c402211834702b581bb0.jpg', 0, 1),
(8, 'MAY', 'MAY@EMAIL.COM', '$2y$10$Oc94jU8X4BMxOxIXGM/ya.A/WFWuLF1FXYLM8ITUrFt4IwX5OEzvG', '85559555', 'BLOCK 11 TOP ST #11-11 S858585', 'assets/img/06e8e234e512f25e3dbfad15748271fb.jpg', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`foodID`);

--
-- Indexes for table `foodorder`
--
ALTER TABLE `foodorder`
  ADD PRIMARY KEY (`foodorderID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `foodID` (`foodID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `foodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `foodorder`
--
ALTER TABLE `foodorder`
  MODIFY `foodorderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foodorder`
--
ALTER TABLE `foodorder`
  ADD CONSTRAINT `foodorder_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `foodorder_ibfk_2` FOREIGN KEY (`foodID`) REFERENCES `food` (`foodID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

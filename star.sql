-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2022 at 07:52 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `star`
--

-- --------------------------------------------------------

--
-- Table structure for table `expensecategory`
--

CREATE TABLE `expensecategory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expensecategory`
--

INSERT INTO `expensecategory` (`id`, `name`, `createdon`) VALUES
(1, 'Food', '2022-05-11 08:22:35'),
(2, 'test 6', '2022-05-11 10:04:17'),
(4, 'sdsdsds', '2022-05-11 10:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `budget` double NOT NULL,
  `date_incurred` date NOT NULL,
  `categoryid` int(11) NOT NULL,
  `expenseamount` double NOT NULL,
  `status` enum('l','e','g') NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `budget`, `date_incurred`, `categoryid`, `expenseamount`, `status`, `createdon`) VALUES
(6, 23, '2022-05-25', 2, 144, '', '2022-05-11 10:11:02'),
(7, 44, '2022-05-09', 1, 133, '', '2022-05-11 10:15:14'),
(8, 44, '2022-05-09', 1, 133, '', '2022-05-11 10:17:47'),
(9, 8, '2022-05-17', 4, 8, 'e', '2022-05-11 10:53:59'),
(10, 45000, '2022-05-18', 2, 4500, 'l', '2022-05-11 11:02:14'),
(11, 2800, '2022-05-17', 4, 27000, 'g', '2022-05-11 11:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pwdreset`
--

INSERT INTO `pwdreset` (`pwdResetId`, `pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) VALUES
(10, 'knavin393@gmail.com', '4a16a4c30857ea0d', '$2y$10$Ts6ZTxcO00N4iD6lOTsdgOX0dpqa62GZ00gVb.CXXRxH0aJC0o7x6', '1648386686'),
(12, 'test@yahoo.com', '0f2fa003b90dac8b', '$2y$10$9JCOwevERj.ilyVavcPQbOQbB5FwhhulGnbf3h/oCcc.kD8/Rwi5S', '1652854307');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `uidUsers` tinytext NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `pwdUsers` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `uidUsers`, `emailUsers`, `pwdUsers`) VALUES
(1, 'dasdas', 'knavin393@gmail.com', '$2y$10$KRT7s7ewn9ddFEXjw/JiB.mfeJOkUG57xPcGUaIfcd8y8n4EmTULK'),
(24, 'kumar', 'knavassain393@gmail.com', '$2y$10$exCg.LjZZUGlaXjeAvLx4.yODbVpNcJcK4vjAF8maMuwEl8nlLfhG'),
(25, 'test', 'test@yahoo.com', '$2y$10$DsVaOen3WfQXR/wp82zwWunf1pDuvltfh/6qZL8Xue/ZdecbQSluC'),
(26, 'test2', 'test2@yahoo.com', '$2y$10$jwvBLVc8qDfKlDGK5hxk/.b66Fu/aFr1gggtT22rKxJr2qbHZY4zu'),
(27, 'test3', 'test2255@yahoo.com', '$2y$10$vo04sFYjffcwlcXJUSogfe1Ih6LAea.I4ePFuBlvRVI9THhumYlgS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expensecategory`
--
ALTER TABLE `expensecategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`categoryid`);

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expensecategory`
--
ALTER TABLE `expensecategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`categoryid`) REFERENCES `expensecategory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

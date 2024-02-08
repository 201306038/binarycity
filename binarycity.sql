-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2024 at 01:58 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `binarycity`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `client_code`) VALUES
(3, 'Inter IT Solution', 'david@loc.com.na', '0853253838', '7503 Perskes Street, Windhoek', '2024-02-07 10:47:12', 'INT570'),
(4, 'First National Bank', 'fnb@fnb.com', '06122222222', '7503 Perskes Street, Windhoek', '2024-02-07 10:53:36', 'FIR198'),
(5, 'Field of Studies Consultation', 'davidsonhangula@gmail.com', '0813253838', '2671 Erf, Oshitenda street\r\ninternshipinternship', '2024-02-07 10:57:13', 'FIE374'),
(6, 'Claudia Moono', 'info@ej-hrc.com', '0811295509', '2671 Erf, Oshitenda street', '2024-02-07 10:58:24', 'CLA966'),
(7, 'Rotalia Hs', 'davidsonhangula@gmail.com', '0811248211', '2671ErfOshitendastreet', '2024-02-07 11:39:05', 'ROT870'),
(8, 'David Hangula', 'davidsonhangula@gmail.com', '0813253838', '2671 Erf, Oshitenda street\r\ninternshipinternship', '2024-02-08 07:59:17', 'DAV261');

-- --------------------------------------------------------

--
-- Stand-in structure for view `client_links_view`
-- (See below for the actual view)
--
CREATE TABLE `client_links_view` (
`client_name` varchar(255)
,`num_contacts` bigint(21)
,`id` int(11)
,`client_code` varchar(6)
);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`) VALUES
(1, 'David', 'david@dh.com', '081'),
(2, 'Samuel', 'samuel@nbc.com.na', '08132'),
(6, 'Mwadjehafo', 'david@hangulas.com', '08123583838');

-- --------------------------------------------------------

--
-- Table structure for table `contact_client`
--

CREATE TABLE `contact_client` (
  `contact_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_client`
--

INSERT INTO `contact_client` (`contact_id`, `client_id`) VALUES
(1, 3),
(1, 4),
(6, 6);

-- --------------------------------------------------------

--
-- Stand-in structure for view `contact_view`
-- (See below for the actual view)
--
CREATE TABLE `contact_view` (
`id` int(11)
,`name` varchar(255)
,`email` varchar(255)
,`phone` varchar(20)
,`num_clients` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `client_links_view`
--
DROP TABLE IF EXISTS `client_links_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `client_links_view`  AS  select `c`.`name` AS `client_name`,count(`cc`.`contact_id`) AS `num_contacts`,`c`.`id` AS `id`,`c`.`client_code` AS `client_code` from (`clients` `c` left join `contact_client` `cc` on(`c`.`id` = `cc`.`client_id`)) group by `c`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `contact_view`
--
DROP TABLE IF EXISTS `contact_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `contact_view`  AS  select `c`.`id` AS `id`,`c`.`name` AS `name`,`c`.`email` AS `email`,`c`.`phone` AS `phone`,count(`cl`.`client_id`) AS `num_clients` from (`contacts` `c` left join `contact_client` `cl` on(`c`.`id` = `cl`.`contact_id`)) group by `c`.`id`,`c`.`name`,`c`.`email`,`c`.`phone` order by `c`.`name` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_client`
--
ALTER TABLE `contact_client`
  ADD PRIMARY KEY (`contact_id`,`client_id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_client`
--
ALTER TABLE `contact_client`
  ADD CONSTRAINT `contact_client_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`),
  ADD CONSTRAINT `contact_client_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

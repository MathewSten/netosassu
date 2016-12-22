-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2016 at 06:54 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sassuapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `nato_saasu`
--

CREATE TABLE `nato_saasu` (
  `id` int(11) NOT NULL,
  `netoapi` varchar(250) NOT NULL,
  `netosite` varchar(250) NOT NULL,
  `saasufile` varchar(250) NOT NULL,
  `saasukey` varchar(250) NOT NULL,
  `ebaystore` varchar(250) NOT NULL,
  `autostart` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nato_saasu`
--

INSERT INTO `nato_saasu` (`id`, `netoapi`, `netosite`, `saasufile`, `saasukey`, `ebaystore`, `autostart`) VALUES
(2, 'er2ucreZ1nTOOyvrGBw2DmCxbnje6eKM', 'pkgwph', '69483', 'C008542ADCE44E58B7FA74D3222F7933', '', '1'),
(3, '0lzA2aDwbEDj0c4lWH66XHPDEM0CdB9E', 'digoptions', '69200', 'D0B96340B4914AFBBD355A87F697FC65', 'DIG_Options', '0'),
(4, '0lzA2aDwbEDj0c4lWH66XHPDEM0CdB9E', 'trakracer', '69483', 'C008542ADCE44E58B7FA74D3222F7933', 'DIG_Options', '0');

-- --------------------------------------------------------

--
-- Table structure for table `neto_accounts`
--

CREATE TABLE `neto_accounts` (
  `id` int(11) NOT NULL,
  `netoapi` varchar(255) NOT NULL,
  `netosite` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `neto_accounts`
--

INSERT INTO `neto_accounts` (`id`, `netoapi`, `netosite`, `created`) VALUES
(2, '0lzA2aDwbEDj0c4lWH66XHPDEM0CdB9E', 'digoptions', '2016-12-09 09:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `status`) VALUES
(1, 1, 'admin', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nato_saasu`
--
ALTER TABLE `nato_saasu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `neto_accounts`
--
ALTER TABLE `neto_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nato_saasu`
--
ALTER TABLE `nato_saasu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `neto_accounts`
--
ALTER TABLE `neto_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

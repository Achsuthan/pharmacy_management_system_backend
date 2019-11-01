-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 01, 2019 at 03:59 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `PLMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `laboratory`
--

CREATE TABLE `laboratory` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laboratory`
--

INSERT INTO `laboratory` (`id`, `email`, `name`, `password`) VALUES
(1, 'achsuthan2@icloud.com', 'Achsuthan', 'pass@123'),
(2, 'achsuthan4@icloud.com', 'Achsuthan', 'pass@123');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`id`, `email`, `name`, `password`) VALUES
(1, 'achsuthan@icloud.com', 'Achsuthan', 'pass@123'),
(14, 'achsuthan1@icloud.com', 'Achsuthan', 'pass@123'),
(15, 'achsuthan2@icloud.com', 'Achsuthan', 'pass@123'),
(16, 'achsuthan4@icloud.com', 'Achsuthan', 'pass@123');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `doctor_id` varchar(50) NOT NULL,
  `pre_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `user_id`, `doctor_id`, `pre_name`) VALUES
(7, '12', '23456', 'Test'),
(8, '234123', '23456', 'Test'),
(9, '234123', '23456', 'Test'),
(10, '234123', '23456', 'Test'),
(11, '234123', '23456', 'Test'),
(12, '234123', '23456', 'Test'),
(13, '234123', '23456', 'Test'),
(14, '234123', '23456', 'Test'),
(15, '12', '123', 'Achsuthans Pres'),
(16, '12', '123', 'Achsuthans Pres'),
(17, '12', '123', 'Achsuthans Pres'),
(18, '12', '123', 'Achsuthans Pres'),
(19, '12', '123', 'Achsuthans Pres'),
(20, '12', '123', 'Achsuthans Pres');

-- --------------------------------------------------------

--
-- Table structure for table `qr`
--

CREATE TABLE `qr` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `qr`
--

INSERT INTO `qr` (`id`, `user_id`, `prescription_id`, `pharmacy_id`) VALUES
(1, 12, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tablet`
--

CREATE TABLE `tablet` (
  `id` int(11) NOT NULL,
  `tablet_name` varchar(100) NOT NULL,
  `time` varchar(50) NOT NULL,
  `is_done` varchar(50) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `isQr` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tablet`
--

INSERT INTO `tablet` (`id`, `tablet_name`, `time`, `is_done`, `prescription_id`, `isQr`, `duration`) VALUES
(21, 'A', 'A1', '1', 20, 'true', '1'),
(22, 'B', 'B1', '1', 20, 'true', '2'),
(23, 'C', 'C1', '', 20, '', '3'),
(24, 'D', 'D1', '', 20, '', '4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr`
--
ALTER TABLE `qr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`),
  ADD KEY `prescription_id` (`prescription_id`);

--
-- Indexes for table `tablet`
--
ALTER TABLE `tablet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_id` (`prescription_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laboratory`
--
ALTER TABLE `laboratory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `qr`
--
ALTER TABLE `qr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tablet`
--
ALTER TABLE `tablet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `qr`
--
ALTER TABLE `qr`
  ADD CONSTRAINT `qr_ibfk_1` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy` (`id`),
  ADD CONSTRAINT `qr_ibfk_2` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`id`);

--
-- Constraints for table `tablet`
--
ALTER TABLE `tablet`
  ADD CONSTRAINT `tablet_ibfk_1` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`id`);

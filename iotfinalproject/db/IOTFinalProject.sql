-- phpMyAdmin SQL Dump
-- version 5.2.1deb1ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2024 at 08:05 PM
-- Server version: 8.0.36-0ubuntu0.23.10.1
-- PHP Version: 8.2.10-2ubuntu1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `IOTFinalProject`
--

-- --------------------------------------------------------

--
-- Table structure for table `Readings`
--

CREATE TABLE `Readings` (
  `reading_id` int NOT NULL,
  `timestamp` timestamp NOT NULL,
  `node_id` int NOT NULL,
  `sensor_id` int NOT NULL,
  `reading_type_id` int NOT NULL,
  `value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ReadingTypes`
--

CREATE TABLE `ReadingTypes` (
  `reading_type_id` int NOT NULL,
  `reading_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ReadingTypes`
--

INSERT INTO `ReadingTypes` (`reading_type_id`, `reading_type`) VALUES
(1, 'Temperature'),
(2, 'Humidity'),
(3, 'Light Intensity');

-- --------------------------------------------------------

--
-- Table structure for table `SensorNodes`
--

CREATE TABLE `SensorNodes` (
  `node_id` int NOT NULL,
  `node_location` varchar(255) DEFAULT NULL,
  `extra_details` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Sensors`
--

CREATE TABLE `Sensors` (
  `sensor_id` int NOT NULL,
  `sensor_type` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Readings`
--
ALTER TABLE `Readings`
  ADD PRIMARY KEY (`reading_id`),
  ADD KEY `node_id` (`node_id`),
  ADD KEY `sensor_id` (`sensor_id`),
  ADD KEY `reading_type_id` (`reading_type_id`);

--
-- Indexes for table `ReadingTypes`
--
ALTER TABLE `ReadingTypes`
  ADD PRIMARY KEY (`reading_type_id`);

--
-- Indexes for table `SensorNodes`
--
ALTER TABLE `SensorNodes`
  ADD PRIMARY KEY (`node_id`);

--
-- Indexes for table `Sensors`
--
ALTER TABLE `Sensors`
  ADD PRIMARY KEY (`sensor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Readings`
--
ALTER TABLE `Readings`
  MODIFY `reading_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ReadingTypes`
--
ALTER TABLE `ReadingTypes`
  MODIFY `reading_type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `SensorNodes`
--
ALTER TABLE `SensorNodes`
  MODIFY `node_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Sensors`
--
ALTER TABLE `Sensors`
  MODIFY `sensor_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Readings`
--
ALTER TABLE `Readings`
  ADD CONSTRAINT `Readings_ibfk_1` FOREIGN KEY (`node_id`) REFERENCES `SensorNodes` (`node_id`),
  ADD CONSTRAINT `Readings_ibfk_2` FOREIGN KEY (`sensor_id`) REFERENCES `Sensors` (`sensor_id`),
  ADD CONSTRAINT `Readings_ibfk_3` FOREIGN KEY (`reading_type_id`) REFERENCES `ReadingTypes` (`reading_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

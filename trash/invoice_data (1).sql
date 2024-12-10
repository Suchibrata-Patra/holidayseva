-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 10, 2024 at 02:10 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u955994755_timora`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice_data`
--

CREATE TABLE `invoice_data` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT 'Not Available',
  `pickup_address` varchar(255) DEFAULT 'Not Provided',
  `tour_package` varchar(255) DEFAULT 'NA',
  `pricing` decimal(10,2) DEFAULT 0.00,
  `special_requirements` varchar(255) DEFAULT 'NA',
  `date_of_journey` date DEFAULT NULL,
  `no_of_adults` int(11) DEFAULT 0,
  `cars_provided` varchar(20) DEFAULT 'NA',
  `no_of_cars` int(11) DEFAULT 1,
  `food_included` varchar(10) DEFAULT 'No',
  `booking_status` varchar(20) DEFAULT 'Not Confirm',
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `invoice_data`
--

INSERT INTO `invoice_data` (`id`, `customer_name`, `mobile_no`, `pickup_address`, `tour_package`, `pricing`, `special_requirements`, `date_of_journey`, `no_of_adults`, `cars_provided`, `no_of_cars`, `food_included`, `booking_status`, `registration_date`) VALUES
(29, 'Suman', '9475755847', '947575847', '1d2 night ', '12857.00', 'No', '2025-10-02', 1, '0', 2, '1', 'Confirmed', '2024-12-09 21:16:13'),
(30, 'Kumar', '9732710635', 'Hotel park', 'Same day Ganga Sagar tour', '7000.00', '', '0000-00-00', 2, '0', 1, '0', 'Not Confirm', '2024-12-10 01:27:45'),
(33, 'Lopamudra Chatterjee', '087792 87965', '9/11 Fern Road, Kolkata, 700019.', 'Same Day Ganga Sagar Tour', '8500.00', 'nil', '2024-12-14', 3, 'Swift Dzire', 1, '0', 'Confirmed', '2024-12-10 13:32:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice_data`
--
ALTER TABLE `invoice_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice_data`
--
ALTER TABLE `invoice_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

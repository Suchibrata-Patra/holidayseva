-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2024 at 06:33 PM
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
  `drop_address` varchar(255) DEFAULT 'Not Provided',
  `tour_package` varchar(255) DEFAULT 'NA',
  `pricing` decimal(10,2) DEFAULT 0.00,
  `token_paid` decimal(10,0) NOT NULL DEFAULT 0,
  `special_requirements` varchar(255) DEFAULT 'NA',
  `date_of_journey` date DEFAULT NULL,
  `no_of_adults` int(11) DEFAULT 0,
  `meal_plan` varchar(255) DEFAULT 'NA',
  `cars_provided` varchar(20) DEFAULT 'NA',
  `no_of_cars` int(11) DEFAULT 1,
  `food_included` varchar(10) DEFAULT 'No',
  `booking_status` varchar(20) DEFAULT 'Not Confirm',
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `invoice_data`
--

INSERT INTO `invoice_data` (`id`, `customer_name`, `mobile_no`, `pickup_address`, `drop_address`, `tour_package`, `pricing`, `token_paid`, `special_requirements`, `date_of_journey`, `no_of_adults`, `meal_plan`, `cars_provided`, `no_of_cars`, `food_included`, `booking_status`, `registration_date`) VALUES
(29, 'Suman Kalyan Nayak', '8145302135', 'Kolkata', 'Kolkata', '1d2 night ', 10000.00, 0, 'No', '2024-12-12', 0, 'NA', '0', 2, '1', 'Confirmed', '2024-12-09 21:16:13'),
(30, 'Kumar', '9732710635', 'Hotel park', 'Not Provided', 'Same day Ganga Sagar tour', 7000.00, 0, '', '2024-12-12', 2, 'NA', '0', 1, '0', 'Not Confirm', '2024-12-10 01:27:45'),
(33, 'Lopamudra Chatterjee', '087792 87965', '9/11 Fern Road, Kolkata, 700019.', '9/11 Fern Road, Kolkata, 700019.', 'Same Day Ganga Sagar Tour', 8500.00, 0, 'nil', '2024-12-14', 3, 'Breakfast', 'Swift Dzire', 1, '0', 'Confirmed', '2024-12-10 13:32:39'),
(82, 'Mr Rajesh Kumar', '9732710635', 'Kolkata Airport', '', 'Same Day Gangasagar Tour', 8900.00, 400, 'Veg meal ', '2025-03-05', 6, 'full_board', 'Ertiga', 1, '1', 'Confirmed', '2024-12-11 13:14:48'),
(85, 'Tukun', '8145302135', 'Garia', 'new alipur', 'Same Day Ganga Sagar Tour Package', 8000.00, 5000, 'nil', '2024-12-13', 3, NULL, 'Dzire/Similar', 1, '0', 'Declined', '2024-12-12 06:48:50'),
(86, 'Mr Sachin ', '859632148', 'Itc Hotel', 'airport', 'Kolkata To Ganga Sagar Day Trip', 20000.00, 20000, 'Spical Havan', '2024-12-29', 17, 'half_board', 'Traveller/ Two Small', 2, '1', 'Confirmed', '2024-12-12 07:00:02'),
(87, 'Mr. Gaurav', '9673997083', 'Park Street', '', '1 Day Round Trip', 8450.00, 0, 'No', '2024-12-28', 7, NULL, 'Marazzo / Innova', 1, '0', 'Confirmed', '2024-12-21 17:33:11'),
(88, 'Mr. Varun', '+65 - 82553383', 'Kolkata', '', 'GangaSagar Tour Package 1 Night 2 Days', 18250.00, 0, 'Not Mentioned.', '2025-03-16', 5, 'half_board', 'Marazzo / Innova', 1, '1', 'Confirmed', '2024-12-22 08:36:42'),
(89, 'Test User', '9475755847', 'Kolkata', '', 'test', 100.00, 0, 'No', '2024-12-25', 100, NULL, 'Rolls Royace', 1, '0', 'Not Confirm', '2024-12-22 18:02:56');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

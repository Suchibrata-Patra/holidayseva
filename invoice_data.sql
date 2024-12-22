-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 22, 2024 at 08:18 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice_data`
--

CREATE TABLE `invoice_data` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT 'Not Available',
  `customer_email_id` varchar(200) DEFAULT NULL,
  `pickup_address` varchar(255) DEFAULT 'Not Provided',
  `drop_address` varchar(255) DEFAULT 'Not Provided',
  `tour_package` varchar(255) DEFAULT 'NA',
  `pricing` decimal(10,2) DEFAULT '0.00',
  `token_paid` decimal(10,0) NOT NULL DEFAULT '0',
  `special_requirements` varchar(255) DEFAULT 'NA',
  `date_of_journey` date DEFAULT NULL,
  `date_of_return` date DEFAULT NULL,
  `no_of_adults` int(11) DEFAULT '0',
  `no_of_children` int(3) NOT NULL,
  `meal_plan` varchar(255) DEFAULT 'NA',
  `cars_provided` varchar(20) DEFAULT 'NA',
  `no_of_cars` int(11) DEFAULT '1',
  `food_included` varchar(10) DEFAULT 'No',
  `hotel_used` varchar(255) DEFAULT 'Not Required',
  `hotel_room_details` varchar(255) DEFAULT NULL,
  `booking_status` varchar(20) DEFAULT 'Not Confirm',
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_data`
--

INSERT INTO `invoice_data` (`id`, `customer_name`, `mobile_no`, `customer_email_id`, `pickup_address`, `drop_address`, `tour_package`, `pricing`, `token_paid`, `special_requirements`, `date_of_journey`, `date_of_return`, `no_of_adults`, `no_of_children`, `meal_plan`, `cars_provided`, `no_of_cars`, `food_included`, `hotel_used`, `hotel_room_details`, `booking_status`, `registration_date`) VALUES
(33, 'Lopamudra Chatterjee', '087792 87965', NULL, '9/11 Fern Road, Kolkata, 700019.', '9/11 Fern Road, Kolkata, 700019.', 'Same Day Ganga Sagar Tour', '8500.00', '0', 'nil', '2024-12-14', NULL, 3, 0, 'Breakfast', 'Swift Dzire', 1, '0', NULL, NULL, 'Confirmed', '2024-12-10 13:32:39'),
(82, 'Mr Rajesh Kumar', '9732710635', NULL, 'Kolkata Airport', '', 'Same Day Gangasagar Tour', '8900.00', '400', 'Veg meal ', '2025-03-05', NULL, 6, 0, 'full_board', 'Ertiga', 1, '1', NULL, NULL, 'Confirmed', '2024-12-11 13:14:48'),
(86, 'Mr Sachin ', '859632148', NULL, 'Itc Hotel', 'airport', 'Kolkata To Ganga Sagar Day Trip', '20000.00', '20000', 'Spical Havan', '2024-12-29', NULL, 17, 0, 'half_board', 'Traveller/ Two Small', 2, '1', NULL, NULL, 'Confirmed', '2024-12-12 07:00:02'),
(87, 'Mr. Gaurav', '9673997083', NULL, 'Park Street', '', '1 Day Round Trip', '8450.00', '0', 'No', '2024-12-28', NULL, 7, 0, NULL, 'Marazzo / Innova', 1, '0', NULL, NULL, 'Confirmed', '2024-12-21 17:33:11'),
(88, 'Mr. Varun', '+65 - 82553383', NULL, 'Kolkata', '', 'GangaSagar Tour Package 1 Night 2 Days', '18250.00', '0', 'Not Mentioned.', '2025-03-16', NULL, 5, 0, 'half_board', 'Marazzo / Innova', 1, '1', NULL, NULL, 'Confirmed', '2024-12-22 08:36:42');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

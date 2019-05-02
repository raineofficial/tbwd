-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2017 at 03:55 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` bigint(20) NOT NULL,
  `account_no` varchar(30) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `meter_no` varchar(60) DEFAULT NULL,
  `street_add` varchar(60) NOT NULL,
  `purok_sub` varchar(60) NOT NULL,
  `barangay` varchar(60) NOT NULL,
  `town` varchar(60) NOT NULL,
  `status` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `date_requested` date NOT NULL,
  `approved` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_no`, `user_id`, `meter_no`, `street_add`, `purok_sub`, `barangay`, `town`, `status`, `name`, `date_requested`, `approved`) VALUES
(1, '1391919042', 4, 'TBD892765681651', 'Bonifacio', 'Purok 1', 'Poblacion', 'Tubod', 1, 'Miley Cyrus', '2017-10-23', 'Rick Kievin Dayak'),
(2, '1228911949', 5, 'TBD892765681652', 'Bonifacio', 'Purok 2', 'Poblacion', 'Tubod', 1, 'Jay Pagente', '2017-10-23', 'Rick Kievin Dayak'),
(3, '1200866737', 6, 'TBD892765681653', 'Bonifacio', 'Purok 3', 'Poblacion', 'Tubod', 1, 'Adora Urbano', '2017-10-23', 'Rick Kievin Dayak'),
(4, '1124212257', 7, 'TBD892765681654', 'Bonifacio', 'Purok 4', 'Poblacion', 'Tubod', 1, 'Ares Escarpe', '2017-10-23', 'Rick Kievin Dayak'),
(5, '1346283990', 8, 'TBD892765681655', 'Bonifacio', 'Purok 5', 'Poblacion', 'Tubod', 1, 'Jan Lebron', '2017-10-23', 'Rick Kievin Dayak');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` bigint(20) NOT NULL,
  `account_id` bigint(20) NOT NULL,
  `bill_no` bigint(20) NOT NULL,
  `date_time` date NOT NULL,
  `prev_reading` double NOT NULL,
  `pres_reading` double NOT NULL,
  `prev_reading_date` date NOT NULL,
  `pres_reading_date` date NOT NULL,
  `arears` double NOT NULL,
  `amount_due` double NOT NULL,
  `amount_paid` double NOT NULL DEFAULT '0',
  `amount_paid_date` date DEFAULT NULL,
  `teller` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `account_id`, `bill_no`, `date_time`, `prev_reading`, `pres_reading`, `prev_reading_date`, `pres_reading_date`, `arears`, `amount_due`, `amount_paid`, `amount_paid_date`, `teller`) VALUES
(1, 3, 3, '2017-10-23', 0, 20, '2017-07-20', '2017-10-23', 0, 270, 300, '2017-08-16', 'Honey Bee Urbano'),
(2, 2, 2, '2017-10-23', 0, 20, '2017-07-20', '2017-10-23', 0, 270, 250, '2017-09-20', 'Honey Bee Urbano'),
(3, 1, 1, '2017-10-23', 0, 30, '2017-07-20', '2017-10-23', 0, 405, 300, '2017-10-23', 'Honey Bee Urbano'),
(4, 5, 1, '2017-10-23', 0, 40, '2017-07-20', '2017-10-23', 0, 540, 600, '2017-10-23', 'Honey Bee Urbano');

-- --------------------------------------------------------

--
-- Table structure for table `reading`
--

CREATE TABLE `reading` (
  `reading_no` bigint(20) NOT NULL,
  `account_id` bigint(20) NOT NULL,
  `date_time` date NOT NULL,
  `meter_level` double NOT NULL,
  `emp_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reading`
--

INSERT INTO `reading` (`reading_no`, `account_id`, `date_time`, `meter_level`, `emp_name`) VALUES
(1, 1, '2017-07-20', 0, 'Rick Kievin Dayak'),
(2, 2, '2017-07-20', 0, 'Rick Kievin Dayak'),
(3, 3, '2017-07-20', 0, 'Rick Kievin Dayak'),
(4, 4, '2017-07-20', 0, 'Rick Kievin Dayak'),
(5, 5, '2017-07-20', 0, 'Rick Kievin Dayak'),
(6, 3, '2017-10-23', 20, 'Rick Kievin Dayak'),
(7, 2, '2017-10-23', 20, 'Rick Kievin Dayak'),
(8, 1, '2017-10-23', 30, 'Rick Kievin Dayak'),
(9, 5, '2017-10-23', 40, 'Rick Kievin Dayak');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pword` varchar(60) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `phone`, `email`, `uname`, `pword`, `user_type`) VALUES
(1, 'Lizzie Lorraine', 'Dimasuhid', '09752275123', 'maknaeliz01@gmail.com', 'manager', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'Rick Kievin', 'Dayak', '09351234567', 'rick@hotmail.com', 'rick', 'e10adc3949ba59abbe56e057f20f883e', 2),
(3, 'Honey Bee', 'Urbano', '09261234567', 'honey@hotmail.com', 'honey', 'e10adc3949ba59abbe56e057f20f883e', 4),
(4, 'Miley', 'Cyrus', '09171234567', 'miley@hotmail.com', 'miley', 'e10adc3949ba59abbe56e057f20f883e', 3),
(5, 'Jay', 'Pagente', '09151234567', 'jay@hotmail.com', 'jay', 'e10adc3949ba59abbe56e057f20f883e', 3),
(6, 'Adora', 'Urbano', '09268612508', 'adora@hotmail.com', 'adora', 'e10adc3949ba59abbe56e057f20f883e', 3),
(7, 'Ares', 'Escarpe', '09271234568', 'ares@hotmail.com', 'ares', 'e10adc3949ba59abbe56e057f20f883e', 3),
(8, 'Jan', 'Lebron', '09123212321', 'jan@hotmail.com', 'jan', 'e10adc3949ba59abbe56e057f20f883e', 3),
(9, 'Denver', 'Modio', '09056383577', 'denver@hotmail.com', 'denver', 'e10adc3949ba59abbe56e057f20f883e', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD UNIQUE KEY `bill_id_2` (`bill_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `reading`
--
ALTER TABLE `reading`
  ADD PRIMARY KEY (`reading_no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reading`
--
ALTER TABLE `reading`
  MODIFY `reading_no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2017 at 04:47 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `twbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `approved` varchar(255) NOT NULL,
  PRIMARY KEY (`account_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_no`, `user_id`, `meter_no`, `street_add`, `purok_sub`, `barangay`, `town`, `status`, `name`, `date_requested`, `approved`) VALUES
(1, '20170003', 7, 'TB123456789', 'Bonifacio', 'Purok 7', 'Poblacion', 'Tubod', 1, 'Tom Cruise', '2017-10-12', 'Rick Kievin Dayak'),
(2, '20170004', 6, 'WD987456123', 'Rizal', 'Purok 5', 'Bato', 'Baroy', 1, 'Taylor Swift', '2017-10-10', 'Rick Kievin Dayak'),
(5, '', 7, '', 'STREET', 'PUROK', 'BARANGAY', 'TOWN', 3, 'Tom Cruise', '2017-10-15', 'Rick Kievin Dayak'),
(7, '1224368515', NULL, 'meter', 'street', 'purok', 'barangay', 'town', 1, 'Miley Cyrus', '0000-00-00', 'Rick Kievin Dayak');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE IF NOT EXISTS `bill` (
  `bill_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `date_time` date NOT NULL,
  `prev_reading` double NOT NULL,
  `pres_reading` double NOT NULL,
  `prev_reading_date` date NOT NULL,
  `pres_reading_date` date NOT NULL,
  `arears` double NOT NULL,
  `amount_due` double NOT NULL,
  `amount_paid` double DEFAULT '0',
  `amount_paid_date` date DEFAULT NULL,
  `teller` varchar(255) NOT NULL,
  PRIMARY KEY (`bill_id`),
  UNIQUE KEY `bill_id_2` (`bill_id`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `account_id`, `date_time`, `prev_reading`, `pres_reading`, `prev_reading_date`, `pres_reading_date`, `arears`, `amount_due`, `amount_paid`, `amount_paid_date`, `teller`) VALUES
(1, 1, '2017-10-12', 0, 23, '2017-09-12', '2017-10-12', 0, 200.5, 200, '2017-10-17', 'Honey Bee Urbano'),
(2, 2, '2017-10-12', 0, 36, '2017-09-13', '2017-10-12', 0, 315, 200, '0000-00-00', 'Honey Bee Urbano'),
(5, 1, '2017-10-17', 23, 56, '2017-09-18', '2017-10-17', 0.5, 756, 756, '2017-10-17', 'Honey Bee Urbano');

-- --------------------------------------------------------

--
-- Table structure for table `reading`
--

CREATE TABLE IF NOT EXISTS `reading` (
  `reading_no` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `date_time` date NOT NULL,
  `meter_level` double NOT NULL,
  `emp_name` varchar(60) NOT NULL,
  PRIMARY KEY (`reading_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `reading`
--

INSERT INTO `reading` (`reading_no`, `account_id`, `date_time`, `meter_level`, `emp_name`) VALUES
(8, 1, '2017-08-16', 0, 'Rick Kievin Dayak'),
(9, 1, '2017-09-18', 23, 'Rick Kievin Dayak'),
(11, 2, '2017-08-16', 0, 'Rick Kievin Dayak'),
(15, 1, '2017-10-17', 56, 'Rick Kievin Dayak');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pword` varchar(60) NOT NULL,
  `user_type` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `phone`, `email`, `uname`, `pword`, `user_type`) VALUES
(1, 'Lizzie Lorraine', 'Dimasuhid', '09752275123', 'maknaeliz01@gmail.com', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1),
(4, 'Honey Bee', 'Urbano', '09271234568', 'hongie.urbano@gmail.com', 'honey', 'e10adc3949ba59abbe56e057f20f883e', 4),
(5, 'Rick Kievin', 'Dayak', '09151234567', 'rickkievindayak@gmail.com', 'rick', 'e10adc3949ba59abbe56e057f20f883e', 2),
(6, 'Taylor', 'Swift', '0923456789', 'taylorswift@gmail.com', 'taylor', 'e10adc3949ba59abbe56e057f20f883e', 3),
(7, 'Tom', 'Cruise', '09261457896', 'tom.cruise@hotmail.com', 'tom', 'e10adc3949ba59abbe56e057f20f883e', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

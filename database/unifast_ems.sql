-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2023 at 07:34 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unifast_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_attendees`
--

CREATE TABLE `tbl_event_attendees` (
  `id` int(30) NOT NULL,
  `event_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `position` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `username_email` text NOT NULL,
  `password` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_list`
--

CREATE TABLE `tbl_event_list` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `venue` text NOT NULL,
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_event_list`
--

INSERT INTO `tbl_event_list` (`id`, `title`, `description`, `venue`, `datetime_start`, `datetime_end`, `user_id`, `date_created`, `date_update`) VALUES
(1, 'Sample Event 1', 'Sample event description', 'Sample event venue', '2023-02-27 11:56:16', '2023-02-28 11:56:16', 0, '2023-02-27 11:57:31', '2023-02-27 04:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_registration_history`
--

CREATE TABLE `tbl_registration_history` (
  `id` int(30) NOT NULL,
  `event_id` int(30) NOT NULL,
  `event_attendees` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_staff_attendees`
--

CREATE TABLE `tbl_users_staff_attendees` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `suffix` varchar(250) NOT NULL,
  `position` varchar(250) NOT NULL,
  `contact` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `username_email` text NOT NULL,
  `password` text NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff,3=Attendees',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_event_attendees`
--
ALTER TABLE `tbl_event_attendees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_event_list`
--
ALTER TABLE `tbl_event_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_registration_history`
--
ALTER TABLE `tbl_registration_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users_staff_attendees`
--
ALTER TABLE `tbl_users_staff_attendees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_event_attendees`
--
ALTER TABLE `tbl_event_attendees`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_event_list`
--
ALTER TABLE `tbl_event_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_registration_history`
--
ALTER TABLE `tbl_registration_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users_staff_attendees`
--
ALTER TABLE `tbl_users_staff_attendees`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

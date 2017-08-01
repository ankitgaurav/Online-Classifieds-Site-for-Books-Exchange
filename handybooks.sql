-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2017 at 09:11 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `handybooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `from_user` int(250) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `to_user` int(250) NOT NULL,
  `from_user_read` int(11) NOT NULL DEFAULT '0',
  `to_user_read` int(10) NOT NULL DEFAULT '0',
  `displayble` int(11) NOT NULL DEFAULT '1',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `from_user`, `msg`, `to_user`, `from_user_read`, `to_user_read`, `displayble`, `time`) VALUES
(1, 2, 'Reply to the book post WBUT Study Guide posted on 2017-07-19 10:25:40<hr>I want to buy this book man', 1, 1, 1, 1, '2017-07-19 06:19:16'),
(2, 1, '', 2, 0, 1, 0, '2017-07-19 06:19:16'),
(3, 2, 'Bhak nahi dege', 1, 1, 1, 1, '2017-07-19 06:19:47'),
(4, 1, 'Nahi dege', 2, 1, 1, 1, '2017-07-19 06:20:17'),
(5, 2, 'Marbo', 1, 1, 1, 1, '2017-07-19 06:26:19'),
(6, 1, 'ami marbo', 2, 1, 0, 1, '2017-07-19 06:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_category` varchar(250) NOT NULL,
  `post_name` varchar(100) NOT NULL,
  `post_description` varchar(500) NOT NULL,
  `post_department` varchar(100) NOT NULL,
  `post_author` varchar(100) NOT NULL,
  `post_year` varchar(100) NOT NULL,
  `post_genre` varchar(100) NOT NULL,
  `post_class` varchar(250) NOT NULL,
  `post_subject` varchar(250) NOT NULL,
  `post_type` varchar(250) NOT NULL,
  `post_price` int(100) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(250) NOT NULL,
  `image_path` varchar(250) NOT NULL,
  `image_upload` int(10) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_category`, `post_name`, `post_description`, `post_department`, `post_author`, `post_year`, `post_genre`, `post_class`, `post_subject`, `post_type`, `post_price`, `post_time`, `user_id`, `image_path`, `image_upload`, `deleted`) VALUES
(1, 'Academic', 'WBUT Study Guide', 'In Excellent Condition', 'Travel &amp; Tourism', 'MAKAUT Teachers', 'First Semester', '', '', '', '', 200, '2017-07-19 04:55:40', 1, 'images/post_images/car-magenta.png', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `user_id` int(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `email` varchar(100) NOT NULL,
  `institution` varchar(100) NOT NULL,
  `phone` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `hash` varchar(250) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `institution` varchar(250) NOT NULL,
  `city` varchar(100) NOT NULL DEFAULT 'Kolkata',
  `phone` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `hash`, `deleted`, `name`, `institution`, `city`, `phone`) VALUES
(1, 'RAJVAIBHAVSINGH2310@gmail.com', '$2y$10$/PNFODBR9jXHAkIE3s4GweU9.gITeIGIs29XzKCFZ6Y7Nvl5PRdyu', 0, 'Raj Vaibhav SIngh', 'Central Calcutta Polytechnic', 'Kolkata', 0),
(2, 'ankitgauravsvg@gmail.com', '$2y$10$bU.d7MBeJFXQweofVTP2COccsx99Xut9ixYNkgXOtVsVcRHJT4HA.', 0, 'Ankit Gaurav', '', 'Kolkata', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

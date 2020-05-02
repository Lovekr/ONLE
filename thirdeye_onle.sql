-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2020 at 01:01 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thirdeye_onle`
--

-- --------------------------------------------------------

--
-- Table structure for table `sms_admin`
--

CREATE TABLE `sms_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL,
  `loginpwd` varchar(200) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_admin`
--

INSERT INTO `sms_admin` (`id`, `name`, `username`, `loginpwd`, `email_id`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'TDYrNTFRdFRGbDdKczdobkhMWk4wQT09', 'earthtechnology@gmail.com', '2020-05-01 18:30:00', '2020-05-02 02:05:24'),
(2, 'COACHING CENTER', 'unwrap_blogs', 'S0sxOUFsK2haMy9RK1JnZ0lyWTF2Zz09', 'princevictor191@gmail.com', '2020-05-02 03:09:27', '2020-05-02 03:09:27'),
(3, 'COACHING CENTER', 'blogs', 'YzNIR3Q5bmFMSk9ydWN4YmIzRnNkQT09', 'lk@thirdeyeinfo.com', '2020-05-02 03:10:29', '2020-05-02 03:10:29'),
(4, 'Journey/Vacation', 'blogsq', 'YzIvenhpazZ0YXZGMWUrWUQxd2dYQT09', 'lk@thirdeyeinfo.com', '2020-05-02 03:54:06', '2020-05-02 03:54:06'),
(5, 'WOODEN FURNITURES', 'unwrap_blogs1', 'S0sxOUFsK2haMy9RK1JnZ0lyWTF2Zz09', 'admin@gmail.com', '2020-05-02 03:56:30', '2020-05-02 03:56:30'),
(6, 'Tours &amp; Travels', 'unwrap_blo', 'YzIvenhpazZ0YXZGMWUrWUQxd2dYQT09', 'admin@gmail.com', '2020-05-02 04:04:01', '2020-05-02 04:04:01'),
(7, 'Tours &amp; Travels', 'unwrap_blo1', 'S0sxOUFsK2haMy9RK1JnZ0lyWTF2Zz09', 'admin@gmail.com', '2020-05-02 04:32:28', '2020-05-02 04:32:28'),
(8, 'WOODEN FURNITURES', 'unwrap_blogs4', 'S0sxOUFsK2haMy9RK1JnZ0lyWTF2Zz09', 'admin@gmail.com', '2020-05-02 06:54:03', '2020-05-02 06:54:03'),
(9, 'prasanna', 'prjoshi', 'dGRkeWEwNmcxeDEwQzJ6NnZ1VWlndz09', 'prjoshi1992@gmail.com', '2020-05-02 07:10:00', '2020-05-02 07:10:00'),
(10, 'prasanna', 'joshi_joshi', 'dGRkeWEwNmcxeDEwQzJ6NnZ1VWlndz09', 'pra.jps@gmail.com', '2020-05-02 07:17:20', '2020-05-02 07:17:20'),
(11, 'AI', 'ggggh', 'L042bTZ3YjhuN3BGZGxic2t4YW9aUT09', 'admin@gmail.com', '2020-05-02 10:59:20', '2020-05-02 10:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `sms_auth_tokens`
--

CREATE TABLE `sms_auth_tokens` (
  `id` int(11) NOT NULL,
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sms_auth_tokens`
--

INSERT INTO `sms_auth_tokens` (`id`, `token`, `user_id`, `created_date`) VALUES
(131, '675ca647d967c4f6740e33b1687add8bf3091f02d5622ab200d910ed3e34b7045331d838ac13cd95def2cb7618e6576053619008fd8e748a8e9ce6199e3eb742', 11, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sms_create_meeting`
--

CREATE TABLE `sms_create_meeting` (
  `id` int(11) NOT NULL,
  `name_of_meeting` varchar(255) NOT NULL,
  `number_participant` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_create_meeting`
--

INSERT INTO `sms_create_meeting` (`id`, `name_of_meeting`, `number_participant`, `created_at`) VALUES
(1, 'Scrum', '5', '2020-05-02 03:48:16'),
(2, 'daily Scrum meeting', '10', '2020-05-02 03:49:48'),
(3, 'Daily Scrum meeting', '10', '2020-05-02 03:50:29'),
(4, 'fbgb', '45', '2020-05-02 03:51:32'),
(5, 'Scrum meeting', '8', '2020-05-02 07:06:46'),
(6, 'team meeting', '1', '2020-05-02 07:19:05'),
(7, 'daily meeting', '5', '2020-05-02 07:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `sms_login_log`
--

CREATE TABLE `sms_login_log` (
  `id` int(11) NOT NULL,
  `login_date` date NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `login_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_login_log`
--

INSERT INTO `sms_login_log` (`id`, `login_date`, `user_type`, `login_count`) VALUES
(151, '2020-05-02', 'ADMIN', 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sms_admin`
--
ALTER TABLE `sms_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_auth_tokens`
--
ALTER TABLE `sms_auth_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_create_meeting`
--
ALTER TABLE `sms_create_meeting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_login_log`
--
ALTER TABLE `sms_login_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sms_admin`
--
ALTER TABLE `sms_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sms_auth_tokens`
--
ALTER TABLE `sms_auth_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `sms_create_meeting`
--
ALTER TABLE `sms_create_meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sms_login_log`
--
ALTER TABLE `sms_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

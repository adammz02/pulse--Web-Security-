-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 05:41 PM
-- Server version: 10.6.20-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pulse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_suspicious` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `user_id`, `subject`, `type`, `message`, `screenshot`, `created_at`, `is_suspicious`) VALUES
(1, 2, 'sasa', 'bug', 'eg', NULL, '2025-06-05 15:02:43', 0),
(2, 2, '%3Cscript%3Ealert(1)%3C/script%3E', 'bug', '%3Cscript%3Ealert(1)%3C/script%3E', NULL, '2025-06-05 15:03:07', 0),
(3, 2, '&lt;script&gt;alert(&#039;XSS&#039;)&lt;/script&gt;', 'content', '&lt;scr&lt;script&gt;ipt&gt;alert(&#039;XSS&#039;)&lt;/script&gt;', NULL, '2025-06-05 15:08:46', 0),
(4, 2, '&#039; OR &#039;1&#039;=&#039;1', 'bug', '&#039; OR &#039;1&#039;=&#039;1', NULL, '2025-06-05 15:20:04', 0),
(5, 2, '&lt;form action=&#039;hack.php&#039;&gt;', 'bug', '&lt;form action=&#039;hack.php&#039;&gt;', NULL, '2025-06-05 15:35:37', 0),
(6, 2, 'try', 'feedback', 'selamat kot', NULL, '2025-06-05 15:37:49', 0),
(7, 2, '&lt;form action=&quot;hack.php&quot;&gt;', 'feedback', '&lt;form action=&quot;hack.php&quot;&gt;', NULL, '2025-06-05 15:38:05', 1),
(8, 2, '&quot; OR 1=1 --', 'content', '&quot; OR 1=1 --', NULL, '2025-06-05 15:38:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `nric` varchar(20) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `locked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `nric`, `student_id`, `email`, `password`, `login_attempts`, `locked_until`) VALUES
(2, 'Aqilah Joharudin', '010101-01-0101', 'DI220042', 'di220042@student.uthm.edu.my', '$2y$10$WyUNmXQnoVLjKT7nkplDlu6VHZzFmCEBHvszFgAzWmXWgqP7C4p6K', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nric` (`nric`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

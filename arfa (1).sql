-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2021 at 06:08 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arfa`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `AID` int(11) NOT NULL,
  `NAME` varchar(255) COLLATE utf32_bin NOT NULL,
  `LINK` varchar(255) COLLATE utf32_bin NOT NULL,
  `UID` int(11) NOT NULL,
  `STATUS` varchar(25) COLLATE utf32_bin NOT NULL DEFAULT 'OPEN',
  `DUE_DATE` date NOT NULL,
  `TITLE` varchar(255) COLLATE utf32_bin NOT NULL,
  `TEXT` text COLLATE utf32_bin NOT NULL,
  `DATE_CREATED` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Table structure for table `embed_sessions`
--

CREATE TABLE `embed_sessions` (
  `SSID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `LINK` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `embed_sessions`
--

INSERT INTO `embed_sessions` (`SSID`, `UID`, `LINK`) VALUES
(1, 3708, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/f2c8d97b-27d3-48ec-9eb7-d07a3ef7e924?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(2, 9, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/40886abc-cc0c-4a02-98c1-919985c112f8?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(3, 3708, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/40886abc-cc0c-4a02-98c1-919985c112f8?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(4, 3708, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/ae0c1344-5da7-4fe9-9ba6-1e6a5091337a?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(5, 3700, ''),
(6, 3700, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/ae0c1344-5da7-4fe9-9ba6-1e6a5091337a?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(7, 900, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/ae0c1344-5da7-4fe9-9ba6-1e6a5091337a?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(8, 3709, 'The number of modules can be adjusted by clicking on “+1 module” button.'),
(9, 3709, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/ae0c1344-5da7-4fe9-9ba6-1e6a5091337a?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(10, 3710, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/ae0c1344-5da7-4fe9-9ba6-1e6a5091337a?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(11, 100, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/f2c8d97b-27d3-48ec-9eb7-d07a3ef7e924?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>'),
(12, 100, '<iframe width=\"640\" height=\"360\" src=\"https://web.microsoftstream.com/embed/video/efbbed2e-f80d-4a66-b850-9dbc9191110e?autoplay=false&showinfo=true\" allowfullscreen style=\"border:none;\"></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `post_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_text` text DEFAULT NULL,
  `post_create_time` datetime DEFAULT NULL,
  `post_owner` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`post_id`, `topic_id`, `post_text`, `post_create_time`, `post_owner`) VALUES
(1, 4, 'qwertyuiop[]asdfghjkl;\r\nzxcvbnm,/`1234567890-', '2021-08-13 15:35:27', 'akira@toya.com'),
(2, 5, 'qwertyuiop[]asdfghjkl;\r\nzxcvbnm,/`1234567890-', '2021-08-13 15:36:58', 'akira@toya.com'),
(3, 6, 'qwertyuiop[]\\asdfghjkl;\r\nzxcvbnm,/`1234567890-', '2021-08-13 15:39:02', 'akira@toya.com'),
(14, 7, 'sdfgsdfsfsdfs', '2021-08-13 19:07:08', 'akira@toya.com'),
(15, 7, 'sdfsdfsdfs', '2021-08-13 19:11:05', 'aramohapi@gmail.com'),
(16, 7, 'lets see this...', '2021-08-13 19:12:11', 'aramohapi@gmail.com'),
(17, 6, 'Booyah!!', '2021-08-13 19:12:36', 'seth@gmail.com'),
(18, 8, 'awdasdsdsdfsdf', '2021-08-13 19:57:33', 'akira@toya.com'),
(19, 9, 'awdasdsdsdfsdf', '2021-08-13 19:58:01', 'akira@toya.com'),
(20, 10, 'awdasdsdsdfsdf', '2021-08-13 20:00:00', 'akira@toya.com'),
(21, 11, 'awdasdsdsdfsdf', '2021-08-13 20:00:06', 'akira@toya.com'),
(22, 12, 'awdasdsdsdfsdf', '2021-08-13 20:01:02', 'akira@toya.com'),
(23, 13, '', '2021-08-13 20:01:22', ''),
(24, 14, 'sdfsdfsfsdf', '2021-08-13 20:05:42', 'akira@toya.com'),
(25, 15, 'sdfsdfsfsdf', '2021-08-13 20:06:40', 'akira@toya.com'),
(26, 16, 'sdfsdfsfsdf', '2021-08-13 20:06:44', 'akira@toya.com'),
(27, 17, 'sfsdfsdfsdfsdfsdf', '2021-08-13 20:08:17', 'akira@toya.com'),
(28, 18, 'sdfsdfsdfsdf', '2021-08-13 20:09:22', 'akira@toya.com'),
(29, 19, 'gfjhgjhfkjhkhjgk', '2021-08-13 20:10:14', 'akira@toya.com'),
(30, 20, 'sdfdfdfgdfg', '2021-08-13 20:11:09', 'akira@toya.com'),
(31, 21, 'dsfsdfsdgghkfgkh', '2021-08-13 20:13:07', 'akira@toya.com'),
(32, 21, 'fghfghfdh', '2021-08-13 20:13:38', 'aramohapi@gmail.com'),
(33, 21, 'dgfghdgkffdkddj', '2021-08-13 20:21:26', 'seth@gmail.com'),
(34, 21, 'dggdhjdkdmdmweaehar', '2021-08-13 20:24:40', 'kevin@hart.com'),
(35, 21, 'dggdhjdkdmdmweaehar', '2021-08-13 20:27:29', 'kevin@hart.com'),
(36, 21, 'ssdfsdfsdf', '2021-08-13 20:27:50', 'kevin@hart.com'),
(37, 21, 'ssdfsdfsdf', '2021-08-13 20:29:58', 'kevin@hart.com'),
(38, 21, 'ssdfsdfsdf', '2021-08-13 20:33:36', 'kevin@hart.com'),
(39, 21, 'ssdfsdfsdf', '2021-08-13 20:35:58', 'kevin@hart.com'),
(40, 21, 'ssdfsdfsdf', '2021-08-13 20:37:19', 'kevin@hart.com'),
(41, 21, 'ssdfsdfsdf', '2021-08-13 20:38:49', 'kevin@hart.com'),
(42, 21, 'ssdfsdfsdf', '2021-08-13 20:39:24', 'kevin@hart.com'),
(43, 21, 'ssdfsdfsdf', '2021-08-13 20:40:21', 'kevin@hart.com'),
(44, 21, 'ssdfsdfsdf', '2021-08-13 20:40:41', 'kevin@hart.com'),
(45, 21, 'safsdgfhfsh', '2021-08-13 20:48:13', 'seth@gmail.com'),
(46, 21, 'safsdgfhfsh', '2021-08-13 20:48:40', 'seth@gmail.com'),
(47, 21, 'safsdgfhfsh', '2021-08-13 20:52:06', 'seth@gmail.com'),
(48, 21, 'safsdgfhfsh', '2021-08-13 20:55:23', 'seth@gmail.com'),
(49, 21, 'asdfsdfdfag', '2021-08-13 20:56:17', 'seth@gmail.com'),
(50, 21, 'asdfsdfdfag', '2021-08-13 20:58:27', 'seth@gmail.com'),
(51, 21, 'asdfsdfdfag', '2021-08-13 21:00:03', 'seth@gmail.com'),
(52, 21, 'asdfsdfdfag', '2021-08-13 21:01:09', 'seth@gmail.com'),
(53, 21, 'sdfdsfsd', '2021-08-13 21:01:16', 'aramohapi@gmail.com'),
(54, 7, 'cfbzdfb', '2021-08-13 21:04:31', 'aramohapi@gmail.com'),
(55, 7, 'cfbzdfb', '2021-08-13 21:05:23', 'aramohapi@gmail.com'),
(56, 7, 'dfsdagfadfg', '2021-08-13 21:06:20', 'kevin@hart.com'),
(57, 7, 'dgdgd', '2021-08-13 21:08:47', 'aramohapi@gmail.com'),
(58, 7, 'dgdgd', '2021-08-13 21:09:25', 'aramohapi@gmail.com'),
(59, 6, 'dgdga', '2021-08-13 21:10:35', 'aramohapi@gmail.com'),
(60, 22, 'What does it mean to be a god? ', '2021-08-13 21:34:15', 'akira@toya.com'),
(61, 22, 'I believe it means that you have a higher ability of existence...?', '2021-08-13 21:34:57', 'seth@gmail.com'),
(62, 23, 'blah blah blah blah vlah vlah', '2021-08-13 21:57:22', 'akira@toya.com'),
(63, 7, 'xcvbzcxbcvbcvbcvbcvbcvbcvb', '2021-08-14 08:24:30', 'akira@toya.com'),
(64, 24, 'fgzngfnfgnfgnfg', '2021-08-14 08:26:29', 'akira@toya.com'),
(65, 25, 'adgad', '2021-08-14 08:29:56', 'akira@toya.com'),
(66, 26, 'adgad', '2021-08-14 08:32:22', 'akira@toya.com'),
(67, 26, 'fdbDFBDFB', '2021-08-14 08:32:38', 'akira@toya.com'),
(68, 26, 'dzfbdfbdf', '2021-08-14 08:34:17', 'akira@toya.com'),
(69, 26, 'zdf dfzzfd', '2021-08-14 08:35:25', 'akira@toya.com'),
(70, 26, 'try that again', '2021-08-14 08:35:39', 'akira@toya.com'),
(71, 27, 'try this one\r\n', '2021-08-14 08:37:25', 'akira@toya.com'),
(72, 27, 'reply to another unit topic', '2021-08-14 08:37:53', 'akira@toya.com'),
(73, 28, 'sdfSSDFSD', '2021-08-14 09:26:13', 'akira@toya.com'),
(74, 29, 'rxsytuydyuyfuyuffuifuifuuuiu', '2021-08-14 10:36:11', 'akira@toya.com'),
(75, 29, 'gchchgchgkcghkcghghhghg', '2021-08-14 10:38:30', 'akira@toya.com'),
(76, 4, 'sjdgfkjasgfkjasdgf', '2021-08-14 13:50:03', 'aramohapi@gmail.com'),
(77, 30, 'dgdfg', '2021-08-14 14:38:25', 'aramohapi@gmail.com'),
(78, 31, 'dgdfg', '2021-08-14 14:38:41', 'aramohapi@gmail.com'),
(79, 32, 'sefsefwe', '2021-08-14 14:46:06', 'aramohapi@gmail.com'),
(80, 33, 'sefsefwe', '2021-08-14 14:46:33', 'aramohapi@gmail.com'),
(81, 34, 'sefsefwe', '2021-08-14 14:49:57', 'aramohapi@gmail.com'),
(82, 35, 'sefsefwe', '2021-08-14 14:51:39', 'aramohapi@gmail.com'),
(83, 36, 'eerg', '2021-08-14 14:52:37', 'aramohapi@gmail.com'),
(84, 35, 'dfgdfgdsfg', '2021-08-14 14:58:15', 'aramohapi@gmail.com'),
(85, 35, 'dfgdfgdsfg', '2021-08-14 14:59:19', 'aramohapi@gmail.com'),
(86, 35, 'fdgdfgsdfg', '2021-08-14 15:01:00', 'aramohapi@gmail.com'),
(87, 35, 'fdgdfgsdfg', '2021-08-14 15:01:52', 'aramohapi@gmail.com'),
(88, 35, 'sdfsdgfdsa', '2021-08-14 15:01:57', 'aramohapi@gmail.com'),
(89, 35, 'sdfgdfg', '2021-08-14 15:03:03', 'aramohapi@gmail.com'),
(90, 36, 'dfgdfg', '2021-08-14 15:14:57', 'aramohapi@gmail.com'),
(91, 36, 'ramohapi', '2021-08-14 15:17:38', 'aramohapi@gmail.com'),
(92, 36, 'augustinus', '2021-08-14 15:22:01', 'aramohapi@gmail.com'),
(93, 36, 'augustinus', '2021-08-14 15:23:43', 'aramohapi@gmail.com'),
(94, 36, 'augustinus6', '2021-08-14 15:24:57', 'aramohapi@gmail.com'),
(95, 36, 'augustinus90', '2021-08-14 15:25:28', 'aramohapi@gmail.com'),
(96, 30, 'mine', '2021-08-14 15:28:45', 'akira@toya.com'),
(97, 35, 'sdgdafgdfg', '2021-08-14 15:37:48', 'aramohapi@gmail.com'),
(98, 22, 'cfghfgnhfghfshfgh', '2021-08-14 15:46:14', 'aramohapi@gmail.com'),
(99, 29, 'trhsrthsrthrst', '2021-08-14 20:50:25', 'akira@toya.com'),
(100, 37, 'blah', '2021-08-14 20:58:51', 'aramohapi@gmail.com'),
(101, 37, 'great;', '2021-08-14 20:59:31', 'akira@toya.com'),
(102, 38, 'Get it?', '2021-08-14 22:10:19', 'aramohapi@gmail.com'),
(103, 39, 'oh yeah', '2021-08-15 19:49:42', 'akira@toya.com'),
(104, 40, 'hjdf,ckutiuctiutiut', '2021-08-15 20:40:56', 'akira@toya.com'),
(105, 40, 'uyrdyriuriuxu', '2021-08-15 20:41:23', 'akira@toya.com'),
(106, 40, 'htujtr', '2021-08-15 20:43:11', 'aramohapi@gmail.com'),
(107, 41, 'nosi forum', '2021-08-18 11:10:29', 'akira@toya.com'),
(108, 41, 'setho reply', '2021-08-18 11:10:52', 'akira@toya.com'),
(109, 42, 'This is a post about \"How to Make Right Money Decisions\"', '2021-08-20 16:22:17', 'setho.ramohapi@bothouniversity.com'),
(110, 42, 'Budget your income...', '2021-08-20 16:32:50', 'mythoughtsxct@gmail.com'),
(111, 43, 'first post in the money mindset forum', '2021-08-20 19:00:22', 'mythoughtsxct@gmail.com'),
(112, 43, 'reply...', '2021-08-20 19:02:44', 'setho.ramohapi@bothouniversity.com'),
(113, 21, 'wISDFHEFSIHDSFHI', '2021-09-15 14:01:16', 'mythoughtsxct@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE `forum_topics` (
  `topic_id` int(11) NOT NULL,
  `topic_title` varchar(150) DEFAULT NULL,
  `topic_create_time` datetime DEFAULT NULL,
  `topic_owner` varchar(150) DEFAULT NULL,
  `UID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`topic_id`, `topic_title`, `topic_create_time`, `topic_owner`, `UID`) VALUES
(1, 'First Forum', '2021-08-13 15:34:50', 'akira@toya.com', 100),
(2, 'First Forum', '2021-08-13 15:35:11', 'akira@toya.com', 100),
(3, 'First Forum', '2021-08-13 15:35:20', 'akira@toya.com', 200),
(5, 'First Forum', '2021-08-13 15:36:58', 'akira@toya.com', 900),
(6, 'First Forum', '2021-08-13 15:39:02', 'akira@toya.com', 100),
(7, 'testing my limits', '2021-08-13 19:07:08', 'akira@toya.com', 100),
(8, 'another one', '2021-08-13 19:57:33', 'akira@toya.com', 0),
(9, 'another one', '2021-08-13 19:58:01', 'akira@toya.com', 0),
(10, 'another one', '2021-08-13 20:00:00', 'akira@toya.com', 0),
(11, 'another one', '2021-08-13 20:00:06', 'akira@toya.com', 0),
(12, 'another one', '2021-08-13 20:01:02', 'akira@toya.com', 0),
(13, '', '2021-08-13 20:01:22', '', 0),
(14, 'second another one', '2021-08-13 20:05:42', 'akira@toya.com', 0),
(15, 'second another one', '2021-08-13 20:06:40', 'akira@toya.com', 0),
(16, 'second another one', '2021-08-13 20:06:44', 'akira@toya.com', 0),
(17, 'second what what what what', '2021-08-13 20:08:17', 'akira@toya.com', 0),
(18, 'First Forum', '2021-08-13 20:09:21', 'akira@toya.com', 0),
(19, 'ffgjghfkjhkhjk', '2021-08-13 20:10:14', 'akira@toya.com', 0),
(20, 'sdfsdfsd', '2021-08-13 20:11:09', 'akira@toya.com', 0),
(21, 'sdfsdfdfgppppppppppppp', '2021-08-13 20:13:07', 'akira@toya.com', 300),
(22, 'Make What of It What You Will', '2021-08-13 21:34:14', 'akira@toya.com', 900),
(23, 'baby wont you come back?', '2021-08-13 21:57:22', 'akira@toya.com', 200),
(24, 'topic with hidden email', '2021-08-14 08:26:29', 'akira@toya.com', 100),
(25, 'ddga', '2021-08-14 08:29:56', 'akira@toya.com', 100),
(26, 'ddga', '2021-08-14 08:32:22', 'akira@toya.com', 100),
(27, 'topic in another unit', '2021-08-14 08:37:25', 'akira@toya.com', 200),
(28, 'Second Topic', '2021-08-14 09:26:13', 'akira@toya.com', 400),
(29, ',jyfjyfuyiuiukjvkjvjkj', '2021-08-14 10:36:11', 'akira@toya.com', 100),
(38, 'Incubator hehe ', '2021-08-14 22:10:19', 'aramohapi@gmail.com', 1700),
(39, 'sdgfadfg', '2021-08-15 19:49:42', 'akira@toya.com', 100),
(42, 'How to Make Right Money Decisions', '2021-08-20 16:22:16', 'setho.ramohapi@bothouniversity.com', 800),
(43, 'first topic in the money mindset forum', '2021-08-20 19:00:22', 'mythoughtsxct@gmail.com', 3700);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `NID` int(11) NOT NULL,
  `NAME` varchar(225) COLLATE utf32_bin NOT NULL,
  `LINK` varchar(255) COLLATE utf32_bin NOT NULL,
  `UID` int(11) NOT NULL,
  `DATE_CREATED` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `PID` int(11) NOT NULL,
  `NAME` varchar(255) COLLATE utf32_bin NOT NULL,
  `IMG` varchar(255) COLLATE utf32_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`PID`, `NAME`, `IMG`) VALUES
(1, '6-Week Entrepreneur Program', 'cB3gqlkqifBvQafI.png'),
(2, 'Financial Literacy/Money Management Program', 'R02Pzl1knrer0Wqc.png'),
(3, 'BOSS UP', 'POqYPfaWe1bAG8zA.png'),
(4, 'Future Ready incubator', 'MAVpL1DXutb8WnHF.png'),
(5, 'Arielle SME Scale Pad', 'oep3TgkkVegcsYqh.png'),
(20, 'test one more time with image attached', '2860-Screenshot (4).png');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `SSID` int(11) NOT NULL,
  `NAME` varchar(255) COLLATE utf32_bin NOT NULL,
  `UID` int(11) NOT NULL,
  `LINK` varchar(255) COLLATE utf32_bin NOT NULL,
  `DATE_CREATED` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `UID` int(11) NOT NULL,
  `NAME` varchar(255) COLLATE utf32_bin NOT NULL,
  `PID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`UID`, `NAME`, `PID`) VALUES
(100, 'Building Your MVP', 1),
(200, 'Disruptive Business Models', 1),
(300, 'Entrepreneural Finance', 1),
(400, 'Leadership and Opinion Literacy', 1),
(800, 'Budgeting and Saving', 2),
(900, 'Investing', 2),
(1300, 'One on One Coaching', 3),
(1400, ' Managing Director Program', 3),
(1500, 'Chief Financial Officer Program', 3),
(1600, 'Chief Marketing Officer Program', 3),
(1700, 'Chief of Operations Program', 4),
(1800, 'Chief Business Development Officer Program', 3),
(1900, ' Rethinking your Business Strategy', 1),
(2000, 'Social Innovation', 1),
(2100, ' Marketing and Branding', 1),
(2200, ' Entrepreneur Finance', 4),
(2300, ' Public Speaking', 4),
(2400, ' Networking', 4),
(2500, ' Networking', 4),
(2600, ' Operational Plan', 4),
(2700, 'Introduction to Negotiations', 4),
(2800, ' LinkedIn Crash Course', 4),
(2900, 'Social Innovation', 4),
(3000, ' Accounting for your business', 5),
(3100, ' Entrepreneur Assessments', 5),
(3200, ' Leading in the Digital Era', 5),
(3300, 'Do what your competitors do, Better', 5),
(3400, ' Business Risk Management', 5),
(3500, ' Marketing and Branding', 5),
(3600, 'PRACTICAL APPLICATION', 2),
(3700, 'MONEY MINDSET', 2),
(3709, 'MODULE NAME 1', 10),
(3710, 'MODULE NAME 2', 10),
(3711, 'sdfsdf', 11),
(3712, 'new test module name 1', 11),
(3713, 'new test module name 1', 12),
(3714, 'new test module name 1', 12),
(3715, '', 12),
(3716, '', 12),
(3717, '', 12),
(3718, '', 12),
(3719, '', 12),
(3720, '', 12),
(3721, '', 12),
(3722, '', 12),
(3723, 'xxxxx', 13),
(3724, 'xxxxx', 14),
(3725, 'sdfsdf', 15),
(3726, 'sdfsf', 16),
(3727, 'adsad', 17),
(3728, 'sfdok', 18),
(3729, '1', 19),
(3730, 'test module xxx', 20);

-- --------------------------------------------------------

--
-- Table structure for table `user_program`
--

CREATE TABLE `user_program` (
  `EMAIL` varchar(255) COLLATE utf32_bin NOT NULL,
  `PID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `user_program`
--

INSERT INTO `user_program` (`EMAIL`, `PID`) VALUES
('aramohapi@gmail.com', 2),
('holmessherlock536@gmail.com', 3),
('mythoughtsxct@gmail.com', 1),
('mythoughtsxct@gmail.com', 2),
('mythoughtsxct@gmail.com', 3),
('mythoughtsxct@gmail.com', 4),
('mythoughtsxct@gmail.com', 5),
('mythoughtsxct@gmail.com', 20),
('setho.ramohapi@bothouniversity.com', 1),
('setho.ramohapi@bothouniversity.com', 2),
('setho.ramohapi@bothouniversity.com', 3),
('setho.ramohapi@bothouniversity.com', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `EMAIL` varchar(255) COLLATE utf32_bin NOT NULL,
  `NAME` text COLLATE utf32_bin NOT NULL,
  `SURNAME` text COLLATE utf32_bin NOT NULL,
  `TYPE_OF_USER` text COLLATE utf32_bin NOT NULL,
  `PASSWORD` varchar(255) COLLATE utf32_bin NOT NULL,
  `STATUS` varchar(255) COLLATE utf32_bin NOT NULL DEFAULT 'ACTIVE',
  `VERIFIED` tinyint(1) NOT NULL,
  `TOKEN` varchar(255) COLLATE utf32_bin NOT NULL,
  `DATE_CREATED` datetime NOT NULL DEFAULT current_timestamp(),
  `ID` int(11) NOT NULL,
  `USER_TYPE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`EMAIL`, `NAME`, `SURNAME`, `TYPE_OF_USER`, `PASSWORD`, `STATUS`, `VERIFIED`, `TOKEN`, `DATE_CREATED`, `ID`, `USER_TYPE`) VALUES
('				aramohapi@gmail.com				', '					james			', '					ten				', 'STUDENT', '$2y$10$X/pW7az.Ou3l4FLFlfrqROvLpHGhX2NCwkxCQ6/ZIXqAJRCTUHsZO', 'ACTIVE', 0, 'd7b4053cd15e9be909f602fbca341c5d83a73fd913a9c22f44205d7bd077a9a5ca8899b39371c529f4746092888d1b297681', '2021-09-06 09:21:44', 1, 2),
('holmessherlock536@gmail.com', '					stephanie			', '					ten				', 'FACULTY', '$2y$10$W3SZr4nb9qB1yqnb9uLxJ.LRixtgEFhb50qE6ceT6.OsozEJFBsty', 'ACTIVE', 0, 'b05a4111b105a7512ef6f0a75a1776fee0fdfd2d2534c6a7a9e535aa7b5cef699269e4243d32bf41114b42ac5d2cd6d7909e', '2021-09-06 09:25:51', 2, 3),
('mythoughtsxct@gmail.com', 'francine								', 'king					', 'STAFF', '$2y$10$6rEMB2q5nzH.HHTGWdQa3uu1vyEJnUV00GFQ1oTq7xdCj5kIcovCy', 'ACTIVE', 1, '817e778b6dff8ab92c153c9e98521c3871974bfa4760c130948eb8a6fed794c2646790759f4ae855f0bbdfb4eb5be698bec8', '2021-09-15 12:10:44', 3, 1),
('setho.ramohapi@bothouniversity.com', 'setho', 'ramohapi', 'STUDENT', '$2y$10$gPInp4vyoYB/d4TQs38G7.vVqRsR2OIqYYvQ44fq2tZQERIJQI9Bm', 'ACTIVE', 0, 'd119059c400adc95d56d936a7e2988e0e0925d2bda95fb31f1ad1bb446b84eef394e728e5196940f7beeabe861a021e3e85d', '2021-09-19 18:54:39', 21, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`AID`,`NAME`,`UID`);

--
-- Indexes for table `embed_sessions`
--
ALTER TABLE `embed_sessions`
  ADD PRIMARY KEY (`SSID`);

--
-- Indexes for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`post_id`,`topic_id`);

--
-- Indexes for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`NID`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`PID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`SSID`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `user_program`
--
ALTER TABLE `user_program`
  ADD PRIMARY KEY (`EMAIL`,`PID`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `embed_sessions`
--
ALTER TABLE `embed_sessions`
  MODIFY `SSID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `NID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `SSID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3731;

--
-- AUTO_INCREMENT for table `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

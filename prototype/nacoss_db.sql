-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2015 at 08:54 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nacoss_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `type` enum('WEBMASTER','PRO','LIBRARIAN','') NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `board_members`
--

CREATE TABLE IF NOT EXISTS `board_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `other_names` varchar(30) NOT NULL,
  `post` varchar(60) NOT NULL,
  `session` varchar(9) NOT NULL,
  `email` text NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `user_id` varchar(11) NOT NULL COMMENT 'regno in users table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_of_error` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `error_reports`
--

CREATE TABLE IF NOT EXISTS `error_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `time_of_report` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `error_reports`
--

INSERT INTO `error_reports` (`id`, `user_id`, `subject`, `comment`, `time_of_report`) VALUES
(1, '1234/123456', 'Report to prove if reporting bugs really works', 'I just reported a BUG!!!!', '2015-03-25 05:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(1, 'How do I get an academic adviser?', 'Don&rsquo;t worry, one is automatically assigned to you, you simply go to the general office and see the list'),
(2, 'Must I be a programmer in order to do well in computer science?', 'hmm, Yes & No. Yes because most of your assignments and lectures will revolve around a lot of programming concept and tools (not to mention your final year project). No because most people can simply study particularly for a programming exam and pass without really knowing it. (Although it is a standard advice; to be at least average in one programming language (preferably c++ or java) even though you specialize in other aspects of computer science).');

-- --------------------------------------------------------

--
-- Table structure for table `home_page_slider`
--

CREATE TABLE IF NOT EXISTS `home_page_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` text NOT NULL,
  `link` text NOT NULL,
  `caption` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `home_page_slider`
--

INSERT INTO `home_page_slider` (`id`, `img_url`, `link`, `caption`) VALUES
(1, 'img/b6.jpg', 'library.php', 'Keep learning, try out our e-Library'),
(2, 'img/b3.jpg', 'forum/', 'Sample messages'),
(3, 'img/b4.jpeg', '#', 'Sample messages');

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE IF NOT EXISTS `library` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `author` varchar(30) NOT NULL,
  `keywords` varchar(30) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `link` text NOT NULL,
  `file_type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `title`, `author`, `keywords`, `date_added`, `link`, `file_type`) VALUES
(1, 'How to be a programmer', 'K.L Foo', 'programming', '2015-03-24 17:35:14', '', ''),
(2, 'Java: How to Program', 'Harvey Deitel', 'java, programming', '2015-03-24 17:35:14', '', ''),
(3, 'C++: How to program', 'Paul Deitel', 'C++, programming', '2015-03-24 17:36:43', '', ''),
(4, 'Database: Beginners Guide', 'Agozie Eneh', 'mysql, database', '2015-03-24 17:36:43', '', 'docx'),
(5, 'Java: How to Program Edition 8', 'Harvey Deitel', 'java, programming', '2015-03-24 17:35:14', '', ''),
(6, 'Java: How to Program Edition 9', 'Harvey Deitel', 'java, programming', '2015-03-24 17:35:14', '', 'pdf'),
(7, 'C++: How to program Edition 5', 'Paul Deitel', 'C++, programming', '2015-03-24 17:36:43', '', ''),
(8, 'C++: How to program Edition 6', 'Paul Deitel', 'C++, programming', '2015-03-24 17:36:43', '', ''),
(9, 'C++: How to program Edition 9', 'Paul Deitel', 'C++, programming', '2015-03-24 17:36:43', '', ''),
(10, 'Database: Advanced Guide', 'Agozie Eneh', 'mysql, database', '2015-03-24 17:36:43', '', ''),
(11, 'Java: How to Program Edition 10', 'Harvey Deitel', 'java, programming', '2015-03-25 17:35:14', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headline` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `time_of_post` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expire_date` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `headline`, `content`, `time_of_post`, `expire_date`) VALUES
(1, 'Microsoft founder, Bill Gates, is quoted as saying:', '', '2015-03-20 10:54:19', '2015-03-20 10:54:19'),
(2, 'Microsoft founder, Bill Gates, is quoted as saying:', '', '2015-03-20 10:54:35', '2015-03-20 10:54:35'),
(3, 'Software Development Day', 'Unfortunately, in these dire economic times, the ability of school systems such as ours to get the tools necessary to help our students surprise all of us beyond expectations is imperiled.  That is why we’re asking for your help in donating your used computers and computer systems to [school name] so that our students may have access to simple, yet critical, learning advantages such as the internet, word processing, and spreadsheet creation, as well as the opportunity to gain lifelong computing skills.\r\n\r\nI will follow up with you shortly to answer any questions you may have.  If you wish, please take a moment to indicate that you will help sponsor this community effort by calling me at [insert local phone number] or by returning the enclosed response form.  Let me thank you in advance for your time and support.  I look forward to speaking with you soon.\r\n', '2015-03-20 11:21:26', '2015-03-20 11:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) NOT NULL,
  `description` text NOT NULL,
  `time_of_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` text NOT NULL,
  `entry_year` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `year` int(1) NOT NULL COMMENT 'course level i.e 1 for 1st year, 2 for second year etc. ',
  `course_code` varchar(6) NOT NULL,
  `page_no` int(1) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(30) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('email', 'example@domain.com'),
('help_lines', '+23412345678, +23487654321');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `regno` varchar(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `other_names` varchar(30) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `department` varchar(30) DEFAULT NULL,
  `level` varchar(3) DEFAULT NULL,
  `entry_year` year(4) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` text NOT NULL,
  `dob` date DEFAULT NULL,
  `address1` text,
  `address2` text,
  `interests` text,
  `bio` text,
  `pic_url` text NOT NULL,
  `verified` int(1) NOT NULL DEFAULT '0',
  `is_suspended` int(1) NOT NULL DEFAULT '0',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`regno`),
  UNIQUE KEY `regno` (`regno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`regno`, `first_name`, `last_name`, `other_names`, `password`, `department`, `level`, `entry_year`, `phone`, `email`, `dob`, `address1`, `address2`, `interests`, `bio`, `pic_url`, `verified`, `is_suspended`, `is_deleted`) VALUES
('1234/123456', 'Jane', 'Doe', 'Anonymous', 'd14f21b5919900f4cc49333652fb4e92940ac55d', 'COMPUTER SCIENCE', '400', 2015, '07012345678', 'example@domain.com', '1995-07-29', '', '', 'Java', 'Find out', '', 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

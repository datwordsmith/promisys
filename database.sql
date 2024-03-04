-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 04, 2024 at 02:09 AM
-- Server version: 8.0.36
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chukwue1_promisys`
--
CREATE DATABASE IF NOT EXISTS `chukwue1_promisys` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chukwue1_promisys`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int UNSIGNED NOT NULL,
  `client_id` int UNSIGNED NOT NULL,
  `client_property_id` int UNSIGNED NOT NULL,
  `amount` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `staff_id` int NOT NULL,
  `refund` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `client_id`, `client_property_id`, `amount`, `date`, `staff_id`, `refund`) VALUES
(1, 1, 3, 180000, '2020-08-25 13:48:35', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `id` int NOT NULL,
  `clientproperty_id` int NOT NULL,
  `former_staff` int NOT NULL,
  `new_staff` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `assignedby` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `change_type_price`
--

CREATE TABLE `change_type_price` (
  `id` int UNSIGNED NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `property_id` varchar(45) NOT NULL,
  `previous` int UNSIGNED NOT NULL,
  `new` int UNSIGNED NOT NULL,
  `date_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `change_type_price`
--

INSERT INTO `change_type_price` (`id`, `user_id`, `property_id`, `previous`, `new`, `date_edited`) VALUES
(1, '1', '2', 0, 69900000, '2020-02-13 11:08:37'),
(2, '1', '3', 0, 89900000, '2020-02-13 11:08:56'),
(3, '1', '4', 0, 99900000, '2020-02-13 11:09:40'),
(4, '1', '5', 0, 119900000, '2020-02-13 11:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(45) NOT NULL,
  `title` varchar(25) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `occupation` varchar(45) NOT NULL,
  `address` text NOT NULL,
  `prospectid` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `email`, `title`, `lastname`, `firstname`, `middlename`, `sex`, `dob`, `phone`, `mobile`, `occupation`, `address`, `prospectid`) VALUES
(1, 'emeka.daniels@gmail.com', 'Mr', 'Doe', 'John', '', 'Male', '2020-06-08', '08033318112', '', 'N/A', 'FCT - Abuja', 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_property`
--

CREATE TABLE `client_property` (
  `id` int UNSIGNED NOT NULL,
  `fileid` varchar(10) DEFAULT NULL,
  `client_id` int NOT NULL,
  `property_id` int NOT NULL,
  `quantity` int NOT NULL,
  `investmentcategory_id` int NOT NULL,
  `amount` int NOT NULL,
  `tax` float NOT NULL,
  `discount` bigint NOT NULL,
  `markup` bigint NOT NULL,
  `comment` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `staff_id` int UNSIGNED NOT NULL,
  `refund` int NOT NULL DEFAULT '0',
  `assigned_by` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_property`
--

INSERT INTO `client_property` (`id`, `fileid`, `client_id`, `property_id`, `quantity`, `investmentcategory_id`, `amount`, `tax`, `discount`, `markup`, `comment`, `date`, `staff_id`, `refund`, `assigned_by`) VALUES
(3, NULL, 1, 2, 1, 1, 19242500, 7.5, 0, 0, 'This is the space for additional information concerning this transaction.', '2020-08-25 13:48:35', 12, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `client_property_old`
--

CREATE TABLE `client_property_old` (
  `id` int UNSIGNED NOT NULL,
  `fileid` varchar(10) DEFAULT NULL,
  `client_id` int NOT NULL,
  `project_id` int NOT NULL,
  `property_id` int NOT NULL,
  `quantity` int NOT NULL,
  `amount` int NOT NULL,
  `discount` bigint NOT NULL,
  `markup` bigint NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `staff_id` int UNSIGNED NOT NULL,
  `refund` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comms`
--

CREATE TABLE `comms` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(105) NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comms`
--

INSERT INTO `comms` (`id`, `email`, `status`) VALUES
(1, 'hr@hall7projects.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `croncounter`
--

CREATE TABLE `croncounter` (
  `id` int UNSIGNED NOT NULL,
  `counter` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int UNSIGNED NOT NULL,
  `department` varchar(150) NOT NULL,
  `hod` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department`, `hod`) VALUES
(1, 'Accounts', 74),
(2, 'Human Resources', 15),
(3, 'Strategic Communications', 45),
(7, 'Investment Advisory', 39),
(8, 'Legal &amp; Regulatory Compliance', 10),
(9, 'Administration', 40),
(10, 'Internal Control', 72),
(11, 'Procurement', 34),
(12, 'Projects', 22),
(13, 'Innovation Studio', 62);

-- --------------------------------------------------------

--
-- Table structure for table `hbg`
--

CREATE TABLE `hbg` (
  `id` int UNSIGNED NOT NULL,
  `client_property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hbg`
--

INSERT INTO `hbg` (`id`, `client_property_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hbr`
--

CREATE TABLE `hbr` (
  `id` int UNSIGNED NOT NULL,
  `client_property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

CREATE TABLE `hod` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `department` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hod`
--

INSERT INTO `hod` (`id`, `email`, `password`, `lastname`, `firstname`, `middlename`, `department`) VALUES
(1, 'accounts@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Accounts', '', 'accounts'),
(2, 'hr@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Human', 'Resources', 'hr'),
(3, 'admin@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Administration', '', 'admin'),
(4, 'internal.control@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Internal', 'Control', 'control'),
(5, 'legal@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Legal', '', 'legal'),
(6, 'procurement@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Procurement', '', 'procurement'),
(7, 'projects@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Projects', '', 'projects'),
(8, 'studio@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Innovation', 'Studio', 'studio'),
(9, 'comms@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Strategic', 'Communications', 'comms'),
(10, 'investment.advisors@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Head', 'Investment', 'Advisory', 'advisory');

-- --------------------------------------------------------

--
-- Table structure for table `imp`
--

CREATE TABLE `imp` (
  `id` int UNSIGNED NOT NULL,
  `client_property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imp`
--

INSERT INTO `imp` (`id`, `client_property_id`) VALUES
(1, 2),
(2, 3),
(3, 1),
(4, 2),
(5, 3),
(6, 4),
(7, 5),
(8, 6);

-- --------------------------------------------------------

--
-- Table structure for table `investment_category`
--

CREATE TABLE `investment_category` (
  `id` int UNSIGNED NOT NULL,
  `category` varchar(45) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `investment_category`
--

INSERT INTO `investment_category` (`id`, `category`, `description`) VALUES
(1, 'Semi Finished', ''),
(2, 'Fully Finished', 'This means the property is completely finished.'),
(3, 'Entry Level', ''),
(4, 'Luxury Finish', ''),
(5, 'Premium Finish', '');

-- --------------------------------------------------------

--
-- Table structure for table `logindata`
--

CREATE TABLE `logindata` (
  `id` int NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `type` int UNSIGNED DEFAULT '0',
  `status` int UNSIGNED NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `month`
--

CREATE TABLE `month` (
  `id` int UNSIGNED NOT NULL,
  `month` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `month`
--

INSERT INTO `month` (`id`, `month`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Table structure for table `offerletters`
--

CREATE TABLE `offerletters` (
  `id` int NOT NULL,
  `file` text,
  `prospectProperty_id` int NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offerletters`
--

INSERT INTO `offerletters` (`id`, `file`, `prospectProperty_id`, `date_added`) VALUES
(1, '200726130919DSC_0155 (2).JPG', 9, '2020-07-26 11:09:19'),
(3, '200726190439Flier 01.png', 12, '2020-07-26 17:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `id` int NOT NULL,
  `clientproperty_id` int NOT NULL,
  `date` date NOT NULL,
  `amount` bigint NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`id`, `clientproperty_id`, `date`, `amount`, `status`) VALUES
(1, 3, '2020-11-30', 19042500, 0),
(2, 3, '2020-08-31', 180000, 1),
(3, 3, '2020-09-05', 20000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(225) DEFAULT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `state`, `description`, `logo`, `code`) VALUES
(1, 'The Bridge Peridot', 'FCT', 'Mbora District', '171107163336thebridgelogo-484x254.png', 'hbg'),
(2, 'Imperial Vista', 'FCT', 'Kafe District, Life Camp', '171107165018imperial-vista-logo-1-484x254.png', 'imp'),
(3, 'Brookshore Residence', 'FCT', 'Karsana South Gwarimpa Extension', NULL, 'hbr'),
(4, 'The Bridge Garnet', 'FCT', 'Galadimawa', '', 'tbg');

-- --------------------------------------------------------

--
-- Table structure for table `project_property`
--

CREATE TABLE `project_property` (
  `id` int UNSIGNED NOT NULL,
  `project_id` int UNSIGNED NOT NULL,
  `property_type` varchar(225) NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `amount` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_property`
--

INSERT INTO `project_property` (`id`, `project_id`, `property_type`, `quantity`, `amount`) VALUES
(2, 2, 'Peaked Terraces', 102, 69900000),
(3, 2, 'Arrow Head', 40, 89900000),
(4, 2, 'Hexagon', 60, 99900000),
(5, 2, 'Cubiq', 13, 119900000),
(6, 2, 'CubiQ 750', 5, 149900000);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int UNSIGNED NOT NULL,
  `project_id` int UNSIGNED NOT NULL,
  `type_id` int UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `amount` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` int UNSIGNED NOT NULL,
  `propertytype` varchar(45) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prospectplan`
--

CREATE TABLE `prospectplan` (
  `id` int NOT NULL,
  `prospectproperty_id` int NOT NULL,
  `date` date NOT NULL,
  `amount` bigint NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prospectplan`
--

INSERT INTO `prospectplan` (`id`, `prospectproperty_id`, `date`, `amount`, `status`) VALUES
(14, 3, '2020-11-30', 19042500, 0),
(27, 3, '2020-08-31', 180000, 1),
(29, 3, '2020-09-05', 20000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prospects`
--

CREATE TABLE `prospects` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(45) NOT NULL,
  `title` varchar(25) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `occupation` varchar(45) NOT NULL,
  `address` text NOT NULL,
  `staffid` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prospects`
--

INSERT INTO `prospects` (`id`, `email`, `title`, `lastname`, `firstname`, `middlename`, `sex`, `dob`, `phone`, `mobile`, `occupation`, `address`, `staffid`) VALUES
(1, 'emeka.daniels@gmail.com', 'Mr', 'Doe', 'John', '', 'Male', '2020-06-08', '08033318112', '', 'N/A', 'FCT - Abuja', 12),
(2, 'hck@gmail.com', 'Alh', 'Musa', 'Adamu', '', 'Male', '2020-08-12', '08033318112', '', 'NA', 'FCT - Abuja', 12);

-- --------------------------------------------------------

--
-- Table structure for table `prospect_property`
--

CREATE TABLE `prospect_property` (
  `id` int UNSIGNED NOT NULL,
  `fileid` varchar(10) DEFAULT NULL,
  `prospect_id` int NOT NULL,
  `property_id` int NOT NULL,
  `quantity` int NOT NULL,
  `investmentcategory_id` int NOT NULL,
  `amount` int NOT NULL,
  `tax` float NOT NULL,
  `comment` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `staff_id` int UNSIGNED NOT NULL,
  `rfo` int UNSIGNED NOT NULL DEFAULT '0',
  `payStatus` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prospect_property`
--

INSERT INTO `prospect_property` (`id`, `fileid`, `prospect_id`, `property_id`, `quantity`, `investmentcategory_id`, `amount`, `tax`, `comment`, `date`, `staff_id`, `rfo`, `payStatus`) VALUES
(3, NULL, 1, 2, 1, 1, 19242500, 7.5, 'This is the space for additional information concerning this transaction.', '2020-08-25 14:52:08', 12, 2, 2),
(4, NULL, 1, 2, 1, 1, 25746250, 7.5, 'This is the space for additional information concerning this transaction.', '2020-08-18 09:20:18', 12, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `repository`
--

CREATE TABLE `repository` (
  `id` int NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `title` text,
  `department_id` int NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `repository`
--

INSERT INTO `repository` (`id`, `file`, `title`, `department_id`, `date_added`) VALUES
(2, '200626152330Designed to Grow with you.docx', 'Article: Designed to Grow with You.', 1, '2020-06-26 13:23:30'),
(8, '200715170748STEP ONE_CAM 003_crop 1.jpg', 'Admin File', 9, '2020-07-15 15:07:48'),
(9, '200719101005placeholder.png', 'Article: Designed to Grow with You.', 1, '2020-07-19 10:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Super Admin'),
(2, 'Super Admin'),
(3, 'Office Admin'),
(4, 'Accounts'),
(5, 'Staff'),
(6, 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `id` int UNSIGNED NOT NULL,
  `roleid` varchar(45) NOT NULL,
  `page` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `role_id` varchar(20) NOT NULL,
  `department_id` int NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1',
  `pic` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `email`, `password`, `lastname`, `firstname`, `middlename`, `sex`, `dob`, `role_id`, `department_id`, `status`, `pic`) VALUES
(1, 'superadmin@promisys.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Super', 'Admin', '', '', '0000-00-00', '1', 0, 1, NULL),
(2, 'abimbola.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ABIMBOLA', 'OLORUNSIWA', '', 'Female', '2018-04-10', '5', 1, 1, NULL),
(3, 'abiodun.o@hall7projects.com', 'e10adc3949ba59abbe56e057f20f883e', 'OLATUNJI', 'ABIODUN', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(4, 'adedotun.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ADERIBIGBE', 'ADEDOTUN', '', 'Female', '2018-04-10', '5', 1, 1, NULL),
(5, 'adetutu.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'HADIZA', 'ADETUTU', 'ATTA', 'Female', '2018-04-10', '5', 0, 1, NULL),
(8, 'bernaiah.t@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'TARGEMA', 'BERNAIAH', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(10, 'chinwe.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ELEKULA', 'CHINWE', 'UDEZE', 'Female', '2018-04-10', '5', 8, 1, NULL),
(11, 'chioma.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'CHIOMA', 'OBIORAH', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(12, 'chukwuemeka.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NWANERI', 'CHUKWUEMEKA', 'DANIEL', 'Male', '1981-07-27', '5', 0, 1, NULL),
(13, 'clara.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'CLARA', 'EMELIFE', '', 'Female', '2018-04-10', '5', 6, 1, NULL),
(14, 'daniel.y@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'DANIEL', 'YAKUBU', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(15, 'daniella.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'CHIZOROM', 'DANIELLA', 'UKWA', 'Female', '2018-04-10', '5', 0, 1, NULL),
(16, 'david.j@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JIYA', 'DAVID', 'YABAGI', 'Female', '2018-04-10', '5', 1, 1, NULL),
(20, 'ekaette.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'EKAETTE', 'EKENE', '', 'Female', '2018-04-10', '5', 2, 1, NULL),
(21, 'elizabeth.m@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ELIZABETH', 'MARTIN', '', 'Female', '2018-04-10', '5', 2, 1, NULL),
(22, 'emmanuel.m@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'EMMANUEL', 'MUSA', '', 'Female', '2018-04-10', '5', 12, 1, NULL),
(23, 'emmanuel.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NNADOZIE', 'EMMANUEL', 'CHIDI', 'Female', '2018-04-10', '5', 0, 1, NULL),
(24, 'fatima.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'FATIMA', 'SULEIMAN', 'SANUSI', 'Female', '2018-04-10', '5', 1, 1, NULL),
(25, 'femi.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ADEBODUN', 'MOFOLORUNSHO', 'FEMI', 'Female', '2018-04-10', '5', 1, 1, NULL),
(26, 'gana.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'GANA', 'NIMJUL', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(27, 'gboyega.f@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'FASAWE', 'GBOYEGA', '', 'Female', '2018-04-10', '5', 7, 1, NULL),
(28, 'gladys.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'GLADYS', 'IWATAN', '', 'Female', '2018-04-10', '5', 1, 1, NULL),
(29, 'ibanga.u@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'IBANGA', 'UBOKOBONG', '', 'Female', '2018-04-10', '5', 1, 1, NULL),
(30, 'ifeoluwa.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'IFE', 'ODUGBESAN', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(31, 'inori.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'INORI', 'OKWOCHE', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(32, 'ire.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'GRACE', 'IGBINOVIA', '', 'Female', '2018-04-10', '5', 1, 1, NULL),
(33, 'jaja.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SODEIYE', 'JAJA', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(34, 'jighjigh.k@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JIGHJIGH', 'KUKU', '', 'Female', '2018-04-10', '5', 11, 1, NULL),
(35, 'joseph.m@hallprojects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NDZIKAHYEL', 'JOSEPH', 'MSHELIA', 'Female', '2018-04-10', '5', 0, 1, NULL),
(36, 'joshua.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JOSHUA', 'ASUN', '', 'Female', '2018-04-10', '5', 1, 1, NULL),
(37, 'joy.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JOY', 'ONYEKACHI', '', 'Female', '2018-04-10', '5', 1, 1, NULL),
(38, 'kelechi.j@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'KELECHI', 'JOHN', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(39, 'kelechi.u@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'KELECHI', 'UNADIKE', '', 'Female', '2018-04-10', '5', 7, 1, NULL),
(40, 'kenneth.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ADEBOLA', 'KENNETH', 'OLAWALE', 'Female', '2018-04-10', '3', 9, 1, NULL),
(41, 'lola.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'LOLA', 'IJAGBEMI', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(42, 'maimuna.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'MAIMUNA', 'SANUSI', 'SULEIMAN', 'Female', '2018-04-10', '5', 0, 1, NULL),
(43, 'maureen.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'MAUREEN', 'EZEONWU', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(44, 'mayowa.f@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OLUMAYOWA', 'FAPOHUNDA', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(45, 'mukhtar.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'MUKHTAR', 'OYEWO', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(46, 'ndubuisi.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NDUBUISI', 'ABALI', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(47, 'noah.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SALAMI', 'NOAH', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(48, 'ogbe.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ENIGHENO', 'GUY', 'OGBE', 'Female', '2018-04-10', '5', 0, 1, NULL),
(49, 'ogechukwu.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'UKPABIA', 'OGECHUKWU', 'IFEOMA', 'Female', '2018-04-10', '5', 0, 1, NULL),
(50, 'olusola.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OLUSOLA', 'OMOKOGA', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(51, 'oluwafemi.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'IDOWU', 'RASHEED', 'OLUWAFEMI', 'Female', '2018-04-10', '5', 0, 1, NULL),
(52, 'osayi.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ENOBUN', 'OSAYI', 'JOSEPH', 'Female', '2018-04-10', '5', 0, 1, NULL),
(53, 'oses.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OSEIKHUMEN', 'R.', 'OBOIGBATOR', 'Female', '2018-04-10', '5', 0, 1, NULL),
(54, 'patricia.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'PATRICIA', 'I.', 'OZIOKO', 'Female', '2018-04-10', '3', 0, 1, NULL),
(55, 'peter.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'PETER', 'ECHE', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(56, 'ozioma.t@hall7projects.com', 'a59d5dce79f8d4bb273eecd10c53d697', 'ROSEMARY', 'OZIOMA', 'TUKURA', 'Female', '2018-04-10', '3', 0, 1, NULL),
(57, 'russell.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'RUSSELL', 'E.', 'NWUDE', 'Female', '2018-04-10', '5', 0, 1, NULL),
(58, 'samuel.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SAMUEL', 'BABAJIDE', 'OSORE', 'Female', '2018-04-10', '5', 0, 1, NULL),
(59, 'sesugh.g@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SESUGH', 'GBANDE', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(60, 'simon.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OTUGBO', 'SIMON.A', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(61, 'stella.c@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'STELLA', 'CHIGOZIE', 'SAMUEL', 'Female', '2018-04-10', '5', 0, 1, NULL),
(62, 'suleiman.r@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SULEIMAN', 'BASHIR', 'RIBADU', 'Female', '2018-04-10', '5', 13, 1, NULL),
(63, 'tobi.m@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OLUWATOBI', 'MAKANJUOLA', '', 'Female', '2018-04-10', '5', 3, 1, NULL),
(64, 'tucore.r@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SIMON', 'TUCORE', 'RAPHAEL', 'Female', '2018-04-10', '5', 0, 1, NULL),
(65, 'uchenna.d@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'UCHENNA', 'F.', 'DURUMERUO', 'Female', '2018-04-10', '5', 0, 1, NULL),
(66, 'usman.b@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'USMAN', 'ADAMU', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(67, 'victor.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'VICTOR', 'AYANNIYI', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(68, 'vivian.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'VIVIAN', 'EZEUCHE', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(69, 'vivianne.t@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'VIVIANNE', 'OLAIDE', 'THOMAS', 'Female', '2018-04-10', '5', 0, 1, NULL),
(70, 'weyinmi.e@hall7projects.com', '4b1cba12d5e7b6a0fcd30bdda6cf5dc3', 'EYETSEMITAN', 'WEYINMI', '', 'Female', '2018-04-10', '3', 9, 1, NULL),
(71, 'yunusa.f@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'FAROUQ', 'YUNUSA', '', 'Female', '2018-04-10', '5', 0, 1, NULL),
(72, 'akudo.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'AKUDO', 'NWOKORIE', '', 'Female', '2018-04-10', '5', 10, 1, NULL),
(74, 'deborah.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'AJIBOLA', 'DEBORAH', '', 'Female', '2018-04-10', '5', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_new`
--

CREATE TABLE `staff_new` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `role_id` varchar(20) NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1',
  `pic` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_new`
--

INSERT INTO `staff_new` (`id`, `email`, `password`, `lastname`, `firstname`, `middlename`, `sex`, `dob`, `role_id`, `status`, `pic`) VALUES
(1, 'abimbola.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ABIMBOLA', 'OLORUNSIWA', '', 'Female', '2018-04-10', '5', 1, NULL),
(2, 'abiodun.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OLATUNJI', 'ABIODUN', '', 'Female', '2018-04-10', '5', 1, NULL),
(3, 'adedotun.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ADERIBIGBE', 'ADEDOTUN', '', 'Female', '2018-04-10', '5', 1, NULL),
(4, 'adetutu.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'HADIZA', 'ADETUTU', 'ATTA', 'Female', '2018-04-10', '5', 1, NULL),
(5, 'akudo.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'AKUDO', 'NWOKORIE', '', 'Female', '2018-04-10', '5', 1, NULL),
(6, 'ann.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ANN', 'IHUOMA', 'IKPE', 'Female', '2018-04-10', '5', 1, NULL),
(7, 'bernaiah.t@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'TARGEMA', 'BERNAIAH', '', 'Female', '2018-04-10', '5', 1, NULL),
(8, 'chinenye.w@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'CHINENYE', 'WILLIE-NWOBU', '', 'Female', '2018-04-10', '5', 1, NULL),
(9, 'chinwe.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ELEKULA', 'CHINWE', 'UDEZE', 'Female', '2018-04-10', '5', 1, NULL),
(10, 'chioma.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'CHIOMA', 'OBIORAH', '', 'Female', '2018-04-10', '5', 1, NULL),
(11, 'chukwuemeka.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NWANERI', 'CHUKWUEMEKA', 'DANIEL', 'Female', '2018-04-10', '5', 1, NULL),
(12, 'clara.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'CLARA', 'EMELIFE', '', 'Female', '2018-04-10', '5', 1, NULL),
(13, 'daniel.y@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'DANIEL', 'YAKUBU', '', 'Female', '2018-04-10', '5', 1, NULL),
(14, 'daniella.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'CHIZOROM', 'DANIELLA', 'UKWA', 'Female', '2018-04-10', '5', 1, NULL),
(15, 'david.j@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JIYA', 'DAVID', 'YABAGI', 'Female', '2018-04-10', '5', 1, NULL),
(16, 'deborah.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'AJIBOLA', 'DEBORAH', 'TEMITOPE', 'Female', '2018-04-10', '5', 1, NULL),
(17, 'edwin.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'EDWIN', 'ODEH', 'AGADA', 'Female', '2018-04-10', '5', 1, NULL),
(18, 'egwim.c@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'EGWIM', 'CHARLES', 'NNAMDI', 'Female', '2018-04-10', '5', 1, NULL),
(19, 'ekaette.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'EKAETTE', 'EKENE', '', 'Female', '2018-04-10', '5', 1, NULL),
(20, 'elizabeth.m@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ELIZABETH', 'MARTIN', '', 'Female', '2018-04-10', '5', 1, NULL),
(21, 'emmanuel.m@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'EMMANUEL', 'MUSA', '', 'Female', '2018-04-10', '5', 1, NULL),
(22, 'emmanuel.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NNADOZIE', 'EMMANUEL', 'CHIDI', 'Female', '2018-04-10', '5', 1, NULL),
(23, 'fatima.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'FATIMA', 'SULEIMAN', 'SANUSI', 'Female', '2018-04-10', '5', 1, NULL),
(24, 'femi.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ADEBODUN', 'MOFOLORUNSHO', 'FEMI', 'Female', '2018-04-10', '5', 1, NULL),
(25, 'gana.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'GANA', 'NIMJUL', '', 'Female', '2018-04-10', '5', 1, NULL),
(26, 'gboyega.f@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'FASAWE', 'GBOYEGA', '', 'Female', '2018-04-10', '5', 1, NULL),
(27, 'gladys.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'GLADYS', 'IWATAN', '', 'Female', '2018-04-10', '5', 1, NULL),
(28, 'ibanga.u@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'IBANGA', 'UBOKOBONG', '', 'Female', '2018-04-10', '5', 1, NULL),
(29, 'ifeoluwa.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'IFE', 'ODUGBESAN', '', 'Female', '2018-04-10', '5', 1, NULL),
(30, 'inori.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'INORI', 'OKWOCHE', '', 'Female', '2018-04-10', '5', 1, NULL),
(31, 'ire.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'GRACE', 'IGBINOVIA', '', 'Female', '2018-04-10', '5', 1, NULL),
(32, 'jaja.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SODEIYE', 'JAJA', '', 'Female', '2018-04-10', '5', 1, NULL),
(33, 'jighjigh.k@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JIGHJIGH', 'KUKU', '', 'Female', '2018-04-10', '5', 1, NULL),
(34, 'joseph.m@hallprojects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NDZIKAHYEL', 'JOSEPH', 'MSHELIA', 'Female', '2018-04-10', '5', 1, NULL),
(35, 'joshua.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JOSHUA', 'ASUN', '', 'Female', '2018-04-10', '5', 1, NULL),
(36, 'joy.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'JOY', 'ONYEKACHI', '', 'Female', '2018-04-10', '5', 1, NULL),
(37, 'kelechi.j@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'KELECHI', 'JOHN', '', 'Female', '2018-04-10', '5', 1, NULL),
(38, 'kelechi.u@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'KELECHI', 'UNADIKE', '', 'Female', '2018-04-10', '5', 1, NULL),
(39, 'kenneth.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ADEBOLA', 'KENNETH', 'OLAWALE', 'Female', '2018-04-10', '5', 1, NULL),
(40, 'lola.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'LOLA', 'IJAGBEMI', '', 'Female', '2018-04-10', '5', 1, NULL),
(41, 'maimuna.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'MAIMUNA', 'SANUSI', 'SULEIMAN', 'Female', '2018-04-10', '5', 1, NULL),
(42, 'maureen.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'MAUREEN', 'EZEONWU', '', 'Female', '2018-04-10', '5', 1, NULL),
(43, 'mayowa.f@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OLUMAYOWA', 'FAPOHUNDA', '', 'Female', '2018-04-10', '5', 1, NULL),
(44, 'mukhtar.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'MUKHTAR', 'OYEWO', '', 'Female', '2018-04-10', '5', 1, NULL),
(45, 'ndubuisi.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'NDUBUISI', 'ABALI', '', 'Female', '2018-04-10', '5', 1, NULL),
(46, 'noah.s@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SALAMI', 'NOAH', '', 'Female', '2018-04-10', '5', 1, NULL),
(47, 'ogbe.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ENIGHENO', 'GUY', 'OGBE', 'Female', '2018-04-10', '5', 1, NULL),
(48, 'ogechukwu.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'UKPABIA', 'OGECHUKWU', 'IFEOMA', 'Female', '2018-04-10', '5', 1, NULL),
(49, 'olusola.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OLUSOLA', 'OMOKOGA', '', 'Female', '2018-04-10', '5', 1, NULL),
(50, 'oluwafemi.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'IDOWU', 'RASHEED', 'OLUWAFEMI', 'Female', '2018-04-10', '5', 1, NULL),
(51, 'osayi.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ENOBUN', 'OSAYI', 'JOSEPH', 'Female', '2018-04-10', '5', 1, NULL),
(52, 'oses.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OSEIKHUMEN', 'R.', 'OBOIGBATOR', 'Female', '2018-04-10', '5', 1, NULL),
(53, 'patricia.i@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'PATRICIA', 'I.', 'OZIOKO', 'Female', '2018-04-10', '5', 1, NULL),
(54, 'peter.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'PETER', 'ECHE', '', 'Female', '2018-04-10', '5', 1, NULL),
(55, 'rosemary.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ROSEMARY', 'OZIOMA', 'TUKURA', 'Female', '2018-04-10', '5', 1, NULL),
(56, 'russell.n@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'RUSSELL', 'E.', 'NWUDE', 'Female', '2018-04-10', '5', 1, NULL),
(57, 'samuel.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SAMUEL', 'BABAJIDE', 'OSORE', 'Female', '2018-04-10', '5', 1, NULL),
(58, 'sesugh.g@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SESUGH', 'GBANDE', '', 'Female', '2018-04-10', '5', 1, NULL),
(59, 'simon.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OTUGBO', 'SIMON.A', '', 'Female', '2018-04-10', '5', 1, NULL),
(60, 'stella.c@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'STELLA', 'CHIGOZIE', 'SAMUEL', 'Female', '2018-04-10', '5', 1, NULL),
(61, 'suleiman.r@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SULEIMAN', 'BASHIR', 'RIBADU', 'Female', '2018-04-10', '5', 1, NULL),
(62, 'tobi.m@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'OLUWATOBI', 'MAKANJUOLA', '', 'Female', '2018-04-10', '5', 1, NULL),
(64, 'tucore.r@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'SIMON', 'TUCORE', 'RAPHAEL', 'Female', '2018-04-10', '5', 1, NULL),
(65, 'uchenna.d@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'UCHENNA', 'F.', 'DURUMERUO', 'Female', '2018-04-10', '5', 1, NULL),
(66, 'usman.b@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'USMAN', 'ADAMU', '', 'Female', '2018-04-10', '5', 1, NULL),
(67, 'victor.a@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'VICTOR', 'AYANNIYI', '', 'Female', '2018-04-10', '5', 1, NULL),
(68, 'vivian.o@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'VIVIAN', 'EZEUCHE', '', 'Female', '2018-04-10', '5', 1, NULL),
(69, 'vivianne.t@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'VIVIANNE', 'OLAIDE', 'THOMAS', 'Female', '2018-04-10', '5', 1, NULL),
(70, 'weyinmi.e@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'EYETSEMITAN', 'WEYINMI', '', 'Female', '2018-04-10', '5', 1, NULL),
(71, 'yunusa.f@hall7projects.com', '827ccb0eea8a706c4c34a16891f84e7b', 'FAROUQ', 'YUNUSA', '', 'Female', '2018-04-10', '5', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int UNSIGNED NOT NULL,
  `state` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `state`) VALUES
(1, 'ABIA'),
(2, 'ADAMAWA'),
(3, 'AKWA IBOM'),
(4, 'ANAMBRA'),
(5, 'BAUCHI'),
(6, 'BAYELSA'),
(7, 'BENUE'),
(8, 'BORNO'),
(9, 'CROSS RIVER'),
(10, 'DELTA'),
(11, 'EBONYI'),
(12, 'EDO'),
(13, 'EKITI'),
(14, 'ENUGU'),
(15, 'FCT'),
(16, 'GOMBE'),
(17, 'IMO'),
(18, 'JIGAWA'),
(19, 'KADUNA'),
(20, 'KANO'),
(21, 'KATSINA'),
(22, 'KEBBI'),
(23, 'KOGI'),
(24, 'KWARA'),
(25, 'LAGOS'),
(26, 'NASARAWA'),
(27, 'NIGER'),
(28, 'OGUN'),
(29, 'ONDO'),
(30, 'OSUN'),
(31, 'OYO'),
(32, 'PLATEAU'),
(33, 'RIVERS'),
(34, 'SOKOTO'),
(35, 'TARABA'),
(36, 'YOBE'),
(37, 'ZAMFARA'),
(38, 'OTHERS');

-- --------------------------------------------------------

--
-- Table structure for table `tbg`
--

CREATE TABLE `tbg` (
  `id` int UNSIGNED NOT NULL,
  `client_property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign`
--
ALTER TABLE `assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_type_price`
--
ALTER TABLE `change_type_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_property`
--
ALTER TABLE `client_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_property_old`
--
ALTER TABLE `client_property_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comms`
--
ALTER TABLE `comms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `croncounter`
--
ALTER TABLE `croncounter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hbg`
--
ALTER TABLE `hbg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hbr`
--
ALTER TABLE `hbr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hod`
--
ALTER TABLE `hod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imp`
--
ALTER TABLE `imp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_category`
--
ALTER TABLE `investment_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logindata`
--
ALTER TABLE `logindata`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `month`
--
ALTER TABLE `month`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offerletters`
--
ALTER TABLE `offerletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_property`
--
ALTER TABLE `project_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prospectplan`
--
ALTER TABLE `prospectplan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prospects`
--
ALTER TABLE `prospects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prospect_property`
--
ALTER TABLE `prospect_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repository`
--
ALTER TABLE `repository`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_new`
--
ALTER TABLE `staff_new`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbg`
--
ALTER TABLE `tbg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assign`
--
ALTER TABLE `assign`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `change_type_price`
--
ALTER TABLE `change_type_price`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_property_old`
--
ALTER TABLE `client_property_old`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comms`
--
ALTER TABLE `comms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `croncounter`
--
ALTER TABLE `croncounter`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hbg`
--
ALTER TABLE `hbg`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hbr`
--
ALTER TABLE `hbr`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hod`
--
ALTER TABLE `hod`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `imp`
--
ALTER TABLE `imp`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `investment_category`
--
ALTER TABLE `investment_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logindata`
--
ALTER TABLE `logindata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `month`
--
ALTER TABLE `month`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `offerletters`
--
ALTER TABLE `offerletters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_property`
--
ALTER TABLE `project_property`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prospectplan`
--
ALTER TABLE `prospectplan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prospect_property`
--
ALTER TABLE `prospect_property`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `repository`
--
ALTER TABLE `repository`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_access`
--
ALTER TABLE `role_access`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `staff_new`
--
ALTER TABLE `staff_new`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbg`
--
ALTER TABLE `tbg`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

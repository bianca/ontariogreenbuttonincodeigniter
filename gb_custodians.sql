-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2013 at 07:47 PM
-- Server version: 5.6.10
-- PHP Version: 5.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mygreenneighbour`
--

-- --------------------------------------------------------

--
-- Table structure for table `gb_custodians`
--

CREATE TABLE IF NOT EXISTS `gb_custodians` (
  `name` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `registration_url` varchar(100) NOT NULL,
  `authorization_url` varchar(100) NOT NULL,
  `token_endpoint` varchar(100) NOT NULL,
  `revoke_endpoint` varchar(100) NOT NULL,
  `usage_endpoint` varchar(100) NOT NULL,
  `subscription_endpoint` varchar(100) NOT NULL,
  `readservice_endpoint` varchar(100) NOT NULL,
  `readauthorization_endpoint` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gb_custodians`
--

INSERT INTO `gb_custodians` (`name`, `profile`, `website`, `registration_url`, `authorization_url`, `token_endpoint`, `revoke_endpoint`, `usage_endpoint`, `subscription_endpoint`, `readservice_endpoint`, `readauthorization_endpoint`) VALUES
('affsys', '', 'greenbutton.affsys.com', 'https://greenbutton.affsys.com/auth/signin.jsp', 'https://greenbutton.affsys.com/auth/signin.jsp', 'https://greenbutton.affsys.com/auth/j_oauth_resolve_access_code', ' https:// greenbutton.affsys.com/auth/j_oauth_token_grant', 'https://greenbutton.affsys.com/ldc/api/v1/UsagePoint', 'https://greenbutton.affsys.com/ldc/api/v1/Subscription', ' https://greenbutton.affsys.com/ldc/api/v1/ReadServiceStatus', 'https://greenbutton.affsys.com/ldc/api/v1/ReadAuthorizationStatus');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

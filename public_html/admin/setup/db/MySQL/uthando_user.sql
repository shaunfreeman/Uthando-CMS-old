-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2010 at 08:10 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uthando_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(10) unsigned NOT NULL DEFAULT '4',
  `email_type_id` int(10) unsigned NOT NULL DEFAULT '1',
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `iv` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activation` int(1) NOT NULL DEFAULT '1',
  `block` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`,`email`),
  KEY `name` (`first_name`,`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE IF NOT EXISTS `user_groups` (
  `user_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group` varchar(50) NOT NULL,
  PRIMARY KEY (`user_group_id`),
  UNIQUE KEY `user_type` (`user_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_orders`
--

DROP TABLE IF EXISTS `ushop_orders`;
CREATE TABLE IF NOT EXISTS `ushop_orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `order_status_id` int(4) unsigned NOT NULL,
  `invoice` int(10) unsigned NOT NULL,
  `total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `shipping` decimal(4,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(100) NOT NULL,
  `txn_id` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `invoice` (`invoice`),
  KEY `customer_id` (`user_id`),
  KEY `order_date` (`order_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_order_items`
--

DROP TABLE IF EXISTS `ushop_order_items`;
CREATE TABLE IF NOT EXISTS `ushop_order_items` (
  `order_item_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `order_id` int(5) unsigned NOT NULL,
  `product_id` int(5) unsigned NOT NULL,
  `quantity` int(5) unsigned NOT NULL,
  `item_price` decimal(10,2) unsigned NOT NULL,
  `tax` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_order_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_user_cda`
--

DROP TABLE IF EXISTS `ushop_user_cda`;
CREATE TABLE IF NOT EXISTS `ushop_user_cda` (
  `user_cda_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_info_id` int(5) unsigned NOT NULL DEFAULT '0',
  `country_id` int(2) unsigned NOT NULL DEFAULT '0',
  `address1` varchar(45) NOT NULL DEFAULT '',
  `address2` varchar(45) DEFAULT NULL,
  `address3` varchar(60) DEFAULT NULL,
  `city` varchar(45) NOT NULL DEFAULT '',
  `county` varchar(45) NOT NULL DEFAULT '',
  `phone` varchar(15) NOT NULL DEFAULT '0',
  `post_code` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_cda_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_user_cda`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_user_info`
--

DROP TABLE IF EXISTS `ushop_user_info`;
CREATE TABLE IF NOT EXISTS `ushop_user_info` (
  `user_info_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(255) unsigned NOT NULL,
  `prefix_id` int(1) unsigned DEFAULT '0',
  `country_id` int(2) unsigned DEFAULT '0',
  `user_cda_id` int(5) unsigned DEFAULT '0',
  `address1` varchar(80) DEFAULT NULL,
  `address2` varchar(80) DEFAULT NULL,
  `address3` varchar(60) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `county` varchar(40) DEFAULT NULL,
  `post_code` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`user_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_user_info`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_user_prefix`
--

DROP TABLE IF EXISTS `ushop_user_prefix`;
CREATE TABLE IF NOT EXISTS `ushop_user_prefix` (
  `prefix_id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`prefix_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_user_prefix`
--

INSERT INTO `ushop_user_prefix` (`prefix_id`, `prefix`) VALUES(1, 'Mr.');
INSERT INTO `ushop_user_prefix` (`prefix_id`, `prefix`) VALUES(2, 'Mrs.');
INSERT INTO `ushop_user_prefix` (`prefix_id`, `prefix`) VALUES(3, 'Ms.');
INSERT INTO `ushop_user_prefix` (`prefix_id`, `prefix`) VALUES(4, 'Miss.');
INSERT INTO `ushop_user_prefix` (`prefix_id`, `prefix`) VALUES(5, 'Dr.');
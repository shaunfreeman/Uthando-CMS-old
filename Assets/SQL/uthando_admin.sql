-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2010 at 12:47 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uthando_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `component_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `component` varchar(45) NOT NULL,
  `version` varchar(10) NOT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`component_id`),
  UNIQUE KEY `conponent` (`component`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`component_id`, `component`, `version`, `enabled`) VALUES
(1, 'user', '1', 1),
(2, 'content', '1', 1),
(3, 'admin', '1', 1),
(4, 'ushop', '1', 1),
(5, 'menu', '1', 1),
(6, 'template', '1', 1),
(7, 'media', '1.0rc1', 1),
(8, 'component', '1', 1),
(9, 'module', '1', 1),
(10, 'plugin', '1', 1),
(11, 'webmail', '0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_type_id` int(10) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL DEFAULT '0',
  `url_id` int(10) unsigned DEFAULT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `item_type_id` int(10) unsigned DEFAULT NULL,
  `item` varchar(60) NOT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES
(1, NULL, 2, 1, NULL, 1, 'Admin', 2, 3),
(2, NULL, 2, 4, NULL, 1, 'Menus', 4, 5),
(3, NULL, 2, 5, NULL, 1, 'Content', 6, 7),
(4, NULL, 2, 2, NULL, 1, 'Logout', 10, 11),
(5, 1, 2, NULL, NULL, NULL, 'Main Menu', 1, 12),
(6, NULL, 2, 6, NULL, 1, 'Ushop', 8, 9);

-- --------------------------------------------------------

--
-- Table structure for table `menu_urls`
--

CREATE TABLE IF NOT EXISTS `menu_urls` (
  `url_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(45) NOT NULL DEFAULT '',
  `enssl` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`url_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menu_urls`
--

INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES
(1, 'admin/overview', 0),
(2, 'user/logout', 0),
(4, 'menu/overview', 0),
(5, 'content/overview', 0),
(6, 'ushop/overview', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_name_id` int(10) unsigned NOT NULL DEFAULT '0',
  `position_id` int(10) unsigned NOT NULL DEFAULT '0',
  `module` varchar(45) NOT NULL,
  `sort_order` int(2) unsigned NOT NULL DEFAULT '0',
  `show_title` int(1) unsigned NOT NULL DEFAULT '0',
  `params` text,
  `html` text,
  `enabled` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`),
  KEY `module_name_id` (`module_name_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name_id`, `position_id`, `module`, `sort_order`, `show_title`, `params`, `html`, `enabled`) VALUES
(2, 1, 1, 'Main Menu', 2, 1, 'menu=Main Menu\r\nclass_sfx=\r\nmoduleclass_sfx=_menu brdPad\r\nlog_in=0', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules_position`
--

CREATE TABLE IF NOT EXISTS `modules_position` (
  `position_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `modules_position`
--

INSERT INTO `modules_position` (`position_id`, `position`) VALUES
(1, 'left');

-- --------------------------------------------------------

--
-- Table structure for table `module_names`
--

CREATE TABLE IF NOT EXISTS `module_names` (
  `module_name_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  PRIMARY KEY (`module_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module_names`
--

INSERT INTO `module_names` (`module_name_id`, `module_name`) VALUES
(1, 'menu'),
(2, 'custom');

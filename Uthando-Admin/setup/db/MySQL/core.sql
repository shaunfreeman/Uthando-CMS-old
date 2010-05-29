-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2010 at 12:25 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uthando_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

DROP TABLE IF EXISTS `components`;
CREATE TABLE IF NOT EXISTS `components` (
  `component_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `component` varchar(45) NOT NULL,
  `version` int(10) NOT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`component_id`),
  UNIQUE KEY `conponent` (`component`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`component_id`, `component`, `version`, `enabled`) VALUES(1, 'user', 1, 1);
INSERT INTO `components` (`component_id`, `component`, `version`, `enabled`) VALUES(2, 'content', 1, 1);
INSERT INTO `components` (`component_id`, `component`, `version`, `enabled`) VALUES(4, 'ushop', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_body`
--

DROP TABLE IF EXISTS `email_body`;
CREATE TABLE IF NOT EXISTS `email_body` (
  `email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(100) DEFAULT NULL,
  `body` text,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `email_body`
--

INSERT INTO `email_body` (`email_id`, `template`, `body`) VALUES(1, 'password reminder', 'Dear ####USER####\r\n\r\nYou have requested to be reminded of your password at ####SITE####.\r\n\r\nYour password is: ####PASSWORD####\r\n\r\nRegards\r\n####ADMINISTRATOR####  ');
INSERT INTO `email_body` (`email_id`, `template`, `body`) VALUES(2, 'register user', 'Dear ####USER####\r\n\r\nYou have registered an account at ####SITE####.\r\n\r\nYour password is: ####PASSWORD####\r\n\r\nRegards\r\n####ADMINISTRATOR####  ');

-- --------------------------------------------------------

--
-- Table structure for table `email_type`
--

DROP TABLE IF EXISTS `email_type`;
CREATE TABLE IF NOT EXISTS `email_type` (
  `email_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_type` varchar(10) NOT NULL DEFAULT 'html',
  PRIMARY KEY (`email_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `email_type`
--

INSERT INTO `email_type` (`email_type_id`, `email_type`) VALUES(1, 'html');
INSERT INTO `email_type` (`email_type_id`, `email_type`) VALUES(2, 'plain');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_type_id` int(11) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL DEFAULT '0',
  `url_id` int(10) unsigned DEFAULT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `item_type_id` int(10) unsigned DEFAULT NULL,
  `item` varchar(255) NOT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(1, 1, 1, NULL, NULL, NULL, 'Main Menu', 1, 12);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(2, 2, 1, NULL, NULL, NULL, 'Top Menu', 13, 20);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(3, NULL, 1, 1, 1, 1, 'Home', 2, 3);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(4, NULL, 3, 2, NULL, 1, 'Register', 6, 7);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(5, NULL, 3, 3, NULL, 1, 'Login', 8, 9);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(7, NULL, 2, 4, NULL, 1, 'Logout', 10, 11);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(8, NULL, 1, 1, 1, 1, 'Home', 14, 15);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(9, NULL, 1, 5, NULL, 1, 'Books', 4, 5);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(10, NULL, 1, 5, NULL, 1, 'Books', 16, 17);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(11, NULL, 1, 6, NULL, 1, 'Terms', 18, 19);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(12, 1, 2, NULL, NULL, NULL, 'My Account', 21, 28);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(13, NULL, 2, 7, NULL, 1, 'Overview', 22, 23);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(14, NULL, 2, 9, NULL, 1, 'Change Details', 24, 25);
INSERT INTO `menu_items` (`item_id`, `menu_type_id`, `status_id`, `url_id`, `page_id`, `item_type_id`, `item`, `lft`, `rgt`) VALUES(15, NULL, 2, 10, NULL, 1, 'Change Address', 26, 27);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_types`
--

DROP TABLE IF EXISTS `menu_item_types`;
CREATE TABLE IF NOT EXISTS `menu_item_types` (
  `item_type_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `item_type` varchar(255) NOT NULL,
  PRIMARY KEY (`item_type_id`),
  KEY `item_type` (`item_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `menu_item_types`
--

INSERT INTO `menu_item_types` (`item_type_id`, `item_type`) VALUES(1, 'component');
INSERT INTO `menu_item_types` (`item_type_id`, `item_type`) VALUES(2, 'external');
INSERT INTO `menu_item_types` (`item_type_id`, `item_type`) VALUES(3, 'heading');

-- --------------------------------------------------------

--
-- Table structure for table `menu_link_status`
--

DROP TABLE IF EXISTS `menu_link_status`;
CREATE TABLE IF NOT EXISTS `menu_link_status` (
  `status_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `status` char(2) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `menu_link_status`
--

INSERT INTO `menu_link_status` (`status_id`, `status`) VALUES(1, 'A');
INSERT INTO `menu_link_status` (`status_id`, `status`) VALUES(2, 'LI');
INSERT INTO `menu_link_status` (`status_id`, `status`) VALUES(3, 'LO');

-- --------------------------------------------------------

--
-- Table structure for table `menu_types`
--

DROP TABLE IF EXISTS `menu_types`;
CREATE TABLE IF NOT EXISTS `menu_types` (
  `menu_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_type` varchar(60) NOT NULL,
  PRIMARY KEY (`menu_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `menu_types`
--

INSERT INTO `menu_types` (`menu_type_id`, `menu_type`) VALUES(1, 'vertical');
INSERT INTO `menu_types` (`menu_type_id`, `menu_type`) VALUES(2, 'horizontal');

-- --------------------------------------------------------

--
-- Table structure for table `menu_urls`
--

DROP TABLE IF EXISTS `menu_urls`;
CREATE TABLE IF NOT EXISTS `menu_urls` (
  `url_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `enssl` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`url_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `menu_urls`
--

INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(1, 'content/article/page-Welcome_to_Charisma_Books', 0);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(2, 'user/register', 1);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(3, 'user/login', 1);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(4, 'user/logout', 0);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(5, 'ushop/view/shopfront', 0);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(6, 'ushop/view/terms', 0);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(7, 'user/overview', 1);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(9, 'user/change_details', 1);
INSERT INTO `menu_urls` (`url_id`, `url`, `enssl`) VALUES(10, 'ushop/view/change_details', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name_id`, `position_id`, `module`, `sort_order`, `show_title`, `params`, `html`, `enabled`) VALUES(1, 1, 3, 'Top Menu', 1, 0, 'menu=Top Menu\r\nclass_sfx=-nav\r\nmoduleclass_sfx=\r\nlog_in=0', NULL, 1);
INSERT INTO `modules` (`module_id`, `module_name_id`, `position_id`, `module`, `sort_order`, `show_title`, `params`, `html`, `enabled`) VALUES(2, 1, 1, 'Main Menu', 2, 1, 'menu=Main Menu\r\nclass_sfx=\r\nmoduleclass_sfx=_menu\r\nlog_in=0', NULL, 1);
INSERT INTO `modules` (`module_id`, `module_name_id`, `position_id`, `module`, `sort_order`, `show_title`, `params`, `html`, `enabled`) VALUES(3, 2, 1, 'Site Specs', 3, 1, 'log_in=0', '<p>\r\n	Site best viewed in a screen resolution of 1024x768 &#038; 32 bit colours or higher using the latest version of <a href="http://www.mozilla.com/en-US/firefox" target="_blank">Firefox</a>\r\n</p>\r\n<p>\r\n	<a href="http://www.mozilla.com/en-US/firefox" target="_blank">\r\n		<img src="/Common/images/firefox.png" />\r\n	</a>\r\n</p>', 1);
INSERT INTO `modules` (`module_id`, `module_name_id`, `position_id`, `module`, `sort_order`, `show_title`, `params`, `html`, `enabled`) VALUES(5, 1, 1, 'My Account', 3, 1, 'menu=My Account\r\nclass_sfx=\r\nmoduleclass_sfx=_menu\r\nlog_in=1', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules_position`
--

DROP TABLE IF EXISTS `modules_position`;
CREATE TABLE IF NOT EXISTS `modules_position` (
  `position_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `modules_position`
--

INSERT INTO `modules_position` (`position_id`, `position`) VALUES(1, 'left');
INSERT INTO `modules_position` (`position_id`, `position`) VALUES(2, 'right');
INSERT INTO `modules_position` (`position_id`, `position`) VALUES(3, 'top menu');

-- --------------------------------------------------------

--
-- Table structure for table `module_names`
--

DROP TABLE IF EXISTS `module_names`;
CREATE TABLE IF NOT EXISTS `module_names` (
  `module_name_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  PRIMARY KEY (`module_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module_names`
--

INSERT INTO `module_names` (`module_name_id`, `module_name`) VALUES(1, 'menu');
INSERT INTO `module_names` (`module_name_id`, `module_name`) VALUES(2, 'custom');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(60) NOT NULL,
  `content` text,
  `params` text,
  `cdate` datetime NOT NULL,
  `mdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_id`),
  KEY `title` (`page`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page`, `content`, `params`, `cdate`, `mdate`) VALUES(1, 'Welcome to Charisma Books', '<h1>Site Under Construction lhk''ddd @ "'' 2;;"''</h1>\r\n<div id="mooflow">&nbsp;</div>', 'a:4:{s:10:"show_title";s:1:"1";s:10:"show_cdate";s:1:"1";s:10:"show_mdate";s:1:"1";s:8:"metadata";a:2:{s:11:"description";s:0:"";s:8:"keywords";s:0:"";}}', '2009-05-13 12:58:36', '2010-01-19 13:57:50');

-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2010 at 08:37 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `ushop_authors`
--

DROP TABLE IF EXISTS `ushop_authors`;
CREATE TABLE IF NOT EXISTS `ushop_authors` (
  `author_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forename` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=329 ;

--
-- Dumping data for table `ushop_authors`
--

INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(5, 'Francis LM', 'Corbet');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(6, 'Spike', 'Milligan');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(7, 'Paul', 'Sanders');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(8, 'Sheila', 'Le Sueur');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(9, 'Edward', 'Le Brocq');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(10, 'Edward', 'Le Quesne');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(11, 'Lynn', 'New');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(12, 'Sonia', 'Hillsdon');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(13, 'June', 'Beslievre');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(14, 'Sybil', 'Hathaway');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(15, 'Elizabeth', 'Bois & Others');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(16, 'Michael', 'Leapman');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(17, 'Beth', 'Lloyd');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(18, 'David', 'Le Feuvre');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(19, 'Francis', 'Le Sueur');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(20, 'Miriam', 'Mahy');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(21, 'Beryl', 'Ozanne');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(22, 'John', 'Botrel');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(23, 'Hilary St George', 'Saunders');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(24, 'Horace', 'Wyatt');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(25, 'Donald', 'Journeaux');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(26, 'Sheila', 'Parker');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(27, 'Norman', 'Barfield');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(28, 'Leslie', 'Sinel');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(29, 'Frank', 'Falla');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(30, 'Neville', 'Doyle');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(31, 'Jan', 'Proustie');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(32, 'Cathy', 'Ryan');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(33, 'Peter', 'Hunt');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(34, 'Tessa', 'Coleman');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(35, 'C', 'Russell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(36, 'Jack', 'Benest');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(37, 'Nan', 'Le Ruez');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(38, 'John', 'Manning');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(39, 'John', 'Kelleher');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(40, 'Joan', 'Stevens');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(41, 'Margaret', 'Syvret');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(42, 'Charles', 'Larbalestier');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(43, 'Judith', 'Kerr');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(44, 'Buster', 'Merryfield');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(45, 'L', 'Foley');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(46, 'Terry', 'Jones');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(47, 'Lilian', 'Harry');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(48, 'Pauline', 'Samuelson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(49, 'Iona & Robert', 'Opie');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(50, 'Patricia', 'Williams');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(51, 'Emily', 'Wood');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(52, 'Geoff', 'Simpson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(53, 'Ted', 'Hughes');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(54, 'Louis', 'Untermeyer');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(55, 'Charmaine', 'Solomon');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(56, 'Jennifer', 'Paterson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(57, 'Carol', 'Armstrong');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(58, 'Carl', 'Chinn');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(59, 'R', 'Henwood');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(60, 'Derek', 'Haylock');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(61, 'Mike', 'Salter');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(62, 'Margaret', 'Lane');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(63, 'Marcus', 'Pfister');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(64, 'Peggy', 'Boleat');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(65, 'George R', 'Balleine');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(66, 'James', 'Brough');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(67, 'Kevin', 'Le Scelleur');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(68, 'Kenneth', 'Renault');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(69, 'Christopher', 'Weir');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(70, 'John', 'McCormack');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(71, 'Peter Double &', 'Nick Parlett');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(72, 'H C', 'Wyld');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(73, 'W H', 'Maxwell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(74, 'Betty', 'Brooke');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(75, 'Gerald', 'Durrell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(76, 'Judy', 'Taylor');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(77, 'George', 'Frank');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(78, 'Luke', 'Le Moignan');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(79, 'J E R', 'Wood');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(80, 'D', 'Scott Warren');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(81, 'Lorraine', 'Simeon');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(82, 'Diana', 'Rigg');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(83, 'Dick', 'Ray');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(84, 'Jane', 'Struthers');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(85, 'Jim', 'Brown');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(86, 'Peter', 'Hay');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(87, 'Dinah', 'Starkey');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(88, 'Ian', 'Le Moignard');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(89, 'R J', 'Unstead');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(90, 'Marita', 'Conlon-McKenna');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(91, 'Lam Kam', 'Chuen');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(92, 'Howard', 'Hill');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(93, 'Chris', 'Greenhalgh');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(94, 'Paul', 'Danziger');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(95, 'Lois', 'Henderson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(96, 'June', 'Factor');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(97, 'Margaret', 'Mahy');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(98, 'Penelope', 'Browning');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(99, 'David', 'Woolger');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(100, 'Geoffrey', 'Chamberlain');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(101, 'Anne', 'Millard');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(102, 'Charles', 'Kingsley');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(103, 'Caroline', 'Mutasiak');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(104, 'Max', 'De Boo');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(105, 'Rhona', 'Whiteford');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(106, 'Jan', 'Thompson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(107, 'Marlee', 'Alex');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(108, 'James', 'Horton');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(109, 'Michael', 'Rosen');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(110, 'Adrian', 'Mitchell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(111, 'Helen', 'Gilks');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(112, 'Carol', 'Bowyer');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(113, 'Barnabas', 'Kindersley');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(114, 'Malcolm', 'Hilliers');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(115, 'Robert', 'Gee');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(116, 'John', 'Kelham');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(117, 'Arthur G', 'Willis');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(118, 'Beverley', 'Clearly');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(119, 'Barbara', 'Hayes');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(120, 'Roger', 'Knights');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(121, 'Meryl', 'Doney');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(122, 'Janet', 'Ahlberg');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(123, 'Brian', 'Webb');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(124, 'Lesley', 'Young');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(125, 'Ronda', 'Armitage');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(126, 'Simon', 'Bond');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(127, 'Barbara Hayes', 'Pages');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(128, 'James M', 'Barrie');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(129, 'Peter', 'Seabourne');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(130, 'Annie', 'Fitzgerald');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(131, 'Bobbi', 'Katz');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(132, 'Rose', 'Impey');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(133, 'Richard', 'Scarry');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(134, 'Maurice', 'Bamford');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(135, 'Fiona', 'Geddes');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(136, 'Joseph', 'Conrad');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(137, 'Patricia', 'Walker');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(138, 'Rosemary', 'Wadey');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(139, 'Miriam', 'Stoppard');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(140, 'Molly', 'Harrison');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(141, 'Katie', 'Stewart');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(142, 'Wendy', 'Godfrey');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(143, 'John', 'Tovey');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(144, 'Nick', 'Rowe');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(145, 'Louise', 'Steele');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(146, 'Marshall', 'Cavendish');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(147, 'Philip', 'Dowell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(148, 'Angela', 'Wilkes');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(149, 'Denise', 'Jarrett-Macauley');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(150, 'Caroline', 'Matusiak');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(151, 'Readers', 'Digest');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(152, 'Kitty', 'Kelley');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(153, 'Grethe', 'Fagerstrom');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(154, 'Roald', 'Dahl');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(155, 'Anne', 'Moses');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(156, 'J Stevens', 'Cox');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(157, 'Sonia', 'Allison');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(158, 'Ben', 'Turner');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(159, 'Gill', 'Edden');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(160, 'Stephen', 'Doyle');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(161, 'John', 'Le Dain');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(162, 'Leslie', 'Carter');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(163, 'Louise', 'Somerville');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(164, 'John', 'O''Reilly');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(165, 'Emma', 'Danes');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(166, 'Sheila', 'Nelson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(167, 'Alan', 'Menken');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(168, 'Cyril', 'Watters');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(169, 'Andrew', 'Lloyd-Webber');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(170, 'Lionel', 'Salter');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(171, 'C Paul', 'Herfurth');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(172, 'Christopher', 'Bull');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(173, 'Jane', 'Bastien');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(174, 'Peter', 'Canwell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(175, 'Arthur', 'Benoy');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(176, 'Hy', 'White');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(177, 'Elton', 'John');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(178, 'Kenneth', 'Baker');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(179, 'Pauline', 'Hall');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(180, 'David', 'Liggins');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(181, 'Julian', 'Lloyd-Webber');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(182, 'Kathryn', 'Meyrick');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(183, 'Maggie', 'Tucker');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(184, 'Barrie Carson', 'Tucker');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(185, 'Karen', 'Lavut');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(186, 'Robina', 'Willson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(187, 'Ronnie', 'Barker');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(188, 'Benjamin', 'Zephaniah');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(189, 'Joseph', 'O''Connor');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(190, 'Alfred', 'Calcutt');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(191, 'Rev C S', 'Carter');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(192, 'Mel', 'Calman');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(193, 'Nina', 'Bawden');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(194, 'Lionel', 'Blue');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(195, 'Eric', 'Carle');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(196, 'John', 'Cunliffe');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(197, 'Pamela', 'Clark');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(198, 'Michael', 'Stewart');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(199, 'F M', 'Scherer');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(200, 'Rudyard', 'Kipling');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(201, 'Gail', 'Duff');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(202, 'Jane', 'Ray');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(203, 'Serena', 'Sutcliffe');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(204, 'Edith', 'Holden');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(205, 'G S Boolos &', 'R C Jeffrey');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(206, 'J P', 'Brasier-Creagh');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(207, 'Kelvin', 'Lancaster');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(208, 'David M', 'Burton');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(209, 'Charles', 'Schulz');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(210, 'Richard', 'Falkiner');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(211, 'A S', 'Silke');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(212, 'F S', 'Brooman');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(213, 'Raoul', 'Lempriere');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(214, 'George W', 'Croad');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(215, 'W J', 'Makin');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(216, 'Enid', 'Blyton');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(217, 'R G', 'Burnett');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(218, 'Richard', 'Fowler');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(219, 'Jeffrey', 'Robinson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(220, 'Brian', 'Hoey');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(221, 'Esther', 'Wilkin');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(222, 'Hilde', 'Heyduck-Huth');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(223, 'Sonia', 'Allison');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(224, 'Michelle', 'Berriedale-Johnson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(225, 'Deborah', 'Gray');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(226, 'Charles', 'Keller');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(227, 'Sue', 'Ashworth');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(228, 'Elizabeth', 'Morse');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(229, 'Mary Pat', 'Fergus');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(230, 'Roger', 'Hargreaves');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(231, 'Susan', 'Reimer');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(232, 'Josceline', 'Dimbleby');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(233, 'Marguerite', 'Paul');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(234, 'Jane', 'Pettigrew');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(235, 'Elaine', 'Prisk');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(236, 'Midge', 'Thomas');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(237, 'Kate', 'Kime');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(238, 'Jenny', 'Ridgwell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(239, 'Annette', 'Yates');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(240, 'Wendy', 'Veale');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(241, 'Ted', 'Smart');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(242, 'Louis', 'Saulnier');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(243, 'Geraldine', 'Kaye');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(244, 'Chris', 'Trump');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(245, 'Ann', 'Schweninger');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(246, 'Dorothea', 'King');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(247, 'Katharine', 'Holabird');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(248, 'Brian', 'Alderson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(249, 'Vratislav', 'Stovicek');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(250, 'Unknown', 'Author');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(251, 'Family', 'Circle');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(252, 'Meteorological', 'Office');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(253, 'Stork', 'Cookery Service');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(254, 'Dairy', 'Diaries');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(255, 'Junior League', 'Of Dayton Ohio');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(256, 'Jill', 'Walker');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(257, 'Pat', 'Purcell');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(258, 'New World', 'Cookery');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(259, 'Molly', 'Harrison');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(260, 'Colin R', 'Chapman');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(261, '', 'Oasis');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(262, '', 'Snazaroo');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(263, 'Science', 'Museum');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(264, 'Maureen', 'Orchard (Moggs)');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(265, '', 'The Useful Booklet Company');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(266, 'Jane', 'Davis');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(267, 'C & B', 'Assemi');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(268, 'Brenda', 'Whitehead');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(269, 'Cheryl', 'Assemi');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(270, 'Jeanette', 'Shanigan');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(271, 'Sonia', 'Pojan');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(272, 'Sadie', 'Starr');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(273, 'Carole', 'Rodgers');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(274, 'Cyril', 'Cunningham');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(275, 'Lord Montague', 'Of Beaulieu');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(276, 'Frank E', 'Wilson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(277, 'Ronald G', 'Burt');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(278, 'Kate', 'Atkinson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(279, 'Peter', 'Crill');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(280, 'Gaston', 'Tissandier');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(281, 'Dr. Andrew', 'Wilson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(282, 'Henry', 'Coutanche & Others');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(283, 'C W', 'Judge');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(284, 'G J C', 'Bois');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(285, 'David', 'Scott Warren');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(286, 'Chris', 'Lake');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(287, 'Philip', 'Ahier');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(288, 'Roy', 'Thomas');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(289, 'Arthur', 'Lamy');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(290, 'Jenny', 'King');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(291, 'Brian Ahier', 'Read');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(292, 'A', 'Fairclough');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(293, 'Jersey Committee Of The', 'British Heart Foundation');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(294, 'Doris', 'Carter');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(295, 'Audrey F', 'Anquetil');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(296, 'Philip', 'Malzard');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(297, 'William Gerard', 'Walmesley');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(298, 'Jersey', 'Evening Post');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(299, 'Eileen', 'Nicolle');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(300, 'Louise', 'Pickford');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(301, 'Chris Blackstone &', 'Katie Le Quesne');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(302, 'Nella', 'Last');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(303, 'Robert L', 'Stevenson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(304, 'Helen', 'McPhail');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(305, 'Michael', 'Wright');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(306, 'John', 'Lewis');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(307, 'Erich Maria', 'Remarque');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(308, 'Beve Hornsby &', 'Frula Shear');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(309, 'Marie-Louise', 'Backhurst');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(310, 'Ann', 'Olley');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(311, 'W S', 'Ashworth');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(312, 'Lillie Aubin', 'Morris');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(313, 'Alan & Mary', 'Wood');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(314, 'Therese', 'Spears');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(315, 'Diane', 'Fitzgerald');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(316, 'Sigrid', 'Wynne-Evans');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(317, 'Virginia L', 'Blakelock');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(318, 'Yvonne', 'Rivero');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(319, 'Suzanne', 'Cooper');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(320, 'Lynda S', 'Musante');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(321, 'Carol Rogers, Jennifer Mayer &', 'Deb Bergs');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(322, 'Ruth', 'Wilson');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(323, 'Christine', 'Prussing');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(324, 'Bethany', 'Barry');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(325, 'Mary Jo', 'Hiney');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(326, 'Elizabeth Gourley, Jane Davis', 'Ellen Talbot');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(327, 'Lynda Scott', 'Musante');
INSERT INTO `ushop_authors` (`author_id`, `forename`, `surname`) VALUES(328, 'Carole Rodgers, Jennifer Mayer', '& Deb Bergs');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_counties`
--

DROP TABLE IF EXISTS `ushop_counties`;
CREATE TABLE IF NOT EXISTS `ushop_counties` (
  `county_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(4) unsigned NOT NULL DEFAULT '0',
  `county` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`county_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_counties`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_countries`
--

DROP TABLE IF EXISTS `ushop_countries`;
CREATE TABLE IF NOT EXISTS `ushop_countries` (
  `country_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `post_zone_id` int(2) unsigned NOT NULL DEFAULT '0',
  `country` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country` (`country`),
  KEY `ushop_countries_ibfk_1` (`post_zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ushop_countries`
--

INSERT INTO `ushop_countries` (`country_id`, `post_zone_id`, `country`) VALUES(1, 1, 'Jersey');
INSERT INTO `ushop_countries` (`country_id`, `post_zone_id`, `country`) VALUES(2, 2, 'UK');
INSERT INTO `ushop_countries` (`country_id`, `post_zone_id`, `country`) VALUES(3, 3, 'Europe');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_order_status`
--

DROP TABLE IF EXISTS `ushop_order_status`;
CREATE TABLE IF NOT EXISTS `ushop_order_status` (
  `order_status_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `order_status` varchar(255) NOT NULL,
  PRIMARY KEY (`order_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ushop_order_status`
--

INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(1, 'Processing');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(2, 'Waiting for Payment');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(3, 'Dispatched');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(4, 'Cancelled');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(5, 'Pending');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(6, 'Paypal Payment Completed');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(7, 'Paypal Payment Pending');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(8, 'Cheque Payment Pending');
INSERT INTO `ushop_order_status` (`order_status_id`, `order_status`) VALUES(9, 'Cheque Payment Completed');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_paypal_currency`
--

DROP TABLE IF EXISTS `ushop_paypal_currency`;
CREATE TABLE IF NOT EXISTS `ushop_paypal_currency` (
  `currency_id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `currency` varchar(45) NOT NULL DEFAULT '',
  `code` varchar(3) NOT NULL DEFAULT '',
  `mta` decimal(9,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ushop_paypal_currency`
--

INSERT INTO `ushop_paypal_currency` (`currency_id`, `currency`, `code`, `mta`) VALUES(1, 'Pounds Sterling', 'GBP', '5500.00');
INSERT INTO `ushop_paypal_currency` (`currency_id`, `currency`, `code`, `mta`) VALUES(2, 'U.S Dollars', 'USD', '10000.00');
INSERT INTO `ushop_paypal_currency` (`currency_id`, `currency`, `code`, `mta`) VALUES(3, 'Australian Dollars', 'AUD', '12500.00');
INSERT INTO `ushop_paypal_currency` (`currency_id`, `currency`, `code`, `mta`) VALUES(4, 'Canadian Dollars', 'CAD', '12500.00');
INSERT INTO `ushop_paypal_currency` (`currency_id`, `currency`, `code`, `mta`) VALUES(5, 'Euros', 'EUR', '8000.00');
INSERT INTO `ushop_paypal_currency` (`currency_id`, `currency`, `code`, `mta`) VALUES(6, 'Japanese Yen', 'JPY', '1000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_post_costs`
--

DROP TABLE IF EXISTS `ushop_post_costs`;
CREATE TABLE IF NOT EXISTS `ushop_post_costs` (
  `post_cost_id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `post_level_id` int(3) unsigned NOT NULL DEFAULT '0',
  `post_zone_id` int(3) unsigned NOT NULL DEFAULT '0',
  `cost` decimal(6,2) NOT NULL DEFAULT '0.00',
  `vat_inc` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_cost_id`),
  KEY `cost` (`cost`),
  KEY `level` (`post_level_id`),
  KEY `ushop_post_costs_ibfk_2` (`post_zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `ushop_post_costs`
--

INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(1, 1, 1, '2.50', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(2, 2, 1, '3.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(4, 3, 1, '4.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(5, 4, 1, '5.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(6, 5, 1, '6.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(7, 6, 1, '7.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(8, 7, 1, '8.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(9, 8, 1, '9.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(10, 9, 1, '10.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(11, 10, 1, '12.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(12, 11, 1, '14.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(13, 12, 1, '16.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(14, 1, 2, '2.50', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(15, 2, 2, '3.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(16, 3, 2, '4.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(17, 4, 2, '5.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(18, 5, 2, '6.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(19, 6, 2, '7.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(20, 7, 2, '8.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(21, 8, 2, '9.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(22, 9, 2, '10.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(23, 10, 2, '12.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(24, 11, 2, '14.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(25, 12, 2, '16.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(26, 1, 3, '5.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(27, 2, 3, '6.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(28, 3, 3, '8.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(29, 4, 3, '10.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(30, 5, 3, '12.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(31, 6, 3, '14.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(32, 7, 3, '16.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(33, 12, 3, '18.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(34, 13, 1, '18.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(35, 13, 2, '18.00', 0);
INSERT INTO `ushop_post_costs` (`post_cost_id`, `post_level_id`, `post_zone_id`, `cost`, `vat_inc`) VALUES(36, 13, 3, '20.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ushop_post_levels`
--

DROP TABLE IF EXISTS `ushop_post_levels`;
CREATE TABLE IF NOT EXISTS `ushop_post_levels` (
  `post_level_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `post_level` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`post_level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ushop_post_levels`
--

INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(1, '0.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(2, '100.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(3, '250.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(4, '500.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(5, '750.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(6, '1000.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(7, '1250.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(8, '1500.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(9, '1750.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(10, '2000.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(11, '4000.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(12, '6000.00');
INSERT INTO `ushop_post_levels` (`post_level_id`, `post_level`) VALUES(13, '8000.00');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_post_zones`
--

DROP TABLE IF EXISTS `ushop_post_zones`;
CREATE TABLE IF NOT EXISTS `ushop_post_zones` (
  `post_zone_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `tax_code_id` int(2) unsigned NOT NULL DEFAULT '0',
  `zone` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`post_zone_id`),
  KEY `ushop_post_zones_ibfk_1` (`tax_code_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ushop_post_zones`
--

INSERT INTO `ushop_post_zones` (`post_zone_id`, `tax_code_id`, `zone`) VALUES(1, 1, '1 - Jersey');
INSERT INTO `ushop_post_zones` (`post_zone_id`, `tax_code_id`, `zone`) VALUES(2, 1, '2 - UK');
INSERT INTO `ushop_post_zones` (`post_zone_id`, `tax_code_id`, `zone`) VALUES(3, 1, '3 - Europe');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_price_groups`
--

DROP TABLE IF EXISTS `ushop_price_groups`;
CREATE TABLE IF NOT EXISTS `ushop_price_groups` (
  `price_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price_group` varchar(5) DEFAULT '0',
  `price` decimal(4,2) DEFAULT '0.00',
  PRIMARY KEY (`price_group_id`),
  UNIQUE KEY `price_group` (`price_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ushop_price_groups`
--

INSERT INTO `ushop_price_groups` (`price_group_id`, `price_group`, `price`) VALUES(1, 'A', '2.70');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_products`
--

DROP TABLE IF EXISTS `ushop_products`;
CREATE TABLE IF NOT EXISTS `ushop_products` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `tax_code_id` int(10) unsigned NOT NULL,
  `price_group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `author_id` int(10) unsigned NOT NULL,
  `sku` varchar(255) NOT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `weight` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `description` text,
  `short_description` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_status` int(1) NOT NULL DEFAULT '1',
  `quantity` int(5) unsigned NOT NULL DEFAULT '0',
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enabled` int(1) unsigned NOT NULL DEFAULT '0',
  `vat_inc` int(1) unsigned NOT NULL DEFAULT '0',
  `postage` int(1) unsigned NOT NULL DEFAULT '1',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `discontinued` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `sku` (`sku`),
  KEY `isbn` (`isbn`),
  KEY `category_id` (`category_id`),
  KEY `tax_code_id` (`tax_code_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=387 ;

--
-- Dumping data for table `ushop_products`
--

INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(1, 3, 1, 0, 5, 'CB0001', '0901897256', 'A biographical Dictionary of Jersey Vol 2', '25.00', '820.00', '<p>A collection of brief biographies of some 200 persons whose lives began in Jersey .</p>', '', 'Biography/CB0001.jpg', 1, 1, '2009-06-05 10:05:26', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(2, 5, 1, 0, 6, 'CB0002', '1852278919', 'A Children''s Treasury of Milligan', '10.00', '1000.00', 'A anthology of Spike Milligan''s Poems and stories for children', '', 'Children/CB0002.jpg', 1, 1, '2009-06-05 10:09:23', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(3, 4, 1, 0, 7, 'CB0003', '', 'The Ultimate Sacrifice', '5.50', '325.00', 'The stories of twenty Jersey men and women who died in &nbsp;German camps and prisons during the occupation of Jersey', '', 'Occupation_History/CB0003.jpg', 1, 1, '2009-06-05 10:10:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(4, 4, 1, 0, 8, 'CB0004', '0952565986', 'Two Flags One Heart', '2.50', '390.00', 'A brief biography of a Jersey girl who emigrated to the USA', '', 'Occupation_History/CB0004.jpg', 1, 1, '2009-06-05 10:20:44', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(5, 4, 1, 0, 9, 'CB0005', '1903341582', 'Memoirs of Edward Le Brocq', '10.00', '655.00', '<p>Stories from a master of the thumbnail character sketches.</p>', '', 'Occupation_History/CB0005.jpg', 1, 1, '2009-06-05 10:49:26', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(6, 4, 1, 0, 10, 'CB0006', '0861200705', 'The Occupation of Jersey Day by Day', '10.00', '560.00', '<p>A personal view of the occupation of Jersey</p>', '', 'Occupation_History/CB0006.jpg', 1, 1, '2009-06-05 10:51:15', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(7, 3, 1, 0, 12, 'CB0008', '0948578556', 'The Jersey Lily', '5.00', '250.00', '<p>A faithful account of Lillie''s life and times, that makes enthralling reading.</p>', 'The Story of Lily Langtree', 'Biography/CB0008.jpg', 1, 1, '2009-06-05 11:29:23', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(8, 4, 1, 0, 13, 'CB0009', '0953230708', 'Still the candle burns', '8.00', '350.00', 'An Anthology of reminiscences and reflections on Group Captain Leonard Cheshire. VC.OM.DSO.DFC', '', 'Occupation_History/CB0009.jpg', 1, 1, '2009-06-27 21:09:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(9, 6, 1, 0, 250, 'CB0080', '0752900455', 'Ragtime to Wartime - The Best of Good Housekeeping', '2.50', '970.00', 'The best of Good Housekeeping 1922 - 1939', '', 'General/CB0080.jpg', 1, 1, '2009-06-28 07:12:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(10, 3, 1, 0, 14, 'CB0010', '0861200136', 'Dame of Sark', '6.50', '545.00', '<p>An Autobiography of the great lady, herself.</p>', '', 'Biography/CB0010.jpg', 1, 1, '2009-06-28 08:38:20', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(11, 4, 1, 0, 15, 'CB0011', '0850337194', 'Jersey through the lens again', '9.00', '530.00', 'A follow-up to ''Jersey Through The Lens''', '', 'Occupation_History/CB0011.jpg', 1, 1, '2009-06-28 08:39:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(12, 8, 1, 0, 17, 'CB0013', '0709006594', 'De Gruchys - The history of the store', '3.00', '400.00', 'The history of Jersey''s department store of distinction.', '', 'History/CB0013.jpg', 1, 1, '2009-06-28 08:41:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(13, 4, 1, 0, 16, 'CB0012', '0670873861', 'Witness to War', '6.00', '600.00', 'Eight true-life stories of Nazi persecution', '', 'Occupation_History/CB0012.jpg', 1, 1, '2009-06-28 08:42:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(14, 4, 1, 0, 18, 'CB0014', '0948578572', 'Jersey not quite British', '1.50', '260.00', 'The rural history of a singular people', '', 'Occupation_History/CB0014.jpg', 1, 1, '2009-06-28 08:50:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(15, 4, 1, 0, 19, 'CB0015', '', 'Shadow of the Swastika', '2.50', '172.00', 'A personal account of one man''s experiences.', '', 'Occupation_History/CB0015.jpg', 1, 1, '2009-06-28 08:51:46', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(16, 4, 1, 0, 20, 'CB0016', '0951976702', 'There is an occupation', '2.50', '180.00', 'A personal view of life during the German occupation of Jersey. (A signed first edition)', '', 'Occupation_History/CB0016.jpg', 1, 1, '2009-06-28 08:53:14', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(17, 4, 1, 0, 21, 'CB0017', '0952457903', 'A Peep behind the Screens', '2.50', '270.00', 'The memories of a Ward Sister in Guernsey during the occupation.\r\n(Has an inscription on inside cover and signed by the author)', '', 'Occupation_History/CB0017.jpg', 1, 0, '2009-06-28 08:54:25', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(18, 6, 1, 0, 22, 'CB0018', '0902830317', 'Fred''s Folly', '4.50', '245.00', 'Stories of a Telephone engineer in a small sleepy seaside town.', '', 'General/CB0018.jpg', 1, 1, '2009-06-28 08:55:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(19, 4, 1, 0, 23, 'CB0019', '', 'The Red Cross and the White', '14.00', '360.00', '<p>A Short history of the joint war organization of the British Red Cross Society &amp; the Order of St John of Jerusalam 1939 - 1945.</p>\r\n\r\n<p>(Slightly damaged)</p>', '', 'Occupation_History/CB0019.jpg', 1, 1, '2009-06-28 10:59:33', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(20, 4, 1, 0, 24, 'CB0020', '0861200063', 'Jersey in Jail 1940 - 1945', '15.00', '350.00', 'A view of life in Jersey during the occupation. (First published 1945)', '', 'Occupation_History/CB0020.jpg', 1, 1, '2009-06-28 11:00:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(21, 4, 1, 0, 25, 'CB0021', '1852533218', 'Raise the white flag', '8.00', '310.00', 'A study through one pair of eyes of the Occupation of jersey', '', 'Occupation_History/CB0021.jpg', 1, 1, '2009-06-28 11:01:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(22, 4, 1, 0, 26, 'CB0022', '0951023403', 'An Occupational Hazard', '2.00', '110.00', 'A story of a war-widow discovering how her husband had died.', '', 'Occupation_History/CB0022.jpg', 1, 1, '2009-06-28 11:02:45', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(23, 6, 1, 0, 27, 'CB0023', '0752406051', 'Supermarine', '2.00', '300.00', 'A pictorial guide to Supermarine.', '', 'General/CB0023.jpg', 1, 1, '2009-06-28 11:04:12', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(24, 4, 1, 0, 28, 'CB0024', '', 'The German occupation of Jersey', '2.00', '225.00', 'Leslie Sinel''s secret diary of the occupation of Jersey.', '', 'Occupation_History/CB0024.jpg', 1, 1, '2009-06-28 11:05:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(25, 4, 1, 0, 30, 'CB0026', '185421103X', 'From Sea-eagle to Flamingo', '10.00', '900.00', 'A history of Jersey''s&nbsp;commercial aviation.', '', 'Occupation_History/CB0026.jpg', 1, 1, '2009-06-28 12:10:26', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(26, 4, 1, 0, 29, 'CB0025', '', 'The Silent War', '2.00', '140.00', 'The tales of a war-time journalist in occupied Guernsey.', '', 'Occupation_History/CB0025.jpg', 1, 1, '2009-06-28 12:11:21', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(27, 6, 1, 0, 31, 'CB0027', '1901544001', 'Solutions for specific learning difficulties', '9.00', '300.00', 'A identification guide for specific learning difficulties.', '', 'General/CB0027.jpg', 1, 1, '2009-06-28 13:32:40', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(28, 4, 1, 0, 32, 'CB0028', '0948204621', 'Eric''s War', '3.00', '78.00', '<p>Set during the occupation of Jersey, Eric''s war tells the story of a young boy and his sister and how they managed.</p>\r\n\r\n\r\n<p>(Â£3.00p&amp;p)</p>', '', 'Occupation_History/CB0028.jpg', 1, 1, '2009-06-28 13:33:38', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(29, 6, 1, 0, 33, 'CB0029', '1870544161', 'A guide to the dolmens of Jersey', '6.00', '100.00', 'A guide to the Major Neolithic stone monuments in Jersey and what we know of the people who built the.', '', 'General/CB0029.jpg', 1, 1, '2009-06-28 13:34:46', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(30, 4, 1, 0, 34, 'CB0030', '0952579308', 'Threads of History - Jersey Occupation Tapestry', '2.00', '150.00', 'The Story of the creation and making of the Jersey Occupation Tapestry', '', 'Occupation_History/CB0030.jpg', 1, 1, '2009-06-28 13:35:50', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(31, 4, 1, 0, 35, 'CB0031', '095248580X', 'Spitfire Postscript', '2.00', '360.00', 'A personal view on the history of the Supermarine Spitfire', '', 'Occupation_History/CB0031.jpg', 1, 1, '2009-06-28 13:37:00', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(32, 8, 1, 0, 36, 'CB0032', '0951323806', 'The Benests of Millbrook 100 years 1888 - 1988', '5.00', '250.00', 'A history of one of the oldest stores in Jersey.', '', 'History/CB0032.jpg', 1, 1, '2009-06-28 13:38:36', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(33, 4, 1, 0, 37, 'CB0033', '0948578610', 'Jersey Occupation Diary', '5.00', '570.00', 'Nan Le Ruez''s story of the German occupation of Jersey.', '', 'Occupation_History/CB0033.jpg', 1, 1, '2009-06-28 13:40:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(34, 4, 1, 0, 38, 'CB0034', '0952544709', 'Grandpa versus Germany', '2.00', '182.00', 'One man''s attempts to thwart Jersey''s occupying forces.', '', 'Occupation_History/CB0034.jpg', 1, 1, '2009-06-28 13:41:48', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(35, 8, 1, 0, 39, 'CB0035', '0951816241', 'The Triumph of the Country', '20.00', '820.00', 'The rural community in Nineteenth Century Jersey.', '', 'History/CB0035.jpg', 1, 0, '2009-06-28 13:44:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(36, 8, 1, 0, 40, 'CB0036', '', 'Old Jersey Houses', '6.50', '1200.00', '<p>Old Jersey Houses and those who lived in them - 1500 - 1700. Signed by the authoress.</p>\r\n\r\n<p>(Not in perfect condition.)</p>', '', 'History/CB0036.jpg', 1, 0, '2009-06-28 13:46:02', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(37, 8, 1, 0, 40, 'CB0037', '', 'Old Jersey Houses volume 2', '6.50', '1100.00', '<p>Old jersey houses and those who lived in them from 1700 onwards.</p>\r\n\r\n<p>(A Follow-up to ''Old Jersey Houses''</p>', '', 'History/CB0037.jpg', 1, 1, '2009-06-28 13:47:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(38, 3, 1, 0, 41, 'CB0038', '090603020X', 'Edmund Blampied', '30.00', '940.00', '<p>A biography of the artist - 1886 to 1966</p>', '', 'Biography/CB0038.jpg', 1, 1, '2009-06-28 13:48:47', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(39, 8, 1, 0, 42, 'CB0039', '0951673602', 'A Century of Music in Jersey', '10.00', '560.00', 'A history of&nbsp;Jersey&nbsp;music in pictures', '', 'History/CB0039.jpg', 1, 1, '2009-06-28 13:50:14', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(40, 4, 1, 0, 43, 'CB0040', '000675077X', 'Out of the Hitler Time', '3.50', '540.00', 'Three stories about a young girl fleeing from Germany, during the war.', '', 'Occupation_History/CB0040.jpg', 1, 1, '2009-06-28 13:52:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(41, 8, 1, 0, 44, 'CB0041', '1873475543', 'During the War', '3.00', '350.00', 'An Autobiography by Buster Merryfield. (Signed by the author.)', '', 'History/CB0041.jpg', 1, 1, '2009-06-28 16:56:47', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(42, 4, 1, 0, 45, 'CB0042', '0952531623', 'Raising a Clameur', '5.00', '220.00', 'The history of the the Clameur de Haro - an ancient Jersey custom.', '', 'Occupation_History/CB0042.jpg', 1, 1, '2009-06-28 16:57:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(43, 6, 1, 0, 46, 'CB0043', '1851450009', 'Nicobobinus', '2.00', '700.00', 'The story of the most extraordinary child who ever stuck his tongue out at a Prime Minister.', '', 'General/CB0043.jpg', 1, 1, '2009-06-28 16:58:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(44, 8, 1, 0, 47, 'CB0044', '1857979567', 'Goodbye Sweetheart', '5.00', '530.00', 'A warm magical novel of families and children at war.', '', 'History/CB0044.jpg', 1, 1, '2009-06-28 16:59:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(45, 8, 1, 0, 49, 'CB0046', '1857936248', 'The Treasures of Childhood', '12.00', '980.00', 'A glorious pictorial celebration of the books, toys and games which have entranced children for the past century', '', 'History/CB0046.jpg', 1, 1, '2009-06-28 17:00:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(46, 4, 1, 0, 50, 'CB0047', '0563344067', 'Children at War', '3.00', '170.00', 'A collection of twelve childhood wartime memories.', '', 'Occupation_History/CB0047.jpg', 1, 1, '2009-06-28 17:02:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(47, 4, 1, 0, 51, 'CB0048', '0751301736', 'The Red Cross Story', '1.00', '400.00', 'A pictorial history of 125 years of the British Red Cross', '', 'Occupation_History/CB0048.jpg', 1, 1, '2009-06-28 17:03:51', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(48, 4, 1, 0, 52, 'CB0049', '0851952682', 'A Good Aggressive Fighter Pilot', '2.00', '80.00', 'The story of one airman who fought in the Battle of Britain.', '', 'Occupation_History/CB0049.jpg', 1, 1, '2009-06-28 17:05:12', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(49, 8, 1, 0, 250, 'CB0050', '0951843788', '1851 Census of Jersey', '130.00', '1100.00', 'A definitive of who was on the Island on 31st March 1851', '', 'History/CB0050.jpg', 1, 1, '2009-06-28 17:05:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(50, 9, 1, 0, 53, 'CB0051', '0571194737', 'Birthday Letters', '1.00', '250.00', 'Whitbread book of the year 1998.', '', 'Poetry/CB0051.jpg', 1, 1, '2009-06-28 17:38:24', 1, 0, 0, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(51, 9, 1, 0, 54, 'CB0052', '0001061240', 'The Golden Treasury of Poetry', '5.00', '960.00', 'A collection of carefully selected poems.', '', 'Poetry/CB0052.jpg', 1, 1, '2009-06-28 17:39:23', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(52, 9, 1, 0, 11, 'CB0007', '1899392041', 'An Island Treasury in Verse', '6.00', '290.00', 'A short collection of poems.', '', 'Poetry/CB0007.jpg', 1, 1, '2009-06-28 17:40:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(53, 2, 1, 0, 55, 'CB0053', '0385193874', 'Love & a wooden spoon', '2.00', '430.00', 'Recipes, anecdotes and poems to bring happiness to the heart of young and old.', '', 'Recipes/CB0053.jpg', 1, 1, '2009-06-28 17:44:32', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(54, 2, 1, 0, 56, 'CB0054', '190117055', 'Jennifer''s Diary', '5.00', '208.00', 'A collection of her best recipes.', '', 'Recipes/CB0054.jpg', 1, 1, '2009-06-28 17:45:29', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(55, 7, 1, 0, 57, 'CB0055', '0711209766', 'Lives & legends of the Saints', '1.00', '520.00', 'The lives and legends of 20 of the greatest Saints.', '', 'Religious/CB0055.jpg', 1, 1, '2009-06-28 17:48:17', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(56, 8, 1, 0, 58, 'CB0056', '1858581052', 'The Cadbury Story', '4.00', '240.00', 'A short history of the chocolate makers.', '', 'History/CB0056.jpg', 1, 1, '2009-06-28 17:49:11', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(57, 6, 1, 0, 59, 'CB0057', '0952531615', 'So you think you know Jersey?', '5.00', '260.00', 'A brief collection of questions - with answers - about Jersey''s history', '', 'General/CB0057.jpg', 1, 1, '2009-06-28 17:50:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(58, 7, 1, 0, 60, 'CB0058', '0715104462', 'Acts for Apostles', '10.00', '100.00', 'Dramatic sketches for family services and youth groups', '', 'Religious/CB0058.jpg', 1, 1, '2009-06-28 17:51:47', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(59, 8, 1, 0, 61, 'CB0059', '187173150X', 'Castles and old Churches of the Channel Islands', '2.00', '168.00', 'A comprehensive guide to the history and architecture of military and ecclesiastical buildings in the Channel Islands', '', 'History/CB0059.jpg', 1, 1, '2009-06-28 17:52:51', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(60, 5, 1, 0, 62, 'CB0060', '0723221081', 'The Magic Years of Beatrix Potter', '4.00', '810.00', 'An exploration of the life and achievements of Beatrice Potter.', '', 'Children/CB0060.jpg', 1, 1, '2009-06-28 17:54:07', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(61, 8, 1, 0, 48, 'CB0045', '0747520208', '125th birthday of the British Red Cross', '10.00', '550.00', 'Celebrating 125 years of the British Red Cross', '', 'History/CB0045.jpg', 1, 1, '2009-06-28 20:27:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(62, 5, 1, 0, 63, 'CB0061', '1558580093', 'The Rainbow Fish', '2.00', '350.00', 'A story about a Rainbow Fish.', '', 'Children/CB0061.jpg', 1, 1, '2009-06-28 20:30:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(63, 10, 1, 0, 64, 'CB0062', '0952305704', 'A Quiet Place', '1.50', '240.00', 'A personal view of life between 1941 and 1943, as a hospital patient in Occupied Jersey', '', 'Fiction/CB0062.jpg', 1, 1, '2009-06-28 20:36:08', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(64, 3, 1, 0, 65, 'CB0063', '0901897108', 'All for the King', '1.50', '500.00', 'The life story of Sir George Carteret (1609 to 1680)', '', 'Biography/CB0063.jpg', 1, 1, '2009-06-28 20:37:07', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(65, 3, 1, 0, 66, 'CB0064', '0340168358', 'The Prince and the Lily', '3.00', '880.00', 'The story of a Prince and Lillie Langtry', '', 'Biography/CB0064.jpg', 1, 1, '2009-06-28 20:41:03', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(66, 8, 1, 0, 67, 'CB0065', '0850597072', 'Channel Islands Railway Steamers', '7.00', '620.00', 'A history of the vessels which plied the route to the Channel Islands from 1823 to modern day.', '', 'History/CB0065.jpg', 1, 1, '2009-06-28 20:44:38', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(67, 8, 1, 0, 68, 'CB0066', '0850338875', 'The Le Riches Story', '4.00', '820.00', '175 years of Le Riches stores - from it''s beginnings in 1818 to modern day.', '', 'History/CB0066.jpg', 1, 1, '2009-06-28 20:45:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(68, 3, 1, 0, 40, 'CB0067', '', 'Victorian Voices - Sir John Le Couteur QADC FRS', '12.00', '1100.00', 'An introduction to the papers of Sir John Le Couteur Q.A.D.C. F.R.S.', '', 'Biography/CB0067.jpg', 1, 1, '2009-06-29 14:38:23', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(69, 3, 1, 0, 69, 'CB0068', '1873116012', 'Jesse Boot of Nottingham', '1.00', '300.00', 'A brief history of Jesse Boot and the company he founded.', '', 'Biography/CB0068.jpg', 1, 1, '2009-06-29 14:39:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(70, 8, 1, 0, 70, 'CB0069', '0850335418', 'Channel Island Churches', '70.00', '1240.00', 'A history of the Channel Islands Churches, including detailed scale plans, and elevations, thus providing a comprehensive and penetrating survey of great appeal to historians.', '', 'History/CB0069.jpg', 1, 1, '2009-06-29 14:40:47', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(71, 6, 1, 0, 71, 'CB0070', '0948578777', 'Wild Island - Jersey Nature Diary', '1.00', '300.00', 'A nature diary.', '', 'General/CB0070.jpg', 1, 1, '2009-06-29 14:42:15', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(72, 15, 1, 0, 72, 'CB0071', '', 'The Universal dictionary of the English language', '17.50', '4000.00', 'Edited by Henry Cecil Wyld and published in 1931. Hard Back', '', 'Antiquarian/CB0071.jpg', 1, 1, '2009-06-29 14:43:02', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(73, 15, 1, 0, 73, 'CB0072', '', 'The Life of Wellington', '100.00', '800.00', 'Bound as a prize given by the College of Preceptors Jersey and inscribed with the recipient.', '', 'Antiquarian/CB0072.jpg', 1, 1, '2009-06-29 14:43:49', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(74, 6, 1, 0, 74, 'CB0073', '0853052948', 'Tovey a free range dog', '25.00', '120.00', 'A dog''s eye view of life.', '', 'General/CB0073.jpg', 1, 1, '2009-06-29 14:44:58', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(75, 6, 1, 0, 12, 'CB0074', '0953461602', 'Seeking and loosing', '10.00', '140.00', 'A short story of a young girl coming to terms with a reversal of fate.', '', 'General/CB0074.jpg', 1, 1, '2009-06-29 14:45:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(76, 5, 1, 0, 75, 'CB0075', '1854790323', 'Toby the Tortoise', '2.50', '340.00', 'Gerald Durrell''s encounter with a tortoise that fell into the sea.', '', 'Children/CB0075.jpg', 1, 1, '2009-06-29 14:46:46', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(77, 5, 1, 0, 76, 'CB0076', '0723241953', 'Letters to Children from Beatrice Potter', '10.00', '720.00', 'A collection of letters by Beatrice Potter to children.', '', 'Children/CB0076.jpg', 1, 1, '2009-06-29 14:49:38', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(78, 6, 1, 0, 77, 'CB0077', '0806965630', 'Wood Finishing with George Frank', '2.50', '420.00', 'A book to guide you through the intricacies of finishing wood surfaces.', '', 'General/CB0077.jpg', 1, 1, '2009-06-29 14:51:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(79, 4, 1, 0, 78, 'CB0078', '0861200489', 'Stories of an Occupation', '10.00', '600.00', 'Memories of Jersey 1939 - 1945.', '', 'Occupation_History/CB0078.jpg', 1, 1, '2009-06-29 14:51:52', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(80, 4, 1, 0, 79, 'CB0079', '', 'Detour - The Story of Oflag IV C', '25.00', '850.00', '<p>True stories from officers confined to the prisoner of war camp, during the war.</p>\r\n\r\n<p>(Slightly suffering from age)</p>', '', 'Occupation_History/CB0079.jpg', 1, 1, '2009-06-29 14:53:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(81, 8, 1, 0, 40, 'CB0081', '0901897175', 'Jersey Place Names volume1', '30.00', '4000.00', 'A guide to historical Jersey place names.&nbsp;', '', 'History/CB0081.jpg', 1, 0, '2009-06-29 17:40:09', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(82, 8, 1, 0, 80, 'CB0082', '', 'Bluebottles: the Story of the States of Jersey police', '25.00', '420.00', 'The life story of the States of Jersey Police service.', '', 'History/CB0082.jpg', 1, 1, '2009-06-29 17:41:04', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(83, 5, 1, 0, 81, 'CB0083', '0216940397', 'The Streetwise kid', '3.00', '90.00', 'A lively survival kit of does and don''t for the ultimate in streetwise street credibility.', '', 'Children/CB0083.jpg', 1, 1, '2009-06-29 17:42:05', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(84, 6, 1, 0, 82, 'CB0084', '0241108551', 'No Turn Unstoned', '1.50', '500.00', 'A compilation of worst-ever theatrical reviews.', '', 'General/CB0084.jpg', 1, 1, '2009-06-29 17:43:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(85, 8, 1, 0, 83, 'CB0085', '0952565978', 'The Opera House Jersey', '25.00', '700.00', 'The story of Dick Ray''s association with Jersey''s Opera House.', '', 'History/CB0085.jpg', 1, 1, '2009-06-29 17:45:21', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(86, 5, 1, 0, 84, 'CB0086', '009177781X', 'Step-by-Step Ballet Class', '7.50', '720.00', 'An illustrated guide to the official ballet syllabus.', '', 'Children/CB0086.jpg', 1, 1, '2009-06-29 17:47:00', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(87, 8, 1, 0, 85, 'CB0087', '1874287368', 'An Illustrated History of Coventry City FC', '82.00', '630.00', 'The charting of the club''s history from 1883 to the present day.', '', 'History/CB0087.jpg', 1, 1, '2009-06-29 17:48:09', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(88, 6, 1, 0, 86, 'CB0088', '0245548815', 'Harraps Book of Legal Anecdotes', '1.50', '840.00', 'A collection of intriguing and amusing stories from all ages and countries.', '', 'General/CB0088.jpg', 1, 1, '2009-06-29 17:56:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(89, 5, 1, 0, 87, 'CB0089', '', 'Sainsbury''s Atlas of Exploration', '1.50', '300.00', 'An introduction to the history of exploration for children aged 8 and over.', '', 'Children/CB0089.jpg', 1, 1, '2009-06-29 17:58:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(90, 6, 1, 0, 250, 'CB0090', '', 'Before another song ends', '4.50', '230.00', 'A Tribute for the people who work for the Jersey Wildlife Preservation Tust.', '', 'General/CB0090.jpg', 1, 1, '2009-06-29 18:00:58', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(91, 8, 1, 0, 88, 'CB0091', '0850530059', 'The History of Jersey''s lifeboats', '1.50', '140.00', 'A history of jersey''s lifeboats from 1825 to 1975, their crews and their recorded rescues.', '', 'History/CB0091.jpg', 1, 1, '2009-06-29 18:38:49', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(92, 8, 1, 0, 89, 'CB0092', '', 'Looking at History', '17.50', '1350.00', 'With 1100 pictures, this volume covers 20th Century history up to the 1970''s', '', 'History/CB0092.jpg', 1, 1, '2009-06-29 18:39:40', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(93, 5, 1, 0, 90, 'CB0093', '0862784220', 'Safe Harbour', '2.50', '140.00', 'A moving story of children facing the horrors of war &nbsp;and the heartbreak of a family feud.', '', 'Children/CB0093.jpg', 1, 1, '2009-06-29 18:40:35', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(94, 6, 1, 0, 91, 'CB0094', '1856750663', 'Tai Chi', '3.00', '420.00', 'A step-by-step guide to Tai Chi, with pictures to help.', '', 'General/CB0094.jpg', 1, 1, '2009-06-29 18:41:33', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(95, 3, 1, 0, 92, 'CB0095', '0715812637', 'Secret Ingredient', '2.50', '270.00', 'The story of Fletchers'' (of Sheffield) Seven bakeries/.', '', 'Biography/CB0095.jpg', 1, 1, '2009-06-29 18:42:29', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(96, 3, 1, 0, 93, 'CB0096', '0755300866', 'Coco and Igor', '4.00', '500.00', 'A novel of Music, Perfume &amp; Passion.', '', 'Biography/CB0096.jpg', 1, 1, '2009-06-29 18:43:33', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(97, 5, 1, 0, 94, 'CB0097', '0434965715', 'The Divorce Express', '2.00', '300.00', 'A child''s view of parental divorce.', '', 'Children/CB0097.jpg', 1, 1, '2009-06-29 18:44:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(98, 5, 1, 0, 95, 'CB0098', '0854219951', 'Touch of the Golden Scepter', '1.50', '130.00', 'An imaginative story of Esther, taken from the Old Testament.', '', 'Children/CB0098.jpg', 1, 1, '2009-06-29 18:45:21', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(99, 6, 1, 0, 96, 'CB0099', '0340509945', 'Real Keen Baked Beans', '7.00', '200.00', 'A Fourth collection of Australian children''s chants and rhymes.', '', 'General/CB0099.jpg', 1, 1, '2009-06-29 18:46:21', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(100, 10, 1, 0, 97, 'CB0100', '0460062859', 'The Door in the Air', '3.00', '340.00', 'Stories for the younger reader.', '', 'Fiction/CB0100.jpg', 1, 1, '2009-06-29 18:47:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(101, 5, 1, 0, 98, 'CB0101', '0590763237', 'Crocodile Tears', '4.50', '270.00', 'Bedtime poems for the very young.', '', 'Children/CB0101.jpg', 1, 1, '2009-06-30 09:14:18', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(102, 6, 1, 0, 99, 'CB0102', '0192760742', 'Who do you think you are?', '1.00', '390.00', 'Poems about people.', '', 'General/CB0102.jpg', 1, 1, '2009-06-30 09:15:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(103, 6, 1, 0, 100, 'CB0103', '', 'Readers Digest Mothercare book', '8.00', '970.00', 'An illustrated guide for parents and parents to be.', '', 'General/CB0103.jpg', 1, 0, '2009-06-30 09:16:41', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(104, 6, 1, 0, 101, 'CB0104', '0746009712', 'Ancient World', '1.50', '1080.00', 'A detailed description of the world''s oldest cultures and civilizations/', '', 'General/CB0104.jpg', 1, 1, '2009-06-30 09:17:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(105, 5, 1, 0, 102, 'CB0105', '1870461061', 'The Water Babies', '5.00', '690.00', 'The story of Tom, the chimney-sweep who runs away from his cruel master.', '', 'Children/CB0105.jpg', 1, 1, '2009-06-30 09:19:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(106, 5, 1, 0, 103, 'CB0106', '0590530003', 'Seasonal Activities:- Spring & Summer', '1.50', '270.00', 'Essential reading for anyone who works with 3 to 6 year olds.', '', 'Children/CB0106.jpg', 1, 1, '2009-06-30 13:57:36', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(107, 5, 1, 0, 104, 'CB0107', '0590762303', 'Science Activities', '1.50', '270.00', 'Especially written for nursery and reception teachers and others who work with 3 to 6 year olds.', '', 'Children/CB0107.jpg', 1, 1, '2009-06-30 13:58:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(108, 5, 1, 0, 105, 'CB0108', '0590764020', 'Music & Movement', '1.50', '270.00', 'An offering of dozens of new ideas for music and movement.', '', 'Children/CB0108.jpg', 1, 1, '2009-06-30 13:59:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(109, 7, 1, 0, 106, 'CB0109', '0713177675', 'The Many Paths of Christianity', '2.50', '250.00', 'A description of the history, beliefs and practices of the Orthodox, Roman Catholic and Protestant Churches.', '', 'Religious/CB0109.jpg', 1, 1, '2009-06-30 14:00:52', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(110, 5, 1, 0, 107, 'CB0110', '0551014830', 'Esther', '2.50', '370.00', 'The Story of ''Esther''. A woman who was as courageous as she was beautiful.', '', 'Children/CB0110.jpg', 1, 1, '2009-06-30 14:01:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(111, 6, 1, 0, 108, 'CB0111', '0751300705', 'An Introduction to Drawing', '4.50', '600.00', 'An Introduction to Drawing shows you everything you need to know about the materials and techniques of this lively art.', '', 'General/CB0111.jpg', 1, 1, '2009-06-30 14:04:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(112, 5, 1, 0, 110, 'CB0112', '0006626777', 'Don''t put mustard in the custard', '1.50', '100.00', 'Things <strong>not</strong>&nbsp;to do!', '', 'Children/CB0112.jpg', 1, 1, '2009-06-30 14:06:04', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(113, 5, 1, 0, 110, 'CB0113', '0361083556', 'Strawberry Drums', '2.00', '150.00', 'A short book of poems.', '', 'Children/CB0113.jpg', 1, 1, '2009-06-30 14:07:10', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(114, 5, 1, 0, 110, 'CB0114', '0750004479', 'All my own Stuff', '2.50', '130.00', 'Poems for bedtime.', '', 'Children/CB0114.jpg', 1, 1, '2009-06-30 14:42:46', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(115, 5, 1, 0, 111, 'CB0115', '185602038X', 'Bears', '13.50', '540.00', 'A guide to the different types of bears around the world.', '', 'Children/CB0115.jpg', 1, 1, '2009-06-30 15:58:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(116, 5, 1, 0, 112, 'CB0116', '0860209016', 'People and Homes', '3.50', '510.00', 'A book about people who live in other countries - their houses, homes and customs.', '', 'Children/CB0116.jpg', 1, 1, '2009-06-30 15:59:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(117, 5, 1, 0, 113, 'CB0117', '0751356506', 'Celebrations', '18.00', '700.00', 'A glimpse into the lives of children around the world.', '', 'Children/CB0117.jpg', 1, 1, '2009-06-30 16:00:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(118, 5, 1, 0, 114, 'CB0118', '0863189083', 'Christmas', '3.00', '840.00', 'A sumptuous guide to stylish, festive decorations.', '', 'Children/CB0118.jpg', 1, 1, '2009-06-30 16:01:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(119, 5, 1, 0, 115, 'CB0119', '0860207056', 'Better English', '1.50', '310.00', 'An introduction to English punctuation, spelling and grammar .', '', 'Children/CB0119.jpg', 1, 1, '2009-06-30 16:02:53', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(120, 5, 1, 0, 116, 'CB0120', '', 'Herbert the Hedgehog goes to sea', '6.00', '70.00', 'Herbert goes to sea and is rescued by the RNLI', '', 'Children/CB0120.jpg', 1, 1, '2009-06-30 16:04:05', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(121, 10, 1, 0, 117, 'CB0121', '', 'Yarns on Wessex Pioneers', '16.00', '160.00', '<p>A brief history of Wessex &nbsp;AD 200 to AD1200.</p>\r\n\r\n<p>(Ex school copy)</p>', '', 'Fiction/CB0121.jpg', 1, 1, '2009-06-30 17:16:58', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(122, 5, 1, 0, 118, 'CB0122', '0600206750', 'Henry and the clubhouse', '2.50', '90.00', '<p>A story of a nine-years-old boy.</p>\r\n\r\n<p>(Ex School library)</p>', '', 'Children/CB0122.jpg', 1, 1, '2009-06-30 17:18:20', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(123, 5, 1, 0, 119, 'CB0123', '070642591X', 'Micky the MG', '1.00', '70.00', 'One of the ''Favourite Motor Car'' collection', '', 'Children/CB0123.jpg', 1, 1, '2009-06-30 17:19:22', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(124, 5, 1, 0, 119, 'CB0124', '0706425928', 'Bertie the Bentley', '1.50', '70.00', 'A favourite motor car story.', '', 'Children/CB0124.jpg', 1, 1, '2009-07-02 20:15:50', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(125, 5, 1, 0, 120, 'CB0125', '0361066600', 'Dear God Kids - Animal Friends', '10.00', '170.00', 'A storybook for the younger reader.', '', 'Children/CB0125.jpg', 1, 1, '2009-07-02 20:16:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(126, 5, 1, 0, 121, 'CB0127', '0745919197', 'The very worried sparrow', '6.00', '320.00', 'Why would a sparrow worry? This book tells you why!', '', 'Children/CB0127.jpg', 1, 1, '2009-07-03 08:25:33', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(127, 5, 1, 0, 122, 'CB0128', '0434925322', 'The Jolly Christmas Postman', '4.00', '390.00', 'The Jolly Postman rides again with more letters and presents in his Christmas post-bag.', '', 'Children/CB0128.jpg', 1, 1, '2009-07-03 08:26:53', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(128, 5, 1, 0, 123, 'CB0129', '1856549828', 'Becky', '10.00', '110.00', 'The story of a runner bean called ''Becky''', '', 'Children/CB0129.jpg', 1, 1, '2009-07-03 08:28:15', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(129, 5, 1, 0, 124, 'CB0130', '0006642217', 'Superted saves the day', '2.00', '90.00', 'An adventure story for the younger reader.', '', 'Children/CB0130.jpg', 1, 1, '2009-07-03 08:29:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(130, 5, 1, 0, 120, 'CB0126', '036166589', 'Dear God kids - Number Fun', '4.00', '170.00', 'Numbers for the younger reader.', '', 'Children/CB0126.jpg', 1, 1, '2009-07-03 08:32:17', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(131, 5, 1, 0, 125, 'CB0131', '140541853', 'The Lighthouse keeper''s rescue', '1.50', '100.00', 'How a beached whale saved a sleepy lighthouse keeper.', '', 'Children/CB0131.jpg', 1, 1, '2009-07-03 10:17:28', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(132, 5, 1, 0, 126, 'CB0132', '140900225', 'Tough Ted & the tale of the tattered ear', '1.00', '90.00', 'A ''Tough Ted'' story.', '', 'Children/CB0132.jpg', 1, 1, '2009-07-03 10:18:46', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(133, 5, 1, 0, 125, 'CB0133', '140503277', 'The Lighthouse Keepers Lunch', '3.00', '100.00', 'How did the lighthouse keeper''s wife defeat the seagulls to get him his lunch?', '', 'Children/CB0133.jpg', 1, 1, '2009-07-03 10:19:50', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(134, 5, 1, 0, 250, 'CB0134', '014090008X', 'Tough Ted Sticker fun book', '6.00', '50.00', 'A collection of re-usable Tough Ted stickers that make delightful pictures.', '', 'Children/CB0134.jpg', 1, 1, '2009-07-03 10:20:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(135, 7, 1, 0, 127, 'CB0135', '0600311511', 'Talking to God', '1.00', '160.00', 'Children''s prayers for special occasions.', '', 'Religious/CB0135.jpg', 1, 1, '2009-07-03 10:22:19', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(136, 5, 1, 0, 122, 'CB0136', '0434969427', 'The Jolly Pocket Postman', '1.50', '320.00', 'A storybook for the younger reader.', '', 'Children/CB0136.jpg', 1, 1, '2009-07-03 10:55:10', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(137, 5, 1, 0, 128, 'CB0137', '1857159020', 'Peter Pan', '3.00', '440.00', 'A hardback copy of the original story.', '', 'Children/CB0137.jpg', 1, 1, '2009-07-03 10:56:22', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(138, 5, 1, 0, 129, 'CB0138', '0907825001', 'Joey - Thunderstorm', '2.50', '100.00', 'An original story of the adventures of a little yellow plane.', '', 'Children/CB0138.jpg', 1, 1, '2009-07-03 10:57:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(139, 5, 1, 0, 129, 'CB0139', '0907825028', 'Joey - Oil Slick', '4.50', '60.00', 'The story of one of &nbsp;Joey''s adventure''s', '', 'Children/CB0139.jpg', 1, 1, '2009-07-03 10:58:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(140, 5, 1, 0, 130, 'CB0140', '0895051273', 'Dear God, thanks for thinking up love', '4.50', '40.00', 'A little book of prayers for little children.', '', 'Children/CB0140.jpg', 1, 1, '2009-07-03 10:59:10', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(141, 5, 1, 0, 131, 'CB0141', '039486719X', 'Month by Month - Care Bears', '3.50', '140.00', 'A Care Bear book of poems.', '', 'Children/CB0141.jpg', 1, 1, '2009-07-03 11:32:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(142, 5, 1, 0, 122, 'CB0142', '0434925152', 'The Jolly Postman & other people''s letters', '2.50', '220.00', 'The story of ''other people''s letters''', '', 'Children/CB0142.jpg', 1, 1, '2009-07-03 11:33:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(143, 5, 1, 0, 132, 'CB0143', '0001856448', 'Sir Billy Bear and other friends', '3.50', '320.00', 'Do you ever wonder what happens after dark when everyone''s in bed... and the toys in the toy-box come to life?', '', 'Children/CB0143.jpg', 1, 1, '2009-07-03 11:34:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(144, 5, 1, 0, 154, 'CB0144', '224046918', 'The Roald Dahl Treasury', '6.50', '1530.00', 'The Roald Dahl Treasury brings together some of the &nbsp;most dazzling moments in the works of this most extraordinary writer.', '', 'Children/CB0144.jpg', 1, 1, '2009-07-03 11:35:30', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(145, 5, 1, 0, 250, 'CB0145', '0751350567', 'Dorling Kindersley Science Encyclopaedia', '9.50', '2100.00', 'The essential scientific reference book for today''s young scientist.', '', 'Children/CB0145.jpg', 1, 1, '2009-07-03 11:36:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(146, 5, 1, 0, 133, 'CB0146', '0600381447', 'European word book', '6.50', '180.00', 'French, German &amp; English for&nbsp;Beginners&nbsp;.', '', 'Children/CB0146.jpg', 1, 1, '2009-07-26 14:12:11', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(147, 5, 1, 0, 134, 'CB0147', '1852231971', 'Rugby Leage Skills of the game', '2.50', '0.00', '<p>This book covers the major individual skills of kicking, tackling, passing and handling, plus team skills such as scrummaging and support play.</p>\r\n\r\n<p>(Ex library edition)</p>', '', 'Children/CB0147.jpg', 1, 1, '2009-07-26 14:14:51', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(148, 6, 1, 0, 252, 'CB0148', '', 'Weather map - an introduction to weather forecasting', '15.00', '330.00', 'This book gives an excellent introductory account of the preparation of weather maps.', '', 'General/CB0148.jpg', 1, 1, '2009-07-26 14:16:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(149, 8, 1, 0, 40, 'CB0149', '0901897175', 'Jersey Place Names volume 2', '30.00', '2100.00', 'A guide to historical Jersey place names.', '', 'History/CB0149.jpg', 1, 0, '2009-07-26 14:17:35', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(150, 2, 1, 0, 135, 'CB0150', '075220503X', 'Book of Soups', '6.50', '580.00', 'A collection of new, old and odd recipes.', '', 'Recipes/CB0150.jpg', 1, 1, '2009-07-26 14:18:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(151, 2, 1, 0, 251, 'CB0151', '0864113870', 'Party & Finger Food', '25.00', '440.00', 'Luscious desserts and elegant cakes plus delightful morsels - clear recipes&nbsp;and&nbsp;photographs&nbsp;to&nbsp;take the guesswork out of the cooking.', '', 'Recipes/CB0151.jpg', 1, 1, '2009-07-26 14:22:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(152, 2, 1, 0, 251, 'CB0152', '0864114613', 'Scones Muffins & Teatime treats', '5.00', '430.00', 'From old favourites like pumpkin scones and blueberry muffins to coffee pecan muffins and parmesan scones - they are all here.', '', 'Recipes/CB0152.jpg', 1, 1, '2009-07-26 14:25:38', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(153, 6, 1, 0, 136, 'CB0153', '2253047627', 'Heart of Darkness - Bi-lingual (English & French)', '14.50', '160.00', 'For students of french - or english - a parallel text book.', '', 'General/CB0153.jpg', 1, 1, '2009-07-26 14:26:52', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(154, 2, 1, 0, 256, 'CB0154', '', 'Cooking in Barbados', '6.50', '280.00', 'A collection of Barbadian recipes for those who want to try something different.', '', 'Recipes/CB0154.jpg', 1, 1, '2009-07-26 14:29:49', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(155, 2, 1, 0, 257, 'CB0155', '0904015297', 'Bostin'' Fittle', '3.50', '80.00', 'A collection of Black Country recipes', '', 'Recipes/CB0155.jpg', 1, 1, '2009-07-26 14:33:25', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(156, 2, 1, 0, 253, 'CB0156', '', 'The art of home cooking', '4.50', '180.00', 'A comprehensive cookery book from The Stork Cookery Service', '', 'Recipes/CB0156.jpg', 1, 1, '2009-07-26 14:44:03', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(157, 2, 1, 0, 254, 'CB0157', '', 'More recipe round-ups', '4.00', '390.00', 'A selection of popular recipes from Daily Diaries 1986 - 1990.', '', 'Recipes/CB0157.jpg', 1, 1, '2009-07-26 14:46:07', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(158, 2, 1, 0, 255, 'CB0158', '0960308210', 'Discover Dayton', '7.50', '700.00', 'A collection of recipes tried and tested by the Junior League of Dayton', '', 'Recipes/CB0158.jpg', 1, 1, '2009-07-26 16:01:38', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(159, 2, 1, 0, 258, 'CB0159', '', 'Radiation cookery book', '12.50', '350.00', 'The original selection of recipes to use with Regulo new world gas cooker.', '', 'Recipes/CB0159.jpg', 1, 1, '2009-07-26 16:02:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(160, 2, 1, 0, 138, 'CB0160', '0862733863', 'The Complete Hostess', '10.00', '1310.00', 'Want to plan a party and not sure how - this is for you!', '', 'Recipes/CB0160.jpg', 1, 1, '2009-07-26 16:03:22', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(161, 6, 1, 0, 139, 'CB0161', '0706416937', 'Your Baby', '20.00', '1100.00', 'Everything you need to know about having a baby - from conception to 3 years old.', '', 'General/CB0161.jpg', 1, 1, '2009-07-26 16:04:30', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(162, 2, 1, 0, 140, 'CB0162', '', 'Farmhouse cookery - recipes from the country kitchen', '10.00', '1510.00', 'Over 500 wholesome dishes for your delectation.', '', 'Recipes/CB0162.jpg', 1, 1, '2009-07-26 16:06:47', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(163, 2, 1, 0, 141, 'CB0163', '0330252003', 'Times Calendar cookbook', '3.00', '280.00', 'From winter soups , stews and casseroles to summer salads &amp; picnic recipes - they are all here.', '', 'Recipes/CB0163.jpg', 1, 1, '2009-07-26 16:07:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(164, 2, 1, 0, 142, 'CB0164', '', 'Golden Cookery', '18.00', '80.00', 'The original Golden Cookery Book recipe book.', '', 'Recipes/CB0164.jpg', 1, 1, '2009-07-26 16:08:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(165, 2, 1, 0, 143, 'CB0165', '', 'Entertaining with Tovey', '6.50', '1080.00', 'How to star in your own kitchen.', '', 'Recipes/CB0165.jpg', 1, 1, '2009-07-26 16:09:18', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(166, 2, 1, 0, 144, 'CB0166', '', 'Everyday Specials', '10.00', '480.00', '60 All new Main Courses.', '', 'Recipes/CB0166.jpg', 1, 1, '2009-07-26 16:09:58', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(167, 2, 1, 0, 145, 'CB0167', '0862732808', 'The Teddy Bear Cook Book', '3.00', '280.00', 'Lots of fun food to make and eat - suitable for over 9-year-olds.', '', 'Recipes/CB0167.jpg', 1, 1, '2009-07-26 16:10:50', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(168, 2, 1, 0, 146, 'CB0168', '0863074529', 'Cookery Year Book 1986', '1.50', '830.00', 'Contains information on new ingredients and techniques, advice from professionals and lots of recipes.', '', 'Recipes/CB0168.jpg', 1, 1, '2009-07-26 16:11:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(169, 2, 1, 0, 147, 'CB0169', '0718122682', 'The Book of Ingredients', '6.50', '1210.00', 'Everything about herbs, spices and vegetables that you ever wanted to know.', '', 'Recipes/CB0169.jpg', 1, 1, '2009-07-26 16:12:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(170, 2, 1, 0, 250, 'CB0170', '0746025289', 'The Usborne Good Housekeeping Cookbook', '3.50', '930.00', 'An inspiring collection of fresh, modern recipes which use up-to-date methods and ingredients.', '', 'Recipes/CB0170.jpg', 1, 1, '2009-07-26 16:13:35', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(171, 2, 1, 0, 148, 'CB0171', '0860208524', 'The Usborne First Cookbook', '9.00', '410.00', 'A collection of recipes for all sorts of delicious things that young cooks can try.', '', 'Recipes/CB0171.jpg', 1, 1, '2009-07-26 16:14:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(172, 2, 1, 0, 149, 'CB0172', '0862832276', 'Cake & Cake Decoration', '3.00', '290.00', 'Need to decorate a cake? this is the book for you!', '', 'Recipes/CB0172.jpg', 1, 1, '2009-07-26 16:15:33', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(173, 2, 1, 0, 250, 'CB0173', '0307168123', 'Mickey Mouse cookbook', '14.00', '580.00', 'Favourite recipes from Mickey and his friends.', '', 'Recipes/CB0173.jpg', 1, 1, '2009-07-26 16:16:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(174, 6, 1, 0, 103, 'CB0174', '0590765078', 'Seasonal Activities - Autumn & Winter', '1.00', '260.00', 'The changing seasons are a constant source of fascination for young children and this book builds upon that interest.', '', 'General/CB0174.jpg', 1, 1, '2009-07-26 16:18:42', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(175, 2, 1, 0, 151, 'CB0175', '0276421884', 'The Cooks Scrapbook', '6.50', '1490.00', 'Secrets from our Grandmother''s kitchens rediscovered for todays cooks.', '', 'Recipes/CB0175.jpg', 1, 1, '2009-07-26 16:19:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(176, 2, 1, 0, 148, 'CB0176', '0751351210', 'The Childrens'' Step-by-Step Cookbook', '1.50', '850.00', 'More than 50 easy-to-follow recipes that are fun to make and delicious to eat.', '', 'Recipes/CB0176.jpg', 1, 1, '2009-07-26 16:40:26', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(177, 3, 1, 0, 152, 'CB0177', '', 'Nancy Reagan - an unauthorized biography', '3.50', '650.00', 'From one of the greatest writers of biographies.', '', 'Biography/CB0177.jpg', 1, 1, '2009-07-26 16:41:17', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(178, 6, 1, 0, 153, 'CB0178', '0356113604', 'Our New Baby', '6.00', '220.00', 'A new baby coming? - this is an ideal book for explaining&nbsp;to existing children&nbsp;what will happen.', '', 'General/CB0178.jpg', 1, 1, '2009-07-26 16:42:09', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(179, 2, 1, 0, 154, 'CB0179', '0140139052', 'Roald Dahl''s Cookbook', '11.00', '810.00', 'A recreation of the many wonderful meals that the Dahl family have shared.', '', 'Recipes/CB0179.jpg', 1, 1, '2009-07-26 16:43:00', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(180, 2, 1, 0, 155, 'CB0180', '0750222999', 'WartimeCookbook - Food & Recipes from 2nd World War', '15.50', '220.00', 'War time recipes accompanied by stories of how people managed with shortages.', '', 'Recipes/CB0180.jpg', 1, 1, '2009-07-26 16:43:58', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(181, 2, 1, 0, 156, 'CB0181', '', 'Guernsey Dishes of Bygone Days', '3.50', '50.00', 'Guernsey dishes from the 18th &amp; 19th Century.', '', 'Recipes/CB0181.jpg', 1, 1, '2009-07-26 17:09:47', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(182, 2, 1, 0, 250, 'CB0182', '', 'Spiller''s Recipe Book', '15.00', '50.00', 'Established recipes from a bye-gone era.', '', 'Recipes/CB0182.jpg', 1, 1, '2009-07-26 17:10:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(183, 2, 1, 0, 157, 'CB0183', '187456719', 'Punch & Party Drinks made easy', '20.00', '80.00', 'Simple step-by-step instructions for making fabulous drinks for all occasions.', '', 'Recipes/CB0183.jpg', 1, 1, '2009-07-26 17:11:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(184, 2, 1, 0, 158, 'CB0184', '0723407940', 'Book of home wine & beermaking', '2.00', '730.00', 'Everything you need to know to make your own wine and beer.', '', 'Recipes/CB0184.jpg', 1, 1, '2009-07-26 19:43:52', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(185, 2, 1, 0, 159, 'CB0185', '', 'Good Housekeeping Cookery Book', '30.00', '1520.00', 'tried and tested recipes from an earlier era.', '', 'Recipes/CB0185.jpg', 1, 1, '2009-07-26 19:45:12', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(186, 6, 1, 0, 160, 'CB0186', '0748753168', 'Information systems for you', '1.50', '730.00', 'A lay-man''s guide to spreadsheets and word processing.', '', 'General/CB0186.jpg', 1, 1, '2009-07-26 19:47:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(187, 6, 1, 0, 161, 'CB0187', '1903341124', 'Wish you were here.', '4.50', '540.00', 'A visitor''s guide to Jersey through pictorial postcards.', '', 'General/CB0187.jpg', 1, 1, '2009-07-26 19:52:35', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(188, 6, 1, 0, 162, 'CB0188', '0241104580', 'The music people', '4.50', '480.00', 'Music made fun - an introduction to music for the younger student', '', 'General/CB0188.jpg', 1, 1, '2009-07-26 19:53:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(190, 11, 1, 0, 163, 'CB0189', '0746001932', 'Learn to Play Guitar', '2.00', '220.00', 'Ideal for a budding guitarist - an introduction to the acoustic and electric guitar.', '', 'Music/CB0189.jpg', 1, 1, '2009-07-27 18:09:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(191, 11, 1, 0, 164, 'CB0190', '0739014412', 'Strictly Classics - Strictly Strings', '14.00', '110.00', '18 Classical ensemble arrangements of 18 classic favourites.', '', 'Music/CB0190.jpg', 1, 1, '2009-07-27 18:13:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(192, 8, 1, 0, 260, 'CB0191', '1873686188', 'Pre-1841 censuses & Population listings', '6.00', '150.00', 'For the genealogist in you. This will help you in your search for long-begotten ancestors.', '', 'History/CB0191.jpg', 1, 1, '2009-07-29 09:16:08', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(193, 11, 1, 0, 165, 'CB0192', '0746016751', 'Easy Guitar Tunes', '2.00', '270.00', 'An introduction to playing the classical guitar.', '', 'Music/CB0192.jpg', 1, 1, '2009-07-29 09:16:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(194, 11, 1, 0, 166, 'CB0193', '', 'Tunes you know 2', '10.00', '80.00', 'Waltzing Matilda and many other easy favourites for ''cello duet.', '', 'Music/CB0193.jpg', 1, 1, '2009-07-29 09:17:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(195, 11, 1, 0, 167, 'CB0194', '0793518733', 'Aladdin', '1.50', '310.00', 'Music and lyrics for piano players.', '', 'Music/CB0194.jpg', 1, 1, '2009-07-29 09:18:42', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(196, 11, 1, 0, 168, 'CB0195', '0860016978', 'It''s Easy to Play Disney', '15.50', '220.00', 'Easy to read simplified arrangements of favourite songs for piano/vocal with guitar chord symbols', '', 'Music/CB0195.jpg', 1, 1, '2009-07-29 09:19:38', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(197, 11, 1, 0, 169, 'CB0196', '0711916217', 'Piano Solos', '3.00', '240.00', 'Piano solos from some of the greatest Andrew Lloyd-Webber shows.', '', 'Music/CB0196.jpg', 1, 1, '2009-07-29 09:21:00', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(198, 11, 1, 0, 170, 'CB0197', '1854723006', 'Short Romantic Pieces for Pianos', '5.50', '180.00', 'Easy play pieces for grade 3/ 4 pianists.', '', 'Music/CB0197.jpg', 1, 1, '2009-07-29 09:21:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(199, 11, 1, 0, 171, 'CB0198', '0711915709', 'A Tune a Day', '5.50', '170.00', 'Learn to play the easy way with a tune a day.', '', 'Music/CB0198.jpg', 1, 1, '2009-07-29 09:22:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(200, 11, 1, 0, 172, 'CB0199', '0863599885', 'Team Strings', '5.50', '280.00', 'A collection of easy play tunes for the individual or ensemble.', '', 'Music/CB0199.jpg', 1, 1, '2009-07-29 09:23:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(201, 11, 1, 0, 173, 'CB0200', '0849760801', 'Level 1 Bastien Favorites', '3.50', '130.00', 'Fourteen solo''s at elementary level.', '', 'Music/CB0200.jpg', 1, 1, '2009-07-29 09:24:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(202, 11, 1, 0, 174, 'CB0201', '', 'Early Learning Centre Counting Songs', '5.00', '190.00', 'A collection of traditional well-known counting songs.', '', 'Music/CB0201.jpg', 1, 1, '2009-07-29 12:32:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(203, 11, 1, 0, 174, 'CB0202', '', 'Early Learning Centre Teddy Bear Songbook', '6.50', '300.00', 'Twelve songs for young children with guitar/piano accompanyment', '', 'Music/CB0202.jpg', 1, 1, '2009-07-29 12:33:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(204, 11, 1, 0, 175, 'CB0203', '0193553996', 'The cellist''s books of Carols', '4.50', '90.00', 'Twelve well-known carols for cello and piano.', '', 'Music/CB0203.jpg', 1, 1, '2009-07-29 12:35:03', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(205, 11, 1, 0, 173, 'CB0204', '0849760364', 'Pop, Rock''n Blues - Book 3', '15.00', '80.00', 'Seven compositions designed to introduce the pianist to the styles and sounds of todays music.', '', 'Music/CB0204.jpg', 1, 1, '2009-07-29 12:36:07', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(206, 11, 1, 0, 176, 'CB0205', '', 'Leed''s Guitar Method and song Folio', '8.50', '260.00', '41 popular folk, novelty and other songs.', '', 'Music/CB0205.jpg', 1, 1, '2009-07-29 12:36:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(207, 11, 1, 0, 177, 'CB0206', '0793534720', 'The Lion King - piano score', '4.50', '280.00', 'For piano.', '', 'Music/CB0206.jpg', 1, 1, '2009-07-29 12:37:51', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(208, 11, 1, 0, 261, 'CB0207', '071195464X', '(What''s the Story) Morning Glory', '1.50', '280.00', 'Piano, voice and guitar arrangements of all the songs from the album.', '', 'Music/CB0207.jpg', 1, 1, '2009-07-29 12:39:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(209, 11, 1, 0, 178, 'CB0208', '0711904324', 'The Complete Piano Player (Book 2)', '1.50', '210.00', 'The only piano course based on today''s popular songs.', '', 'Music/CB0208.jpg', 1, 1, '2009-07-29 12:42:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(210, 11, 1, 0, 179, 'CB0209', '0193727374', 'Piano Time Carols', '4.50', '140.00', '19 easy arrangements for piano.', '', 'Music/CB0209.jpg', 1, 1, '2009-07-29 12:43:10', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(211, 11, 1, 0, 180, 'CB0210', '1871210119', 'Tunes for your Ocarina', '1.00', '80.00', 'Packed with exciting tunes for everyone to play and enjoy.', '', 'Music/CB0210.jpg', 1, 1, '2009-07-29 12:43:58', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(212, 11, 1, 0, 168, 'CB0211', '0711905673', 'It''s Easy To Play Nursery Rhymes', '1.50', '220.00', 'Easy to play children''s favourite nursery rhymes.', '', 'Music/CB0211.jpg', 1, 1, '2009-07-29 12:44:48', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(213, 11, 1, 0, 169, 'CB0212', '0853601496', 'Joseph & the Amazing Technicolour Dreamcoat', '6.50', '150.00', 'Vocal selections from the amazing show.', '', 'Music/CB0212.jpg', 1, 1, '2009-07-29 12:45:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(214, 11, 1, 0, 178, 'CB0213', '0711916934', 'The Complete Piano Player Show Tunes', '9.50', '230.00', '21 essential show songs for piano.', '', 'Music/CB0213.jpg', 1, 1, '2009-07-29 12:48:36', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(215, 11, 1, 0, 181, 'CB0214', '0711933812', 'Cello Song', '12.50', '350.00', 'fourteen not so well known pieces for the cello.', '', 'Music/CB0214.jpg', 1, 1, '2009-07-29 12:49:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(216, 11, 1, 0, 182, 'CB0215', '0859533476', 'The musical life of Gustav Mole', '4.00', '160.00', 'An introduction to different musical instruments', '', 'Music/CB0215.jpg', 1, 1, '2009-07-29 12:50:40', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(217, 5, 1, 0, 183, 'CB0216', '0140376194', 'Ballet and Dance', '1.00', '170.00', 'Find out about Ballet School and life on the stage.', '', 'Children/CB0216.jpg', 1, 1, '2009-07-29 12:51:52', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(218, 5, 1, 0, 184, 'CB0217', '185793119X', 'Joseph & the Amazing Technicolor Dreamcoat', '7.50', '230.00', 'An exciting action-packed Old Testament story told in verse and pictures.', '', 'Children/CB0217.jpg', 1, 1, '2009-07-29 12:53:23', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(219, 11, 1, 0, 184, 'CB0218', '0333684192', 'The Compact Cello', '3.00', '440.00', 'A complete guide to the cello and ten great composers. Includes a full-length audio CD.', '', 'Music/CB0218.jpg', 1, 1, '2009-07-29 19:26:53', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(220, 5, 1, 0, 185, 'CB0219', '185406018X', 'Jacques'' Jungle Ballet', '2.50', '400.00', 'The story of an elephant that wanted to be a ballet dancer.', '', 'Children/CB0219.jpg', 1, 1, '2009-07-29 19:27:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(221, 5, 1, 0, 186, 'CB0220', '0713633115', 'Mozart''s Story', '6.50', '420.00', 'The story of Mozart, retold for the younger reader.', '', 'Children/CB0220.jpg', 1, 1, '2009-07-29 19:28:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(222, 5, 1, 0, 154, 'CB0221', '0044406215', 'James and the Giant Peach', '1.00', '360.00', '''Something is about to happen'' James told himself. Read the book to find out what.', '', 'Children/CB0221.jpg', 1, 1, '2009-07-29 19:30:17', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(223, 5, 1, 0, 154, 'CB0222', '0224036475', 'My Year', '9.00', '340.00', 'Roald Dhal''s diary, written in his final year.', '', 'Children/CB0222.jpg', 1, 1, '2009-07-29 19:31:09', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(224, 3, 1, 0, 187, 'CB0223', '', 'The Two Ronnies', '1.00', '230.00', 'A pocket compendium of their funniest jokes, one-liners and sketches.', '', 'Biography/CB0223.jpg', 1, 1, '2009-07-29 19:32:02', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(225, 5, 1, 0, 154, 'CB0224', '0224039784', 'Revolting Recipes', '1.00', '380.00', 'Recipes for children - with help from adults', '', 'Children/CB0224.jpg', 1, 1, '2009-07-29 19:33:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(226, 5, 1, 0, 154, 'CB0225', '0224015796', 'The Enormous Crocodile', '1.50', '300.00', 'How the Enormous Crocodile met his match!', '', 'Children/CB0225.jpg', 1, 1, '2009-07-29 19:34:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(227, 5, 1, 0, 188, 'CB0226', '0747550867', 'Refugee Boy', '2.00', '250.00', 'A powerful novel about a young refugee.', '', 'Children/CB0226.jpg', 1, 1, '2009-07-29 19:51:14', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(228, 10, 1, 0, 189, 'CB0227', '009928653X', 'Inishowen', '1.00', '350.00', 'A fictional story of a police detective in Ireland during the troubles.', '', 'Fiction/CB0227.jpg', 1, 1, '2009-07-29 19:52:33', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(229, 3, 1, 0, 190, 'CB0228', '0952139804', 'De La Salle - A Biography', '10.00', '1080.00', 'A biography of John Baptist de la Salle. 1651 to 1719', '', 'Biography/CB0228.jpg', 1, 1, '2009-07-29 19:57:44', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(230, 15, 1, 0, 191, 'CB0229', '', 'The English Church and The reformation', '4.50', '450.00', 'A brief history of the Church between 1509 and 1603.', '', 'Antiquarian/CB0229.jpg', 1, 1, '2009-07-29 19:58:51', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(231, 7, 1, 0, 192, 'CB0230', '0413573303', 'My God', '9.50', '70.00', 'A pocket-book of drawings and comments, to stir the imagination.', '', 'Religious/CB0230.jpg', 1, 1, '2009-07-29 19:59:48', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(232, 7, 1, 0, 130, 'CB0231', '0852234821', 'Dear God Kids', '4.50', '90.00', 'A collection of the cartoons that first appeared in a national newspaper.', '', 'Religious/CB0231.jpg', 1, 1, '2009-07-29 20:01:06', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(233, 5, 1, 0, 193, 'CB0232', '0140309446', 'The peppermint pig', '2.00', '100.00', 'The story of a little pig that made a little girl happy.', '', 'Children/CB0232.jpg', 1, 1, '2009-07-29 20:02:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(234, 7, 1, 0, 194, 'CB0233', '0002151928', 'How to get up when life gets you down', '1.50', '420.00', 'Stories from those great orators Lionel Blue &amp; Jonathan Magonet.', '', 'Religious/CB0233.jpg', 1, 1, '2009-07-29 20:04:06', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(235, 5, 1, 0, 195, 'CB0234', '0241129850', 'The Very Quiet Cricket', '4.50', '540.00', 'The story of a little cricket and his song.', '', 'Children/CB0234.jpg', 1, 1, '2009-07-29 20:04:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(236, 5, 1, 0, 196, 'CB0235', '0590550543', 'Postman Pat & the toy soldier', '3.00', '140.00', '40 re-usable stickers to colour the story of Postman Pat and the toy soldiers', '', 'Children/CB0235.jpg', 1, 1, '2009-07-29 20:06:08', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(237, 2, 1, 0, 197, 'CB0236', '0949892742', 'Children''s birthday cake book', '2.50', '460.00', 'More than 100 cake recipes for children''s birthdays.', '', 'Recipes/CB0236.jpg', 1, 1, '2009-07-29 20:40:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(238, 6, 1, 0, 198, 'CB0237', '0080224695', 'Politics & Economic Policy in the UK since 1964', '1.00', '360.00', 'A potential explanation of the erratic economic policies post 1964.', '', 'General/CB0237.jpg', 1, 1, '2009-07-29 20:41:42', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(239, 6, 1, 0, 199, 'CB0238', '0395307260', 'Industrial Market Structure & economic performance', '7.50', '1200.00', 'Supply versus demand, or government managed output? A good read to stimulate the mind.', '', 'General/CB0238.jpg', 1, 1, '2009-07-29 20:42:42', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(240, 5, 1, 0, 200, 'CB0239', 'CN6151', 'Tales of Mowgli from The Jungle Book', '4.00', '700.00', 'Kipling''s stories re-written for the younger reader.', '', 'Children/CB0239.jpg', 1, 1, '2009-07-29 20:43:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(241, 5, 1, 0, 201, 'CB0240', '000194293X', 'Little Grey Rabbit''s Country Book', '2.00', '520.00', 'Based on the original ''Little grey Rabbit'' books, this is a collection of seasonal activities for children ranging from Valentine day cards to Easter eggs and pancakes to garlands.', '', 'Children/CB0240.jpg', 1, 1, '2009-07-29 20:45:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(242, 7, 1, 0, 202, 'CB0241', '1852132817', 'The Story of Creation', '32.00', '450.00', 'The Story of Creation, taken from the Book of Genesis and explained with words and pictures for the younger reader.', '', 'Religious/CB0241.jpg', 1, 1, '2009-07-29 20:46:15', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(243, 6, 1, 0, 203, 'CB0242', 'CN1356', 'Andre Simon''s Wines of the World', '8.50', '1850.00', 'What makes a great wine region? Why do different grapes make different wines? It''s all here.', '', 'General/CB0242.jpg', 1, 1, '2009-07-29 20:47:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(244, 6, 1, 0, 204, 'CB0243', 'CN4234', 'The Country Diary of an Edwardian Lady', '1.50', '810.00', 'A reproduction of a naturalist''s diary for 1906, in words and paintings.', '', 'General/CB0243.jpg', 1, 1, '2009-07-29 20:48:14', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(245, 6, 1, 0, 250, 'CB0244', '', 'The Home Encyclopedia', '4.00', '440.00', 'An ideal companion for the housewife.', '', 'General/CB0244.jpg', 1, 1, '2009-07-29 20:48:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(249, 6, 1, 0, 205, 'CB0245', '0521299675', 'Computability and Logic 2nd edition', '4.50', '410.00', 'Ideal for students of pure or applied mathematics.', '', 'General/CB0245.jpg', 1, 1, '2009-07-29 21:03:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(250, 6, 1, 0, 206, 'CB0246', '0361054254', 'Purnell''s Family Dictionary in Colour', '11.50', '1050.00', 'A dictionary with pictures.', '', 'General/CB0246.jpg', 1, 1, '2009-07-30 08:03:29', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(251, 6, 1, 0, 207, 'CB0247', '0710400454', 'Introduction to Modern microEconomics', '4.00', '480.00', 'An elementary account of the principals of microeconomics.', '', 'General/CB0247.jpg', 1, 1, '2009-07-30 08:04:35', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(252, 6, 1, 0, 208, 'CB0248', '0205069789', 'Elementary Number Theory', '12.00', '540.00', 'A simplified account of number theory.', '', 'General/CB0248.jpg', 1, 1, '2009-07-30 08:05:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(253, 5, 1, 0, 209, 'CB0249', '', 'Snoopy & his friends', '1.00', '540.00', 'A ''Snoopy'' double album', '', 'Children/CB0249.jpg', 1, 1, '2009-07-30 08:07:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(254, 5, 1, 0, 209, 'CB0250', 'CN1480', 'Snoopy Treasury', '3.50', '890.00', 'A collection of some of the best ''snoopy'' cartoon strips.', '', 'Children/CB0250.jpg', 1, 1, '2009-07-30 08:08:30', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(255, 6, 1, 0, 210, 'CB0251', '0552986488', 'Investing in antique Jewellery', '2.00', '570.00', 'A review of Jewellery through the ages - from the ancient world to the 19th century.', '', 'General/CB0251.jpg', 1, 1, '2009-07-30 08:09:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(256, 6, 1, 0, 211, 'CB0252', '036202040X', 'Hambro Tax guide 1981/1982', '3.00', '460.00', 'For those who want to complete their library.', '', 'General/CB0252.jpg', 1, 1, '2009-07-30 08:10:33', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(257, 6, 1, 0, 212, 'CB0253', '0043302823', 'Macro-economics', '2.00', '500.00', 'For students wanting to enhance their understanding of Macro-economics.', '', 'General/CB0253.jpg', 1, 1, '2009-07-30 08:11:32', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(258, 8, 1, 0, 213, 'CB0254', '0709158424', 'Customs, Ceremonies & Traditions of the Channel Islands', '7.00', '500.00', 'A history of the legislature, judicatures, feudalism and other aspects of Channel Island life.', '', 'History/CB0254.jpg', 1, 1, '2009-07-30 08:12:35', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(259, 8, 1, 0, 214, 'CB0255', '', 'A Jersey Album', '15.00', '1270.00', 'A history of places in Jersey. (Signed by the author).', '', 'History/CB0255.jpg', 1, 0, '2009-07-30 08:13:26', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(260, 8, 1, 0, 250, 'CB0256', '', 'Golden Book of the Coronation', '12.50', '440.00', 'The events of the coronation of Her Majesty Queen Elizabeth 2nd.', '', 'History/CB0256.jpg', 1, 1, '2009-07-30 10:57:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(261, 8, 1, 0, 215, 'CB0257', '', 'The Life of King George the Fifth', '12.00', '1250.00', 'A complete record of the late King''s life of seventy eventful years.', '', 'History/CB0257.jpg', 1, 1, '2009-07-30 10:58:18', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(262, 5, 1, 0, 216, 'CB0258', '', 'The island of adventure', '50.00', '470.00', 'A rattling good yarn from enid Blyton.', '', 'Children/CB0258.jpg', 1, 1, '2009-07-30 11:02:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(263, 8, 1, 0, 217, 'CB0259', '', 'These my brethren', '5.00', '230.00', 'The story of the London East End Mission and it''s ministry to the needs of the people of the East End. (INcludes a birthday dedication).', '', 'History/CB0259.jpg', 1, 1, '2009-07-30 11:03:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(264, 5, 1, 0, 218, 'CB0260', '', 'The amazing journey of spaceship H-20', '3.50', '420.00', 'A follow the line book to learn about space.', '', 'Children/CB0260.jpg', 1, 1, '2009-07-30 11:04:13', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(265, 6, 1, 0, 219, 'CB0261', '0671713841', 'The Laundrymen', '2.50', '670.00', 'The story of how a US$ bill can be involved i money laundering.', '', 'General/CB0261.jpg', 1, 1, '2009-07-30 14:18:18', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(266, 8, 1, 0, 220, 'CB0262', '1852606010', 'The Royal Yacht Britannia', '7.00', '840.00', 'The full story of HMS Britannia.', '', 'History/CB0262.jpg', 1, 1, '2009-07-30 14:20:30', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(267, 7, 1, 0, 221, 'CB0263', '0723508100', 'The Golden Treasury of Prayers for boys and girls', '9.00', '620.00', 'A collection of prayers for young children.', '', 'Religious/CB0263.jpg', 1, 1, '2009-07-30 14:21:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(268, 7, 1, 0, 222, 'CB0264', '0222000740', 'A Christmas Story', '5.00', '360.00', 'A Board book story of the first Christmas', '', 'Religious/CB0264.jpg', 1, 1, '2009-07-30 14:22:29', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(269, 2, 1, 0, 12, 'CB0265', '0711703736', 'A Taste of Jersey', '6.00', '40.00', 'Traditional island recipes. (Signed by the author.)', '', 'Recipes/CB0265.jpg', 1, 1, '2009-07-30 14:23:38', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(270, 2, 1, 0, 157, 'CB0266', '0091879574', 'Complete Bread Machine Cookbook', '30.00', '830.00', 'Over 100 recipes for making bread from all sorts of flours, yeast free, gluten free, etc.', '', 'Recipes/CB0266.jpg', 1, 1, '2009-07-30 14:25:23', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(271, 2, 1, 0, 250, 'CB0267', '0091868777', 'The Dairy Book of British Food', '20.00', '1450.00', 'A collection of regional recipes from all over England.', '', 'Recipes/CB0267.jpg', 1, 1, '2009-07-30 14:26:12', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(272, 2, 1, 0, 224, 'CB0268', '1859675727', 'The diabetic cook book', '1.50', '910.00', 'Tantalizing recipes for those who need to watch what they eat.', '', 'Recipes/CB0268.jpg', 1, 1, '2009-07-30 14:27:40', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(273, 2, 1, 0, 250, 'CB0269', '0091864941', 'Good Housekeeping:- New step by step cookbook', '10.00', '1890.00', 'Fish, meats, breads - recipes of all kinds with colour pictures to guide you to perfection.', '', 'Recipes/CB0269.jpg', 1, 1, '2009-07-30 14:29:06', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(274, 2, 1, 0, 225, 'CB0270', '1861552033', 'The Colossal Cookie cookbook', '25.00', '1970.00', 'Over 400 outrageously delicious and easy to do recipes for cookies.', '', 'Recipes/CB0270.jpg', 1, 1, '2009-07-30 14:30:26', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(275, 7, 1, 0, 250, 'CB0271', '0603004458', 'Prayers for Tinies', '3.50', '230.00', 'A pop-up prayer book for little ones.', '', 'Religious/CB0271.jpg', 1, 1, '2009-07-30 18:31:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(276, 5, 1, 0, 226, 'CB0272', '0340541970', 'Tongue twisters', '7.00', '330.00', 'A collection of tongue twisters for all ages.', '', 'Children/CB0272.jpg', 1, 1, '2009-07-30 18:32:49', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(277, 5, 1, 0, 262, 'CB0273', '185697099X', 'Fantastic Faces', '2.50', '250.00', 'Over 40 fantastic face and body painting designs.', '', 'Children/CB0273.jpg', 1, 1, '2009-07-30 18:33:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(278, 2, 1, 0, 250, 'CB0274', '009186366X', 'Good Housekeeping 50th Anniversary Cookery Book', '7.00', '1620.00', 'Over 900 recipes of classical favourites and contemporary ideas.', '', 'Recipes/CB0274.jpg', 1, 1, '2009-07-30 18:36:44', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(279, 2, 1, 0, 227, 'CB0275', '', 'The New Dairy Cookbook', '30.00', '760.00', '150 recipes &nbsp;for all occasions.', '', 'Recipes/CB0275.jpg', 1, 1, '2009-07-30 18:39:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(280, 2, 1, 0, 263, 'CB0276', '0901805750', 'Health Matters', '2.00', '160.00', 'Modern medicine and the search for better health.', '', 'Recipes/CB0276.jpg', 1, 1, '2009-07-30 18:40:49', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(281, 2, 1, 0, 228, 'CB0277', '1850292957', 'The Healthy Eating recipe Book', '9.50', '570.00', 'Foods and recipes from first tastes to family meals.', '', 'Recipes/CB0277.jpg', 1, 1, '2009-07-30 19:50:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(282, 2, 1, 0, 230, 'CB0278', '085985227X', 'Little Miss Cook Book', '7.50', '130.00', 'Simple recipes for the younger cook.', '', 'Recipes/CB0278.jpg', 1, 1, '2009-07-30 19:51:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(283, 2, 1, 0, 151, 'CB0279', '0276421930', 'Foods that harm & Foods that heal', '2.00', '1400.00', 'An A to Z guide to foods and ailments.', '', 'Recipes/CB0279.jpg', 1, 1, '2009-07-30 19:52:32', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(284, 2, 1, 0, 250, 'CB0280', '', 'The Cook Book', '2.50', '320.00', 'A selection of recipes from starters to desserts.', '', 'Recipes/CB0280.jpg', 1, 1, '2009-07-30 19:53:27', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(285, 2, 1, 0, 229, 'CB0281', '1852383208', 'Kid''s CookBook', '1.00', '460.00', 'A fun cook book for someone just exploring cooking.', '', 'Recipes/CB0281.jpg', 1, 1, '2009-07-30 19:54:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(286, 2, 1, 0, 231, 'CB0282', '0952885808', 'Muffins', '2.50', '110.00', 'over 20 easy to follow recipes plus helpful hints on the art of muffin making.', '', 'Recipes/CB0282.jpg', 1, 1, '2009-07-31 11:06:58', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(287, 2, 1, 0, 232, 'CB0283', '', 'The Josceline Dimbleby Christmas Book', '1.00', '450.00', 'Recipes to make Christmas meals unforgettable.', '', 'Recipes/CB0283.jpg', 1, 1, '2009-07-31 11:07:51', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(288, 2, 1, 0, 233, 'CB0284', '1903341108', 'Channel Fish', '5.00', '510.00', 'A collection of sea-fish and crustacean recipes to make your mouth water.', '', 'Recipes/CB0284.jpg', 1, 1, '2009-07-31 11:08:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(289, 2, 1, 0, 234, 'CB0285', '1903341108', 'Tuck in Chaps', '2.50', '370.00', 'Over 150 simple and lovable recipes from Bangers and Mash to Spotted Dick', '', 'Recipes/CB0285.jpg', 1, 1, '2009-07-31 11:10:05', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(290, 2, 1, 0, 235, 'CB0286', '0003294862', 'Home Economics & Food Technology', '2.50', '440.00', 'A book designed to meet the needs of students following GCSE courses in Food Science and Nutrition.', '', 'Recipes/CB0286.jpg', 1, 1, '2009-07-31 11:14:11', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(291, 2, 1, 0, 236, 'CB0287', '0947990070', 'A Taste of W.I. Markets', '2.50', '240.00', 'More than 135 seasonal recipes which pass the W.I. test!', '', 'Recipes/CB0287.jpg', 1, 1, '2009-07-31 11:15:44', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(292, 2, 1, 0, 237, 'CB0288', '0333779479', 'Soup & Beyond', '4.00', '660.00', 'A voyage of discovery in Soups and Beans.', '', 'Recipes/CB0288.jpg', 1, 1, '2009-07-31 11:16:36', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(293, 2, 1, 0, 238, 'CB0289', '0435420585', 'Examining Food & Nutrition', '1.50', '530.00', 'Written to complement the GCSE syllabus in Home Economics: Food and Nutrition.', '', 'Recipes/CB0289.jpg', 1, 1, '2009-07-31 11:17:41', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(294, 2, 1, 0, 239, 'CB0290', '0572009704', 'Tower Pressure Cook Book', '3.50', '680.00', 'Recipes for your pressure cooker.', '', 'Recipes/CB0290.jpg', 1, 1, '2009-07-31 11:18:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(295, 2, 1, 0, 240, 'CB0291', '0743207564', 'Winter Warmers', '1.00', '270.00', 'On a diet? Over 60 recipes for the diet conscious!', '', 'Recipes/CB0291.jpg', 1, 1, '2009-07-31 11:19:40', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(296, 2, 1, 0, 241, 'CB0292', '1856138275', 'Italian Cookbook', '8.00', '800.00', '240 recipes from all over Italy - Pasta''s, Pizza''s and more.', '', 'Recipes/CB0292.jpg', 1, 1, '2009-07-31 11:20:28', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(297, 2, 1, 0, 242, 'CB0293', '', 'Le repertoire de la Cuisine', '10.00', '290.00', 'Over 2600 original French recipes.', '', 'Recipes/CB0293.jpg', 1, 1, '2009-07-31 11:21:17', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(298, 2, 1, 0, 250, 'CB0294', '1840389311', 'Sweet Treats - 10 irresistable cookbooks', '40.00', '1360.00', 'A series of ten little books full of delectable recipes.&nbsp;', '', 'Recipes/CB0294.jpg', 1, 1, '2009-07-31 11:21:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(299, 5, 1, 0, 243, 'CB0295', '0140324879', 'The School Pool Gang', '1.50', '60.00', 'A story of a group of friends who raised money for a school swimming pool.', '', 'Children/CB0295.jpg', 1, 1, '2009-07-31 14:29:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(300, 5, 1, 0, 244, 'CB0296', '', 'Gumnut Factory Folk Tales', '20.00', '200.00', 'Meet Cyril the kookaburra, Booky the owl, Kippy the koala and their friends in their stories.', '', 'Children/CB0296.jpg', 1, 1, '2009-07-31 14:30:29', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(301, 5, 1, 0, 245, 'CB0297', '0670221090', 'Christmas Secrets', '29.00', '250.00', 'A story of warmth and good cheer, about a family of rabbits at Christmas.', '', 'Children/CB0297.jpg', 1, 1, '2009-07-31 14:31:21', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(302, 5, 1, 0, 204, 'CB0298', '0718116933', 'The Hedgehog Feast', '2.00', '270.00', 'The story of the Hedgehog family at hibernation time.', '', 'Children/CB0298.jpg', 1, 1, '2009-07-31 14:32:10', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(303, 5, 1, 0, 246, 'CB0299', '0907516327', 'Rex QC', '5.50', '270.00', 'A series of witty water-colours following the adventures of a (royal) corgi who lived in a palace.&nbsp;', '', 'Children/CB0299.jpg', 1, 1, '2009-07-31 14:33:04', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(304, 5, 1, 0, 264, 'CB0300', '1870949005', 'The Christmas Doll', '12.50', '140.00', 'A story from the ''Little girl'' series.', '', 'Children/CB0300.jpg', 1, 1, '2009-07-31 14:34:40', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(305, 5, 1, 0, 247, 'CB0301', '094814940X', 'Angelina on Stage', '4.50', '370.00', 'Angelina is in a grown up ballet production - with her own cousin!', '', 'Children/CB0301.jpg', 1, 1, '2009-07-31 14:36:06', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(306, 5, 1, 0, 248, 'CB0302', '0575042516', 'The Arabian Nights', '2.50', '930.00', 'Tales told by Sheherezade during a thousand nights and one night.', '', 'Children/CB0302.jpg', 1, 1, '2009-07-31 14:36:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(307, 5, 1, 0, 249, 'CB0303', '0861367391', 'The Book of Goodnight Stories', '8.00', '1140.00', '365 bed-time stories for the younger listener.', '', 'Children/CB0303.jpg', 1, 1, '2009-07-31 14:37:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(321, 8, 1, 0, 274, 'CB0304', '0952338602', 'The Beaulieu River goes to War', '5.50', '340.00', 'A history of the every vessel that was on the river and the part they played in Operation Overload.', '', 'History/CB0304.jpg', 1, 1, '2009-08-06 11:56:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(322, 3, 1, 0, 275, 'CB0305', '0297817396', 'Wheels within Wheels', '14.00', '720.00', 'An autobiography, signed by Lord Montague.', '', 'Biography/CB0305.jpg', 1, 1, '2009-08-06 11:59:30', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(323, 8, 1, 0, 276, 'CB0306', '', 'Railways in Guersney', '9.50', '70.00', 'A History of Guernsey''s railways with special reference to the German Steam Railways.', '', 'History/CB0306.jpg', 1, 1, '2009-08-24 15:16:45', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(324, 8, 1, 0, 277, 'CB0307', '', 'Old Jersey Railways', '6.50', '30.00', 'A brief history of the two railways operating in Jersey', '', 'History/CB0307.jpg', 1, 1, '2009-08-24 15:19:07', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(325, 10, 1, 0, 278, 'CB0308', '1856137090', 'Human Croquet & other titles', '20.00', '2000.00', 'A trilogy of Books from Kate Atkinson being:- Human Croquet, Emotionally Weird &amp; Behind the Scenes at the Museum.', '', 'Fiction/CB0308.jpg', 1, 1, '2009-09-01 14:09:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(326, 3, 1, 0, 279, 'CB0309', '1902918347', 'A Little Brief Authority - A memoir', '30.00', '310.00', 'An autobiographical account of Sir Peter Crill''s role in the life of the Channel Islands.', '', 'Biography/CB0309.jpg', 1, 1, '2009-09-01 19:55:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(328, 15, 1, 0, 280, 'CB0310', '', 'Popular Scientific Recreations', '145.00', '1720.00', 'Translated and enlarged from ''Les Recreations Scientifiques'' of Gaston Tissandier - editor of ''La Nature''', '', 'Antiquarian/CB0310.jpg', 1, 1, '2009-09-01 21:51:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(329, 15, 1, 0, 281, 'CB0311', '', 'The Modern Physician Volume 2', '20.00', '900.00', '<p>Being a complete guide to the attainment and preservation of health.</p>\r\n\r\n<p>Profusely illustrated by colour plates and models, photographs, diagrams and woodcuts</p>', '', 'Antiquarian/CB0311.jpg', 1, 1, '2009-09-02 09:20:44', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(330, 15, 1, 0, 250, 'CB0312', '', 'Sunday Hours for boys and girls Vol.1', '20.00', '1240.00', '&nbsp;A collection of stories for boys and girls. (With presentation inscription.)', '', 'Antiquarian/CB0312.jpg', 1, 1, '2009-09-02 09:41:20', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(331, 8, 1, 0, 282, 'CB0313', '1903051006', 'St Lawrence Jersey', '50.00', '1310.00', 'A celebration of the Parish of St Lawrence, Jersey, recording the past, present and future hopes of the Parish.', '', 'History/CB0313.jpg', 1, 1, '2009-09-03 10:54:53', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(332, 8, 1, 0, 283, 'CB0314', '0853614326', 'Railways of the Channel Islands', '12.50', '200.00', 'A pictorial Survey compiled by C Judge. With wonderful pictures', '', 'History/CB0314.jpg', 1, 1, '2009-09-03 18:24:07', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(333, 6, 1, 0, 284, 'CB0315', '0950796603', 'Jersey Superstitions in Etching & Poetry', '10.00', '320.00', 'Signed by the author, the book represents an expression of the author''s reactions to the superstitions of jersey', '', 'General/CB0315.jpg', 1, 1, '2009-09-03 18:26:31', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(334, 8, 1, 0, 285, 'CB0316', '0948578688', 'The Motor Car in Jersey', '9.00', '260.00', 'Signed by the author, this is a history of motor cars in Jersey, complied with help from the Motor Tax department and others.', '', 'History/CB0316.jpg', 1, 1, '2009-09-03 18:29:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(335, 8, 1, 0, 286, 'CB0317', '1870544153', 'Flight in Jersey', '25.00', '240.00', 'The story of Jersey Airport from it''s inception - the beach version to modern day.', '', 'History/CB0317.jpg', 1, 1, '2009-09-03 18:32:14', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(336, 8, 1, 0, 287, 'CB0318', '0861200098', 'Jersey Sea Stories', '15.00', '480.00', 'A collection of stories covering factual accounts of historic landmarks to the true adventure of Louisa Journeax', '', 'History/CB0318.jpg', 1, 1, '2009-09-03 18:35:13', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(337, 4, 1, 0, 288, 'CB0319', '0861200381', 'Lest We Forget', '40.00', '330.00', '<p>Stories of escapes and attempted escapes from Jersey during the German Occupation 1940 - 1945</p>', '', 'Occupation_History/CB0319.jpg', 1, 1, '2009-09-03 18:37:10', 0, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(338, 6, 1, 0, 289, 'CB0320', '1903341116', 'jersey Cycles - Exploring the Island by bike', '3.50', '250.00', 'A description of 12 routes, based upon the Island''s 12 Parishes.', '', 'General/CB0320.jpg', 1, 1, '2009-09-06 20:27:45', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(339, 6, 1, 0, 260, 'CB0321', '1873686099', 'How Heavy, How Much and How Long?', '5.50', '170.00', 'Weights, money and other measures used by our ancestors.', '', 'General/CB0321.jpg', 1, 1, '2009-09-06 20:29:59', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(340, 8, 1, 0, 260, 'CB0322', '1873686056', 'The Growth of British Education and it''s Records', '1.50', '160.00', 'A History of Education in the UK from earliest known times.', '', 'History/CB0322.jpg', 1, 1, '2009-09-06 20:34:22', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(341, 8, 1, 0, 297, 'CB0323', '0850338379', 'A pedestrian tour through the Islands of Guernsey and Jersey', '8.75', '470.00', 'Transcribed by Ken Renault, the book traces the walks followed by Walmesley in 1821, just after the Napoleonic wars.', '', 'History/CB0323.jpg', 1, 1, '2009-09-07 09:41:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(342, 8, 1, 0, 296, 'CB0324', '0952206587', 'A Life in the Street', '8.50', '360.00', 'An insight into life in a Hill Street, Jersey Law Office between 1945 and 1995.', '', 'History/CB0324.jpg', 1, 1, '2009-09-07 09:43:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(343, 4, 1, 0, 295, 'CB0325', '', 'Wartime Memories', '4.00', '80.00', 'A true account of the author''s life as a schoolgirl in the Bailiwick of jersey between 1940 and 1945.', '', 'Occupation_History/CB0325.jpg', 1, 1, '2009-09-07 09:45:30', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(344, 3, 1, 0, 294, 'CB0326', '', 'A Jersey Childhood', '30.00', '100.00', 'The life and times of the author, who was born and brought up in Jersey.', '', 'Biography/CB0326.jpg', 1, 1, '2009-09-07 09:49:03', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(345, 2, 1, 0, 293, 'CB0327', '', 'Favourite Recipes of Channel Islanders', '25.00', '450.00', 'With a foreword by Eric Morecambe OBE, this recipe book contains over 150 Channel Island recipes.', '', 'Recipes/CB0327.jpg', 1, 1, '2009-09-07 09:51:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(346, 8, 1, 0, 292, 'CB0328', '', 'The Story of Cornwall''s Railways', '8.00', '90.00', 'Complete with maps and black and white pictures.', '', 'History/CB0328.jpg', 1, 1, '2009-09-07 09:54:32', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(347, 7, 1, 0, 290, 'CB0329', '1853450472', 'Early Days with Jesus - On the move', '4.00', '100.00', 'A book for little children, which includes a pages that can be coloured in.', '', 'Religious/CB0329.jpg', 1, 1, '2009-09-07 09:56:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(348, 4, 1, 0, 291, 'CB0330', '0948578696', 'No Cause for Panic', '2.00', '310.00', 'The story of the evacuation and exile of British residents to England, it is a deeply human account of an aspect of the Occupation Years not previously recorded.', '', 'Occupation_History/CB0330.jpg', 1, 1, '2009-09-07 10:01:00', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(349, 8, 1, 0, 301, 'CB0331', '1860771041', 'St Martin Jersey', '25.00', '1630.00', 'The Story of an Island Parish and dedicated to the Parishioners who gave their lives in the two world wars', '', 'History/CB0331.jpg', 1, 1, '2009-09-07 18:57:00', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(350, 2, 1, 0, 300, 'CB0332', '', 'Step-By-Step Vegetarian Cookbook', '20.00', '1570.00', 'A superb collection of over 500 delicious, stylish recipes from Good Housekeeping.', '', 'Recipes/CB0332.jpg', 1, 1, '2009-09-07 19:00:56', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(351, 8, 1, 0, 299, 'CB0333', '', 'A History of Highlands College', '5.00', '350.00', 'A look at the History of HIghlands College from the Jesuits to the present time.', '', 'History/CB0333.jpg', 1, 1, '2009-09-07 19:02:43', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(352, 8, 1, 0, 298, 'CB0334', '1859831362', 'Island Images', '19.50', '950.00', '', '', 'History/CB0334.jpg', 1, 1, '2009-09-07 19:03:44', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(353, 8, 1, 0, 298, 'CB0335', '1873626800', 'Images of Jersey', '25.00', '1020.00', 'A history of 20th century Jersey presented in pictures from the JEP archives.', '', 'History/CB0335.jpg', 1, 1, '2009-09-07 19:06:00', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(354, 8, 1, 0, 298, 'CB0336', '1859831923', 'A Jersey Century', '12.50', '950.00', 'One hundred years of memories from the Jersey Evening Post files, in &nbsp;association with Societe Jersiaise.', '', 'History/CB0336.jpg', 1, 1, '2009-09-07 19:07:52', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(355, 8, 1, 0, 302, 'CB0337', '0905046153', 'Nella Last''s War', '24.00', '520.00', 'Written as part of the Mass Observation project, this is the diary of one housewife, written during the 1939 - 1945 war. (Stamped as discarded by a public library)', '', 'History/CB0337.jpg', 1, 1, '2009-10-09 18:48:12', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(356, 6, 1, 0, 303, 'CB0338', '2253047635', 'The Strange Case of Dr Jekyl and Mr Hyde', '5.70', '130.00', 'A Bi-lingual version (French &amp; English) of Stevenson''s famous novel.', '', 'General/CB0338.jpg', 1, 1, '2009-10-14 13:33:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(357, 8, 1, 0, 304, 'CB0339', '0947893318', 'Wilfred Owen Poet and Soldier', '42.00', '130.00', 'A Biography of a Soldier who served in the First World War', '', 'History/CB0339.jpg', 1, 1, '2009-10-14 13:37:13', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(358, 10, 1, 0, 305, 'CB0340', '0593054695', 'C''est La Folie', '3.70', '580.00', 'One man''s quest for a meaningful life.', '', 'Fiction/CB0340.jpg', 1, 1, '2009-10-14 13:38:36', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(359, 15, 1, 0, 250, 'CB0341', '', 'Amateur Work, Illustrated - Volume 1', '50.00', '1680.00', 'Edited by the Author of ''Everyman his own mechanic'' (John Barnard?) with lithographic Supplements containing Designs, sketches and working drawings and 500 wood engravings in the text', '', 'Antiquarian/CB0341.jpg', 1, 1, '2009-10-31 12:11:01', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(360, 15, 1, 0, 250, 'CB0342', '', 'Amateur Work, Illustrated Volume 2', '50.00', '1680.00', 'Edited by the author of ''Every man his own mechanic'' (John Barnard?) with 12 supplements, contains Designs and working drawings to scale, for various pieces of work, useful and ornamental.', '', 'Antiquarian/CB0342.jpg', 1, 1, '2009-10-31 12:13:51', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(361, 15, 1, 0, 250, 'CB0343', '', 'Amateur Work Illustrated volume 3', '50.00', '1680.00', 'Edited by the author of ''Every man his own mechanic (John Barnard?) with supplements containing designs and working drawings to scale for various pieces of work, useful and ornamental&nbsp;', '', 'Antiquarian/CB0343.jpg', 1, 1, '2009-10-31 12:17:42', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(362, 15, 1, 0, 250, 'CB0344', '', 'Amateur Work, Illustrated volume 5', '50.00', '1680.00', 'Edited by the author of ''Every man his own mechanic'' (John Barnard?) with supplements containing designs and working drawings to scale for various work, useful and ornamental. Note, this volume has minor rear cover damage.', '', 'Antiquarian/CB0344.jpg', 1, 1, '2009-10-31 12:20:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(363, 6, 1, 0, 260, 'CB0345', '1873686021', 'Marriage Laws, Rites, Records & Customs', '5.00', '210.00', 'A short history of various marriage rites, with an overview of historical records and customs', '', 'General/CB0345.jpg', 1, 1, '2009-10-31 12:28:49', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(364, 15, 1, 0, 250, 'CB0346', '', 'The National Encyclopaedia in 14 volumes', '250.00', '0.00', 'A complete set of 14 volumes of The National Encyclopaedia, &nbsp;- A Dictionary of Universal Knowledge, published by William McKenzie, London, and dated around 1880. Price <strong>does not</strong>&nbsp;include post &amp; packaging.', '', 'Antiquarian/CB0346.jpg', 1, 1, '2009-10-31 14:08:27', 1, 0, 0, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(365, 4, 1, 0, 306, 'CB0347', '0450056767', 'A Doctor''s Occupation', '13.50', '150.00', 'The dramatic true story of life in Nazi-occupied Jersey.', '', 'Occupation_History/CB0347.jpg', 1, 1, '2009-10-31 14:28:24', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(366, 8, 1, 0, 307, 'CB0348', '0099532816', 'All Quiet on the Western Front', '2.50', '170.00', 'Translated by Brian Murdoch, this is an account of life, seen from a German''s view-point, in the trenches during the First World War.', '', 'History/CB0348.jpg', 1, 1, '2009-10-31 14:32:20', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(367, 6, 1, 0, 308, 'CB0349', '0435103881', 'Alpha to Omega', '10.50', '450.00', 'The A-Z of teaching reading, writing and spelling, using a phonetic linguistic approach.', '', 'General/CB0349.jpg', 1, 1, '2009-10-31 14:46:32', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(368, 8, 1, 0, 309, 'CB0350', '0951843702', 'Family History in Jersey', '15.00', '130.00', 'A Brief history of the civil registers that are available, in Jersey, for those who wish to trace their family histories', '', 'History/CB0350.jpg', 1, 1, '2009-10-31 20:43:39', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(369, 2, 1, 0, 310, 'CB0351', '', 'Dishes from the Dairy', '4.50', '140.00', 'A collection of recipes from the South Eastern Jersey &nbsp;Club for Jersey Cows', '', 'Recipes/CB0351.jpg', 1, 1, '2009-10-31 20:45:40', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(370, 2, 1, 0, 250, 'CB0352', '', 'Bouon Appetit', '5.00', '70.00', 'A collection of Jersey recipes, compiled by the Jersey Island Federation of Women''s Institutes.', '', 'Recipes/CB0352.jpg', 1, 1, '2009-10-31 20:48:34', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(371, 8, 1, 0, 311, 'CB0353', '', 'Historic Jersey', '15.00', '290.00', 'A Sequel to ''A Short Parochial &amp; Commercial History of Jersey'' , the volume is an updated and revised version of Philip Ahier''s original book.', '', 'History/CB0353.jpg', 1, 1, '2009-10-31 20:52:11', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(372, 2, 1, 0, 312, 'CB0354', '', 'A Collection of Occupation Recipes', '5.00', '120.00', 'This book is a collection of recipes put together by Mrs Lillie Morris, from St Clement, Jersey, who lived through the occupation. Foreword by Beth Lloyd.', '', 'Recipes/CB0354.jpg', 1, 1, '2009-10-31 20:55:19', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(373, 4, 1, 0, 313, 'CB0355', '', 'Islands in Danger', '7.00', '450.00', '<p>The Story of the German occupation of the Channel Islands, 1940 - 1945. Has some page markings, as if used as a reference.</p>\r\n\r\n<p>(Discharged by RAF Innsworth, Officer''s Mess)</p>', '', 'Occupation_History/CB0355.jpg', 1, 1, '2009-11-03 11:04:05', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(374, 13, 1, 0, 314, 'BK0695', '0932255027', 'Contemporary Loomed Beadwork', '50.00', '60.00', '<p>An ''out of print'' book which graphically teaches the whole loomwork process from stringing the loom to advanced loom techniques.</p>', '', 'Beading/BK0695.jpg', 1, 1, '2009-12-03 19:10:17', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(375, 13, 1, 0, 315, 'BK0794', '0964607719', 'Contemporary Beadwork II Sea Anemone Beadwork', '45.00', '120.00', '<p>Now ''out of print'', this little book provides a technique for three dimensional loomed beadwork.</p>', '', 'Beading/BK0794.jpg', 1, 1, '2009-12-04 10:20:57', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(376, 13, 1, 0, 316, 'BK1190', '0964836025', 'The Magic Amulet Bag Volume 2', '15.00', '120.00', '<p>Now out of print, this book includes directions for making lids and buttonhole closures.</p>', '', 'Beading/BK1190.jpg', 1, 1, '2009-12-04 10:26:11', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(377, 13, 1, 0, 322, 'BK1488', '1863511474', 'Beautiful Beading - a beginners guide.', '100.00', '320.00', '<p>A much sought-after rare copy of this delightful book from Australia</p>', '', 'Beading/BK1488.jpg', 1, 1, '2009-12-04 10:29:37', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(378, 13, 1, 0, 317, 'BK1703', '', 'Those Bad Bad Beads', '35.00', '350.00', '<p>A Spiral-Bound copy of this 6th edition book by this American author, includes drawings, tips and techniques to die for.</p>', '', 'Beading/BK1703.jpg', 1, 1, '2009-12-04 10:35:13', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(379, 13, 1, 0, 318, 'BK1938', '', 'The Beaded Ornament', '25.00', '150.00', '<p>This ''difficult to get'' American book includes four designs in full colour.</p>', '', 'Beading/BK1938.jpg', 1, 1, '2009-12-04 10:36:55', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(380, 13, 1, 0, 319, 'BK2028', '', 'Adorn Thyself', '25.00', '200.00', '<p>64 patterns in Peyote or Brick stitch, with full colour pictures, in this otherwise unavailable book.</p>', '', 'Beading/BK2028.jpg', 1, 1, '2009-12-04 10:39:46', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(381, 13, 1, 0, 323, 'BK2106', '1931499500', 'Beading with Right Angle Weave', '60.00', '470.00', '<p>In short supply, this book includes 21 dazzling projects, explains single and double needle techniques, simply, and has a full colour gallery to inspire your own designs.</p>', '', 'Beading/BK2106.jpg', 1, 0, '2009-12-04 10:42:54', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(382, 13, 1, 0, 324, 'BK2121', '193149942x', 'Bead Crochet', '50.00', '460.00', '<p>Difficult to get hold of, this book will get you hooked on Bead Crochet and take your beadwork in a whole new direction.</p>', '', 'Beading/BK2121.jpg', 1, 1, '2009-12-04 10:46:17', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(383, 13, 1, 0, 325, 'BK2788', '0806960906', 'The Beaded OBject', '65.00', '760.00', '<p>A difficult-to-obtain hard-back book which will show you how to make gorgeous Flowers and other Decorative Accents</p>', '', 'Beading/BK2788.jpg', 1, 1, '2009-12-04 10:51:26', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(384, 13, 1, 0, 326, 'BK2790', '0806978295', 'Art of Seed Beading', '25.00', '540.00', '<p>This full colour, soft-back, American book, will provide 23 fabulous designs for you to try.</p>', '', 'Beading/BK2790.jpg', 1, 1, '2009-12-04 10:55:16', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(385, 13, 1, 0, 327, 'BK3292', '1574211692', 'Wire Jewelry', '45.00', '90.00', '<p>From an American company - Design Originals - this slim volume will show you all you need to know to make wire-based jewelry.</p>', '', 'Beading/BK3292.jpg', 1, 1, '2009-12-04 10:58:02', 1, 0, 1, 0, 0);
INSERT INTO `ushop_products` (`product_id`, `category_id`, `tax_code_id`, `price_group_id`, `author_id`, `sku`, `isbn`, `name`, `price`, `weight`, `description`, `short_description`, `image`, `image_status`, `quantity`, `date_entered`, `enabled`, `vat_inc`, `postage`, `hits`, `discontinued`) VALUES(386, 13, 1, 0, 328, 'BK3364', '1574212419', 'Classy & Chic Bead Jewelry', '20.00', '110.00', '<p>An American book, it includes know-how tips and design suggestions for all ages and skills</p>', '', 'Beading/BK3364.jpg', 1, 1, '2009-12-04 11:00:20', 1, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ushop_product_attributes`
--

DROP TABLE IF EXISTS `ushop_product_attributes`;
CREATE TABLE IF NOT EXISTS `ushop_product_attributes` (
  `attribute_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute` varchar(255) NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ushop_product_attributes`
--

INSERT INTO `ushop_product_attributes` (`attribute_id`, `attribute`) VALUES(1, 'Size');
INSERT INTO `ushop_product_attributes` (`attribute_id`, `attribute`) VALUES(2, 'Colour');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_product_attribute_list`
--

DROP TABLE IF EXISTS `ushop_product_attribute_list`;
CREATE TABLE IF NOT EXISTS `ushop_product_attribute_list` (
  `attribute_list_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned NOT NULL,
  `price` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`attribute_list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_product_attribute_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_product_attribute_properties`
--

DROP TABLE IF EXISTS `ushop_product_attribute_properties`;
CREATE TABLE IF NOT EXISTS `ushop_product_attribute_properties` (
  `property_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property` varchar(255) NOT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_product_attribute_properties`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_product_categories`
--

DROP TABLE IF EXISTS `ushop_product_categories`;
CREATE TABLE IF NOT EXISTS `ushop_product_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(60) DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `category_image` varchar(255) DEFAULT NULL,
  `category_image_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`),
  KEY `lft` (`lft`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ushop_product_categories`
--

INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(2, 'Recipes', 21, 22, 'Recipes/CB0053.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(3, 'Biography', 5, 6, 'Biography/CB0001.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(4, 'Occupation History', 17, 18, 'Occupation_History/CB0003.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(5, 'Children', 7, 8, 'Children/CB0002.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(6, 'General', 11, 12, 'General/CB0080.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(7, 'Religious', 23, 24, 'Religious/CB0055.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(8, 'History', 13, 14, 'History/CB0036.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(9, 'Poetry', 19, 20, 'Poetry/CB0051.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(10, 'Fiction', 9, 10, 'Fiction/CB0062.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(11, 'Music', 15, 16, 'Music/CB0189.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(13, 'Beading', 3, 4, 'Beading/BK0695.jpg', 1);
INSERT INTO `ushop_product_categories` (`category_id`, `category`, `lft`, `rgt`, `category_image`, `category_image_status`) VALUES(15, 'Antiquarian', 1, 2, 'Antiquarian/CB0311.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ushop_product_custom_fields`
--

DROP TABLE IF EXISTS `ushop_product_custom_fields`;
CREATE TABLE IF NOT EXISTS `ushop_product_custom_fields` (
  `custom_field_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `custom_field` varchar(60) NOT NULL,
  `unique` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_product_custom_fields`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_product_names`
--

DROP TABLE IF EXISTS `ushop_product_names`;
CREATE TABLE IF NOT EXISTS `ushop_product_names` (
  `name_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` mediumtext,
  PRIMARY KEY (`name_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ushop_product_names`
--


-- --------------------------------------------------------

--
-- Table structure for table `ushop_tax_codes`
--

DROP TABLE IF EXISTS `ushop_tax_codes`;
CREATE TABLE IF NOT EXISTS `ushop_tax_codes` (
  `tax_code_id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `tax_rate_id` int(1) unsigned NOT NULL DEFAULT '0',
  `tax_code` varchar(2) NOT NULL DEFAULT '',
  `description` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`tax_code_id`),
  KEY `ushop_tax_codes_ibfk_1` (`tax_rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ushop_tax_codes`
--

INSERT INTO `ushop_tax_codes` (`tax_code_id`, `tax_rate_id`, `tax_code`, `description`) VALUES(1, 1, 'N', 'Not Registered');

-- --------------------------------------------------------

--
-- Table structure for table `ushop_tax_rates`
--

DROP TABLE IF EXISTS `ushop_tax_rates`;
CREATE TABLE IF NOT EXISTS `ushop_tax_rates` (
  `tax_rate_id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `tax_rate` decimal(4,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`tax_rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ushop_tax_rates`
--

INSERT INTO `ushop_tax_rates` (`tax_rate_id`, `tax_rate`) VALUES(1, '0.000');

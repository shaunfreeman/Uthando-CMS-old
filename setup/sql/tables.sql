CREATE TABLE administrators (
  administrator_id int(10) unsigned NOT NULL auto_increment,
  username varchar(20) NOT NULL,
  password varchar(20) NOT NULL,
  PRIMARY KEY  (administrator_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
--
CREATE TABLE components (
  component_id int(10) unsigned NOT NULL auto_increment,
  component varchar(45) NOT NULL,
  version varchar(10) NOT NULL,
  PRIMARY KEY  (component_id),
  UNIQUE KEY conponent (component)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE email_body (
  email_id int(10) unsigned NOT NULL auto_increment,
  template varchar(100) default NULL,
  body text,
  PRIMARY KEY  (email_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE email_type (
  email_type_id int(10) unsigned NOT NULL auto_increment,
  email_type varchar(10) NOT NULL default 'html',
  PRIMARY KEY  (email_type_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE menus (
  menu_id int(10) unsigned NOT NULL auto_increment,
  menu varchar(60) NOT NULL,
  deletable int(1) unsigned NOT NULL default '0',
  menu_type_id int(10) unsigned NOT NULL,
  PRIMARY KEY  (menu_id),
  KEY menu_type_id (menu_type_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE menu_items (
  item_id int(10) unsigned NOT NULL auto_increment,
  menu_id int(10) unsigned NOT NULL default '0',
  lft int(10) unsigned NOT NULL default '0',
  rgt int(10) unsigned NOT NULL default '0',
  status_id int(10) unsigned NOT NULL default '0',
  url_id int(10) unsigned NOT NULL default '0',
  title varchar(60) NOT NULL,
  PRIMARY KEY  (item_id),
  KEY menu_id (menu_id),
  KEY status_id (status_id),
  KEY url_id (url_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE menu_link_status (
  status_id int(3) unsigned NOT NULL auto_increment,
  status char(2) NOT NULL,
  PRIMARY KEY  (status_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE menu_type (
  menu_type_id int(10) unsigned NOT NULL auto_increment,
  menu_type varchar(60) NOT NULL,
  PRIMARY KEY  (menu_type_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE menu_urls (
  url_id int(3) unsigned NOT NULL auto_increment,
  page_id int(5) unsigned NOT NULL default '0',
  url varchar(45) NOT NULL default '',
  modified_date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (url_id),
  KEY page_id (page_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE modules (
  module_id int(10) unsigned NOT NULL auto_increment,
  module_name_id int(10) unsigned NOT NULL default '0',
  position_id int(10) unsigned NOT NULL default '0',
  module varchar(45) NOT NULL,
  sort_order int(2) unsigned NOT NULL default '0',
  show_title int(1) unsigned NOT NULL default '0',
  params text,
  html text,
  PRIMARY KEY  (module_id),
  KEY module_name_id (module_name_id),
  KEY position_id (position_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE modules_position (
  position_id int(10) unsigned NOT NULL auto_increment,
  position varchar(30) default NULL,
  PRIMARY KEY  (position_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE module_names (
  module_name_id int(10) unsigned NOT NULL auto_increment,
  module_name varchar(100) NOT NULL,
  PRIMARY KEY  (module_name_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE pages (
  page_id int(10) unsigned NOT NULL auto_increment,
  page varchar(60) NOT NULL,
  content text,
  date_entered timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  hits int(10) NOT NULL default '0',
  deletable char(1) NOT NULL default 'N',
  PRIMARY KEY  (page_id),
  KEY title (page)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
--
CREATE TABLE sessions (
  session_id int(10) unsigned NOT NULL auto_increment,
  session varchar(255) character set utf8 collate utf8_bin NOT NULL,
  session_expires int(10) unsigned NOT NULL default '0',
  session_data mediumtext,
  PRIMARY KEY  (session_id),
  KEY session (session)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
--
CREATE TABLE users (
  user_id int(10) unsigned NOT NULL auto_increment,
  email_type_id int(10) unsigned NOT NULL default '1',
  name varchar(60) NOT NULL,
  email varchar(40) NOT NULL,
  password varchar(40) NOT NULL,
  cdate datetime NOT NULL default '0000-00-00 00:00:00',
  mdate timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  activation int(1) NOT NULL,
  block int(1) NOT NULL,
  PRIMARY KEY  (user_id),
  UNIQUE KEY email (email),
  KEY password (password),
  KEY name (name),
  KEY email_type_id (email_type_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
--
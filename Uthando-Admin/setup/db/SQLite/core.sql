BEGIN TRANSACTION;

--
-- Database: "uthando_core"
--

-- --------------------------------------------------------

--
-- Table structure for table "components"
--

DROP TABLE IF EXISTS "components";
CREATE TABLE IF NOT EXISTS "components" (
  "component_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "component" VARCHAR(45) UNIQUE NOT NULL,
  "version" INTEGER(10) NOT NULL,
  "enabled" INTEGER(1) NOT NULL DEFAULT '0'
);

--
-- Dumping data for table "components"
--

INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(1, 'user', 1, 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(2, 'content', 1, 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(4, 'ushop', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table "email_body"
--

DROP TABLE IF EXISTS "email_body";
CREATE TABLE IF NOT EXISTS "email_body" (
  "email_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "template" VARCHAR(100) DEFAULT NULL,
  "body" TEXT
);

--
-- Dumping data for table "email_body"
--

INSERT INTO "email_body" ("email_id", "template", "body") VALUES(1, 'password reminder', 'Dear ####USER####\r\n\r\nYou have requested to be reminded of your password at ####SITE####.\r\n\r\nYour password is: ####PASSWORD####\r\n\r\nRegards\r\n####ADMINISTRATOR####  ');
INSERT INTO "email_body" ("email_id", "template", "body") VALUES(2, 'register user', 'Dear ####USER####\r\n\r\nYou have registered an account at ####SITE####.\r\n\r\nYour password is: ####PASSWORD####\r\n\r\nRegards\r\n####ADMINISTRATOR####  ');

-- --------------------------------------------------------

--
-- Table structure for table "email_type"
--

DROP TABLE IF EXISTS "email_type";
CREATE TABLE IF NOT EXISTS "email_type" (
  "email_type_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "email_type" VARCHAR(10) NOT NULL DEFAULT 'html'
);

--
-- Dumping data for table "email_type"
--

INSERT INTO "email_type" ("email_type_id", "email_type") VALUES(1, 'html');
INSERT INTO "email_type" ("email_type_id", "email_type") VALUES(2, 'plain');

-- --------------------------------------------------------

--
-- Table structure for table "menu_items"
--

DROP TABLE IF EXISTS "menu_items";
CREATE TABLE IF NOT EXISTS "menu_items" (
  "item_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "menu_type_id" INTEGER(11) DEFAULT NULL,
  "status_id" INTEGER(10) NOT NULL DEFAULT '0',
  "url_id" INTEGER(10) DEFAULT NULL,
  "page_id" INTEGER(10) DEFAULT NULL,
  "item_type_id" INTEGER(10) DEFAULT NULL,
  "item" VARCHAR(255) NOT NULL,
  "lft" INTEGER(10) NOT NULL,
  "rgt" INTEGER(10) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "menu_item_types"
--

DROP TABLE IF EXISTS "menu_item_types";
CREATE TABLE IF NOT EXISTS "menu_item_types" (
  "item_type_id" INTEGER(255) PRIMARY KEY NOT NULL,
  "item_type" VARCHAR(255) NOT NULL
);

CREATE INDEX "item_type" ON "menu_item_types" ("item_type");

--
-- Dumping data for table "menu_item_types"
--

INSERT INTO "menu_item_types" ("item_type_id", "item_type") VALUES(1, 'component');
INSERT INTO "menu_item_types" ("item_type_id", "item_type") VALUES(2, 'external');
INSERT INTO "menu_item_types" ("item_type_id", "item_type") VALUES(3, 'heading');

-- --------------------------------------------------------

--
-- Table structure for table "menu_link_status"
--

DROP TABLE IF EXISTS "menu_link_status";
CREATE TABLE IF NOT EXISTS "menu_link_status" (
  "status_id" INTEGER(3) PRIMARY KEY NOT NULL,
  "status" CHAR(2) NOT NULL
);

--
-- Dumping data for table "menu_link_status"
--

INSERT INTO "menu_link_status" ("status_id", "status") VALUES(1, 'A');
INSERT INTO "menu_link_status" ("status_id", "status") VALUES(2, 'LI');
INSERT INTO "menu_link_status" ("status_id", "status") VALUES(3, 'LO');

-- --------------------------------------------------------

--
-- Table structure for table "menu_types"
--

DROP TABLE IF EXISTS "menu_types";
CREATE TABLE IF NOT EXISTS "menu_types" (
  "menu_type_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "menu_type" VARCHAR(60) NOT NULL
);

--
-- Dumping data for table "menu_types"
--

INSERT INTO "menu_types" ("menu_type_id", "menu_type") VALUES(1, 'vertical');
INSERT INTO "menu_types" ("menu_type_id", "menu_type") VALUES(2, 'horizontal');

-- --------------------------------------------------------

--
-- Table structure for table "menu_urls"
--

DROP TABLE IF EXISTS "menu_urls";
CREATE TABLE IF NOT EXISTS "menu_urls" (
  "url_id" INTEGER(3) PRIMARY KEY NOT NULL,
  "url" VARCHAR(255) DEFAULT NULL,
  "enssl" INTEGER(1) NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Table structure for table "modules"
--

DROP TABLE IF EXISTS "modules";
CREATE TABLE IF NOT EXISTS "modules" (
  "module_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "module_name_id" INTEGER(10) NOT NULL DEFAULT '0',
  "position_id" INTEGER(10) NOT NULL DEFAULT '0',
  "module" VARCHAR(45) NOT NULL,
  "sort_order" INTEGER(2) NOT NULL DEFAULT '0',
  "show_title" INTEGER(1) NOT NULL DEFAULT '0',
  "params" TEXT,
  "html" TEXT,
  "enabled" INTEGER(1) NOT NULL DEFAULT '0'
);

CREATE INDEX "module_name_id" ON "modules" ("module_name_id");
CREATE INDEX "position_id" ON "modules" ("position_id");

--
-- Dumping data for table "modules"
--

INSERT INTO "modules" ("module_id", "module_name_id", "position_id", "module", "sort_order", "show_title", "params", "html", "enabled") VALUES(1, 1, 3, 'Top Menu', 1, 0, 'menu=Top Menu\r\nclass_sfx=-nav\r\nmoduleclass_sfx=\r\nlog_in=0', NULL, 1);
INSERT INTO "modules" ("module_id", "module_name_id", "position_id", "module", "sort_order", "show_title", "params", "html", "enabled") VALUES(2, 1, 1, 'Main Menu', 2, 1, 'menu=Main Menu\r\nclass_sfx=\r\nmoduleclass_sfx=_menu\r\nlog_in=0', NULL, 1);
INSERT INTO "modules" ("module_id", "module_name_id", "position_id", "module", "sort_order", "show_title", "params", "html", "enabled") VALUES(3, 2, 1, 'Site Specs', 3, 1, 'log_in=0', '<p>\r\n	Site best viewed in a screen resolution of 1024x768 &#038; 32 bit colours or higher using the latest version of <a href="http://www.mozilla.com/en-US/firefox" target="_blank">Firefox</a>\r\n</p>\r\n<p>\r\n	<a href="http://www.mozilla.com/en-US/firefox" target="_blank">\r\n		<img src="/Common/images/firefox.png" />\r\n	</a>\r\n</p>', 1);
INSERT INTO "modules" ("module_id", "module_name_id", "position_id", "module", "sort_order", "show_title", "params", "html", "enabled") VALUES(5, 1, 1, 'My Account', 3, 1, 'menu=My Account\r\nclass_sfx=\r\nmoduleclass_sfx=_menu\r\nlog_in=1', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table "modules_position"
--

DROP TABLE IF EXISTS "modules_position";
CREATE TABLE IF NOT EXISTS "modules_position" (
  "position_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "position" VARCHAR(30) DEFAULT NULL
);

--
-- Dumping data for table "modules_position"
--

INSERT INTO "modules_position" ("position_id", "position") VALUES(1, 'left');
INSERT INTO "modules_position" ("position_id", "position") VALUES(2, 'right');
INSERT INTO "modules_position" ("position_id", "position") VALUES(3, 'top menu');

-- --------------------------------------------------------

--
-- Table structure for table "module_names"
--

DROP TABLE IF EXISTS "module_names";
CREATE TABLE IF NOT EXISTS "module_names" (
  "module_name_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "module_name" VARCHAR(100) NOT NULL
);

--
-- Dumping data for table "module_names"
--

INSERT INTO "module_names" ("module_name_id", "module_name") VALUES(1, 'menu');
INSERT INTO "module_names" ("module_name_id", "module_name") VALUES(2, 'custom');

-- --------------------------------------------------------

COMMIT;
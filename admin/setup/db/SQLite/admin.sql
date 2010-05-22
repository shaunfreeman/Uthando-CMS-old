BEGIN TRANSACTION;

--
-- Database: "uthando_admin"
--

-- --------------------------------------------------------

--
-- Table structure for table "components"
--

DROP TABLE IF EXISTS "components";
CREATE TABLE "components" (
  "component_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "component" VARCHAR(45) UNIQUE NOT NULL,
  "version" VARCHAR(10) NOT NULL,
  "enabled" INTEGER(1) NOT NULL DEFAULT '0'
);

--
-- Dumping data for table "components"
--

INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(1, 'user', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(2, 'content', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(3, 'admin', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(4, 'ushop', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(5, 'menu', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(6, 'template', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(7, 'media', '1.0rc1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(8, 'component', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(9, 'module', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(10, 'plugin', '1', 1);
INSERT INTO "components" ("component_id", "component", "version", "enabled") VALUES(11, 'webmail', '0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table "menu_items"
--

DROP TABLE IF EXISTS "menu_items";
CREATE TABLE IF NOT EXISTS "menu_items" (
  "item_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "menu_type_id" INTEGER(10) DEFAULT NULL,
  "status_id" INTEGER(10) NOT NULL DEFAULT '0',
  "url_id" INTEGER(10) DEFAULT NULL,
  "page_id" INTEGER(10) DEFAULT NULL,
  "item_type_id" INTEGER(10) DEFAULT NULL,
  "item" VARCHAR(60) NOT NULL,
  "lft" INTEGER(10)  NOT NULL,
  "rgt" INTEGER(10)  NOT NULL
);

--
-- Dumping data for table "menu_items"
--

INSERT INTO "menu_items" ("item_id", "menu_type_id", "status_id", "url_id", "page_id", "item_type_id", "item", "lft", "rgt") VALUES(1, NULL, 2, 1, NULL, 1, 'Admin', 2, 3);
INSERT INTO "menu_items" ("item_id", "menu_type_id", "status_id", "url_id", "page_id", "item_type_id", "item", "lft", "rgt") VALUES(2, NULL, 2, 4, NULL, 1, 'Menus', 4, 5);
INSERT INTO "menu_items" ("item_id", "menu_type_id", "status_id", "url_id", "page_id", "item_type_id", "item", "lft", "rgt") VALUES(3, NULL, 2, 5, NULL, 1, 'Content', 6, 7);
INSERT INTO "menu_items" ("item_id", "menu_type_id", "status_id", "url_id", "page_id", "item_type_id", "item", "lft", "rgt") VALUES(4, NULL, 2, 2, NULL, 1, 'Logout', 10, 11);
INSERT INTO "menu_items" ("item_id", "menu_type_id", "status_id", "url_id", "page_id", "item_type_id", "item", "lft", "rgt") VALUES(5, 1, 2, NULL, NULL, NULL, 'Main Menu', 1, 12);
INSERT INTO "menu_items" ("item_id", "menu_type_id", "status_id", "url_id", "page_id", "item_type_id", "item", "lft", "rgt") VALUES(6, NULL, 2, 6, NULL, 1, 'Ushop', 8, 9);

-- --------------------------------------------------------

--
-- Table structure for table "menu_urls"
--

DROP TABLE IF EXISTS "menu_urls";
CREATE TABLE IF NOT EXISTS "menu_urls" (
  "url_id" INTEGER(3) PRIMARY KEY NOT NULL,
  "url" VARCHAR(45) NOT NULL DEFAULT '',
  "enssl" INTEGER(1)  NOT NULL DEFAULT '0'
);

--
-- Dumping data for table "menu_urls"
--

INSERT INTO "menu_urls" ("url_id", "url", "enssl") VALUES(1, 'admin/overview', 0);
INSERT INTO "menu_urls" ("url_id", "url", "enssl") VALUES(2, 'user/logout', 0);
INSERT INTO "menu_urls" ("url_id", "url", "enssl") VALUES(4, 'menu/overview', 0);
INSERT INTO "menu_urls" ("url_id", "url", "enssl") VALUES(5, 'content/overview', 0);
INSERT INTO "menu_urls" ("url_id", "url", "enssl") VALUES(6, 'ushop/overview', 0);

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
  "enabled" INTEGER(1)  NOT NULL DEFAULT '0'
);

CREATE INDEX "module_name_id" ON "modules" ("module_name_id");
CREATE INDEX "position_id" ON "modules" ("position_id");

--
-- Dumping data for table "modules"
--

INSERT INTO "modules" ("module_id", "module_name_id", "position_id", "module", "sort_order", "show_title", "params", "html", "enabled") VALUES(2, 1, 1, 'Main Menu', 2, 1, 'menu=Main Menu\r\nclass_sfx=\r\nmoduleclass_sfx=_menu brdPad\r\nlog_in=0', NULL, 1);

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

COMMIT;
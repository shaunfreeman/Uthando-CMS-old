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

--
-- Table structure for table "pages"
--

DROP TABLE IF EXISTS "pages";
CREATE TABLE IF NOT EXISTS "pages" (
  "page_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "page" VARCHAR(60) NOT NULL,
  "content" TEXT,
  "params" TEXT,
  "cdate" DATETIME NOT NULL,
  "mdate" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX "title" ON "pages" ("page");

-- --------------------------------------------------------

--
-- Table structure for table "ushop_authors"
--

DROP TABLE IF EXISTS "ushop_authors";
CREATE TABLE IF NOT EXISTS "ushop_authors" (
  "author_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "forename" VARCHAR(100) NOT NULL,
  "surname" VARCHAR(100) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_counties"
--

DROP TABLE IF EXISTS "ushop_counties";
CREATE TABLE IF NOT EXISTS "ushop_counties" (
  "county_id" INTEGER(4) PRIMARY KEY NOT NULL,
  "country_id" INTEGER(4) NOT NULL DEFAULT '0',
  "county" VARCHAR(100) NOT NULL DEFAULT ''
);

--
-- Dumping data for table "ushop_counties"
--


-- --------------------------------------------------------

--
-- Table structure for table "ushop_countries"
--

DROP TABLE IF EXISTS "ushop_countries";
CREATE TABLE IF NOT EXISTS "ushop_countries" (
  "country_id" INTEGER(3) PRIMARY KEY NOT NULL,
  "post_zone_id" INTEGER(2) NOT NULL DEFAULT '0',
  "country" VARCHAR(100) UNIQUE NOT NULL DEFAULT ''
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_order_status"
--

DROP TABLE IF EXISTS "ushop_order_status";
CREATE TABLE IF NOT EXISTS "ushop_order_status" (
  "order_status_id" INTEGER(4) PRIMARY KEY NOT NULL,
  "order_status" VARCHAR(255) NOT NULL
);

--
-- Dumping data for table "ushop_order_status"
--

INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(1, 'Processing');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(2, 'Waiting for Payment');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(3, 'Dispatched');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(4, 'Cancelled');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(5, 'Pending');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(6, 'Paypal Payment Completed');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(7, 'Paypal Payment Pending');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(8, 'Cheque Payment Pending');
INSERT INTO "ushop_order_status" ("order_status_id", "order_status") VALUES(9, 'Cheque Payment Completed');

-- --------------------------------------------------------

--
-- Table structure for table "ushop_paypal_currency"
--

DROP TABLE IF EXISTS "ushop_paypal_currency";
CREATE TABLE IF NOT EXISTS "ushop_paypal_currency" (
  "currency_id" INTEGER(1) PRIMARY KEY NOT NULL,
  "currency" VARCHAR(45) NOT NULL DEFAULT '',
  "code" varchar(3) NOT NULL DEFAULT '',
  "mta" DECIMAL(9,2) NOT NULL DEFAULT '0.00'
);

--
-- Dumping data for table "ushop_paypal_currency"
--

INSERT INTO "ushop_paypal_currency" ("currency_id", "currency", "code", "mta") VALUES(1, 'Pounds Sterling', 'GBP', '5500.00');
INSERT INTO "ushop_paypal_currency" ("currency_id", "currency", "code", "mta") VALUES(2, 'U.S Dollars', 'USD', '10000.00');
INSERT INTO "ushop_paypal_currency" ("currency_id", "currency", "code", "mta") VALUES(3, 'Australian Dollars', 'AUD', '12500.00');
INSERT INTO "ushop_paypal_currency" ("currency_id", "currency", "code", "mta") VALUES(4, 'Canadian Dollars', 'CAD', '12500.00');
INSERT INTO "ushop_paypal_currency" ("currency_id", "currency", "code", "mta") VALUES(5, 'Euros', 'EUR', '8000.00');
INSERT INTO "ushop_paypal_currency" ("currency_id", "currency", "code", "mta") VALUES(6, 'Japanese Yen', 'JPY', '1000000.00');

-- --------------------------------------------------------

--
-- Table structure for table "ushop_post_costs"
--

DROP TABLE IF EXISTS "ushop_post_costs";
CREATE TABLE IF NOT EXISTS "ushop_post_costs" (
  "post_cost_id" INTEGER(2) PRIMARY KEY NOT NULL,
  "post_level_id" INTEGER(3) NOT NULL DEFAULT '0',
  "post_zone_id" INTEGER(3) NOT NULL DEFAULT '0',
  "cost" DECIMAL(6,2) NOT NULL DEFAULT '0.00',
  "vat_inc" INTEGER(1) NOT NULL DEFAULT '0'
);

CREATE INDEX "cost" ON "ushop_post_costs" ("cost");
CREATE INDEX "level" ON "ushop_post_costs" ("post_level_id");

-- --------------------------------------------------------

--
-- Table structure for table "ushop_post_levels"
--

DROP TABLE IF EXISTS "ushop_post_levels";
CREATE TABLE IF NOT EXISTS "ushop_post_levels" (
  "post_level_id" INTEGER(4) PRIMARY KEY NOT NULL,
  "post_level" DECIMAL(10,2) NOT NULL DEFAULT '0.00'
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_post_zones"
--

DROP TABLE IF EXISTS "ushop_post_zones";
CREATE TABLE IF NOT EXISTS "ushop_post_zones" (
  "post_zone_id" INTEGER(4) PRIMARY KEY NOT NULL,
  "tax_code_id" INTEGER(2) NOT NULL DEFAULT '0',
  "zone" VARCHAR(45) NOT NULL DEFAULT ''
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_price_groups"
--

DROP TABLE IF EXISTS "ushop_price_groups";
CREATE TABLE IF NOT EXISTS "ushop_price_groups" (
  "price_group_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "price_group" VARCHAR(5) UNIQUE DEFAULT '0',
  "price" DECIMAL(4,2) DEFAULT '0.00'
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_products"
--

DROP TABLE IF EXISTS "ushop_products";
CREATE TABLE IF NOT EXISTS "ushop_products" (
  "product_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "category_id" INTEGER(10) NOT NULL,
  "tax_code_id" INTEGER(10) NOT NULL,
  "price_group_id" INTEGER(10) NOT NULL DEFAULT '0',
  "author_id" INTEGER(10) NOT NULL,
  "sku" VARCHAR(255) UNIQUE NOT NULL,
  "isbn" VARCHAR(255) DEFAULT NULL,
  "name" VARCHAR(60) NOT NULL,
  "price" DECIMAL(6,2) NOT NULL DEFAULT '0.00',
  "weight" DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  "description" TEXT,
  "short_description" VARCHAR(100) DEFAULT NULL,
  "image" VARCHAR(255) DEFAULT NULL,
  "image_status" INTEGER(1) NOT NULL DEFAULT '1',
  "quantity" INTEGER(5) NOT NULL DEFAULT '0',
  "date_entered" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "enabled" INTEGER(1) NOT NULL DEFAULT '0',
  "vat_inc" INTEGER(1) NOT NULL DEFAULT '0',
  "postage" INTEGER(1) NOT NULL DEFAULT '1',
  "hits" INTEGER(10) NOT NULL DEFAULT '0',
  "discontinued" INTEGER(1) NOT NULL DEFAULT '0'
);

CREATE INDEX "isbn" ON "ushop_products" ("isbn");
CREATE INDEX "category_id" ON "ushop_products" ("category_id");
CREATE INDEX "tax_code_id" ON "ushop_products" ("tax_code_id");
CREATE INDEX "author_id" ON "ushop_products" ("author_id");

-- --------------------------------------------------------

--
-- Table structure for table "ushop_product_attributes"
--

DROP TABLE IF EXISTS "ushop_product_attributes";
CREATE TABLE IF NOT EXISTS "ushop_product_attributes" (
  "attribute_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "attribute" VARCHAR(255) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_product_attribute_list"
--

DROP TABLE IF EXISTS "ushop_product_attribute_list";
CREATE TABLE IF NOT EXISTS "ushop_product_attribute_list" (
  "attribute_list_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "product_id" INTEGER(10) NOT NULL,
  "attribute_id" INTEGER(10) NOT NULL,
  "property_id" INTEGER(10) NOT NULL,
  "price" VARCHAR(20) DEFAULT NULL,
  "image" VARCHAR(255) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_product_attribute_properties"
--

DROP TABLE IF EXISTS "ushop_product_attribute_properties";
CREATE TABLE IF NOT EXISTS "ushop_product_attribute_properties" (
  "property_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "property" varchar(255) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_product_categories"
--

DROP TABLE IF EXISTS "ushop_product_categories";
CREATE TABLE IF NOT EXISTS "ushop_product_categories" (
  "category_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "category" varchar(60) DEFAULT NULL,
  "lft" INTEGER(10) NOT NULL DEFAULT '0',
  "rgt" INTEGER(10) NOT NULL DEFAULT '0',
  "category_image" varchar(255) DEFAULT NULL,
  "category_image_status" INTEGER(1) NOT NULL DEFAULT '1'
);

CREATE INDEX "lft" ON "ushop_product_categories" ("lft");

-- --------------------------------------------------------

--
-- Table structure for table "ushop_product_custom_fields"
--

DROP TABLE IF EXISTS "ushop_product_custom_fields";
CREATE TABLE IF NOT EXISTS "ushop_product_custom_fields" (
  "custom_field_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "product_id" INTEGER(10) NOT NULL,
  "custom_field" VARCHAR(60) NOT NULL,
  "unique" INTEGER(1) NOT NULL DEFAULT '0'
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_product_names"
--

DROP TABLE IF EXISTS "ushop_product_names";
CREATE TABLE IF NOT EXISTS "ushop_product_names" (
  "name_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "name" varchar(255) NOT NULL,
  "description" MEDIUMTEXT
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_tax_codes"
--

DROP TABLE IF EXISTS "ushop_tax_codes";
CREATE TABLE IF NOT EXISTS "ushop_tax_codes" (
  "tax_code_id" INTEGER(1) PRIMARY KEY NOT NULL,
  "tax_rate_id" INTEGER(1) NOT NULL DEFAULT '0',
  "tax_code" VARCHAR(2) NOT NULL DEFAULT '',
  "description" VARCHAR(20) NOT NULL DEFAULT ''
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_tax_rates"
--

DROP TABLE IF EXISTS "ushop_tax_rates";
CREATE TABLE IF NOT EXISTS "ushop_tax_rates" (
  "tax_rate_id" INTEGER(1) PRIMARY KEY NOT NULL,
  "tax_rate" DECIMAL(4,3) NOT NULL DEFAULT '0.000'
);

COMMIT;

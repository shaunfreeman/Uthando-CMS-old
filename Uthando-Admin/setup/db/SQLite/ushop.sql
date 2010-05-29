BEGIN TRANSACTION;

--
-- Database: "ushop"
--

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

--
-- Table structure for table "ushop_shoppingcart"
--

DROP TABLE IF EXISTS "ushop_shoppingcart";
CREATE TABLE IF NOT EXISTS "ushop_shoppingcart" (
  "user_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "cart" TEXT
);

--
-- Table structure for table "ushop_orders"
--

DROP TABLE IF EXISTS "ushop_orders";
CREATE TABLE IF NOT EXISTS "ushop_orders" (
  "order_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "user_id" INTEGER(5) NOT NULL,
  "order_status_id" INTEGER(4) NOT NULL,
  "invoice" INTEGER(10) UNIQUE NOT NULL,
  "total" DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  "order_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "shipping" DECIMAL(4,2) NOT NULL DEFAULT '0.00',
  "tax" DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  "payment_method" VARCHAR(100) NOT NULL,
  "txn_id" VARCHAR(19) DEFAULT NULL
);

CREATE INDEX "customer_id" ON "ushop_orders" ("user_id");
CREATE INDEX "order_date" ON "ushop_orders" ("order_date");

-- --------------------------------------------------------

--
-- Table structure for table "ushop_order_items"
--

DROP TABLE IF EXISTS "ushop_order_items";
CREATE TABLE IF NOT EXISTS "ushop_order_items" (
  "order_item_id" INTEGER(5) PRIMARY KEY NOT NULL,
  "user_id" INTEGER(10) NOT NULL,
  "order_id" INTEGER(5) NOT NULL,
  "product_id" INTEGER(5) NOT NULL,
  "quantity" INTEGER(5) NOT NULL,
  "item_price" DECIMAL(10,2) NOT NULL,
  "tax" DECIMAL(10,2) NOT NULL DEFAULT '0.00'
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_user_cda"
--

DROP TABLE IF EXISTS "ushop_user_cda";
CREATE TABLE IF NOT EXISTS "ushop_user_cda" (
  "user_cda_id" INTEGER(5) PRIMARY KEY NOT NULL,
  "user_info_id" INTEGER(5) NOT NULL DEFAULT '0',
  "country_id" INTEGER(2) NOT NULL DEFAULT '0',
  "address1" VARCHAR(45) NOT NULL DEFAULT '',
  "address2" VARCHAR(45) DEFAULT NULL,
  "address3" VARCHAR(60) DEFAULT NULL,
  "city" VARCHAR(45) NOT NULL DEFAULT '',
  "county" VARCHAR(45) NOT NULL DEFAULT '',
  "phone" VARCHAR(15) NOT NULL DEFAULT '0',
  "post_code" VARCHAR(45) NOT NULL DEFAULT ''
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_user_info"
--

DROP TABLE IF EXISTS "ushop_user_info";
CREATE TABLE IF NOT EXISTS "ushop_user_info" (
  "user_info_id" INTEGER(5) PRIMARY KEY NOT NULL,
  "user_id" INTEGER(255) NOT NULL,
  "prefix_id" INTEGER(1) DEFAULT '0',
  "country_id" INTEGER(2) DEFAULT '0',
  "user_cda_id" INTEGER(5) DEFAULT '0',
  "address1" VARCHAR(80) DEFAULT NULL,
  "address2" VARCHAR(80) DEFAULT NULL,
  "address3" VARCHAR(60) DEFAULT NULL,
  "city" VARCHAR(40) DEFAULT NULL,
  "county" VARCHAR(40) DEFAULT NULL,
  "post_code" VARCHAR(10) DEFAULT NULL,
  "phone" VARCHAR(20) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_user_prefix"
--

DROP TABLE IF EXISTS "ushop_user_prefix";
CREATE TABLE IF NOT EXISTS "ushop_user_prefix" (
  "prefix_id" INTEGER(1) PRIMARY KEY NOT NULL,
  "prefix" VARCHAR(5) NOT NULL DEFAULT ''
);

--
-- Dumping data for table "ushop_user_prefix"
--

INSERT INTO "ushop_user_prefix" ("prefix_id", "prefix") VALUES(1, 'Mr.');
INSERT INTO "ushop_user_prefix" ("prefix_id", "prefix") VALUES(2, 'Mrs.');
INSERT INTO "ushop_user_prefix" ("prefix_id", "prefix") VALUES(3, 'Ms.');
INSERT INTO "ushop_user_prefix" ("prefix_id", "prefix") VALUES(4, 'Miss.');
INSERT INTO "ushop_user_prefix" ("prefix_id", "prefix") VALUES(5, 'Dr.');

-- --------------------------------------------------------

COMMIT;
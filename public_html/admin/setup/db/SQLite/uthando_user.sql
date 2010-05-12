BEGIN TRANSACTION;

--
-- Database: "uthando_users"
--

-- --------------------------------------------------------

--
-- Table structure for table "users"
--

DROP TABLE IF EXISTS "users";
CREATE TABLE IF NOT EXISTS "users" (
  "user_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "user_group_id" INTEGER(10) NOT NULL DEFAULT '4',
  "email_type_id" INTEGER(10) NOT NULL DEFAULT '1',
  "first_name" VARCHAR(60) NOT NULL,
  "last_name" VARCHAR(60) NOT NULL,
  "username" VARCHAR(255) UNIQUE DEFAULT NULL,
  "email" VARCHAR(255) NOT NULL,
  "password" VARCHAR(40) NOT NULL,
  "iv" VARCHAR(255) NOT NULL,
  "cdate" DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  "mdate" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "activation" INTEGER(1) NOT NULL DEFAULT '1',
  "block" INTEGER(1) NOT NULL DEFAULT '0'
);

CREATE INDEX "name" ON "users" ("first_name","last_name");

-- --------------------------------------------------------

--
-- Table structure for table "user_groups"
--

DROP TABLE IF EXISTS "user_groups";
CREATE TABLE IF NOT EXISTS "user_groups" (
  "user_group_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "user_group" varchar(50) UNIQUE NOT NULL
);

-- --------------------------------------------------------

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

COMMIT;
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

COMMIT;
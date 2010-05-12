BEGIN TRANSACTION;

--
-- Database: "uthando_sessions"
--

-- --------------------------------------------------------

--
-- Table structure for table "sessions"
--

DROP TABLE IF EXISTS "sessions";
CREATE TABLE IF NOT EXISTS "sessions" (
  "session" varchar(255) PRIMARY KEY NOT NULL,
  "session_expires" INTEGER(10) NOT NULL DEFAULT '0',
  "session_data" MEDIUMTEXT
);

-- --------------------------------------------------------

--
-- Table structure for table "ushop_shoppingcart"
--

DROP TABLE IF EXISTS "ushop_shoppingcart";
CREATE TABLE IF NOT EXISTS "ushop_shoppingcart" (
  "user_id" INTEGER(10) PRIMARY KEY NOT NULL,
  "cart" TEXT
);

COMMIT;
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
  "session" VARCHAR(255) PRIMARY KEY NOT NULL,
  "session_expires" INTEGER(10) NOT NULL DEFAULT '0',
  "session_data" MEDIUMTEXT
);

-- --------------------------------------------------------

COMMIT;
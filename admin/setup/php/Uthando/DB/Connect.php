<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class DB_Connect
{
	private static $instance = null;

	private function __construct() {}

	private function __clone() {}
	
	public static function getInstance($dsn=null, $username=null, $password=null)
	{
		if (!self::$instance instanceof PDO):
			self::$instance = new PDO("$dsn", $username, $password);
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		endif;
		return self::$instance;
	}
}

?>
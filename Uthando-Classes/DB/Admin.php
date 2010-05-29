<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class DB_Admin extends DB_Core
{
	public function __construct($registry)
	{
		$this->registry = $registry;
		
		$dsn = $this->registry->get ('admin_config.database');
		$this->dsn = $dsn['phptype'] . ":host=" . $dsn['hostspec'] . ";dbname=" .$dsn['admin'];
		$this->username = $dsn['username'];
		$this->password = $dsn['password'];
		$this->conn();
	}
}
?>
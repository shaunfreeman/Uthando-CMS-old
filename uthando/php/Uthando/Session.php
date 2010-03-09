<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Session {
	// session-lifetime
	private $lifeTime = 86400; // expires in 1 day 60*60*24;
	private $conn;
	private $database;
	private $dsn;
	private $password;
	private $username;
	private $db;
	
	function __construct($registry)
	{
		$dsn = array(
			'hostspec' => $registry->get('config.database.hostspec'),
			'phptype' => $registry->get('config.database.phptype'),
			'database' => $registry->get('config.database.session')
		);
		
		$dsn = array_merge($dsn,$registry->get('config.database_guest'));
		
		$this->dsn = $dsn['phptype'] . ":host=" . $dsn['hostspec'] . ";dbname=" .$dsn['database'];
		
		$this->username = $dsn['username'];
		$this->password = $dsn['password'];
		
		$this->conn = new PDO($this->dsn, $this->username, $this->password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		ini_set ('session.session_cookie', $this->lifeTime);
		ini_set ('session.gc_maxlifetime', $this->lifeTime);
		ini_set ('session.gc_probability', 100);
		// get session-lifetime
		$this->lifeTime = ini_get("session.gc_maxlifetime");
		session_set_save_handler(
			array(&$this, 'open'),
			array(&$this, 'close'),
			array(&$this, 'read'),
			array(&$this, 'write'),
			array(&$this, 'destroy'),
			array(&$this, 'gc')
		);
		register_shutdown_function('session_write_close');
		
		if ($registry->sessionId) session_id($registry->sessionId);
		
		session_start();

		return true;
	}
	
	public function open($savePath, $sessName)
	{
		// get session-lifetime
		$this->lifeTime = ini_get("session.gc_maxlifetime");
		return true;
	}
	
	public function close()
	{
		$this->gc(ini_get('session.gc_maxlifetime'));
		// close database-connection
		return $this->conn = null;
	}
	
	public function read($sessID)
	{
		// fetch session-data
		$sql = "
			SELECT session_data
			FROM sessions
			WHERE session = :id
			AND session_expires > :time
		";
		
		$stmt = $this->conn->prepare($sql);
		$stmt->execute(array(':id' => $sessID, ':time' => time()));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['session_data'];
	}
	
	public function write($sessID,$sessData)
	{
		// new session-expire-time
		$newExp = time() + $this->lifeTime;
		// is a session with this id in the database?
		
		$sql = "
			REPLACE INTO ".$this->database.".sessions (
				session,
				session_expires,
				session_data)
			VALUES (
				'$sessID',
				'$newExp',
				'$sessData')
		";
		
		$result = $this->conn->exec($sql);
		
		// if something happened, return true
		if (!$result) {
			return false;
		} else {
			// ...else return true
			return true;
		}
	}
	
	public function destroy($sessID)
	{
		// delete session-data
		$query = "
			DELETE FROM ".$this->database.".sessions
			WHERE session = '$sessID'
		";
		$result = $this->conn->exec($query);
		// if session was not deleted, return false,
 		if (!$result) {
			return false;
 		} else {
			// ...else return true
			return true;
		}
	}
	
	public function gc($sessMaxLifeTime)
	{
		// delete old sessions
		$query = "
			DELETE FROM ".$this->database.".sessions
			WHERE session_expires <
		".time();
		$result = $this->conn->exec($query);
		// return affected rows
		return $result;
	}
}
?>
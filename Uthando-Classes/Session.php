<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Session {
	// session-lifetime
	private $lifeTime = 1200; // expires in 20 minutes 20*60;
	private $conn;
	private $table;
	
	function __construct($registry)
	{	
		$dsn =  $registry->get('config.database.phptype') . ":host=" . $registry->get('config.database.hostspec') . ";dbname=" . $registry->get('config.database.session');
		
		$this->conn = new PDO($dsn, $registry->get('config.database_guest.username'), $registry->get('config.database_guest.password'));
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$this->table = $registry->get('settings.dir');
		
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
			FROM ".$this->table."
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
			REPLACE INTO ".$this->table." (
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
			DELETE FROM ".$this->table."
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
			DELETE FROM ".$this->table."
			WHERE session_expires <
		".time();
		$result = $this->conn->exec($query);
		// return affected rows
		return $result;
	}
}
?>
<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class DB_Core
{
	public $db;
	protected $registry;

	public function __construct($registry)
	{
		$dsn = array(
			'hostspec' => $registry->get('config.datase.hostspec'),
			'phptype' => $registry->get('config.database.phptype'),
			'database' => $registry->get('config.database.core')
		);

		if ($registry->loggedInUser):
			$dsn = array_merge($dsn,$registry->get('config.database_user'));
		else:
			$dsn = array_merge($dsn,$registry->get('config.database_guest'));
		endif;
		
		$this->dsn = $dsn['phptype'] . ":host=" . $dsn['hostspec'] . ";dbname=" .$dsn['database'];
		
		$this->username = $dsn['username'];
		$this->password = $dsn['password'];
		$this->conn();
	}
	
	public function __set($name, $value)
	{
		switch($name):
			case 'username':
				$this->username = $value;
				break;
				
			case 'password':
				$this->password = $value;
				break;
			
			case 'dsn':
				$this->dsn = $value;
				break;
			
			default:
				throw new Exception("$name is invalid");
		endswitch;
	}

	public function __isset($name)
	{
		switch($name):
			case 'username':
				$this->username = null;
				break;
			
			case 'password':
				$this->password = null;
				break;
		endswitch;
	}

	protected function conn()
	{
		isset($this->username);
		isset($this->password);
		if (!$this->db instanceof PDO)
		{
			$this->db = DB_Connect::getInstance($this->dsn, $this->username, $this->password);
		}
	}

	public function getConn()
	{
		return $this->db;
	}

	public function query($sql, $bind=null)
	{
		$stmt = $this->db->prepare($sql);
		if (!is_null($bind)):
			foreach ($bind as $key => $value):
				$stmt->bindParam($key,$value);
			endforeach;
		endif;
		//print_rr($stmt);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_OBJ)) $obj[] = $row;
		return $obj;
	}

	public function exec($sql)
	{
		//$stmt = $this->db->prepare($sql);
		return $this->db->exec($sql);
	}

	public function getRow($sql, $bind=null)
	{
		$stmt = $this->db->prepare($sql);
		if (!is_null($bind)):
			foreach ($bind as $key => $value):
				$stmt->bindParam($key,$value);
			endforeach;
		endif;
		//print_rr($stmt);
		$stmt->execute();
		$obj = $stmt->fetch(PDO::FETCH_OBJ);
		return $obj;
	}

	public function escape($data)
	{
		return addslashes($data);
	}

	// sql functions.
	protected function execQuery($query, $iud=true, $array_mode=true)
	{
		if ($iud):
			$result = $this->exec($query);
		else:
			$result = $this->query($query);
		endif;
		
		if ($iud):
			return $result;
		else:
			if (count($result) > 0):
				foreach ($result as $row) $return_rows[] = $row;
				if (count($return_rows) == 1 && !$array_mode) $return_rows = $return_rows[0];
				return $return_rows;
			else:
				return false;
			endif;
		endif;
	}
	
	public function remove($table, $where)
	{
		$sql = "
			DELETE FROM $table
			WHERE $where
		";
		return $this->execQuery($sql);
	}
	
	public function update($update, $table, $filter, $quote=true)
	{
		$set = null;
		
		foreach ($update as $col => $val):
			if ($quote) if ($val != 'NULL') $val = "'".$val."'";
			$set .= $col . " = " . $val . ",";
		endforeach;
		
		$sql = "
			UPDATE $table
			SET ".substr($set,0,-1)."
			".$this->filter($filter)."
		";
		
		return $this->execQuery($sql);
		
	}
	
	public function insert($insert, $table, $quote=true)
	{
		foreach ($insert as $col => $val):
			//$val = escape_db_data($val);
			if ($quote) if ($val != 'NULL') $val = "'".$val."'";
			$insert[$col] = $val;
		endforeach;
		
		$set = implode(',', array_keys($insert));
		$values = implode(',', array_values($insert));
		
		$sql = "
			INSERT INTO $table ($set)
			VALUES ($values)
		";
		
		return $this->execQuery($sql);
		
	}
	
	protected function joinTable($join)
	{
		if (is_array($join)):
			$j = null;
			foreach ($join as $table) $j .= "NATURAL JOIN ".$table."\n";
			$join = $j;
		elseif ($join):
			$join = "NATURAL JOIN ".$join;
		else:
			$join = null;
		endif;
		return $join;
	}
	
	protected function filter($filter)
	{
		if (is_array($filter)):
			$f = null;
			foreach ($filter as $key => $value):
				if (is_array($value)):
					foreach ($value as $val) $f .= strtoupper($key).' '.$val."\n";
				else:
					$f .= strtoupper($key).' '.$value."\n";
				endif;
			endforeach;
			$filter = $f;
		else:
			$filter = null;
		endif;
		return $filter;
	}
	
	public function getResult($values, $table, $join=null, $filter=null, $array_mode=true)
	{
		$sql = "
			SELECT $values
			FROM $table
			".$this->joinTable($join)."
			".$this->filter($filter)."
		";
		//print_rr($sql);
		return $this->execQuery($sql, false, $array_mode);
	}
	
	// method todo.
	public function getOne($value, $table, $join=null, $filter=null)
	{
		$res = $this->getResult($value, $table, $join=null, $filter=null, $array_mode=true);
		
		return $res;
	}

	public function lastInsertID()
	{
		return $this->db->lastInsertId();
	}
}

?>
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

Class Admin_Registry extends Registry {
	
	public function registerPath() {

		$br = new Browser();

		switch ($br->Name) {
			case 'Firefox':
			case 'Mozilla':
			case 'Safari':
			case 'Opera':
				$browser = true;
				break;
			default:
				$browser = false;
				break;
		}
		
		if (!$browser) {
			goto('/index2.php');
		}
		
		if ($this->path == '/index.php' || $this->path == '/') {
			$this->component = 'admin';
			$this->action = 'default';
		} else {
			$path = split("/",substr($this->path,1));
			$path[1] = split("\.", $path[1]);
			
			$this->component = $path[0];
			$this->action = $path[1][0];
			
			if (!$this->action) $this->action = "default";
			
			unset($path[0],$path[1]);
			
			foreach ($path as $value) {
				$value = split("-",$value);
				
				if (!is_numeric($value[0]) && count($value) == 2) {
					$params[$value[0]] = $value[1];
				} elseif (count($value) == 1) {
					$params[] = $value[0];
				} else {
					$this->Error("Too many page parameters", $this->path);
				}
			}
			
			if (isset($params)) $this->params = $params;
			
		}
	}
	
}
?>
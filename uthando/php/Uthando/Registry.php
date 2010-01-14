<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

Class Registry {
	
	private $vars = array();
	public  $errors = null;
	
	public function __construct() {
		
		$this->path = urldecode($_SERVER['REQUEST_URI']);
		$this->registerPath();
	}
	
	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}
	
	public function __get($index) {
		return $this->vars[$index];
	}
	
	public function registerPath() {
		
		if ($this->path == '/index.php' || $this->path == '/') {
			$this->component = 'content';
			$this->action = 'default';
		} else {
			$path = split("/",substr($this->path,1));
			$path[1] = split("\.", $path[1]);
			
			$this->component = $path[0];
			$this->action = split('#', $path[1][0]);
			$this->action = $this->action[0];
			
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
			
			if ($params) $this->params = $params;
		}
	}
	
	public function Ok($error, $debug=NULL) {
		
		if (isset ($debug)) {
			$this->errors .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/Common/images/OKShield.png\" /> " . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p></span>\n";
		} else {
			$this->errors .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/Common/images/OKShield.png\" /> " . $error . "</p></span>";
		}
	}
	
	public function Warning($error, $debug=NULL) {
		
		if (isset ($debug)) {
			$this->errors .= "<span class=\"smcap\"><p class=\"info\"><img src=\"/Common/images/WarningShield.png\" /> " . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p></span>\n";
		} else {
			$this->errors .= "<span class=\"smcap\"><p class=\"info\"><img src=\"/Common/images/WarningShield.png\" /> " . $error . "</p></span>";
		}
	}
	
	public function Error($error, $debug=NULL) {
		
		if (isset ($debug)) {
			$this->errors .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/Common/images/ErrorShield.png\" /> " . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p></span>\n";
		} else {
			$this->errors .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/Common/images/ErrorShield.png\" /> " . $error . "</p></span>";
		}
	}
}
?>
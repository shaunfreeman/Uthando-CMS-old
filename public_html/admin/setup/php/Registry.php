<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

Class Registry {
	
	protected $vars = array();
	public  $errors = null;
	
	public function __construct()
	{
		$this->path = urldecode($_SERVER['REQUEST_URI']);
		$this->registerPath();
		$this->registerServer();
		
		$pos = strpos($this->server, '.') + 1;
		$server = substr($this->server, $pos);
		
		$this->config = array('server' => array('web_url' => 'http://'.$server));
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
	
	public function get($key=null)
	{
		$key = explode('.', $key);
		switch(count($key)):
			case 3: $value = $this->{$key[0]}[$key[1]][$key[2]]; break;
			case 2: $value = $this->{$key[0]}[$key[1]]; break;
			case 1: $value = $this->{$key[0]}; break;
			default: $value = false;
		endswitch;
		return ($value===false) ? null : $value;
	}
	
	protected function registerServer()
	{
		$this->server = (substr($_SERVER['SERVER_NAME'], 0, 3) == 'www') ? substr($_SERVER['SERVER_NAME'], 4) : $this->server = $_SERVER['SERVER_NAME'];
	}
	
	public function loadIniFiles($files)
	{
		foreach ($files as $section => $file):
			$this->loadIniFile($file, $section);
		endforeach;
	}
	
	public function loadIniFile($file, $section)
	{
		$this->$section = parse_ini_file($this->ini_dir.'/'.$file.'.ini.php', true);
	}
	
	public function registerPath()
	{
		if ($this->path == '/index.php' || $this->path == '/') {
			$this->component = 'setup';
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
	
	public function Ok($error, $debug=null)
	{
		if (isset ($debug)):
			$this->errors .= "<p class=\"pass\">" . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p>";
		else:
			$this->errors .= "<p class=\"pass\">" . $error . "</p>";
		endif;
	}
	
	public function Warning($error, $debug=null)
	{
		if (isset ($debug)):
			$this->errors .= "<p class=\"info\">" . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p>\n";
		else:
			$this->errors .= "<p class=\"info\">" . $error . "</p>";
		endif;
	}
	
	public function Error($error, $debug=null)
	{
		if (isset ($debug)):
			$this->errors .= "<p class=\"fail\">" . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p>";
		else:
			$this->errors .= "<p class=\"fail\">" . $error . "</p>";
		endif;
	}
}
?>
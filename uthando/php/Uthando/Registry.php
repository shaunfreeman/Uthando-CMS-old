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
			case 3:
				$value = $this->{$key[0]}[$key[1]][$key[2]];
				break;
			case 2:
				$value = $this->{$key[0]}[$key[1]];
				break;
			case 1:
				$value = $this->{$key[0]};
				break;
			default:
				$value = false;
		endswitch;
		return ($value===false) ? null : $value;
	}
	
	protected function registerServer()
	{
		$this->server = (substr($_SERVER['SERVER_NAME'], 0, 3) == 'www') ? substr($_SERVER['SERVER_NAME'], 0, 4) : $this->server = $_SERVER['SERVER_NAME'];
	}
	
	public function setSite($file)
	{
		$settings = parse_ini_file($file, true);
		$this->settings = $settings[$this->server];
		if (!$this->settings) goto('/index3.php');
		$this->ini_dir = realpath(__SITE_PATH.'/../uthando/ini/'.$this->settings['resolve']);
	}
	
	public function loadIniFiles($files)
	{
		foreach ($files as $section => $file):
			$this->loadIniFile($file, $section);
		endforeach;
	}
	
	public function setDefaults()
	{
		$this->host = (isset($_SERVER['HTTPS'])) ? $this->config['server']['ssl_url'] : $this->config['server']['web_url'];
		$this->db_default = $this->config['database']['core'].'.';
		$this->core = $this->config['database']['core'].'.';
		$this->user = $this->config['database']['user'].'.';
		$this->sessions = $this->config['database']['session'].'.';
		date_default_timezone_set($this->config['server']['timezone']);
	}
	
	public function loadIniFile($file, $section)
	{
		$this->$section = parse_ini_file($this->ini_dir.'/'.$file.'.ini.php', true);
	}
	
	public function registerPath()
	{
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
	
	public function Ok($error, $debug=null)
	{
		if (isset ($debug)):
			$this->errors .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/Common/images/OKShield.png\" /> " . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p></span>\n";
		else:
			$this->errors .= "<span class=\"smcap\"><p class=\"pass\"><img src=\"/Common/images/OKShield.png\" /> " . $error . "</p></span>";
		endif;
	}
	
	public function Warning($error, $debug=null)
	{
		if (isset ($debug)):
			$this->errors .= "<span class=\"smcap\"><p class=\"info\"><img src=\"/Common/images/WarningShield.png\" /> " . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p></span>\n";
		else:
			$this->errors .= "<span class=\"smcap\"><p class=\"info\"><img src=\"/Common/images/WarningShield.png\" /> " . $error . "</p></span>";
		endif;
	}
	
	public function Error($error, $debug=null)
	{
		if (isset ($debug)):
			$this->errors .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/Common/images/ErrorShield.png\" /> " . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p></span>\n";
		else:
			$this->errors .= "<span class=\"smcap\"><p class=\"fail\"><img src=\"/Common/images/ErrorShield.png\" /> " . $error . "</p></span>";
		endif;
	}
}
?>
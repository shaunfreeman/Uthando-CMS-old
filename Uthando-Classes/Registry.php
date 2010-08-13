<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

Class Registry {
	
	protected $vars = array();
	public  $errors = null;
	
	public function __construct($path=null)
	{
		$this->path = ($path) ? urldecode($path) : urldecode(REQUEST_URI);
		$this->registerServer();
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		if (array_key_exists($index, $this->vars)) return $this->vars[$index];
        return null;
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
	
	public function setSite($file)
	{
		$settings = parse_ini_file($file, true);
		$this->settings = $settings[$this->server];
		/*foreach ($settings['general'] as $key => $value):
			$this->$key = $value;
		endforeach;*/
		if (!$this->settings) Uthando::go('/index3.php');
		$this->ini_dir = BASE.DS.'Uthando-ini'.DS.$this->server;
	}
	
	public function loadIniFiles($files)
	{
		foreach ($files as $section => $file):
			$this->loadIniFile($file, $section);
		endforeach;
	}
	
	public function setDefaults()
	{
		$this->host = $this->get('config.server.web_url');
		$this->db_default = $this->get('config.database.core').'.';
		$this->core = $this->get('config.database.core').'.';
		$this->user = $this->get('config.database.user').'.';
		$this->sessions = $this->get('config.database.session').'.';
		date_default_timezone_set($this->get('config.server.timezone'));
		$this->registerPath();
	}
	
	public function loadIniFile($file, $section)
	{
		$this->$section = parse_ini_file($this->ini_dir.DS.$file.'.ini'.EXT, true);
	}
	
	public function registerPath()
	{
		if ($this->path == '/index.php' || $this->path == '/') {
			$this->path = $this->get('config.site.default_page');
			$this->registerPath();
		} else {
			$path = explode('/',substr($this->path,1));
			$path[1] = explode("\.", $path[1]);
			
			$this->component = $path[0];
			$this->action = explode('#', $path[1][0]);
			$this->action = $this->action[0];
			
			unset($path[0],$path[1]);
			
			foreach ($path as $value) {
				$value = explode("-",$value);
				
				if (!is_numeric($value[0]) && count($value) == 2) {
					$params[$value[0]] = $value[1];
				} elseif (count($value) == 1) {
					$params[] = $value[0];
				} else {
					$this->Error("Too many page parameters", $this->path);
				}
			}
			
			$this->params = (isset($params)) ? $params : null;
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
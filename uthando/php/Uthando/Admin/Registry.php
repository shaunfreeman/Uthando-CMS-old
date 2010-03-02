<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

Class Admin_Registry extends Registry
{
	protected function registerServer()
	{
		$pos = strpos($_SERVER['SERVER_NAME'], '.') + 1;
		$this->server = substr($_SERVER['SERVER_NAME'], $pos);
	}
	
	public function setSite($file)
	{
		$settings = parse_ini_file($file, true);
		$this->settings = $settings[$this->server];
		if (!$this->settings) goto('/index3.php');
		
		$this->ini_dir = dirname($file).'/'.$this->settings['resolve'];
	}
	
	public function setDefaults()
	{
		$this->host = $this->admin_config['server']['admin_url'];
		$this->db_default = $this->admin_config['database']['admin'].'.';
		$this->core = $this->config['database']['core'].'.';
		$this->user = $this->config['database']['user'].'.';
		$this->sessions = $this->config['database']['session'].'.';
		if ($_SERVER['DOCUMENT_ROOT'] == __SITE_PATH):
			$this->admin_dir = null;
		else:
			$admin_path = split("/", __SITE_PATH);
			$this->admin_dir = '/'.$admin_path[count($admin_path) - 1];
		endif;
	}
	
	public function registerPath()
	{
		$br = new Browser();
		
		switch ($br->Name):
			case 'Firefox':
			case 'Mozilla':
			case 'Safari':
			case 'Opera':
				$browser = true;
				break;
			default:
				$browser = false;
				break;
		endswitch;
		
		if (!$browser) goto('/index2.php');
		
		if ($this->path == '/index.php' || $this->path == '/'):
			$this->component = 'admin';
			$this->action = 'default';
		else:
			$path = split("/",substr($this->path,1));
			$path[1] = split("\.", $path[1]);
			
			$this->component = $path[0];
			$this->action = $path[1][0];
			
			if (!$this->action) $this->action = "default";
			
			unset($path[0],$path[1]);
			
			foreach ($path as $value):
				$value = split("-",$value);
				
				if (!is_numeric($value[0]) && count($value) == 2):
					$params[$value[0]] = $value[1];
				elseif (count($value) == 1):
					$params[] = $value[0];
				else:
					$this->Error("Too many page parameters", $this->path);
				endif;
			endforeach;
			
			if (isset($params)) $this->params = $params;
			
		endif;
	}
	
}
?>
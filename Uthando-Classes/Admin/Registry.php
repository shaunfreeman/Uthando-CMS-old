<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

Class Admin_Registry extends Registry
{
	public function __construct($ajax=false)
	{
		if ($ajax):
			$this->path = urldecode($_SERVER['REQUEST_URI']);
			$this->registerServer();
		else:
			parent::__construct();
		endif;
	}
	
	protected function registerServer()
	{
		$pos = strpos($_SERVER['SERVER_NAME'], '.') + 1;
		$this->server = substr($_SERVER['SERVER_NAME'], $pos);
	}
	
	public function setSite($file)
	{
		$settings = parse_ini_file($file, true);
		$this->settings = $settings[$this->server];
		/*
		foreach ($settings['general'] as $key => $value):
			$this->$key = $value;
		endforeach;
		*/
		if (!$this->settings) Uthando::go('/index3.php');
		$this->ini_dir = BASE.DS.'Uthando-ini'.DS.$this->get('settings.resolve');
	}
	
	public function setDefaults($ajax=false)
	{
		$this->host = $this->admin_config['server']['admin_url'];
		$this->db_default = $this->admin_config['database']['admin'].'.';
		$this->core = $this->config['database']['core'].'.';
		$this->user = $this->config['database']['user'].'.';
		$this->sessions = $this->config['database']['session'].'.';
		
		$this->admin_dir = $_SERVER['DOCUMENT_ROOT'];
		if (!$ajax) $this->registerPath();
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
		
		if (!$browser) Uthando::go('/index2.php');
		
		if ($this->path == '/index.php' || $this->path == '/'):
			$this->path = $this->get('admin_config.site.default_page');
			parent::registerPath();
		else:
			parent::registerPath();
		endif;
	}
	
}
?>
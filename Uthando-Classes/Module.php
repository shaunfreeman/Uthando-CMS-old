<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Module
{
	public $module = null;
	public $title = null;
	public $moduleclass_sfx = null;
	public $params;
	protected $registry;
	
	public function __construct($registry)
	{
		$this->registry = $registry;
		//parent::__construct();
	}
	
	function makeModule($params)
	{
		$this->params = $params;
		$log_in = $this->getParams($params->params);
		
		switch($log_in['log_in']):
			case 1:
				if (UthandoUser::authorize()) $return_mod = true;
				break;
				
			case 0:
				$return_mod = true;
				break;
		endswitch;
		
		$this->module = null;
		
		if ($return_mod):

			$this->getModuleHeader();
			$this->getModuleTitle($this->params->module);
		
			if ($this->params->show_title == 1):
				$this->module_wrap->appendChild($this->title);
			endif;
			
			$this->module = $this->getModule($params->module_name, $this->getParams($params->params));
			
			//$this->appendChild($this->module_wrap);
			
			//return $this->toHTML();
			return $this->module_wrap;
  		endif;
	}
	
	function getParams($params)
	{
		
		$params = explode("\r\n", $params);
		
		foreach ($params as $value):
			$value = explode("=", $value);	
			$new_params[$value[0]] = $value[1];
		endforeach;
		
		return $new_params;
	}
	
	function getModule($mod, $params)
	{
		include ($mod.'/index.php');
	}
	
	function getModuleHeader()
	{
		$this->module_wrap = $this->registry->template->doc->createElement('div');
		$this->module_wrap->setAttribute('class', 'moduletable'.$this->moduleclass_sfx);
	}
	
	function getModuleTitle($title)
	{
		$this->title = $this->registry->template->doc->createElement('h3');
		$this->title->appendChild($this->registry->template->doc->createElement('span', $title));
	}
}

?>
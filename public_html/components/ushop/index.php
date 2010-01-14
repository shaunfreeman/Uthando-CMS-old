<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (is_readable($this->file."/action/".$this->registry->action.".php") == false || $this->registry->action == "index") {
	$this->registry->Error('404 Page NOT Found', $this->registry->path);
	$this->AddParameter ('PAGE',  'Page Not Found');
} else {

	$title = ucwords($this->registry->component) . " " . ucwords($this->registry->action);
	
	$this->registry->component_css = array('ushop_css' => '/components/ushop/css/ushop.css');
		
	require_once('action/'.$this->registry->action.'.php');
	
	$this->setTitle($title . ' | ' . $this->registry->config->get('site_name', 'SERVER'));
		
	$this->AddParameter ('PAGE',  $title);
}

?>
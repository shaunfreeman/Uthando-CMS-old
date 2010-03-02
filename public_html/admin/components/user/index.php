<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (is_readable($this->file."/action/".$this->registry->action.".php") == false || $this->registry->action == "index") {
	$this->registry->Error('404 Page NOT Found', $this->registry->path);
	$this->AddParameter ('PAGE',  'Page Not Found');
} else {

	$title = ucwords($this->registry->component) . " " . ucwords($this->registry->action);
	$this->registry->page_title = ucwords($this->registry->component);
	$this->registry->template->setTitle($title . ' | ' . $this->registry->get('config.server.site_name'));
		
	require_once('action/'.$this->registry->action.'.php');
	
	$this->registry->component_css = array('/components/user/css/user.css');
	
	$this->registry->template->AddParameter ('page',  $title);
}

?>
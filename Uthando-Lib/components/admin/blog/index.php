<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (is_readable($this->file."/action/".$this->registry->action.".php") == false || $this->registry->action == "index"):
		$this->registry->Error('404 Page NOT Found', $this->registry->path);
		$this->addParameter ('page',  'Page Not Found');
	else:

		$title = ucwords($this->registry->component) . " " . ucwords($this->registry->action);
		$this->registry->page_title = ucwords($this->registry->component);
		$this->setTitle($title . ' | ' . $this->get('config.server.site_name'));
		
		$this->addComponentCSS();
		
		require_once('action/'.$this->registry->action.'.php');
		
		$this->addParameter ('page',  $title);
	endif;
endif;
?>
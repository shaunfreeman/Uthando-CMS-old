<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (is_readable($this->file."/action/".$this->registry->action.".php") == false || $this->registry->action == "index"):
		$this->registry->Error('404 Page NOT Found', $this->registry->path);
		$this->addParameter ('page',  'Page Not Found');
	else:

		$title = ucwords($this->registry->component) . " " . ucwords($this->registry->action);
		$this->registry->page_title = ucwords($this->registry->component).'s';
		$this->setTitle($title . ' | ' . $this->get('config.server.site_name'));
		
		if ($this->upid == 1):
			$dirs = array('site' => $_SERVER['DOCUMENT_ROOT'].'/../templates/', 'administration' => $_SERVER['DOCUMENT_ROOT'].'/templates/');
			
			require_once('action/'.$this->registry->action.'.php');
		else:
			$menuBar['back'] = '/admin/overview';
			$params['CONTENT'] = $this->makeToolbar($menuBar, 24);
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = '<h2>You do not have permission to access this component.</h2>';
			$this->addContent($this->message($params));
		endif;
		
		$this->addParameter ('page',  $title);
		
		$this->registry->component_css = array('/components/template/css/'.$this->registry->component.'.css');
	endif;
endif;
?>
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array(
		'back' => '/admin/overview'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$session = Utility::encodeString(session_id());
	
	$this->addScriptDeclaration("UthandoAdmin.sid = ['" . $session[0] . "','" . $session[1] . "'];");
	
	$this->registry->component_js = array(
		'/components/media/js/filemanager.js'
	);

	$this->registry->component_css = array(
		'/templates/'.$this->get('admin_config.site.template').'/css/FileManager.css',
		'/templates/'.$this->get('admin_config.site.template').'/css/Additions.css'
	);
endif;
?>
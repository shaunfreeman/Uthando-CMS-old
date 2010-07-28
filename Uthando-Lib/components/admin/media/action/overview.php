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
	
	$this->addComponentJS();
	$this->addComponentCSS(array('FileManager','Additions'));
endif;
?>
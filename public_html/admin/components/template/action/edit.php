<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$opts = $this->registry->params;
	$opt = null;
	
	foreach ($opts as $key => $value) $opt .= $key.'-'.$value.'/';
	
	$opt = substr($opt,0,-1);
	
	$menuBar = array(
		'back' => '/template/overview',
		'cancel' => '/template/overview',
		'save' => null,
		'edit_html' => '/template/html/overview/'.$opt,
		'edit_css' => null,
		'edit_javascript' => null,
		'mootools' => null
	);
	
	$this->addContent($this->makeToolbar($menuBar, 24));
	
	if (isset($this->registry->params['action'])):
		$action = $this->registry->params['action'];
		require_once('template/html/'.$action.'.php');
	else:
		
	endif;
endif;
?>
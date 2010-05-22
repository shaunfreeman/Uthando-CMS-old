<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['action'])):
		$action = $this->registry->params['action'];
	else:
		$action = 'overview';
	endif;
	
	$title .= " : " . ucwords(str_replace('_', ' ',$action));
	
	if (isset($this->registry->params['attr'])) $title .= ' : ' . ucwords(str_replace('_', ' ', $this->registry->params['attr']));
	
	//$this->registry->component_js = array(
	//	'/components/ushop/js/customers.js'
	//);
	
	require_once('ushop/customers/'.$action.'.php');
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
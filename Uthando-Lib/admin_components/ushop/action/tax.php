<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	if (isset($this->registry->params['action'])) {
		$action = $this->registry->params['action'];
	} else {
		$action = 'overview';	
	}
	
	$title .= " : " . ucwords(str_replace('_', ' ',$action));
	
	require_once('ushop/tax/'.$action.'.php');
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
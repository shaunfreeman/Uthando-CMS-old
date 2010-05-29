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
	
	if (isset($this->registry->params['attr'])) $title .= ' : ' . ucwords(str_replace('_', ' ', $this->registry->params['attr']));
	
	require_once('ushop/products/'.$action.'.php');
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
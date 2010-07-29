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
	
	require_once('ushop/postage/'.$action.'.php');
endif;
?>
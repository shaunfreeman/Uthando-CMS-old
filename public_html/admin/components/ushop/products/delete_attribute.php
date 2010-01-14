<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	if (isset($this->registry->params['attr'])) {
		
		require_once ('ushop/products/attributes/delete_'.$this->registry->params['attr'].'.php');
		
	}
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	foreach ($ushop->ATTRIBUTES as $key => $value) {
		if ($value) require_once ('ushop/products/attributes/'.$key.'.php');
	}
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
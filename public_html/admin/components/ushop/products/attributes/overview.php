<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	foreach ($ushop->attributes as $key => $value):
		if ($value) require_once ('ushop/products/attributes/'.$key.'.php');
	endforeach;
	
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
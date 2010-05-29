<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['attr'])):
		require_once ('ushop/products/attributes/new_'.$this->registry->params['attr'].'.php');
	endif;
	
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
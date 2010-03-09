<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::authorize()):
	
	if ($this->registry->params['payment'] && $this->registry->params['callback']):
		define( 'SHOP_STAGE_3', 1 );
		require_once('ushop/checkout/payment/'.$this->registry->params['payment'].'.php');
	else:
		header("Location" . $this->get('config.server.web_url'));
		exit();
	endif;
		
else:
	header("Location" . $this->get('config.server.web_url'));
	exit();
endif;
?>
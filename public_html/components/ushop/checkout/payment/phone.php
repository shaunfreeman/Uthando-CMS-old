<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_STAGE_2' ) or die( 'Restricted access' );

if (UthandoUser::authorize()):
else:
	header("Location" . $this->registry->config->get('web_url', 'SERVER'));
	exit();
endif;
?>
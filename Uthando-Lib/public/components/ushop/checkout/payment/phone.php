<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_STAGE_2' ) or die( 'Restricted access' );

if (UthandoUser::authorize()):
else:
	header("Location" . $this->get('config.server.web_url'));
	exit();
endif;
?>
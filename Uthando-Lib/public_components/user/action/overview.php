<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::authorize()):

	$_SESSION['http_referer'] = '/user/change_details';

	$this->addContent('<p><a href="/user/change_details">Change your details</a></p>');
	
else:
	goto ('../../index.php');
endif;
?>
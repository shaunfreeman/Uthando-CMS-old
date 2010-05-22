<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$form->addElement('text', 'isbn', 'ISBN:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$form->addElement('html', '<fieldset id="admin_display" class="rightcol">');
	$form->addElement('header','admin_display_head','Admin Display');
	
	foreach ($ushop->admin_display as $key => $value):
		$form->addElement('text', 'admin_display['.$key.']', ucwords(str_replace('_', ' ', $key)).':', array('size' => 2, 'maxlength' => 2, 'class' => 'inputbox'));
	endforeach;
	
	$form->addElement('html', '</fieldset>');
	
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
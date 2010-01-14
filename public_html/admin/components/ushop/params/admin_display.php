<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$form->addElement('html', '<fieldset id="admin_display" class="rightcol">');
	$form->addElement('header','admin_display','Admin Display');
	
	foreach ($ushop->ADMIN_DISPLAY as $key => $value) {
		$form->addElement('text', 'ADMIN_DISPLAY['.$key.']', ucwords(str_replace('_', ' ', $key)).':', array('size' => 2, 'maxlength' => 2, 'class' => 'inputbox'));
	}
	
	$form->addElement('html', '</fieldset>');
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
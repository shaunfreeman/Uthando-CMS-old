<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$form->addElement('html', '<fieldset id="frontend_display" class="leftcol">');
	$form->addElement('header','frontend_display','Frontend Display');
	
	foreach ($ushop->FRONTEND_DISPLAY as $key => $value) {
		$form->addElement('text', 'FRONTEND_DISPLAY['.$key.']', ucwords(str_replace('_', ' ', $key)).':', array('size' => 2, 'maxlength' => 2, 'class' => 'inputbox'));
	}
	
	$form->addElement('html', '</fieldset>');
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
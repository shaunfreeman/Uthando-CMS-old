<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$form->addElement('html', '<fieldset id="frontend_display" class="leftcol">');
	$form->addElement('header','frontend_display_head','Frontend Display');
	
	foreach ($ushop->frontend_display as $key => $value):
		$form->addElement('text', 'frontend_display['.$key.']', ucwords(str_replace('_', ' ', $key)).':', array('size' => 2, 'maxlength' => 2, 'class' => 'inputbox'));
	endforeach;
	
	$form->addElement('html', '</fieldset>');	
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
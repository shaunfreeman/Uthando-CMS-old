<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$form->addElement('html', '<fieldset id="store" class="leftcol">');
	$form->addElement('header','store_head','Store');
	
	$form->addElement('text', 'store[address1]', 'Address 1:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	$form->addElement('text', 'store[address2]', 'Address 2:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'store[city]', 'Town/City:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'store[county]', 'County:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'store[postcode]', 'Post Code:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
	
	$form->addElement('text', 'store[country]', 'Country:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('html', '</fieldset>');
	
	$form->addElement('html', '<fieldset id="contact" class="rightcol">');
	$form->addElement('header','contact_head','Contact Information');
	
	$form->addElement('text', 'contact[title]', 'Title:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
	
	$form->addElement('text', 'contact[foremane]', 'Forename:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'contact[surname]', 'Surname:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'contact[phone]', 'Phone:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'contact[mobile]', 'Mobile:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'contact[fax]', 'Fax:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'contact[email]', 'Email:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));
	
	$form->addElement('html', '</fieldset>');
	$form->addElement('html', '<div class="both"></div>');
	
	$form->addElement('html', '<fieldset id="terms" class="leftcol">');
	$form->addElement('header','terms_head','Terms of Service');
	
	$form->addElement('textarea', 'information[terms]', null, array('class' => 'inputbox', 'cols' => 60, 'rows' => 5, 'id' => 'info_textarea'));
	
	$form->addElement('html', '</fieldset>');
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
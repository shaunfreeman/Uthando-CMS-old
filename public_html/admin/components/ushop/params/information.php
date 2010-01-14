<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$form->addElement('html', '<fieldset id="store" class="leftcol">');
	$form->addElement('header','store','Store');
	
	$form->addElement('text', 'STORE[address1]', 'Address 1:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	$form->addElement('text', 'STORE[address2]', 'Address 2:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'STORE[city]', 'Town/City:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'STORE[county]', 'County:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'STORE[postcode]', 'Post Code:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
	
	$form->addElement('text', 'STORE[country]', 'Country:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('html', '</fieldset>');
	
	$form->addElement('html', '<fieldset id="contact" class="rightcol">');
	$form->addElement('header','contact','Contact Information');
	
	$form->addElement('text', 'CONTACT[title]', 'Title:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
	
	$form->addElement('text', 'CONTACT[foremane]', 'Forename:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'CONTACT[surname]', 'Surname:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'CONTACT[phone]', 'Phone:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'CONTACT[mobile]', 'Mobile:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'CONTACT[fax]', 'Fax:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'CONTACT[email]', 'Email:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));
	
	$form->addElement('html', '</fieldset>');
	$form->addElement('html', '<div class="both"></div>');
	
	$form->addElement('html', '<fieldset id="terms" class="leftcol">');
	$form->addElement('header','terms','Terms of Service');
	
	$form->addElement('textarea', 'INFORMATION[terms]', null, array('class' => 'inputbox', 'cols' => 60, 'rows' => 5, 'id' => 'info_textarea'));
	
	$form->addElement('html', '</fieldset>');
	
} else {
	header("Location: " . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
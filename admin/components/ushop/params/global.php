<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$form->addElement('html', '<fieldset id="global" class="leftcol">');
	$form->addElement('header','global_head','Global');
	
	$ols[] = $form->createElement('radio', null, null, 'Yes', '1');
	$ols[] = $form->createElement('radio', null, null, 'No', '0');
	$form->addGroup($ols, 'global[offline]', 'Shop Offline:');
	
	$form->addElement('textarea', 'information[offline_message]', 'Offline Message:', array('class' => 'mceEditor', 'cols' => 60, 'rows' => 5, 'id' => 'offline_textarea'));
	//array('id' => 'content_textarea', 'class' => 'mceEditor')
	$form->addElement('advcheckbox', 'global[catelogue_mode]', 'Use only as catelogue:', 'if you check this, you disable all cart buttons and checkout.', array('id' => 'catelogue_mode'));
	
	$form->addElement('html', '</fieldset>');
	$form->addElement('html', '<div class="both"></div>');
	
	$form->addElement('html', '<fieldset id="checkout" class="leftcol">');
	$form->addElement('header','checkout_head','Checkout');
	
	$form->addElement('text', 'checkout[orders_email]', 'Orders Email:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));
	
	$ps[] = $form->createElement('radio', null, null, 'By Weight', '1');
	$ps[] = $form->createElement('radio', null, null, 'By Invoice Total', '0');
	$form->addGroup($ps, 'checkout[post_state]', 'Post State:');
	
	$stock_contro[] = $form->createElement('radio', null, null, 'On', '1');
	$stock_contro[] = $form->createElement('radio', null, null, 'Off', '0');
	$form->addGroup($stock_contro, 'checkout[stock_control]', 'Stock Control:');
	
	$vat_state[] = $form->createElement('radio', null, null, 'On', '1', array('id' => 'vat_on'));
	$vat_state[] = $form->createElement('radio', null, null, 'Off', '0', array('id' => 'vat_off'));
	$form->addGroup($vat_state, 'checkout[vat_state]', 'VAT State:');
	
	$form->addElement('text', 'checkout[vat_number]', 'VAT No:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox', 'id' => 'vat_no'));
	
	$pay_check[] = $form->createElement('radio', null, null, 'Yes', '1');
	$pay_check[] = $form->createElement('radio', null, null, 'No', '0');
	$form->addGroup($pay_check, 'checkout[pay_cheque]', 'Pay by Cheque:');
	
	$pay_credit_card[] = $form->createElement('radio', null, null, 'Yes', '1');
	$pay_credit_card[] = $form->createElement('radio', null, null, 'No', '0');
	$form->addGroup($pay_credit_card, 'checkout[pay_credit_card]', 'Pay by Credit Card:');
	
	$pay_phone[] = $form->createElement('radio', null, null, 'Yes', '1');
	$pay_phone[] = $form->createElement('radio', null, null, 'No', '0');
	$form->addGroup($pay_phone, 'checkout[pay_phone]', 'Pay by Phone:');
	
	$pay_paypal[] = $form->createElement('radio', null, null, 'Yes', '1', array('id' => 'paypal_y'));
	$pay_paypal[] = $form->createElement('radio', null, null, 'No', '0', array('id' => 'paypal_n'));
	$form->addGroup($pay_paypal, 'checkout[pay_paypal]', 'Pay by Paypal:');
	
	$form->addElement('html', '</fieldset>');
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
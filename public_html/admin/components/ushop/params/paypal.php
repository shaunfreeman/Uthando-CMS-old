<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$form->addElement('html', '<fieldset id="paypal" class="rightcol">');
	$form->addElement('header','paypal','Paypal');
	
	$form->addElement('text', 'PAYPAL[pp_merchant_id]', 'Paypal Email:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));
	
	$paypal_currency = $this->getResult('currency, code', $ushop->db_name.'paypal_currency');
	
	$ppc_s = $form->createElement('select', 'PAYPAL[pp_currency]', 'Paypal Currency:');
	$ppc_opts[0] = 'Select One';
		
	foreach ($paypal_currency as $value) {
		$ppc_opts[$value->code] = $value->currency;
	}
	
	$ppc_s->loadArray($ppc_opts);
	$form->addElement($ppc_s);
	
	$pp_ipn[] = $form->createElement('radio', null, null, 'On', '1');
	$pp_ipn[] = $form->createElement('radio', null, null, 'Off', '0');
	$form->addGroup($pp_ipn, 'PAYPAL[pp_ipn]', 'Paypal IPN:');
	
	$pp_ar[] = $form->createElement('radio', null, null, 'On', '1');
	$pp_ar[] = $form->createElement('radio', null, null, 'Off', '0');
	$form->addGroup($pp_ar, 'PAYPAL[pp_auto_return]', 'Paypal Auto Return:');
	
	$pp_cr[] = $form->createElement('radio', null, null, 'On', '1');
	$pp_cr[] = $form->createElement('radio', null, null, 'Off', '0');
	$form->addGroup($pp_cr, 'PAYPAL[pp_cancel_return]', 'Paypal Cancel Return:');
	
	$form->addElement('text', 'PAYPAL[pp_merchant_logo]', 'Merchant Logo:', array( 'id' => 'pp_merchant_logo' ,'size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));
	
	$form->addElement('html', '</fieldset>');
	
	$form->addElement('html', '<div class="both"></div>');
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
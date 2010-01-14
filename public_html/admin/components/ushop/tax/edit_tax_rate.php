<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
		'cancel' => '/ushop/tax/overview',
		'save' => null,
   		'seperator' => null,
   		'customers' => '/ushop/customers',
   		'products' => '/ushop/products',
   		'postage' => '/ushop/postage'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	$ushop = new UShopAdmin();
	
	$rate = $this->getResult('tax_rate', $ushop->db_name.'tax_rates', null, array('where' =>'tax_rate_id = '.$this->registry->params['id']));
			
	$form = new HTML_QuickForm('edit_tax_rate', 'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
			
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','edit_tax_rate','Edit Tax Rate');
		
	$form->addElement('text', 'tax_rate', 'Tax Rate:', array('size' => 5, 'maxlength' => 5, 'class' => 'inputbox'));
	$form->addElement('html', '</fieldset>');
	
	$form->addRule('tax_rate', 'Please enter a tax rate', 'required');
	$form->addRule('tax_code', 'Tax rates must be a number', 'numeric');
		
			
	if ($form->validate()) {
			
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);
		
		$menuBar['back'] = '/ushop/tax/overview';
			
		//check then enter the record.
		$res = $this->update($values, $ushop->db_name.'tax_rates', array('where' => 'tax_rate_id='.$this->registry->params['id']));
			
		if ($res) {
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Tax rate was successfully edited.</h2>';
				
		} else {
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Tax rate could not be edited due to an error.</h2>';
		}
				
		// done!
			
	} else {
			
		$form->setDefaults(array(
			'tax_rate' => $rate[0]->tax_rate,
		));
				
		$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->registry->admin_config->get ('admin_template', 'SERVER'));
			
		$renderer->setFormTemplate('form');
		$renderer->setHeaderTemplate('header');
		$renderer->setElementTemplate('element');
		
		$form->accept($renderer);
		
		// output the form
		$this->content .= $renderer->toHtml();
				
	}
	
	if (isset($params)) {
		$params['CONTENT'] = $this->makeToolbar($menuBar, 24);
		$this->content .= $this->message($params);
	}
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
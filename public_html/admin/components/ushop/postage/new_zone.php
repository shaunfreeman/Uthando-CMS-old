<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
		'cancel' => '/ushop/postage/overview',
		'save' => null,
   		'seperator' => null,
   		'customers' => '/ushop/customers',
   		'products' => '/ushop/products',
   		'tax' => '/ushop/tax'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	$ushop = new UShopAdmin();
	
	if ($this->getResult('tax_code_id', $ushop->db_name.'tax_codes')) {
			
		$form = new HTML_QuickForm('add_zone', 'post', $_SERVER['REQUEST_URI']);
			
		$s = $form->createElement('select', 'tax_code_id', 'Tax Code:');
		$opts[0] = 'Select One';
			
		foreach ($ushop->formatTaxCodes() as $code) {
			$opts[$code['tax_code_id']] = $code['tax_code'];
		}
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','new_zone','New Zone');
		
		$form->addElement('text', 'zone', 'Zone:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
	
		$s->loadArray($opts);
		$form->addElement($s);
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('zone', 'Please enter a zone', 'required');
		$form->addRule('tax_code_id', 'Please enter a tax code', 'nonzero');
			
		if ($form->validate()) {
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$menuBar['add_zone'] = '/ushop/postage/action-new_zone';
			$menuBar['back'] = '/ushop/postage/overview';
			
			//check then enter the record.
			if (!$this->getResult('post_zone_id', $ushop->db_name.'post_zones', null, array('where' => "zone='".$values['zone']."'"))) {
				
				$res = $this->insert($values, $ushop->db_name.'post_zones');
			
				if ($res) {
					$params['TYPE'] = 'pass';
					$params['MESSAGE'] = '<h2>Post zone was successfully entered.</h2>';
				} else {
					$params['TYPE'] = 'error';
					$params['MESSAGE'] = '<h2>Post zone could not be entered into the database.</h2>';
				}
			
			} else {
				$params['TYPE'] = 'warning';
				$params['MESSAGE'] = '<h2>This zone already exits.</h2>';
			}
				
			// done!
			
			
		} else {
				
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->registry->admin_config->get ('admin_template', 'SERVER'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
		
			// output the form
			$this->content .= $renderer->toHtml();
				
		}
			
	} else {
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>First define some tax codes.</h2>';
		
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
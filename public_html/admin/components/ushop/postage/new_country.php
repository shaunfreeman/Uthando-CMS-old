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
	
	if ($post_zones = $this->getResult('post_zone_id, zone', $ushop->db_name.'post_zones')) {
			
		$form = new HTML_QuickForm('add_country', 'post', $_SERVER['REQUEST_URI']);
			
		$s = $form->createElement('select', 'post_zone_id', 'Zone:');
		$opts[0] = 'Select One';
			
		foreach ($post_zones as $value) {
			$opts[$value->post_zone_id] = $value->zone;
		}
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','new_country','New Country');
		
		$form->addElement('text', 'country', 'Country:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
	
		$s->loadArray($opts);
		$form->addElement($s);
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('country', 'Please enter a country', 'required');
		$form->addRule('post_zone_id', 'Please enter a post zone', 'nonzero');
			
		if ($form->validate()) {
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$menuBar['add_country'] = '/ushop/postage/action-new_country';
			$menuBar['back'] = '/ushop/postage/overview';
			
			//check then enter the record.
			if (!$this->getResult('country_id', $ushop->db_name.'countries', null, array('where' => "country='".$values['country']."'"))) {
				
				$res = $this->insert($values, $ushop->db_name.'countries');
			
				if ($res) {
					$params['TYPE'] = 'pass';
					$params['MESSAGE'] = '<h2>Country was successfully entered.</h2>';
				} else {
					$params['TYPE'] = 'error';
					$params['MESSAGE'] = '<h2>Country could not be entered into the database.</h2>';
				}
			
			} else {
				$params['TYPE'] = 'warning';
				$params['MESSAGE'] = '<h2>This country already exits.</h2>';
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
		$params['MESSAGE'] = '<h2>First define some post zones.</h2>';
		
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
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
		'cancel' => '/ushop/products/overview',
		'save' => null,
   		'seperator' => null,
   		'customers' => '/ushop/customers',
   		'postage' => '/ushop/postage',
   		'tax' => '/ushop/tax'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	if ($this->registry->params['id']) {
		
		$rows = $this->getResult('price_group_id, price_group, price', $ushop->db_name.'price_groups',null, array('where' => 'price_group_id = '.$this->registry->params['id']));
			
		$form = new HTML_QuickForm('edit_group', 'post', $_SERVER['REQUEST_URI']);
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','edit_group','Edit Price Group');
		
		$form->addElement('text', 'price_group', 'Price Group:', array('size' => 5, 'maxlength' => 5, 'class' => 'inputbox'));
	
		$form->addElement('text', 'price', 'Price:', array('size' => 5, 'maxlength' => 10, 'class' => 'inputbox'));
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('level', 'Please enter a price group', 'required');
		$form->addRule('price', 'Price have to be a number.', 'numeric');
			
		if ($form->validate()) {
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			// format values.
			$values['price_group'] = strtoupper($values['price_group']);
			
			$menuBar['back'] = '/ushop/products/overview';
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'price_groups', array('where' => 'price_group_id='.$this->registry->params['id']));
			
			if ($res) {
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Price group was successfully edited.</h2>';
				
			} else {
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Price group could not be edited due to an error.</h2>';
			}
				
			// done!
			
		} else {
				
			$form->setDefaults(array(
   				'price_group' => $rows[0]->price_group,
	   			'price' => $rows[0]->price,
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
	}
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
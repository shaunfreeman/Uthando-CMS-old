<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array(
		'cancel' => '/ushop/products/overview',
		'save' => null
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
			
	$form = new HTML_QuickForm('add_group', 'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
			
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','new_group','New Price Group');
		
	$form->addElement('text', 'price_group', 'Price Group:', array('size' => 5, 'maxlength' => 5, 'class' => 'inputbox'));
	
	$form->addElement('text', 'price', 'Price:', array('size' => 5, 'maxlength' => 10, 'class' => 'inputbox'));
			
	$form->addElement('html', '</fieldset>');
		
	$form->addRule('level', 'Please enter a price group', 'required');
	$form->addRule('price', 'Price have to be a number.', 'numeric');
			
	if ($form->validate()):
		
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);
		
		// format values.
		$values['price_group'] = strtoupper($values['price_group']);
			
		$menuBar['add_group'] = '/ushop/products/action-new_group';
		$menuBar['back'] = '/ushop/products/overview';
			
		//check then enter the record.
		if (!$this->getResult('price_group_id', $ushop->db_name.'price_groups', null, array('where' => "price_group='".$values['price_group']."'"))):
				
			$res = $this->insert($values, $ushop->db_name.'price_groups');
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Price group was successfully entered.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Price group could not be entered into the database.</h2>';
			endif;
		else:
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = '<h2>This price group already exits.</h2>';
		endif;	
		// done!
	else:
		
		$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->get ('admin_config.site.template'));
			
		$renderer->setFormTemplate('form');
		$renderer->setHeaderTemplate('header');
		$renderer->setElementTemplate('element');
		
		$form->accept($renderer);
		
		// output the form
		$this->content .= $renderer->toHtml();
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
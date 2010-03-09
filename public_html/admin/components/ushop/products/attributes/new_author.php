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
	
	$ushop = new UShop_Admin();
			
	$form = new HTML_QuickForm('add_author', $ushop->db_name.'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
			
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','new_author','New Author');
		
	$form->addElement('text', 'forename', 'Forename:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
	
	$form->addElement('text', 'surname', 'Surname:', array('size' => 30, 'maxlength' => 30, 'class' => 'inputbox'));
			
	$form->addElement('html', '</fieldset>');
		
	$form->addRule('forename', 'Please enter a forename', 'required');
	$form->addRule('surname', 'Please enter a surname.', 'required');
			
	if ($form->validate()):
		
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);
		
		// format values.
		foreach ($values as $key => $value) $values[$key] = ucwords($value);
			
		$menuBar['add_author'] = '/ushop/products/action-new_attribute/attr-author';
		$menuBar['back'] = '/ushop/products/overview';
			
		//check then enter the record.
		if (!$this->getResult('author_id', $ushop->db_name.'authors', null, array('where' => "forename='".$values['forename']."'", 'and' => "surname='".$values['surname']."'"))):
				
			$res = $this->insert($values, $ushop->db_name.'authors');
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Author was successfully entered.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2Author could not be entered into the database.</h2>';
			endif;
		else:
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = '<h2>This author already exits.</h2>';
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
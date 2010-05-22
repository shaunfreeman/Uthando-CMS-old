<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array(
		'cancel' => '/ushop/tax/overview',
		'save' => null
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
			
	$form = new HTML_QuickForm('add_tax_rate', 'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
			
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','new_tax_rate','New Tax Rate');
		
	$form->addElement('text', 'tax_rate', 'Tax Rate:', array('size' => 5, 'maxlength' => 5, 'class' => 'inputbox'));
	$form->addElement('html', '</fieldset>');
	
	$form->addRule('tax_rate', 'Please enter a tax rate', 'required');
	$form->addRule('tax_code', 'Tax rates must be a number', 'numeric');
		
			
	if ($form->validate()):
		
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);
		
		$menuBar['add_tax_rate'] = '/ushop/tax/action-new_tax_rate';
		$menuBar['back'] = '/ushop/tax/overview';
			
		//check then enter the record.
		if (!$this->getResult('tax_rate_id', $ushop->db_name.'tax_rates', null, array('where' => 'tax_rate='.$values['taxrate']))):
			
			$res = $this->insert($values, $ushop->db_name.'tax_rates');
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Tax rate was successfully entered.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Tax rate could not be entered into the database due to an error.</h2>';
			endif;
		else:
			$params['TYPE'] = 'info';
			$params['MESSAGE'] = '<h2>This rate already exits.</h2>';
		endif;
		// done!
	else:
		
		$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $template);
			
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
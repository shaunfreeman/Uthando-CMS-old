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
	
	if ($tax_rates = $ushop->getTaxRates(true)):
			
		$form = new HTML_QuickForm('add_tax_code', 'post', $_SERVER['REQUEST_URI']);
			
		$s = $form->createElement('select', 'tax_rate', 'Tax Rate:');
		$opts[0] = 'Select One';
			
		foreach ($tax_rates as $rate) $opts[$rate->tax_rate_id] = ucwords($rate->tax_rate);
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','new_tax_code','New Tax Code');
		
		$form->addElement('text', 'tax_code', 'Tax Code:', array('size' => 2, 'maxlength' => 2, 'class' => 'inputbox'));
	
		$s->loadArray($opts);
		$form->addElement($s);
			
		$form->addElement('text', 'description', 'Description:', array('size' => 20, 'maxlength' => 20, 'class' => 'inputbox'));
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('description', 'Please enter a decription', 'required');
		$form->addRule('tax_code', 'Please enter a tax code', 'required');
		$form->addRule('tax_code', 'Tax codes have only letters', 'lettersonly');
		// group rules
		$form->addRule('tax_rate','Please Select a menu type','nonzero');
			
		if ($form->validate()):
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$menuBar['add_tax_code'] = '/ushop/tax/action-new_tax_code';
			$menuBar['back'] = '/ushop/tax/overview';
			
			//check then enter the record.
			if (!$this->getResult('tax_code_id', $ushop->db_name.'tax_codes', null, array('where' => "tax_code='".$value['tax_code']."'"))):
				
				$res = $ushop->insert($values, $ushop->db_name.'tax_codes');
			
				if ($res):
					$params['TYPE'] = 'pass';
					$params['MESSAGE'] = '<h2>Tax code was successfully entered.</h2>';
				else:
					$params['TYPE'] = 'error';
					$params['MESSAGE'] = '<h2>Tax code could not be entered into the database.</h2>';
				endif;
			else:
				$params['TYPE'] = 'warning';
				$params['MESSAGE'] = '<h2>This code already exits.</h2>';
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
	else:
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>First define some tax rates.</h2>';
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
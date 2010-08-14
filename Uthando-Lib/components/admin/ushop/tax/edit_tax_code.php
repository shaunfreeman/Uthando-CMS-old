<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$rows = $this->getResult('tax_code_id, tax_rate_id, tax_code, description', $ushop->db_name.'tax_codes',null, array('where' => 'tax_code_id = '.$this->registry->params['id']));
			
	$form = new HTML_QuickForm('edit_tax_code', 'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
	
	$s = $form->createElement('select', 'tax_rate_id', 'Tax Rate:');
	$opts[0] = 'Select One';
	
	$tax_rates = $ushop->getTaxRates(true);
			
	foreach ($tax_rates as $rate) $opts[$rate->tax_rate_id] = ucwords($rate->tax_rate);
			
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','edit_tax_code','Edit Tax Code');
		
	$form->addElement('text', 'tax_code', 'Tax Code:', array('size' => 2, 'maxlength' => 2, 'class' => 'inputbox'));
	
	$s->loadArray($opts);
	$form->addElement($s);
			
	$form->addElement('text', 'description', 'Description:', array('size' => 20, 'maxlength' => 20, 'class' => 'inputbox'));
	
	$form->addElement('html', '</fieldset>');
		
	$form->addRule('description', 'Please enter a decription', 'required');
	$form->addRule('tax_code', 'Please enter a tax code', 'required');
	$form->addRule('tax_code', 'Tax codes have only letters', 'lettersonly');
	
			
	if ($form->validate()):
		
		$menuBar = array();
		
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);
		
		$menuBar['back'] = '/ushop/tax/overview';
		
		$values['tax_code'] = strtoupper($values['tax_code']);
			
		//check then enter the record.
		$res = $this->update($values, $ushop->db_name.'tax_codes',  array('where' => 'tax_code_id='.$this->registry->params['id']));
			
		if ($res):
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Tax code was successfully edited.</h2>';
		else:
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Tax code could not be edited due to an error.</h2>';
		endif;	
		// done!
	else:
		
		$menuBar = array(
			'cancel' => '/ushop/tax/overview',
			'save' => null
		);
			
		$this->content .= $this->makeToolbar($menuBar, 24);
			
		$form->setDefaults(array(
			'tax_code' => $rows[0]->tax_code,
			'tax_rate_id' => $rows[0]->tax_rate_id,
   			'description' => $rows[0]->description,
		));
				
		$renderer = new UthandoForm(TEMPLATES . $template);
			
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
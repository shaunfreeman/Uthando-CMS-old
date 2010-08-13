<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($this->registry->params['id']):
		
		$rows = $this->getResult('post_zone_id, tax_code_id, zone', $ushop->db_name.'post_zones',null, array('where' => 'post_zone_id = '.$this->registry->params['id']));
			
		$form = new HTML_QuickForm('edit_zone', 'post', $_SERVER['REQUEST_URI']);
			
		$s = $form->createElement('select', 'tax_code_id', 'Tax Code:');
		$opts[0] = 'Select One';
			
		foreach ($ushop->formatTaxCodes() as $code) $opts[$code['tax_code_id']] = $code['tax_code'];
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','edit_zone','Edit Zone');
		
		$form->addElement('text', 'zone', 'Zone:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
	
		$s->loadArray($opts);
		$form->addElement($s);
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('zone', 'Please enter a zone', 'required');
		$form->addRule('tax_code_id', 'Please enter a tax code', 'nonzero');
			
		if ($form->validate()):
			
			$menuBar = array();
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$menuBar['back'] = '/ushop/postage/overview';
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'post_zones', array('where' => 'post_zone_id='.$this->registry->params['id']));
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Post zone was successfully edited.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Post zone could not be edited due to an error.</h2>';
			endif;
			// done!
		else:
			
			$menuBar = array(
				'cancel' => '/ushop/postage/overview',
				'save' => null
			);
				
			$this->content .= $this->makeToolbar($menuBar, 24);
				
			$form->setDefaults(array(
			'tax_code_id' => $rows[0]->tax_code_id,
   			'zone' => $rows[0]->zone,
			));
				
			$renderer = new UthandoForm(TEMPLATES . $template);
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
		
			// output the form
			$this->content .= $renderer->toHtml();
		endif;
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
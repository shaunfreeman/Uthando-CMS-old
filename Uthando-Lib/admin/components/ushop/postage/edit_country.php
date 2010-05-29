<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array(
		'cancel' => '/ushop/postage/overview',
		'save' => null
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	if ($this->registry->params['id']):
		
		$rows = $this->getResult('post_zone_id, country_id, country', $ushop->db_name.'countries',null, array('where' => 'country_id = '.$this->registry->params['id']));
			
		$form = new HTML_QuickForm('edit_country', 'post', $_SERVER['REQUEST_URI']);
			
		$s = $form->createElement('select', 'post_zone_id', 'Zone:');
		$opts[0] = 'Select One';
		
		$post_zones = $this->getResult('post_zone_id, zone', $ushop->db_name.'post_zones');
			
		foreach ($post_zones as $value) $opts[$value->post_zone_id] = $value->zone;
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','edit_country','Edit Country');
		
		$form->addElement('text', 'country', 'Country:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
	
		$s->loadArray($opts);
		$form->addElement($s);
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('country', 'Please enter a country', 'required');
		$form->addRule('post_zone_id', 'Please enter a post zone', 'nonzero');
			
		if ($form->validate()):
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$menuBar['back'] = '/ushop/postage/overview';
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'countries', array('where' => 'country_id='.$this->registry->params['id']));
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Country was successfully edited.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Country could not be edited due to an error.</h2>';
			endif;
			// done!
		else:
				
			$form->setDefaults(array(
			'country' => $rows[0]->country,
   			'post_zone_id' => $rows[0]->post_zone_id,
			));
				
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $template);
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
		
			// output the form
			$this->content .= $renderer->toHtml();
		endif;
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeToolbar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
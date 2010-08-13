<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($this->registry->params['id']):
		
		$rows = $this->getResult('post_zone_id, post_level_id, cost, vat_inc', $ushop->db_name.'post_costs',null, array('where' => 'post_cost_id = '.$this->registry->params['id']));
			
		$form = new HTML_QuickForm('edit_cost', 'post', $_SERVER['REQUEST_URI']);
		
		$post_zones = $this->getResult('post_zone_id, zone', $ushop->db_name.'post_zones');
		$post_levels = $this->getResult('post_level_id, post_level', $ushop->db_name.'post_levels', null, array('ORDER BY' => 'post_level ASC'));
			
		$pz_s = $form->createElement('select', 'post_zone_id', 'Zone:');
		$pz_opts[0] = 'Select One';
		
		$pl_s = $form->createElement('select', 'post_level_id', 'Post Level:');
		$pl_opts[0] = 'Select One';
		
		foreach ($post_zones as $value) $pz_opts[$value->post_zone_id] = $value->zone;
		
		foreach ($post_levels as $value) $pl_opts[$value->post_level_id] = $value->post_level;
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','edit_cost','Edit Post Cost');
		
		$form->addElement('text', 'cost', 'Cost:', array('size' => 5, 'maxlength' => 5, 'class' => 'inputbox'));
		
		$radio[] = $form->createElement('radio', null, null, 'Yes', '1');
		$radio[] = $form->createElement('radio', null, null, 'No', '0');
		$form->addGroup($radio, 'vat_inc', 'Include Tax:');
		
		$pl_s->loadArray($pl_opts);
		$form->addElement($pl_s);
	
		$pz_s->loadArray($pz_opts);
		$form->addElement($pz_s);
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('cost', 'Please enter a post cost', 'required');
		$form->addRule('cost', 'post costs have to be a number', 'numeric');
		$form->addGroupRule('vat_inc', 'Please choose whether to include tax or not.', 'required', null, 1);
		$form->addRule('post_zone_id', 'Please select a post zone', 'nonzero');
		$form->addRule('post_level_id', 'Please select a post level', 'nonzero');
			
		if ($form->validate()):
			
			$menuBar = array();
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$menuBar['back'] = '/ushop/postage/overview';
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'post_costs', array('where' => 'post_cost_id='.$this->registry->params['id']));
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Post cost was successfully edited.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Post cost could not be edited due to an error.</h2>';
			endif;
			// done!
		else:
			
			$menuBar = array(
				'cancel' => '/ushop/postage/overview',
				'save' => null
			);
				
			$this->content .= $this->makeToolbar($menuBar, 24);
				
			$form->setDefaults(array(
				'cost' => $rows[0]->cost,
   				'post_zone_id' => $rows[0]->post_zone_id,
				'post_level_id' => $rows[0]->post_level_id,
				'vat_inc' => $rows[0]->vat_inc
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
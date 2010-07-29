<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id'])):
		
		$row = $this->getResult(
			'menu_type_id, status_id, item',
			$this->registry->core.'menu_items',
			null,
			array(
				'where' => 'item_id='.$this->registry->params['id']
			),
			false
		);
		
		$form = new HTML_QuickForm('menuEdit', 'post', $_SERVER['REQUEST_URI']);
		
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
		
		$menuBar = array(
			'cancel' => '/menu/overview',
			'save' => ''
		);
		
		$this->content .= $this->makeToolbar($menuBar, 24);
		
		// get menu Types
		$menu_types = $this->getResult('menu_type_id, menu_type', $this->registry->core.'menu_types');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','menu_details','Menu Details');
			
		$form->addElement('text', 'item', 'Menu Title:', array('size' => 20, 'maxlength' => 20, 'class' => 'inputbox'));
			
		$s = $form->createElement('select', 'menu_type_id', 'Menu Type:');
		$opts[0] = 'Select One';
			
		foreach ($menu_types as $type) $opts[$type->menu_type_id] = ucwords($type->menu_type);
		
		$s->loadArray($opts);
		$form->addElement($s);
		
		//access level
		$access_level = $this->getResult(
			'status_id, status',
			$this->registry->core.'menu_link_status',
			null,
			array('order by' => 'status_id')
		);
			
		foreach ($access_level as $level):
			switch($level->status):
				case 'A':
					$status = 'Always show';
					break;
				case 'LI':
					$status = 'Only show when logged in';
					break;
				case 'LO':
					$status = 'Only show when logged out';
					break;
			endswitch;
			$access_level_opts[$level->status_id] = $status;
		endforeach;
			
		$s = $form->createElement('select', 'status_id', 'Access Level:', null, array('size' => '3', 'id' => 'access_level'));
		$s->loadArray($access_level_opts);
		$form->addElement($s);
			
		$form->addElement('html', '</fieldset>');
			
		$form->addRule('item', 'Please enter a title', 'required');
		// group rules
		$form->addRule('type_id','Please Select a menu type','nonzero');
		$form->addRule('status_id','Please Select a access level','nonzero');
		
		if ($form->validate()):
			
			$menuBar = array();
			
			// Apply form element filters.
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$result = $this->update($values, $this->registry->core.'menu_items', array('where' => 'item_id='.$this->registry->params['id']));
			
			$menuBar['back'] = '/menu/overview';
			
			// Always check that result is not an error
			if ($result):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Menu was successfully edited.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Menu could not be edited to the database.</h2>';
			endif;
		else:
				
			$form->setDefaults(array(
				'item' => $row->item,
				'menu_type_id' => $row->menu_type_id,
				'status_id' => $row->status_id
			));
			
			$renderer = new UthandoForm(TEMPLATES . $this->get ('admin_config.site.template'));
			
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
		Uthando::go('/menu/overview');
	endif;
endif;
?>
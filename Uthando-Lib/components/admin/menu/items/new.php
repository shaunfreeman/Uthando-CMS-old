<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id'])):
	
		$form = new HTML_QuickForm('menuitemEdit', 'post', $_SERVER['REQUEST_URI']);
		
		// start tree class
		$tree = new Admin_NestedTree($this->registry->core.'menu_items', $this->registry->params['id'], 'item', $this->registry);
		
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
		
		$menuBar = array(
			'cancel' => '/menu/view/id-'.$this->registry->params['id'],
			'save' => ''
		);
	
		$this->content .= $this->makeToolbar($menuBar, 24);
		
		// form elements.
		// Item Type elements.
		$form->addElement('html', '<fieldset id="menu_item_type">');
		$form->addElement('header','menu_item_type','Menu Item Type');
				
		$result = $this->getResult('item_type_id, item_type', $this->registry->core.'menu_item_types');
			
		if ($result):
			foreach ($result as $row):
				$form->addElement('radio', 'item_type_id', $row->item_type.' Link:', null, $row->item_type_id.'|'.$row->item_type, array('id' => $row->item_type));
			endforeach;
		endif;
		
		$form->addElement('html', '</fieldset>');
		
		// external link.
		$form->addElement('html', '<fieldset id="external_link">');
		$form->addElement('header','menu_item_exlink','External Link');
		
		$form->addElement('text', 'external_link', 'Link:', array('size' => 30, 'maxlength' => 255, 'class' => 'inputbox'));
		
		$form->addElement('html', '</fieldset>');
		
		// internal link.
		$form->addElement('html', '<fieldset id="component_link">');
		$form->addElement('header','menu_item_inlink','Internal Link');
		
		$components = $this->getResult(
			'component_id, component',
			$this->registry->core.'components',
			null,
			array('order by' => 'component_id')
		);
		
		$select1[0] = '--- Component ---';
		$select2[0][0] = '--- Page ---';
		
		foreach ($components as $component):
			
			$dir = realpath($_SERVER['DOCUMENT_ROOT']."/../Uthando-Lib/components/public/".$component->component);
			
			$json = file_get_contents($dir.'/action.json');
			$json = json_decode($json, true);
			
			foreach ($json as $key => $value):
				$url = $value['url'].$value['params'];
				$select1[$url] = ucwords($key);
				$select2[$url][0] = '--- Choose Page ---';
				
				if ($value['links'] == 'database'):
					
					$links = $this->getResult(
						$value['fields'],
						$this->registry->core.$value['database_name'],
						null,
						$value['filter']
					);
				
					foreach ($links as $page):
						$select2[$url][str_replace(' ', '_', $page->page).'|'.$page->page_id] = ucwords($page->page);
					endforeach;
				else:
					foreach ($value['links'] as $value):
						$select2[$url][str_replace(' ', '_',$value)] = ucwords($value);
					endforeach;
				endif;
			endforeach;
		endforeach;
		
		$sel = $form->addElement('hierselect', 'url', 'Choose Page:');
		
		// And add the selection options
		$sel->setOptions(array($select1, $select2));
		
		$form->addElement('html', '</fieldset><div class="both"></div>');
		
		$form->addElement('html', '<fieldset id="menu_item_details">');
		$form->addElement('header','menu_item_details','Item Details');
		// title.
		$form->addElement('text', 'item', 'Menu item Title:', array('size' => 20, 'maxlength' => 100, 'class' => 'inputbox', 'id' => 'item_title'));
				
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
		
		$enssl[] = $form->createElement('radio', null, null, 'On', '1');
		$enssl[] = $form->createElement('radio', null, null, 'Off', '0');
		$form->addGroup($enssl, 'enssl', 'Enable SSL:');
		
		$form->addElement('html', '</fieldset>');
		
		$form->addElement('html', '<fieldset id="menu_item_position">');
		$form->addElement('header','menu_item_position','Item Position');
		// menu position
		$items = $tree->getDecendants(true);
		
		$items_opts[$this->registry->params['id']] = 'Top';
		
		foreach ($items as $item):
			$items_opts[$item['item_id']] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', ($item['depth'])).$item['item'];
		endforeach;
		
		$s = $form->createElement('select', 'item_position', 'Position:', null, array('size' => '5', 'id' => 'item_position'));
		$s->loadArray($items_opts);
		$form->addElement($s);
		
		// Creates a radio buttons group
		$radio[] = $form->createElement('radio', null, null, 'at top', 'new child');
		
		if (count($items) > 0):
			$radio[] = $form->createElement('radio', null, null, 'after this item', 'after child');
		endif;
		
		$form->addGroup($radio, 'insert_type', 'Insert as new sub item'); 
		
		$form->addRule('item', 'Please enter a title', 'required');
		
		$form->addRule('item_type_id', 'Select a item type', 'required');
		$form->addRule('insert_type', 'Select a insert type', 'required');
		
		$form->addElement('html', '</fieldset>');
	
		if ($form->validate()):
			
			$menuBar = array();
			
			$menuBar['back'] = '/menu/view/id-' . $this->registry->params['id'];
			
			// Apply form element filters.
			$form->applyFilter('__ALL__', 'escape_data');
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			// Update menu item table.
			$i = $p = explode('|', $values['item_type_id']);
			$values['item_type_id'] = $i[0];
			$item_type = $i[1];
					
			// format url.
			switch ($item_type):
				case 'component':
					$p = explode('|', $values['url'][1]);
					$values['page_id'] = $p[1];
					if (!isset($values['page_id'])) $values['page_id'] = 'NULL';
					$values['url'] = $values['url'][0] . $p[0];
					break;
				case 'external':
					$values['url'] = $values['external_link'];
					break;
				case 'heading':
					$values['url'] = 'NULL';
					$values['page_id'] = 'NULL';
					break;
			endswitch;
			
			// insert the url and get the url id.
			$res = $this->getResult(
				'url_id',
				$this->registry->core.'menu_urls',
				null,
				array('where' => "url='".$values['url']."'"),
				false
			);
			
			$pass = false;
			
			if ($res):
				$values['url_id'] = $res->url_id;
				$pass = true;
			else:
				$res = $this->insert(
					array('url' => $values['url']),
					$this->registry->core.'menu_urls'
				);
				if ($res):
					$values['url_id'] = $this->registry->db->lastInsertID();
					$pass = true;
				else:
					$pass = false;
				endif;
			endif;
			
			$res = $this->update(
				array('enssl' => $values['enssl']),
				$this->registry->core.'menu_urls',
				array('WHERE' => 'url_id='.$values['url_id']),
				false
			);
			
			if ($pass):
				
				$tree = new NestedTreeAdmin($this->registry->core.'menu_items', null, 'item');
			
				$ip = $values['item_position'];
				$it = $values['insert_type'];
				
				unset($values['insert_type'], $values['item_position'], $values['external_link'], $values['url'], $values['enssl']);
			
				$category_id = $tree->insert($ip, $values, $it);
				
				if ($category_id):
					$params['TYPE'] = 'pass';
					$params['MESSAGE'] = '<h2>Menu was successfully added.</h2>';
				else:
					$params['TYPE'] = 'error';
					$params['MESSAGE'] = '<h2>Menu could not be added to the database.</h2>';
				endif;
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Menu could not be added to the database.</h2>';	
			endif;
		else:
			
			$form->setDefaults(array(
				'status_id' => 1,
				'item_position' => $this->registry->params['id'],
				'insert_type' => 'new child',
				'external_link' => 'http://',
				'enssl' => 0
			));
			
			$renderer = new UthandoForm(TEMPLATES . $this->get ('admin_config.site.template'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
		
			// output the form
			$this->content .= $renderer->toHtml();
			
			$this->addComponentJS();
		
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
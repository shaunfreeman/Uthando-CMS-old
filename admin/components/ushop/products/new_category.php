<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array(
		'cancel' => $_SESSION['referer_link'],
		'save' => null
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	$tree = new NestedTreeAdmin($ushop->db_name.'product_categories', null, 'category');
			
	$form = new HTML_QuickForm('add_category', 'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
			
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','new_category','New Category');
		
	$form->addElement('text', 'category', 'Category:', array('size' => 20, 'maxlength' => 20, 'class' => 'inputbox'));
	
	$items_opts[0] = 'Top';
		
	foreach ($items = $tree->getTree() as $item):
		$items_opts[$item['category_id']] = str_repeat(str_repeat('&nbsp;',4), ($item['depth'])).$item['category'];
	endforeach;
		
	$s = $form->createElement('select', 'item_position', 'Position:', null, array('size' => '10', 'id' => 'item_position'));
	
	$s->loadArray($items_opts);
	$form->addElement($s);
		
	// Creates a radio buttons group
	$radio[] = $form->createElement('radio', null, null, 'at top', 'new child');
		
	if (count($items) > 0):
		$radio[] = $form->createElement('radio', null, null, 'after this item', 'after child');
	endif;
		
	$form->addGroup($radio, 'insert_type', 'Insert as new sub item'); 
			
	$form->addElement('html', '</fieldset>');
		
	$form->addRule('category', 'Please enter a category', 'required');
			
	if ($form->validate()):
			
		$c = ucwords($form->exportValue('category'));
		$ip = $form->exportValue('item_position');
		$it = $form->exportValue('insert_type');
		
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);
		
		// format values.
		$values['category'] = ucwords($values['category']);
			
		$menuBar['add_category'] = '/ushop/products/action-new_category';
		$menuBar['back'] = $_SESSION['referer_link'];
			
		//check then enter the record.
		if (!$this->getResult('category_id', $ushop->db_name.'product_categories', null, array('where' => "category='".$values['category']."'"))):
				
			$insert = array (
				'category' => $values['category']
			);
			
			$category_id = $tree->insert($values['item_position'], $insert, $values['insert_type']);
			
			if ($category_id):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Category was successfully entered.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Category could not be entered into the database.</h2>';
			endif;
		else:
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = '<h2>This category already exits.</h2>';
		endif;
		// done!
	else:
			
		$form->setDefaults(array(
			'item_position' => 0,
			'insert_type' => 'new child'
		));
				
		$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->get ('admin_config.site.template'));
			
		$renderer->setFormTemplate('form');
		$renderer->setHeaderTemplate('header');
		$renderer->setElementTemplate('element');
		
		$form->accept($renderer);
		
		// output the form
		$this->content .= $renderer->toHtml();
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
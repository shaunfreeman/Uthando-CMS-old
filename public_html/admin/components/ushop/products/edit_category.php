<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
		'cancel' => '/ushop/products/overview',
		'save' => null,
   		'seperator' => null,
   		'customers' => '/ushop/customers',
   		'postage' => '/ushop/postage',
   		'tax' => '/ushop/tax'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	$ushop = new UShopAdmin();
	
	if ($this->registry->params['id']) {
		
		$rows = $this->getResult('category_id, category, category_image, category_image_status', $ushop->db_name.'product_categories', null, array('where' => 'category_id = '.$this->registry->params['id']));
	
		$tree = new NestedTreeAdmin($ushop->db_name.'product_categories', $this->registry->params['id'], 'category');
		
		$tree->getCategory();
		
		$category = $tree->getField('category');
		$image = $tree->getField('category_image');
		$category_id = $tree->getField('category_id');
		$image_status = $tree->getField('category_image_status');
		
		$base_dir = __SITE_PATH . "/../components/ushop/images/products/";
		
		$form = new HTML_QuickForm('edit_category', 'post', $_SERVER['REQUEST_URI']);
		
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','edit_category','Edit Category');
		
		$form->addElement('text', 'category', 'Category:', array('size' => 20, 'maxlength' => 20, 'class' => 'inputbox'));
		
		$tmpl = file_get_contents(__SITE_PATH.'/components/ushop/html/formHtml.html');
		
		$pathway = $tree->pathway($this->registry->params['id']);
		unset ($pathway[$category_id]);
		$parent = end($pathway);
		
		$parent = $this->templateParser($tmpl, array('LABEL' => 'Parent:', 'ELEMENT' => ($parent['category']) ? $parent['category'] : 'Top' ), '{', '}');
	
		$form->addElement('html', $parent);
		
		if ($image_status == 1) {
	
			if (file_exists($base_dir.$image) && $image != null) {
				$img_file = $ushop->img_dir.$image;
		
			} else {
				$img_file = $ushop->img_dir."nopic.jpg";
			}
		} else {
			$img_file = "IMAGE OFF";
		}
		
		$img = $this->templateParser($tmpl, array('LABEL' => 'Image:', 'ELEMENT' => '<img src="'.$img_file.'" />'), '{', '}');
		
		$form->addElement('html', $img);
		
		// get all decendents
		$nopics = true;
		
		foreach ($tree->getDecendants() as $row) {
			
			$imgs = $this->getResult('category_id, image, image_status', $ushop->db_name.'products', null, array('where' => 'category_id = '.$row['category_id']));
			
			if ($imgs) {
				
				$main[$row['category_id']] = $row['category'];
				
				foreach ($imgs as $key => $value) {
					
					if ($value->image_status == 1 && is_file(__SITE_PATH . '/../components/ushop/images/products/'.$value->image)) {
						$secondary[$row['category_id']][$value->image] = $value->image;
					}
				}
				
				if (!is_array($secondary[$row['category_id']])) $secondary[$row['category_id']][] = '--- No Pictures ---';
				
				$nopics = false;
			}
			
		}
		
		if ($nopics == true) {
			$img_dir = '<span style="vertical-align:middle;">There are no pictures avaliable</span>';
			
			$img_dirs = $this->templateParser($tmpl, array('LABEL' => 'Change Image:', 'ELEMENT' => $img_dir), '{', '}');
	
			$form->addElement('html', $img_dirs);
		} else {
			
			// display dropdown menu of images and in thier categories.
			
			$hs = $form->addElement('hierselect', 'category_image', 'Change Image:');
			$hs->setOptions(array($main,$secondary)); 
			
		}
		
		// Creates a radio buttons group
		$radio[] = $form->createElement('radio', null, null, 'On', 1);
		$radio[] = $form->createElement('radio', null, null, 'Off', 0);
		
		$form->addGroup($radio, 'category_image_status', 'Image Status:'); 
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('category', 'Please enter a category', 'required');
			
		if ($form->validate()) {

			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$values['category_image'] = $values['category_image'][1];

			//print_rr($values);
		
			$menuBar['back'] = '/ushop/products/overview';
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'product_categories', array('where' => 'category_id='.$this->registry->params['id']));
				
			if ($res) {
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Category was successfully edited.</h2>';
			} else {
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Category could not be edited.</h2>';
			}
				
			// done!
			
		} else {
				
			$cat_image = $this->getResult('category_id', $ushop->db_name.'products', null, array('where' => "image = '$image'"));
			
			$form->setDefaults(array(
				'category' => $category,
				'category_image_status' => $image_status,
				'category_image' => array($cat_image[0]->category_id, $image)
			));
				
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->registry->admin_config->get ('admin_template', 'SERVER'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
		
			// output the form
			$this->content .= $renderer->toHtml();
		}
		
	}
	
	if (isset($params)) {
		$params['CONTENT'] = $this->makeToolbar($menuBar, 24);
		$this->content .= $this->message($params);
	}
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
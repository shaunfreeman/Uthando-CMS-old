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
	
	if ($this->registry->params['id']):
		
		$rows = $this->getResult('category_id, category, category_image, category_image_status', $ushop->db_name.'product_categories', null, array('where' => 'category_id = '.$this->registry->params['id']));
		
		//$ushop->tree->getTree();
		
		$ushop->tree->id = $this->registry->params['id'];
		
		$ushop->tree->getCategory();
		
		$category = $ushop->tree->getField('category');
		$image = $ushop->tree->getField('category_image');
		$category_id = $ushop->tree->getField('category_id');
		$image_status = $ushop->tree->getField('category_image_status');
		
		$base_dir = __SITE_PATH . "/../userfiles/".$this->registry->settings['resolve']."/products/";
		
		$form = new HTML_QuickForm('edit_category', 'post', $_SERVER['REQUEST_URI']);
		
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','edit_category','Edit Category');
		
		$form->addElement('text', 'category', 'Category:', array('id' => 'category', 'size' => 20, 'maxlength' => 20, 'class' => 'inputbox'));
		
		$form->addElement('hidden', 'category_image');
		
		$tmpl = file_get_contents(__SITE_PATH.'/components/ushop/html/formHtml.html');
		
		$pathway = $ushop->tree->pathway($this->registry->params['id']);
		$parent = end($pathway);
		
		$parent = $this->templateParser($tmpl, array('LABEL' => 'Parent:', 'ELEMENT' => (count($pathway) > 1) ? $parent['category'] : 'None' ), '{', '}');
	
		$form->addElement('html', $parent);
		
		if ($image_status == 1):
			
			if (file_exists($base_dir.$image) && $image != null):
				$img_file = $ushop->img_dir.$image;
			else:
				$img_file = $ushop->img_dir."noimage.png";
			endif;
		else:
			$img_file = "IMAGE OFF";
		endif;
		
		$attrs = 'id="image" class="Tips" title="Shop Tip" rel="Click to edit this category image."';
		
		$img = $this->templateParser($tmpl, array('LABEL' => 'Image:', 'ELEMENT' => ($img_file != 'IMAGE OFF') ? '<img '.$attrs.' src="'.$img_file.'" />' : '<span '.$attrs.'>'.$img_file.'</span>'), '{', '}');
		
		$form->addElement('html', $img);
		
		// Creates a radio buttons group
		$radio[] = $form->createElement('radio', null, null, 'On', 1);
		$radio[] = $form->createElement('radio', null, null, 'Off', 0);
		
		$form->addGroup($radio, 'category_image_status', 'Image Status:'); 
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('category', 'Please enter a category', 'required');
			
		if ($form->validate()):

			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
		
			$menuBar['back'] = $_SESSION['referer_link'];
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'product_categories', array('where' => 'category_id='.$this->registry->params['id']));
				
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Category was successfully edited.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Category could not be edited.</h2>';
			endif;
			// done!
		else:
			
			$form->setDefaults(array(
				'category' => $category,
				'category_image_status' => $image_status,
				'category_image' => $image
			));
				
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->get ('admin_config.site.template'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
			
			$session = Utility::encodeString(session_id());
			$this->addScriptDeclaration("UthandoAdmin.sid = ['" . $session[0] . "','" . $session[1] . "'];");
			
			$this->registry->component_css = array(
				'/templates/'.$this->get('admin_config.site.template').'/css/FileManager.css',
				'/templates/'.$this->get('admin_config.site.template').'/css/Additions.css'
			);
			
			$this->registry->component_js = array(
				'/components/ushop/js/categories.js'
			);
		
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
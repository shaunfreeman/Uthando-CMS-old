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
	
	$tree = new NestedTreeAdmin($ushop->db_name.'product_categories', null, 'category', $this->registry);
	
	$tax_codes = $this->getResult('tax_code_id', $ushop->db_name.'tax_codes');
	$categories = $this->getResult('category_id', $ushop->db_name.'product_categories');
	
	$attr = array();
	
	foreach ($ushop->attributes as $key => $value):
		if ($value) $attr[$key] = $this->getResult('*', $ushop->db_name.$key);
	endforeach;
	
	$attrs = true;
	
	foreach ($attr as $key => $value):
		if (!$value) $attrs = false;
	endforeach;
	
	if ($tax_codes && $categories && $attrs):
			
		$form = new HTML_QuickForm('add_product', 'post', $_SERVER['REQUEST_URI']);
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
		
		$form->addElement('html', '<fieldset id="details">');
		$form->addElement('header','details', 'Details');
		
		$form->addElement('checkbox', 'enabled', 'Enable:');
		
		$form->addElement('text', 'name', 'Product Name:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
		$errors[] = 'name';
		
		$form->addElement('text', 'sku', 'SKU:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
		$errors[] = 'sku';
		
		$items_opts[0] = 'Select One';
		
		foreach ($items = $tree->getTree() as $item):
			$items_opts[$item['category_id']] = str_repeat(str_repeat('&nbsp;',4), ($item['depth'])).$item['category'];
		endforeach;
		
		$s = $form->createElement('select', 'category_id', 'Category:', null, array('id' => 'category'));
		$errors[] = 'category_id';
	
		$s->loadArray($items_opts);
		$form->addElement($s);
		
		$form->addElement('html', '</fieldset>');
		
		// description
		$form->addElement('html', '<fieldset id="description">');
		$form->addElement('header', 'description_header', 'Description');
		
		$form->addElement('text', 'short_description', 'Short Description:', array('size' => 30, 'maxlength' => 255, 'class' => 'inputbox'));
		
		$form->addElement('textarea', 'description', 'Description:', array('class' => 'inputbox', 'cols' => 40, 'rows' => 5, 'id' => 'descr_textarea'));
		
		$form->addElement('html', '</fieldset>');
		$form->addElement('html', '<div class="both"></div>');
		
		// Price
		$form->addElement('html', '<fieldset id="price">');
		$form->addElement('header','price_header','Price');
		
		$form->addElement('text', 'price', 'Price:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
		$errors[] = 'price';
		
		if ($ushop->checkout['stock_control']):
			$form->addElement('text', 'quantity', 'Quantity:', array('size' => 5, 'maxlength' => 5, 'class' => 'inputbox'));
			
			$form->addRule('quantity', 'quatity has to be a number.', 'numeric');
			$errors[] = 'quantity';
		endif;
		
		if ($ushop->checkout['vat_state'] == 1):
		
			$group_radio[] = $form->createElement('radio', null, null, 'Yes', '1');
			$group_radio[] = $form->createElement('radio', null, null, 'No', '0');
			$form->addGroup($group_radio, 'vat_inc', 'Include Tax:');
			$errors[] = 'vat_inc';
		
			$s = $form->createElement('select', 'tax_code_id', 'Tax Code:');
			$opts[0] = 'Select One';
			
			foreach ($ushop->formatTaxCodes() as $code):
				$opts[$code['tax_code_id']] = $code['tax_code'];
			endforeach;
		
			$s->loadArray($opts);
			$form->addElement($s);
			$errors[] = 'taxcode_id';
		else:
			$no_tax = $this->getResult('tax_code_id', $ushop->db_name.'tax_codes', null, array('where' => "tax_code='N'"));
			$form->addElement('hidden', 'tax_code_id', $no_tax[0]->tax_code_id);
			$form->addElement('hidden', 'vat_inc', 0);
		endif;
		
		// price groups.
		$groups = $this->getResult('price_group_id, price_group, price', $ushop->db_name.'price_groups');
		
		if ($groups):
			
			$group_s = $form->createElement('select', 'price_group_id', 'Price Group:');
			$group_opts[0] = 'Select One';
			
			foreach ($groups as $value):
				$group_opts[$value->price_group_id] = $value->price_group . ' - &pound;' . $value->price;
			endforeach;
		
			$group_s->loadArray($group_opts);
			$form->addElement($group_s);
		else:
			$group = $this->templateParser($tmpl, array('LABEL' => 'Price Group:', 'ELEMENT' => 'No groups aviliable'), '{', '}');
			$form->addElement('hidden', 'price_group_id', 0);
			$form->addElement('html', $group);
		endif;
		
		$postage_radio[] = $form->createElement('radio', null, null, 'On', '1');
		$postage_radio[] = $form->createElement('radio', null, null, 'Off', '0');
		$form->addGroup($postage_radio, 'postage', 'Postage:');
		$errors[] = 'postage';
		
		$form->addElement('html', '</fieldset>');
		
		// Attributes.
		$form->addElement('html', '<fieldset id="attributes">');
		$form->addElement('header','attributes_header','Attributes');

		$form->addElement('text', 'weight', 'Weight (grams):', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
		
		foreach ($ushop->attributes as $key => $value):
			require_once('ushop/products/attributes/'.$key.'_form.php');
		endforeach;
		
		$form->addElement('html', '</fieldset>');
		$form->addElement('html', '<div class="both"></div>');
		
		// Image.
		$form->addElement('html', '<fieldset id="image_upload">');
		$form->addElement('header','image_header','Image');
		
		$form->addElement('text','image','Product Image:', array('id' => 'image','class' => 'inputbox'));
		
		$image_radio[] = $form->createElement('radio', null, null, 'On', '1');
		$image_radio[] = $form->createElement('radio', null, null, 'Off', '0');
		$form->addGroup($image_radio, 'image_status', 'Image Status:');
		$errors[] = 'image_status';
		
		$form->addElement('html', '</fieldset>');
		
		$form->addElement('html', '<div class="both"></div>');
		
		$form->addRule('name', 'Please enter a product name.', 'required');
		$form->addRule('sku', 'Please enter a product sku.', 'required');
		$form->addRule('category_id', 'Please select a category.', 'required');
		$form->addRule('category_id', 'Please select a category.', 'nonzero');
		
		$form->addRule('price', 'Please enter a price.', 'required');
		$form->addRule('price', 'Prices have to be numeric.', 'numeric');
		$form->addRule('postage', 'Please choose weather to postage is turned on or off.', 'required');
		$form->addRule('tax_code_id', 'Please select a tax code.', 'required');
		$form->addRule('vat_inc', 'Please choose if VAT is included or not.', 'required');
		
		$form->addRule('image_status', 'Please choose weather to display an image or not.', 'required');
			
		if ($form->validate()):
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'));
			
			$menuBar['add_product'] = '/ushop/products/action-new_product';
			$menuBar['back'] = $_SESSION['referer_link'];
			
			//check then enter the record.
			if (!$this->getResult('product_id', $ushop->db_name.'products', null, array('where' => "name='".$values['name']."'"))):
				
				$res = $this->insert($values, $ushop->db_name.'products');
			
				if ($res):
					$params['TYPE'] = 'pass';
					$params['MESSAGE'] = '<h2>Product was successfully entered.</h2>';
				else:
					$params['TYPE'] = 'error';
					$params['MESSAGE'] = '<h2>Product could not be entered into the database.</h2>';
				endif;
			else:
				$params['TYPE'] = 'warning';
				$params['MESSAGE'] = '<h2>This product already exits.</h2>';
			endif;
			// done!
		else:
				
			//$this->content .= $this->getTabs(array('details', 'description', 'price', 'attributes', 'image'));
			
			$session = Utility::encodeString(session_id());
			$this->addScriptDeclaration("UthandoAdmin.sid = ['" . $session[0] . "','" . $session[1] . "'];");
			
			$this->loadJavaScript(array(
				'/Common/editor/tiny_mce/tiny_mce_gzip.js',
				'/Common/js/tinyMCEGz.js'
			));
			
			$this->registry->component_css = array(
				'/templates/'.$this->get('admin_config.site.template').'/css/FileManager.css',
				'/templates/'.$this->get('admin_config.site.template').'/css/Additions.css'
			);
			
			$this->registry->component_js = array(
				'/components/ushop/js/products.js'
			);
			
			foreach ($errors as $value):
				$err = $form->getElementError($value);
				if ($err) $this->registry->Warning($err);
			endforeach;
			
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->get ('admin_config.site.template'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
		
			// output the form
			$this->content .= $renderer->toHtml();
		endif;
	else:
		$params['TYPE'] = 'info';
		
		if (!$tax_codes):
			$params['MESSAGE'] = '<h2>First define some tax codes.</h2>';
		elseif (!$categories):
			$params['MESSAGE'] = '<h2>First define some categories.</h2>';
		else:
			$params['MESSAGE'] = '<h2>First define some attributes.</h2>';
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
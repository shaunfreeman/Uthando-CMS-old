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
	
	$tree = new NestedTreeAdmin($ushop->db_name.'product_categories', null, 'category', $this->registry);
	
	if ($this->registry->params['id']) {
		
		$row = $this->getResult('*', $ushop->db_name.'products', null, array('where' => 'product_id = '.$this->registry->params['id']), false);
		
		$tmpl = file_get_contents(__SITE_PATH.'/components/ushop/html/formHtml.html');
		
		$errors = array();
			
		$form = new HTML_QuickForm('edit_product', 'post', $_SERVER['REQUEST_URI']);
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
		
		//$form->addElement('html', '<div id="panelSet">');
		// Details.
		$form->addElement('html', '<div id="details" class="morphtabs_panel"><div class="panel_content">');
		//$form->addElement('header','details','Details');
		
		$form->addElement('checkbox', 'enabled', 'Enable:');
		$form->addElement('checkbox', 'discontinued', 'Discontinue:');
		
		$form->addElement('text', 'name', 'Product Name:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
		$errors[] = 'name';
		
		$form->addElement('text', 'sku', 'SKU:', array('size' => 20, 'maxlength' => 60, 'class' => 'inputbox'));
		$errors[] = 'sku';
		
		$items_opts[0] = 'Select One';
		
		foreach ($items = $tree->getTree() as $item) {
			$items_opts[$item['category_id']] = str_repeat(str_repeat('&nbsp;',4), ($item['depth'])).$item['category'];
		}
		
		$s = $form->createElement('select', 'category_id', 'Category:');
		$errors[] = 'category_id';
	
		$s->loadArray($items_opts);
		$form->addElement($s);
		
		$form->addElement('html', '</div></div>');
		
		// description
		$form->addElement('html', '<div id="description" class="morphtabs_panel"><div class="panel_content">');
		
		$form->addElement('text', 'short_description', 'Short Description:', array('size' => 30, 'maxlength' => 255, 'class' => 'inputbox'));
		
		$form->addElement('textarea', 'description', 'Description:', array('class' => 'inputbox', 'cols' => 40, 'rows' => 5, 'id' => 'descr_textarea'));
		
		$form->addElement('html', '</div></div>');
		
		// Price
		$form->addElement('html', '<div id="price" class="morphtabs_panel"><div class="panel_content">');
		//$form->addElement('header','price_header','Price');
		
		$form->addElement('text', 'price', 'Price:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
		$errors[] = 'price';
		
		if ($ushop->CHECKOUT['stock_control']) {
			$form->addElement('text', 'quantity', 'Quantity:', array('size' => 5, 'maxlength' => 5, 'class' => 'inputbox'));
			
			$form->addRule('quantity', 'quatity has to be a number.', 'numeric');
			$errors[] = 'quantity';
		}
		
		if ($ushop->CHECKOUT['vat_state'] == 1) {
		
			$group_radio[] = $form->createElement('radio', null, null, 'Yes', '1');
			$group_radio[] = $form->createElement('radio', null, null, 'No', '0');
			$form->addGroup($group_radio, 'vat_inc', 'Include Tax:');
			$errors[] = 'vat_inc';
		
			$s = $form->createElement('select', 'tax_code_id', 'Tax Code:');
			$opts[0] = 'Select One';
			
			foreach ($ushop->formatTaxCodes() as $code) {
				$opts[$code['tax_code_id']] = $code['tax_code'];
			}
		
			$s->loadArray($opts);
			$form->addElement($s);
			$errors[] = 'taxcode_id';
		} else {
			$no_tax = $this->getResult('tax_code_id', $ushop->db_name.'tax_codes', null, array('where' => "tax_code='N'"));
			$form->addElement('hidden', 'tax_code_id', $no_tax[0]->tax_code_id);
			$form->addElement('hidden', 'vat_inc', 0);
		}
		
		// price groups.
		$groups = $this->getResult('price_group_id, price_group, price', $ushop->db_name.'price_groups');
		
		if ($groups) {
			
			$group_s = $form->createElement('select', 'price_group_id', 'Price Group:');
			$group_opts[0] = 'Select One';
			
			foreach ($groups as $value) {
				$group_opts[$value->price_group_id] = $value->price_group . ' - &pound;' . $value->price;
			}
		
			$group_s->loadArray($group_opts);
			$form->addElement($group_s);
		} else {
			$group = $this->templateParser($tmpl, array('LABEL' => 'Price Group:', 'ELEMENT' => 'No groups aviliable'), '{', '}');
			$form->addElement('hidden', 'price_group_id', 0);
			$form->addElement('html', $group);
		}
		
		$postage_radio[] = $form->createElement('radio', null, null, 'On', '1');
		$postage_radio[] = $form->createElement('radio', null, null, 'Off', '0');
		$form->addGroup($postage_radio, 'postage', 'Postage:');
		$errors[] = 'postage';
		
		$form->addElement('html', '</div></div>');
		//$form->addElement('html', '<div class="both"></div>');
		
		// Attributes.
		$form->addElement('html', '<div id="attributes" class="morphtabs_panel"><div class="panel_content">');
		//$form->addElement('header','attributes_header','Attributes');

		$form->addElement('text', 'weight', 'Weight (grams):', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
		
		foreach ($ushop->ATTRIBUTES as $key => $value) {
			require_once('ushop/products/attributes/'.$key.'_form.php');
		}
		
		$form->addElement('html', '</div></div>');
		
		// Image.
		$form->addElement('html', '<div id="image" class="morphtabs_panel"><div class="panel_content">');
		//$form->addElement('header','image_header','Image');
		$base_dir = realpath(__SITE_PATH . "/../components/ushop/images/products");
		
		if ($row->image_status == 1) {
	
			if (file_exists($base_dir.'/'.$row->image) && $row->image != null) {
				
				$form->addElement('checkbox', 'delete_image', 'Delete Image:');
				
				$img_file = $ushop->img_dir.$row->image;
		
			} else {
				$img_file = $ushop->img_dir."nopic.jpg";
			}
		} else {
			$img_file = "IMAGE OFF";
		}
		
		$img = $this->templateParser($tmpl, array('LABEL' => 'Current Image:', 'ELEMENT' => '<img src="'.$img_file.'" />'), '{', '}');
		
		$form->addElement('html', $img);
		
		$form->addElement('checkbox', 'upload_image', 'Upload Image:', null, array('id' => 'upload_image'));
		
		$form->addElement('file','image','Product Image:');
		
		$image_radio[] = $form->createElement('radio', null, null, 'On', '1');
		$image_radio[] = $form->createElement('radio', null, null, 'Off', '0');
		$form->addGroup($image_radio, 'image_status', 'Image Status:');
		$errors[] = 'image_status';
		
		$form->addElement('html', '</div></div>');
		//$form->addElement('html', '<div class="both"></div>');
		//$form->addElement('html', '</div>');
		
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
			
		if ($form->validate()) {
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'));
			
			$menuBar['back'] = '/ushop/products/overview';
			
			if ($values['sku'] != $row->sku && !$values['upload_image'] && $row->image) {
				
				$old_name = explode('.', $row->image);
				
				$new_name = $values['sku'].'.'.$old_name[1];
				
				$ftp = new File_FTP($this->registry);
				
				if ($ftp) {
					$rename = $ftp->rename ($login['public_html'] . '/components/ushop/images/products/' . $row->image, $login['public_html'] . '/components/ushop/images/products/' . $new_name);
					
					if (PEAR::isError($rename)) {
						$this->registry->Error($rename->getMessage());
						$this->registry->Error("The file could not be renamed to $new_name.");
					} else {
						$values['image'] = $new_name;
					}
					
					$ftp->disconnect();
				} else {
					$this->registry->Error("The file could not be renamed to $new_name.");
				}
			}
			
			if ($values['delete_image'] && $row->image != null) {
				$di = true; // set delete flag.
				
				if (!is_array($values['image'])) {
					$i = $values['image'];
				} else {
					$i = $row->image;
				}
		
				if ($i) {
					$ftp = new File_FTP($this->registry);
					if ($ftp) {
						$delete = $ftp->rm ($login['public_html'] . '/components/ushop/images/products/' . $i);
			
						if (PEAR::isError($delete)) {
							$this->registry->Error($delete->getMessage());
							$di = false;
						}
						$values['image'] = 'NULL';
						$ftp->disconnect();
					} else {
						$di = false;
					}
				} else {
					$di = false;
				}
			}
			unset ($values['delete_image']);
			
			if ($values['upload_image'] == 1) {
				
				$file_exts = array('png', 'gif', 'jpeg', 'jpg');
				
				$upload = explode('.', $values['image']['name']);
				// Rename files to the sku.
				
				if (in_array(end($upload), $file_exts)) {
					
					$new_name = $values['sku'].'.'.end($upload);
					
					$file =& $form->getElement('image');
					
					if ($file->moveUploadedFile($_SERVER['DOCUMENT_ROOT'] . '/Common/tmp', $new_name)) {
						
						$ftp = new File_FTP($this->registry);
						
						if ($ftp) {
							$image_save = $ftp->put($_SERVER['DOCUMENT_ROOT'].'/Common/tmp/'.$new_name, $login['public_html'].'/components/ushop/images/products/'.$new_name, true, FTP_BINARY);
						
							if (PEAR::isError($image_save)) {
								$this->registry->Error($image_save->getMessage(), "The file could not be uploaded to /components/ushop/images/products/$new_name.");
								$new_name = null;
							}
							$ftp->disconnect();
						}
						
						unlink($_SERVER['DOCUMENT_ROOT'].'/Common/tmp/'.$new_name);
						
					} else {
						$this->registry->Error("The file could not be uploaded to /tmp/$new_name.");
					}
					
				} else {
					
					$new_name = null;
					
				}
				
				$values['image'] = $new_name;
				
			} else {
				if (is_array($values['image'])) unset($values['image']);
			}
			
			
			if (!$values['enabled']) $values['enabled'] = 0;
			
			unset($values['MAX_FILE_SIZE'], $values['upload_image']);
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'products', array('where' => 'product_id='.$this->registry->params['id']));
				
			if ($res) {
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Product was successfully edited.</h2>';
			} else {
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Product could not be edited.</h2>';
			}
				
			// done!
			
		} else {
				
			$form->setDefaults(array(
				'enabled' => $row->enabled,
				'discontinued' => $row->discontinued,
				'name' => $row->name,
				'sku' => $row->sku,
				'category_id' => $row->category_id,
				'short_description' => $row->short_description,
				'description' => $row->description,
				'price' => $row->price,
				'price_group_id' => $row->price_group_id,
				'postage' => $row->postage,
				'weight' => $row->weight,
				'author_id' => $row->author_id,
				'isbn' => $row->isbn,
				'image_status' => $row->image_status,
				'quantity' => $row->quantity
			));
				
			$tab_array = array('details' => null, 'description' => null, 'price' => null, 'attributes' => null, 'image' => null);
			
			foreach ($errors as $value) {
				$err = $form->getElementError($value);
				if ($err) $this->registry->Warning($err);
			}
			
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->registry->admin_config->get ('admin_template', 'SERVER'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
		
			$form->accept($renderer);
		
			// output the form
			$tabs = new HTML_Tabs($tab_array, true);
			$tabs->addPanels($renderer->toHtml());
			$this->content .= $tabs->toHtml();
			
			$this->loadJavaScript(array(
				'/Common/editor/tiny_mce/tiny_mce_gzip.js',
				'/Common/js/tinyMCEGz.js'
			));
		
		} 
	} else {
	
		$params['TYPE'] = 'info';
		
		if (!$tax_codes) {
			$params['MESSAGE'] = '<h2>First define some tax codes.</h2>';
		} elseif (!$categories) {
			$params['MESSAGE'] = '<h2>First define some categories.</h2>';
		} else {
			$params['MESSAGE'] = '<h2>First define some attributes.</h2>';
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
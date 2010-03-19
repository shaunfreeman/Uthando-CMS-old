<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	referer();
	
	$productsBar = array(
		'back' => '/ushop/overview'
	);
	
	unset($menuBar['products']);
	
	$tax_codes = $this->getResult('tax_code_id', $ushop->db_name.'tax_codes');
	
	$tab_array = array();
	
	switch ($this->registry->params['view']):
		case 'categories':
			require_once('ushop/products/categories.php');
			break;
		case 'groups':
			require_once('ushop/products/groups.php');
			break;
		case 'attr':
			require_once('ushop/products/attributes/'.$this->registry->params[0].'.php');
			break;
		case 'products':
		default:
			require_once('ushop/products/products.php');
			break;
	endswitch;
	
	$tab_array = array('products', 'categories', 'groups');
	
	foreach ($ushop->attributes as $key => $value):
		if ($value) array_push($tab_array, 'attr/'.$key);
	endforeach;
	
	$menuBar = array_merge($productsBar, $menuBar);
	
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	if ($this->registry->params['view'] == 'attr'):
		$id = $this->registry->params[0];
	elseif ($this->registry->params['view']):
		$id = $this->registry->params['view'];
	else:
		$id = 'products';
	endif;
	
	//$tabs = new HTML_Tabs($tab_array, true);
	$doc = new HTML_Element();
	$tabs = $doc->createElement('ul', null, array('id' => $id, 'class' => 'product_tabs'));
	
	foreach ($tab_array as $tab):
		$class = 'gradient';
		$tabTitle = str_replace('attr/', '', $tab);
		if ($tabTitle == $id) $class .= ' active';
		$li = $doc->createElement('li', null, array('class' => $class, 'title' => $tabTitle));
		$a = $doc->createElement('a', ucwords(str_replace('_', ' ', $tabTitle)), array('href' => '/ushop/products/view-'.$tab));
		$li->appendChild($a);
		$tabs->appendChild($li);
	endforeach;
	
	$doc->appendChild($tabs);
	
	$this->content .= $doc->toHtml();
	$this->content .= '<div id="productsWrap" class="both">'.$data.'</div>';
endif;
?>
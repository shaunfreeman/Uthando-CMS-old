<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$productsBar = array(
		'back' => '/ushop/overview'
	);
	
	$tax_codes = $this->getResult('tax_code_id', $ushop->db_name.'tax_codes');
	
	$tab_array = array();
	
	require_once('ushop/products/products.php');
	require_once('ushop/products/attributes/overview.php');
	require_once('ushop/products/categories.php');
	require_once('ushop/products/groups.php');
	
	$menuBar = array_merge($productsBar, $menuBar);
	
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$tabs = new HTML_Tabs($tab_array);
	$this->content .= $tabs->toHtml();
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
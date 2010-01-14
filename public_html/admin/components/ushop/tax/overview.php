<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
		'back' => '/ushop/overview',
		'new_tax_codes' => '/ushop/tax/action-new_tax_code',
		'new_tax_rates' => '/ushop/tax/action-new_tax_rate',
		'seperator' => null,
		'customers' => '/ushop/customers',
		'products' => '/ushop/products',
		'postage' => '/ushop/postage'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$ushop = new UShopAdmin();
	
	$tax_rates = $ushop->getTaxRates(true);
	
	require_once('ushop/tax/tax_codes.php');
	require_once('ushop/tax/tax_rates.php');
			
	$tab_array = array('tax_codes' => $display_codes, 'tax_rates' => $display_rates);
	
	$tabs = new HTML_Tabs($tab_array);
	$this->content .= $tabs->toHtml();
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
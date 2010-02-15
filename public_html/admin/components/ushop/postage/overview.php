<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$postageBar = array(
		'back' => '/ushop/overview',
		'new_zone' => '/ushop/postage/action-new_zone',
		'new_country' => '/ushop/postage/action-new_country',
		'new_level' => '/ushop/postage/action-new_level',
		'new_cost' => '/ushop/postage/action-new_cost',
		'seperator' => ''
	);
		
	$this->content .= $this->makeToolbar(array_merge($postageBar,$menuBar), 24);
	
	$tax_codes = $this->getResult('tax_code_id', $ushop->db_name.'tax_codes');
	
	require_once('ushop/postage/zones.php');
	require_once('ushop/postage/countries.php');
	require_once('ushop/postage/levels.php');
	require_once('ushop/postage/costs.php');
			
	$tab_array = array('zones' => $zones, 'countries' => $countries, 'levels' => $levels, 'costs' => $costs);
	
	$tabs = new HTML_Tabs($tab_array);
	$this->content .= $tabs->toHtml();
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
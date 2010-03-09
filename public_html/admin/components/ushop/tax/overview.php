<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$taxBar = array(
		'back' => '/ushop/overview',
		'new_tax_codes' => '/ushop/tax/action-new_tax_code',
		'new_tax_rates' => '/ushop/tax/action-new_tax_rate'
	);
		
	$this->content .= $this->makeToolbar(array_merge($taxBar,$menuBar), 24);
	
	$tax_rates = $ushop->getTaxRates(true);
	
	require_once('ushop/tax/tax_codes.php');
	require_once('ushop/tax/tax_rates.php');
			
	$tab_array = array('tax_codes' => $display_codes, 'tax_rates' => $display_rates);
	
	$tabs = new HTML_Tabs($tab_array);
	$this->content .= $tabs->toHtml();
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
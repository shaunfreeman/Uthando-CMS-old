<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
   		'customers' => '/ushop/customers',
   		'products' => '/ushop/products',
   		'postage' => '/ushop/postage'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	$ushop = new UShopAdmin();
		
	if ($this->registry->params['comfirm'] == 'delete') {
		
		$res = $this->remove($ushop->db_name.'tax_rates', 'tax_rate_id='.$this->registry->params['id']);
			
		if ($res) {
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Tax rate was successfully deleted.</h2>';
				
		} else {
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Tax rate could not be deleted due to an error.</h2>';
		}
				
		// done!
		$menuBar = array('back' => '/ushop/tax/overview');
			
	} else {
		
		$menuBar = array(
			'cancel' => '/ushop/tax/overview',
			'delete' => '/ushop/tax/action-delete_tax_rate/id-' . $this->registry->params['id'] . '/comfirm-delete'
		);
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'Are you sure you want to delete this tax rate';
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
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
   		'customers' => '/ushop/customers',
   		'products' => '/ushop/products',
   		'tax' => '/ushop/tax'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
	
	$ushop = new UShopAdmin();
		
	if ($this->registry->params['comfirm'] == 'delete') {
		
		$res = $this->remove($ushop->db_name.'post_zones', 'post_zone_id='.$this->registry->params['id']);
			
		if ($res) {
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Post zone was successfully deleted.</h2>';
				
		} else {
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Post zone could not be deleted due to an error.</h2>';
		}
				
		// done!
		$menuBar = array('back' => '/ushop/postage/overview');
			
	} else {
		
		$menuBar = array(
			'cancel' => '/ushop/postage/overview',
			'delete' => '/ushop/postage/action-delete_zone/id-' . $this->registry->params['id'] . '/comfirm-delete'
		);
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'Are you sure you want to delete this post zone';
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
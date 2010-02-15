<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$menuBar = array(
   		'customers' => '/ushop/customers',
   		'postage' => '/ushop/postage',
   		'tax' => '/ushop/tax'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
		
	if ($this->registry->params['comfirm'] == 'delete') {
		
		$tree = new NestedTreeAdmin($ushop->db_name.'product_categories', $this->registry->params['id'], 'category');
		
		$res = $tree->remove($this->registry->params['id']);
			
		if ($res) {
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Category was successfully deleted.</h2>';
				
		} else {
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Category could not be deleted due to an error.</h2>';
		}
				
		// done!
		$menuBar = array('back' => '/ushop/products/overview');
			
	} else {
		
		$menuBar = array(
			'cancel' => '/ushop/products/overview',
			'delete' => '/ushop/products/action-delete_category/id-' . $this->registry->params['id'] . '/comfirm-delete'
		);
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'Are you sure you want to delete this category';
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
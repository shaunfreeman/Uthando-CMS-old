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
	
	$ushop = new UShopAdmin();
		
	if ($this->registry->params['comfirm'] == 'delete') {
		
		$res = $this->remove($ushop->db_name.'authors', 'author_id='.$this->registry->params['id']);
			
		if ($res) {
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Author was successfully deleted.</h2>';
				
		} else {
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Author could not be deleted due to an error.</h2>';
		}
				
		// done!
		$menuBar = array('back' => '/ushop/products/overview');
			
	} else {
		
		$menuBar = array(
			'cancel' => '/ushop/products/overview',
			'delete' => '/ushop/products/action-delete_attribute/attr-author/id-' . $this->registry->params['id'] . '/comfirm-delete'
		);
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'Are you sure you want to delete this author';
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
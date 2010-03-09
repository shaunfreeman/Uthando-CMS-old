<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array();
		
	if ($this->registry->params['comfirm'] == 'delete'):
		
		// delete image file first.
		$login = $this->registry->admin_config->get('FTP');
		
		$row = $this->getResult('image', $ushop->db_name.'products', null, array('where' => 'product_id='.$this->registry->params['id']));
		
		$di = true; // set delete flag.
		
		if ($row):
			$ftp = new File_FTP($this->registry);
				
			if ($ftp):
				$delete = $ftp->rm($login['public_html'] . '/components/ushop/images/products/' . $row[0]->image);
					
				if (!$delete) $di = false;
				
				$ftp->disconnect();
			else:
				$di = false;
			endif;
		else:
			$di = false;
		endif;
		
		$res = $this->remove($ushop->db_name.'products', 'product_id='.$this->registry->params['id']);
			
		if ($res):
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Product was successfully deleted.</h2>';
		else:
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Product could not be deleted due to an error.</h2>';
		endif;
		
		if (!$di):
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Product image could not be deleted due to an error. Please delete manually</h2>';
			$this->registry->Error("Product image, ".$row[0]->image.", could not be deleted due to an error. Please delete manually");
		endif;
				
		// done!
		$menuBar = array('back' => '/ushop/products/overview');
	else:
		
		$menuBar = array(
			'cancel' => '/ushop/products/overview',
			'delete' => '/ushop/products/action-delete_product/id-' . $this->registry->params['id'] . '/comfirm-delete'
		);
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'Are you sure you want to delete this product';
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
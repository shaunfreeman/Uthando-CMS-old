<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array();
		
	if ($this->registry->params['comfirm'] == 'delete'):
		
		$tree = new NestedTreeAdmin($ushop->db_name.'product_categories', $this->registry->params['id'], 'category');
		
		$res = $tree->remove($this->registry->params['id']);
			
		if ($res):
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Category was successfully deleted.</h2>';
				
		else:
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Category could not be deleted due to an error.</h2>';
		endif;
				
		// done!
		$menuBar = array('back' => $_SESSION['referer_link']);
	else:
		
		$menuBar = array(
			'cancel' => $_SESSION['referer_link'],
			'delete' => '/ushop/products/action-delete_category/id-' . $this->registry->params['id'] . '/comfirm-delete'
		);
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'Are you sure you want to delete this category';
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
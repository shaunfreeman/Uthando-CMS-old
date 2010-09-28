<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id']) && isset($this->registry->params['item']) && $this->upid <= 2):
		
		if (isset($this->registry->params['itemAction']) == 'delete'):
			
			// start tree class
			$tree = new Admin_NestedTree($this->registry->core.'menu_items', $this->registry->params['item'], 'item');
			
			// Update menu item table.
			$item = $tree->getCategory();
			
			if ($item):
				
				$result = $this->getResult('item_id', $this->registry->core.'menu_items', null, array('where' => 'url_id='.$item['url_id']));
				
				if ($result):
					$num_rows = count($result);
				else:
					$pass = false;
				endif;
				
				// if just one url depends on this item then delete it.
				if ($num_rows == 1):
					
					$result = $this->remove($this->registry->core.'menu_urls', 'url_id='.$item['url_id']);
					
					$pass = ($result) ?  true : false;
					
				endif;
			endif;
			
			if ($num_rows):
				$result = $tree->remove($this->registry->params['item']);
				
				$pass = ($result) ?  true : false;
				
			endif;
			
			if ($pass):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Menu item was successfully deleted.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Menu item could not be deleted due to an error.</h2>';
			endif;
			
			$menuBar = array('back' => '/menu/view/id-' . $this->registry->params['id']);
			
		else:
			
			$menuBar = array(
				'cancel' => '/menu/view/id-' . $this->registry->params['id'],
				'delete' => '/menu/view/id-' . $this->registry->params['id'] . '/action-delete/itemAction-delete/item-' . $this->registry->params['item']
			);
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = 'Are you sure you want to delete this menu item';
			
		endif;
	else:
		$menuBar['back']= '/menu/view/overview';
		$params['TYPE'] = 'error';
		$params['MESSAGE'] = 'You do not have permission to delete this menu item';
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
endif;
?>
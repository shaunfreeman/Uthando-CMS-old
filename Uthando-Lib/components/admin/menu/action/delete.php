<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id']) && $this->upid <= 2):
		
		if (isset($this->registry->params['action']) == 'delete'):
			
			$tree = new Admin_NestedTree($this->registry->core.'menu_items', $this->registry->params['id'], 'item');
			
			$res = $tree->remove($this->registry->params['id']);
			
			// Always check that result is not an error
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Menu was successfully deleted.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Menu could not be deleted due to an error.</h2>';
			endif;
			
			$menuBar = array('back' => '/menu/overview');
			
		else:
			
			$menuBar = array(
				'cancel' => '/menu/overview',
				'delete' => '/menu/delete/id-' . $this->registry->params['id'] . '/action-delete'
			);
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = 'Are you sure you want to delete this menu';
			
		endif;
	else:
		$menuBar['back']= '/menu/overview';
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'You do not have permission to delete this menu';
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
endif;
?>
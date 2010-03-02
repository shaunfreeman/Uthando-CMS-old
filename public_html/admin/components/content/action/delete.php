<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id']) && $this->upid <= 2):
		
		if (isset($this->registry->params['action']) == 'delete'):
			
			$res = $this->remove($this->registry->core.'pages', 'page_id='.$this->registry->params['id']);
			
			// Always check that result is not an error
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Page was successfully deleted.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Page could not be deleted due to an error.</h2>';
			endif;
			
			$menuBar = array('back' => '/content/overview');
			
		else:
			
			$menuBar = array(
				'cancel' => '/content/overview',
				'delete' => '/content/delete/id-' . $this->registry->params['id'] . '/action-delete'
			);
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = 'Are you sure you want to delete this page';
		endif;
	else:
		$menuBar['back']= '/content/overview';
		$params['TYPE'] = 'warning';
		$params['MESSAGE'] = 'You do not have permission to delete this page';
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
endif;
?>
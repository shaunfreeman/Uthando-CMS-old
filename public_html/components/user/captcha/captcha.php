<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
	
	$action = split(":", $action);

	switch($action[1]) {
		
		case 'validate':
			if ($form->validate()) {
				require_once('user/validate/'.$action[0].'.php');
			} else {
				if ($action[0] == 'login') $_SESSION['rand_chars'] = $rand_chars;
				$this->addContent($form->toHtml());
			}
			break;
			
		case 'display':
		default:
			if ($action[0] == 'login') $_SESSION['rand_chars'] = $rand_chars;
			$this->addContent($form->toHtml());
			break;
	}

?>
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	if (isset($this->registry->params['action'])) {
		$action = $this->registry->params['action'];
	} else {
		$action = 'overview';	
	}
	
	$result = $this->getResult(
		'item',
		$this->registry->core.'menu_items',
		null,
		array('where' => 'item_id='.$this->registry->params['id']),
		false
	);
	
	$title .= " : " . ucwords($result->item) . " " . ucwords($action);
	
	require_once('menu/items/'.$action.'.php');
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
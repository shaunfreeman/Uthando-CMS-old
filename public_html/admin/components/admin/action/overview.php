<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$res = $this->registry->db->getResult('component', $this->db_default.'components', null, array('WHERE' => 'enabled=1'), false);
	
	foreach ($res as $value):
		if ($value->component == 'admin') continue;
		$menuBar[$value->component.'_manager'] = '/'.$value->component.'/overview';
	endforeach;
	
	ksort($menuBar);
	$this->content .= $this->makeToolbar($menuBar, 128);
	

} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
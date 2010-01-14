<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$menu = $this->registry->db->getResult(
	'item_id, menu_type, item',
	'menu_items',
	$this->registry->core.'menu_types',
	array(
		'where' => "item='".$params['menu']."'"
	),
	false
);

if ($menu) {
	
	$params['menu_category_id'] = $menu->item_id;
	// Start Navibar class.
	$navibar = new HTML_Menu($this->registry, $params);
		
	$module = $navibar->getMenu($menu->item_id, $menu->item, $menu->menu_type);

	$mod_data = $this->createDocumentFragment(htmlspecialchars($module));
	//$mod_data->appendXML($module);
	$this->module_wrap->appendChild($mod_data);
	
	unset($navibar);
}

?>

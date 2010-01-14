<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$tree = new NestedTree($this->registry->core.'menu_items', null, 'item');
	
	$tree->linked_columns = array(
		'menu_type' => $this->registry->core.'menu_types'
	);
	
	$menus = $tree->getTopLevelTree();
	
	if (count($menus) > 0) {
		$c = 0;
		$data = array();
	
		foreach ($menus as $row) {
			
			$tree->setId($row['item_id']);
		
			$num_items = $tree->numDecendants(true);
			
			$data[$c] = array(
				$row['item'],
				$row['menu_type'],
				''.$num_items.'',
				'<a href="/menu/edit/id-'.$row['item_id'].'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/24x24/Edit3.png" class="Tips" title="Edit Menu" rel="Click to edit the '.$row['item'].' menu" /></a>',
			
				'<a href="/menu/view/id-'.$row['item_id'].'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/24x24/Preview.png" class="Tips" title="View Menu" rel="Click to view the '.$row['item'].' items" /></a>',
			
				'<a href="/menu/delete/id-'.$row['item_id'].'"><img src="/templates/'.$this->registry->template.'/images/24x24/DeleteRed.png" class="Tips" title="Delete Menu" rel="Click to delete the '.$row['item'].' menu" /></a>'
			);
		
			$c++;
		}
		
		$header = array('Menu', 'Menu Type', 'Items', '', '', '');
	
		$table = $this->dataTable($data, $header);
		
	} else {
		$params = array(
			'TYPE' => 'info',
			'MESSAGE' => '<h2>There are currently no records.</h2>'
		);
	}
	
	$menuBar = array(
		'new_menu' => '/menu/new',
	);
	
	$this->content .= $this->makeToolbar($menuBar, 24);

	if (count($menus) > 0) {
		$this->content .= '<div id="tableWrap">';
	
		$this->content .= $table->toHtml();
		$this->content .= '</div>';
	} else {
		$this->content .= $this->message($params);
	}

} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
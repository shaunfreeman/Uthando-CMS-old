<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	// start tree class
	$tree = new NestedTree($this->registry->core.'menu_items', $this->registry->params['id'], 'item');
	
	$rows = $tree->numDecendants(true);
	
	$menuBar = array(
		'menus' => '/menu/overview',
		'new_link' => '/menu/view/id-'.$this->registry->params['id'].'/action-new'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	if ($rows > 0):
		
		$items = $tree->getDecendants(true);
		
		$c = 0;
		$data = array();
		
		foreach ($items as $row):
			
			if ($row['depth'] > 0):
				if ($row['depth'] > 1):
					$r = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',($row['depth'] - 1));
					$r .= "&bull;&nbsp;".$row['item'];
					$data[$c][] = $r;
				else:
					$data[$c][] = $row['item'];
				endif;
			
				$data[$c][] = '<a href="/menu/view/id-'.$this->registry->params['id'].'/action-edit/item-'.$row['item_id'].'"><img src="/images/24x24/Edit3.png" class="Tips" title="Edit Item" rel="Click to edit the '.$row['item'].' menu" /></a>';
	
				$data[$c][] = '<a href="/menu/view/id-'.$this->registry->params['id'].'/action-delete/item-'.$row['item_id'].'" ><img src="/images/24x24/DeleteRed.png" class="Tips" title="Delete item" rel="Click to delete the '.$row['category'].' item" /></a>';
			
				$c++;
			endif;
		endforeach;
		
		$header = array('Menu Item', '', '');
	
		$table = $this->dataTable($data, $header);
		
	else:
		$params = array(
			'TYPE' => 'info',
			'MESSAGE' => '<h2>There are currently no records.</h2>'
		);
	endif;
	
	if ($rows > 0):
		$this->content .= '<div id="tableWrap">';
	
		$this->content .= $table->toHtml();
		$this->content .= '</div>';
	else:
		$this->content .= $this->message($params);
	endif;
endif;
?>
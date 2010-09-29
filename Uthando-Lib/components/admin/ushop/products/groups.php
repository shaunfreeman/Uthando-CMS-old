<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$display = $ushop->getDisplay('group');
	
	$num = count($this->getResult('price_group_id', $ushop->db_name.'price_groups'));
		
	$start = (isset($this->registry->params['gstart']) ? $this->registry->params['gstart'] : 0);
				
	if ($num > $display):
		$paginate = new HTML_Paginate('groups', $start, '/ushop/products/gstart-{start}/view-groups', $num, $display, false);
		$this->content .= $paginate->toHTML();
	endif;
	
	if ($groups = $this->getResult('price_group_id, price_group, price', $ushop->db_name.'price_groups', null, array('LIMIT' => "$start, $display"))):
		
		$c = 0;
		$data = array();
		
		foreach ($groups as $row):
			
			$data[$c][] = $row->price_group;
			$data[$c][] = $row->price;
				
			$data[$c][] = '<a href="/ushop/products/action-edit_group/id-'.$row->price_group_id.'"  style="text-decoration:none;" ><img src="/images/24x24/Edit3.png" class="Tips" title="Edit Price Group" rel="Click to edit this price group." /></a>';
			$data[$c][] = '<a href="/ushop/products/action-delete_group/id-'.$row->price_group_id.'" ><img src="/images/24x24/Delete.png" class="Tips" title="Delete Price Group" rel="Click to delete this price group" /></a>';
			
			$c++;
		endforeach;
		
		$header = array('Group', 'Price', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$data = $table->toHtml();
	else:
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
	endif;
	
	if (isset($params)) $data = $this->message($params);
	
	$productsBar['new_group'] = '/ushop/products/action-new_group';
	
	//$tab_array['groups'] = $groups;
endif;
?>
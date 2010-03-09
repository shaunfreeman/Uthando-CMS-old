<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($rows = $this->getResult('post_cost_id, post_level, zone, cost',$ushop->db_name.'post_costs', array($ushop->db_name.'post_zones', $ushop->db_name.'post_levels'), array('ORDER BY' => 'zone, post_level, cost'))):
		
		$c = 0;
		$data = array();
		
		foreach ($rows as $row):
			
			$data[$c][] = $row->cost;
			$data[$c][] = $row->post_level;
			$data[$c][] = $row->zone;
				
			$data[$c][] = '<a href="/ushop/postage/action-edit_cost/id-'.$row->post_cost_id.'"  style="text-decoration:none;" ><img src="/templates/'.$template.'/images/24x24/Edit3.png" class="Tips" title="Edit Post Cost" rel="Click to edit this post cost." /></a>';
			$data[$c][] = '<a href="/ushop/postage/action-delete_cost/id-'.$row->post_cost_id.'" ><img src="/templates/'.$template.'/images/24x24/Delete.png" class="Tips" title="Delete Post Cost" rel="Click to delete this post cost" /></a>';
			
			$c++;
		endforeach;
		
		$header = array('Post Cost', 'Post Level', 'Post Zone', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$costs = $table->toHtml();
	else:
			
		$params['TYPE'] = 'info';
		
		if (!$post_zones):
			$params['MESSAGE'] = '<h2>First define some post zones.</h2>';
		elseif (!$post_levels):
			$params['MESSAGE'] = '<h2>First define some post levels.</h2>';
		else:
			$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
		endif;
	endif;
	
	if (isset($params)):
		$costs = $this->message($params);
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
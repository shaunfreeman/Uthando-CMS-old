<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($post_zones = $this->getResult('post_zone_id, tax_code, zone', $ushop->db_name.'post_zones', $ushop->db_name.'tax_codes')):
		
		$c = 0;
		$data = array();
		
		foreach ($post_zones as $row):
			
			$data[$c][] = $row->zone;
			$data[$c][] = $row->tax_code;
				
			$data[$c][] = '<a href="/ushop/postage/action-edit_zone/id-'.$row->post_zone_id.'"  style="text-decoration:none;" ><img src="/images/24x24/Edit3.png" class="Tips" title="Edit Post Zone" rel="Click to edit this zone." /></a>';
			$data[$c][] = '<a href="/ushop/postage/action-delete_zone/id-'.$row->post_zone_id.'" ><img src="/images/24x24/Delete.png" class="Tips" title="Delete Post Zone" rel="Click to delete this zone" /></a>';
			
			$c++;
		endforeach;
		
		$header = array('Zone', 'Tax Code', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$zones = $table->toHtml();
	else:
			
		$params['TYPE'] = 'info';
		
		$params['MESSAGE'] = (!$tax_codes) ? '<h2>First define some tax codes.</h2>' : '<h2>There are currently no records.</h2>';
	endif;
	
	if (isset($params)):
		$zones = $this->message($params);
	endif;
else:
	Uthando::go();
endif;
?>
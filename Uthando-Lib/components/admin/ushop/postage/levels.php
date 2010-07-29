<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($post_levels = $this->getResult('post_level_id, post_level', $ushop->db_name.'post_levels',null,array('ORDER BY' => 'post_level ASC'))):
		
		$c = 0;
		$data = array();
		
		foreach ($post_levels as $row):
			
			$data[$c][] = $row->post_level;
				
			$data[$c][] = '<a href="/ushop/postage/action-edit_level/id-'.$row->post_level_id.'"  style="text-decoration:none;" ><img src="/images/24x24/Edit3.png" class="Tips" title="Edit Post Level" rel="Click to edit this post level." /></a>';
			$data[$c][] = '<a href="/ushop/postage/action-delete_level/id-'.$row->post_level_id.'" ><img src="/images/24x24/Delete.png" class="Tips" title="Delete Post Level" rel="Click to delete this post level" /></a>';
			
			$c++;
		endforeach;
		
		$header = array('Post Level', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$levels = $table->toHtml();
	else:
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
	endif;
	
	if (isset($params)):
		$levels = $this->message($params);
	endif;
else:
	Uthando::go();
endif;
?>
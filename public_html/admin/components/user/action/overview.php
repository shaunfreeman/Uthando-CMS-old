<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$sql = "
		SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, username, user_group, email, block
		FROM ".$this->registry->user."users
		NATURAL JOIN ".$this->registry->user."user_groups
	";
	$result = $this->registry->db->query($sql);

	if (count($result) > 0):
		
		$c = 0;
		$data = array();
		
		foreach ($result as $row):
			
			$data[$c][] = $row->name;
			$data[$c][] = $row->username;
			$data[$c][] = $row->user_group;
			$data[$c][] = '<a href="mailto:'.$row->email.'">'.$row->email.'</a>';
			
			if ($row->block):
				$data[$c][] = '<a href="/user/block/id-'.$row->user_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/16x16/CheckUnCheked.png" class="Tips" title="Unblock User" rel="Click to unblock '.$row->username.'" /></a>';
			else:
				$data[$c][] = '<a href="/user/block/id-'.$row->user_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/16x16/CheckChecked.png" class="Tips" title="Block User" rel="Click to block '.$row->username.'" /></a>';
			endif;
				
			$data[$c][] = '<a href="/user/edit/id-'.$row->user_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/24x24/Edit3.png" class="Tips" title="Edit User" rel="Click to edit the '.$row->username.' user" /></a>';
			$data[$c][] = '<a href="/user/delete/id-'.$row->user_id.'" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/24x24/DeleteRed.png" class="Tips" title="Delete User" rel="Click to delete the '.$row->username.' user" /></a>';
			
			$c++;
		endforeach;
		
		$table = new HTML_Table();
		$table->setAutoGrow(true);
		$table->setAutoFill('');
	
		$hrAttrs = array('class' => 'highlight');
	
		for ($nr = 0; $nr < count($data); $nr++):
			$table->setHeaderContents($nr+1, 0, (string)$data[$nr][0]);
			for ($i = 1; $i < 7; $i++):
				if ('' != $data[$nr][$i]) $table->setCellContents($nr+1, $i, $data[$nr][$i]);
				$table->setRowAttributes($nr+1, $hrAttrs, true);
			endfor;
		endfor;
		
		$table->setHeaderContents(0, 0, 'Name');
		$table->setHeaderContents(0, 1, 'User Name');
		$table->setHeaderContents(0, 2, 'Group');
		$table->setHeaderContents(0, 3, 'Email');
		$table->setHeaderContents(0, 4, '');
		$table->setHeaderContents(0, 5, '');
		$table->setHeaderContents(0, 6, '');
		
		$menuBar = array(
			'new_user' => '/user/new'
		);
		
		$this->content .= $this->makeToolbar($menuBar, 24);
	
		$this->content .= '<div id="tableWrap">';
	
		$this->content .= $table->toHtml();
		$this->content .= '</div>';
	else:
		$this->content .= "<h3>No Users Yet</h3>";
	endif;
endif
?>
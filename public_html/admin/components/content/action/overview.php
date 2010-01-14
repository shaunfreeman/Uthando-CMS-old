<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$sql = "
		SELECT page_id, page, mdate
		FROM ".$this->registry->core."pages
	";
	$result = $this->registry->db->query($sql);

	$menuBar = array(
		'new_page' => '/content/new',
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);

	if (count($result) > 0) {
		
		$c = 0;
		$data = array();
		
		foreach ($result as $row) {
			
			$data[$c] = array(
				$row->page,
				$row->mdate,
				'<a href="/content/edit/id-'.$row->page_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/24x24/Edit3.png" class="Tips" title="Edit Page" rel="Click to edit the '.$row->page.' page contents" /></a>',
				
				'<a href="/content/delete/id-'.$row->page_id.'" ><img src="/templates/'.$this->registry->template.'/images/24x24/DeleteRed.png" class="Tips" title="Delete Page" rel="Click to delete the '.$row->page.' page" /></a>'
			);
			
			$c++;
		}
		
		$table = new HTML_Table();
		$table->setAutoGrow(true);
		$table->setAutoFill('');
	
		$hrAttrs = array('class' => 'highlight');
	
		for ($nr = 0; $nr < count($data); $nr++) {
			$table->setHeaderContents($nr+1, 0, (string)$data[$nr][0]);
			for ($i = 1; $i < 5; $i++) {
				if ('' != $data[$nr][$i]) {
					$table->setCellContents($nr+1, $i, $data[$nr][$i]);
				}
				$table->setRowAttributes($nr+1, $hrAttrs, true);
			}
		}
	
		$table->setHeaderContents(0, 0, 'Page Name');
		$table->setHeaderContents(0, 1, 'Last Modified');
		$table->setHeaderContents(0, 2, '');
		$table->setHeaderContents(0, 3, '');
		
		$this->content .= '<div id="tableWrap">';
	
		$this->content .= $table->toHtml();
		$this->content .= '</div>';
	} else {
		$this->content .= '<h3>No Content Yet</h3>';
	}

} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
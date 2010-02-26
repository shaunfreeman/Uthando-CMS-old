<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->registry->params['page']) {
	
	if (!is_numeric($this->registry->params['page'])) {
		$page = "WHERE page='".addslashes(str_replace('_', ' ', $this->registry->params['page']))."'";
	} else {
		$page = "WHERE page_id='".$this->registry->params['page']."'";
	}
	
	//DATE_FORMAT(registration_date, '%W %D %M %Y') AS date
	$sql = "
		SELECT page_id, page, content, DATE_FORMAT(cdate, '%W, %d %M %Y %h:%i %p') AS cdate, DATE_FORMAT(mdate, '%W, %d %M %Y %h:%i %p') AS mdate, params
		FROM pages
		$page
	";
	
	$row = $this->registry->db->getRow($sql);
		
	if (PEAR::isError($row)) {
			
		$this->registry->Error ($row->getMessage(), $row->getDebugInfo ());
			
	} else {
		if ($row) {

			$row->params = unserialize($row->params);

			$page = ($row->params['show_title'] == 0) ? null : $row->page;
			$cdate = ($row->params['show_cdate'] == 0) ? null : $row->cdate;
			$mdate = ($row->params['show_mdate'] == 0) ? null : $row->mdate;

			if ($this->registry->template->meta_tags) {
				if (isset($row->params['metadata'])) {
					foreach ($row->params['metadata'] as $key => $value) {
						if (empty($value)) unset ($row->params['metadata'][$key]);
					}
					$this->registry->template->meta_tags = array_merge($this->registry->template->meta_tags, $row->params['metadata']);
				}
			}
			
			$this->registry->template->setTitle($row->page . ' | ' . $this->registry->get('config.server.site_name'));
			$this->registry->page_title = $row->page;
			
			$this->registry->template->addContent($this->displayContentpane(htmlspecialchars($row->content),$page,$cdate,$mdate));
			
			
		} else {
			$this->registry->Error('404 Page NOT Found', $this->registry->path);
		}
	}
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
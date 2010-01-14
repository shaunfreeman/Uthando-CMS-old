<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	if ($rows = $this->getResult('country_id, zone, country', $ushop->db_name.'countries', $ushop->db_name.'post_zones')) {
		
		$c = 0;
		$data = array();
		
		foreach ($rows as $row) {
			
			$data[$c][] = $row->country;
			$data[$c][] = $row->zone;
				
			$data[$c][] = '<a href="/ushop/postage/action-edit_country/id-'.$row->country_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/24x24/Edit3.png" class="Tips" title="Edit Country" rel="Click to edit this country." /></a>';
			$data[$c][] = '<a href="/ushop/postage/action-delete_country/id-'.$row->country_id.'" ><img src="/templates/'.$this->registry->template.'/images/24x24/Delete.png" class="Tips" title="Delete Country" rel="Click to delete this country" /></a>';
			
			$c++;
			
		}
		
		$header = array('Country', 'Post Zone', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$countries = $table->toHtml();
		
	} else {
			
		$params['TYPE'] = 'info';
		
		if (!$post_zones) {
			$params['MESSAGE'] = '<h2>First define some post zones.</h2>';
		} else {
			$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
		}
		
	}
	
	if (isset($params)) {
		
		$countries = $this->message($params);
	}
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
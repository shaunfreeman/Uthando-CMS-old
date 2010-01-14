<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	if ($tax_rates) {

		$c = 0;
		$data = array();
		
		foreach ($tax_rates as $row) {
			
			$data[$c][] = $row->tax_rate;
				
			$data[$c][] = '<a href="/ushop/tax/action-edit_tax_rate/id-'.$row->tax_rate_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/24x24/Edit3.png" class="Tips" title="Edit Tax Rate" rel="Click to edit this tax rate." /></a>';
			$data[$c][] = '<a href="/ushop/tax/action-delete_tax_rate/id-'.$row->tax_rate_id.'" ><img src="/templates/'.$this->registry->template.'/images/24x24/Delete.png" class="Tips" title="Delete Tax Rate" rel="Click to delete this tax rate" /></a>';
			
			$c++;
			
		}
		
		$header = array('Tax Rate', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$display_rates = $table->toHtml();
		
	} else {
			
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
	}
	
	if (isset($params)) {
		
		$display_rates = $this->message($params);
	}
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
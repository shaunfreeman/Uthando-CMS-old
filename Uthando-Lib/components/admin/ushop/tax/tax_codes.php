<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($rows = $this->getResult('tax_code_id, tax_rate, tax_code, description',$ushop->db_name.'tax_codes', $ushop->db_name.'tax_rates')):
		
		$c = 0;
		$data = array();
		
		$ushop->formatTaxRates($rows);
		
		foreach ($rows as $row):
			
			$data[$c][] = $row->tax_code;
			$data[$c][] = $row->tax_rate;
			$data[$c][] = $row->description;
				
			$data[$c][] = '<a href="/ushop/tax/action-edit_tax_code/id-'.$row->tax_code_id.'"  style="text-decoration:none;" ><img src="/images/24x24/Edit3.png" class="Tips" title="Edit Tax Code" rel="Click to edit this tax code." /></a>';
			$data[$c][] = '<a href="/ushop/tax/action-delete_tax_code/id-'.$row->tax_code_id.'" ><img src="/images/24x24/Delete.png" class="Tips" title="Delete Tax Code" rel="Click to delete this tax code" /></a>';
			
			$c++;
		endforeach;
		
		$header = array('Tax Code', 'Tax Rate', 'Description', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$display_codes = $table->toHtml();
	else:
			
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = (!$tax_rates) ? '<h2>First define some tax rates.</h2>' : '<h2>There are currently no records.</h2>';
	endif;
	
	if (isset($params)):
		$display_codes = $this->message($params);
		unset($params);
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
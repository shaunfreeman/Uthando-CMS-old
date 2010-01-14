<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UShopAdmin extends UShop {
	
	public function getDisplay($key) {
		return $this->ADMIN_DISPLAY[$key];
	}
	
	public function getSettings(){
		return $this->vars;
	}
	
	public function getTaxRates($format=false) {
		
		$result = $this->uthando->getResult('tax_rate_id, tax_rate', $this->db_name.'tax_rates', null, array('ORDER BY' => 'tax_rate ASC'));
		
		if ($result) {
			
			if ($format) return $this->formatTaxRates($result);
			
			return $result;
		} else {
			return false;
		}
		
		return false;
	}
	
	public function formatTaxRates($rows) {
		
		foreach ($rows as $index => $row) {
			if ($row->tax_rate > 0) {
				$rows[$index]->tax_rate = substr ($row->tax_rate, 2);
				$rows[$index]->tax_rate = substr ($row->tax_rate, 0, 2) . "." . substr ($row->tax_rate, -1);
				if (substr ($row->tax_rate, 0, 1) == 0) {
					$rows[$index]->tax_rate = substr ($row->tax_rate, 1);
				}
			
				$rows[$index]->tax_rate = number_format ($row->tax_rate, 2);
			
			} else {
				$rows[$index]->tax_rate = number_format ($row->tax_rate, 2);
			}
		
			$rows[$index]->tax_rate .= '&#037;';
		}
		
		return $rows;
		
	}
	
	public function formatTaxCodes() {
		
		$rows = $this->uthando->getResult('tax_code_id, tax_rate, tax_code, description', $this->db_name.'tax_codes',$this->db_name.'tax_rates', null);
		
		$this->formatTaxRates($rows);
		
		$return_rows = array();
		
		foreach ($rows as $row) {
			array_push($return_rows ,array('tax_code_id' => $row->tax_code_id ,'tax_code' => $row->tax_code . ' - ' . ucwords($row->description) . ' - ' . $row->tax_rate));
		}
		
		return $return_rows;
	}
	
}
?>
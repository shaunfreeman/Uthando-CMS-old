<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	if ($this->registry->params['id']) {
		$this->update(array(
			'enabled' => $this->registry->params['enable']),
			$ushop->db_name.'products',
			array('where' => 'product_id='.$this->registry->params['id'])
		);
	}
	
	$categories = $this->getResult('category_id', $ushop->db_name.'product_categories');
		
	$display = $ushop->getDisplay('product');
	
	$num = count($this->getResult('product_id', $ushop->db_name.'products'));
		
	$start = (isset($this->registry->params['pstart']) ? $this->registry->params['pstart'] : 0);
				
	if ($num > $display):
		$paginate = new HTML_Paginate('products', $start, '/ushop/products/pstart-{start}#products', $num, $display, false);
		$this->content .= $paginate->toHTML();
	endif;
	
	if ($products = $this->getResult('product_id, sku, name, price, image, enabled, image_status, category', $ushop->db_name.'products', array($ushop->db_name.'product_categories'), array('ORDER BY' => 'sku ASC', 'LIMIT' => "$start, $display"))) {
	
		//$ftp = new File_FTP($this->registry);
		
		$c = 0;
		$data = array();
		$base_dir = __SITE_PATH . "/../components/ushop/images/products/";
		
		foreach ($products as $row) {
		
			//$ftp->rename($ftp->public_html.'/components/ushop/images/products/'.$row->image, $ftp->public_html.'/components/ushop/images/products/'.str_replace(' ', '_', $row->category).'/'.$row->image);
			
			if ($row->image_status == 1) {
	
				if (file_exists($base_dir.str_replace(' ', '_', $row->category).'/'.$row->image) && $row->image != null) {
					$img_file = '<img src="/templates/'.$this->registry->template.'/images/24x24/OK.png" />';
		
				} else {
					$img_file = '<img src="/templates/'.$this->registry->template.'/images/24x24/DeleteRed.png" />';
				}
			} else {
				$img_file = "IMAGE OFF";
			}
			
			$data[$c][] = $row->enabled ? '<a href="/ushop/products/enable-0/id-'.$row->product_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/16x16/IndicatorCircleGreenOn.png" /></a>' : '<a href="/ushop/products/enable-1/id-'.$row->product_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/16x16/IndicatorCircleRedOff.png" /></a>';
			
			$data[$c][] = $row->sku;
			$data[$c][] = HTML_Element::makeXmlSafe($row->name);
			$data[$c][] = '&pound;'.$row->price;
			
			$data[$c][] = $img_file;
				
			$data[$c][] = '<a href="/ushop/products/action-edit_product/id-'.$row->product_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/24x24/Edit3.png" class="Tips" title="Edit Product" rel="Click to edit this product." /></a>';
			$data[$c][] = '<a href="/ushop/products/action-delete_product/id-'.$row->product_id.'" ><img src="/templates/'.$this->registry->template.'/images/24x24/Delete.png" class="Tips" title="Delete Product" rel="Click to delete this product" /></a>';
			
			$c++;
			
		}
		
		$header = array('', 'SKU', 'Title', 'Price', 'Image', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$products = $table->toHtml();
		
	} else {
		
		$params['TYPE'] = 'info';
		
		if (!$tax_codes) {
			$params['MESSAGE'] = '<h2>First define some tax codes.</h2>';
		} elseif (!$categories) {
			$params['MESSAGE'] = '<h2>First define some categories.</h2>';
		} else {
			$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
		}
		
	}
	
	if (isset($params)) {
		
		$products = $this->message($params);
	}
	
	$productsBar['new_product'] = '/ushop/products/action-new_product';
	
	$tab_array['products'] = $products;
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
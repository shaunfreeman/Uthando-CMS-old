<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($this->registry->params['id']):
		$this->update(array(
			'enabled' => $this->registry->params['enable']),
			$ushop->db_name.'products',
			array('where' => 'product_id='.$this->registry->params['id'])
		);
	endif;
	
	$categories = $this->getResult('category_id', $ushop->db_name.'product_categories');
		
	$display = $ushop->getDisplay('product');
	
	$num = count($this->getResult('product_id', $ushop->db_name.'products'));
		
	$start = (isset($this->registry->params['pstart']) ? $this->registry->params['pstart'] : 0);
				
	if ($num > $display):
		$paginate = new HTML_Paginate('products', $start, '/ushop/products/pstart-{start}/view-products', $num, $display, false);
		$this->content .= $paginate->toHTML();
	endif;
	
	if ($products = $this->getResult('product_id, sku, name, price, image, enabled, image_status, category', $ushop->db_name.'products', array($ushop->db_name.'product_categories'), array('ORDER BY' => 'sku ASC', 'LIMIT' => "$start, $display"))):
		
		$c = 0;
		$data = array();
		$base_dir = __SITE_PATH . "/../components/ushop/images/products/";
		
		foreach ($products as $row) {
			
			$data[$c][] = $row->enabled ? '<a href="'.$_SERVER['REQUEST_URI'].'/enable-0/id-'.$row->product_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/16x16/IndicatorCircleGreenOn.png" /></a>' : '<a href="'.$_SERVER['REQUEST_URI'].'/enable-1/id-'.$row->product_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/16x16/IndicatorCircleRedOff.png" /></a>';
			
			$data[$c][] = $row->sku;
			$data[$c][] = HTML_Element::makeXmlSafe($row->name);
			$data[$c][] = '&pound;'.$row->price;
			
			$data[$c][] = $row->category;
				
			$data[$c][] = '<a href="/ushop/products/action-edit_product/id-'.$row->product_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/24x24/Edit3.png" class="Tips" title="Edit Product" rel="Click to edit this product." /></a>';
			$data[$c][] = '<a href="/ushop/products/action-delete_product/id-'.$row->product_id.'" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/24x24/Delete.png" class="Tips" title="Delete Product" rel="Click to delete this product" /></a>';
			
			$c++;
			
		}
		
		$header = array('', 'SKU', 'Title', 'Price', 'Category', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$data = $table->toHtml();
		
	else:
		
		$params['TYPE'] = 'info';
		
		if (!$tax_codes):
			$params['MESSAGE'] = '<h2>First define some tax codes.</h2>';
		elseif (!$categories):
			$params['MESSAGE'] = '<h2>First define some categories.</h2>';
		else:
			$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
		endif;
		
	endif;
	
	if (isset($params)) $products = $this->message($params);
	
	$productsBar['new_product'] = '/ushop/products/action-new_product';
	
	//$tab_array['products'] = $products;
endif;
?>
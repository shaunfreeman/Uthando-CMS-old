<?php

// no direct access
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

$this->registry->page_title = 'ushop/view/'.$this->registry->params[0];

$category = str_replace('_', ' ', $this->registry->params[0]);

$title .= $category;

if ($this->ushop->global['offline']):
	
	$content = '<center><img src="/components/ushop/images/closed-sign.png" /></cente>';
	$content .= file_get_contents('ushop/html/offline_message.html', true);
	
else:
	
	// set referer.
	$_SESSION['http_referer'] = urlencode(stripslashes($this->registry->path));

	$content = '<div id="products">';

	$content .= $this->ushop->displayCartButtons();
	
	$content .= $this->displayContentpane($this->ushop->getCategories(), $category);
	
	$content .= $this->ushop->displayPathway();
	
	$display = $this->ushop->getDisplay('product');
	
	$num = count($this->getResult('product_id', $this->ushop->db_name.'products', null, array('WHERE' => 'category_id='.$this->ushop->category_id, 'AND' => 'enabled=1')));
		
	$start = (isset($this->registry->params['pstart']) ? $this->registry->params['pstart'] : 0);
	
	if ($num > $display):
		$paginate = new HTML_Paginate('products', $start, '/ushop/view/' . $this->registry->params[0] . '/pstart-{start}', $num, $display);
		$paginate = $paginate->toHTML();
		$content .= $paginate;
	endif;
	
	$filter_array[] = 'enabled=1';
	if ($this->ushop->checkout['stock_control']) $filter_array[] = 'quantity > 0';
	
	$products = $this->getResult(
		"product_id, sku, name, CONCAT(forename, ' ', surname) AS author, price, isbn, image, image_status, description, quantity",
		$this->ushop->db_name.'products',
		$this->ushop->db_name.'authors',
		array(
			'WHERE' => 'category_id='.$this->ushop->category_id,
			'AND' => $filter_array ,
			'LIMIT' => "$start,$display"
		)
	);
	
	if ($products):
		$content .= $this->ushop->productList($products, count($products));
		if ($num > $display):
			$content .= $paginate;
		endif;
	else:
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
		$content .= $this->message($params);
	endif;
	
	$content .= '</div>';
endif;

$this->addContent($content);

?>
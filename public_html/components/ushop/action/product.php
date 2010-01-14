<?php

// no direct access
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

if (is_numeric($this->registry->params['id'])) {

	$row = $this->getResult(
		$this->ushop->DATABASE_SELECTS['product_view'],
  		$this->ushop->db_name.'products',
		array(
			$this->ushop->db_name.'product_categories',
			$this->ushop->db_name.$this->ushop->DATABASE_JOINS['product_view']
		),
  		array(
			'WHERE' => 'product_id='.$this->registry->params['id']
		),
		false
	);

	$title .= $row->name;

	$this->addContent('<div id="products">');

	$this->addContent($this->ushop->displayCartButtons());

	$this->addContent($this->ushop->displayPathway($row->category_id));

	$this->addContent($this->ushop->productDetails($row));

	$this->addContent('</div>');
	
} else {
}

?>
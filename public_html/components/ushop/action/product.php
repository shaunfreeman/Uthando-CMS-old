<?php

// no direct access
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

if (is_numeric($this->registry->params['id'])):

	$row = $this->getResult(
		$this->ushop->database_selects['product_view'],
  		$this->ushop->db_name.'products',
		array(
			$this->ushop->db_name.'product_categories',
			$this->ushop->db_name.$this->ushop->database_joins['product_view']
		),
  		array(
			'WHERE' => 'product_id='.$this->registry->params['id']
		),
		false
	);

	$title .= HTML_Element::makeXmlSafe($row->name);

	$this->content .= ('<div id="products">');

	$this->content .= ($this->ushop->displayCartButtons());

	$this->content .= ($this->ushop->displayPathway($row->category_id));

	$this->content .= ($this->ushop->productDetails($row));

	$this->content .= ('</div>');
endif;

?>
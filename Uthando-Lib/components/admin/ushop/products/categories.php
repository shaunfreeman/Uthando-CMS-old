<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$tree = $ushop->tree;
	
	if ($num = $tree->numTree()):
		
		$c = 0;
		$data = array();
		
		$display = $ushop->getDisplay('category');
		
		$start = (isset($this->registry->params['cstart']) ? $this->registry->params['cstart'] : 0);
		
		if ($num > $display):
			$paginate = new HTML_Paginate('categories', $start, '/ushop/products/cstart-{start}/view-categories', $num, $display, false);
			$this->content .= $paginate->toHTML();
		endif;
		
		$rows = $this->registry->db->query('
			SELECT child.category_id, COUNT(product.product_id) AS num_product
			FROM '.$ushop->db_name.'product_categories AS child, '.$ushop->db_name.'product_categories AS parent, '.$ushop->db_name.'products AS product
			WHERE child.lft BETWEEN parent.lft AND parent.rgt
			AND child.category_id = product.category_id
			GROUP BY category_id
			ORDER BY child.lft
		');
		
		foreach($rows as $value) $num_products[$value->category_id] = $value->num_product;
		
		foreach ($tree->getTree("$start, $display") as $row):
			
			if ($row['depth'] > 0):
				$r = str_repeat(str_repeat('&nbsp;', 4),($row['depth']));
				$r .= "&bull;&nbsp;".HTML_Element::makeXmlSafe($row['category']);
				$data[$c][] = $r;
			else:
				$data[$c][] = HTML_Element::makeXmlSafe($row['category']);
			endif;
			
			$data[$c][] = $num_products[$row['category_id']].' [show]';
				
			$data[$c][] = '<a href="/ushop/products/action-edit_category/id-'.$row['category_id'].'"  style="text-decoration:none;" ><img src="/images/24x24/Edit3.png" class="Tips" title="Edit Category" rel="Click to edit this category." /></a>';
			$data[$c][] = '<a href="/ushop/products/action-delete_category/id-'.$row['category_id'].'" ><img src="/images/24x24/Delete.png" class="Tips" title="Delete Category" rel="Click to delete this category" /></a>';
			
			$c++;
		endforeach;
		
		$header = array('Category', 'Products', '', '');
		$table = $this->dataTable($data, $header);
		$data = $table->toHtml();
		
	else:
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
	endif;
	
	if (isset($params)) $categories = $this->message($params);
	
	$productsBar['new_category'] = '/ushop/products/action-new_category';
	
	//$tab_array['categories'] = $categories;
	
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
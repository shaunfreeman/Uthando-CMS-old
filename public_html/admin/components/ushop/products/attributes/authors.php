<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($params)) unset($params);
		
	$display = $ushop->getDisplay('authors');
	
	$num = count($this->getResult('author_id', $ushop->db_name.'authors'));
		
	$start = (isset($this->registry->params['astart']) ? $this->registry->params['astart'] : 0);
				
	if ($num > $display):
		$paginate = new HTML_Paginate('authors', $start, '/ushop/products/astart-{start}/view-attr/authors', $num, $display, false);
		$this->content .= $paginate->toHTML();
	endif;
	
	if ($authors = $this->getResult('author_id, forename, surname', $ushop->db_name.'authors', null, array('LIMIT' => "$start, $display"))):
		
		$c = 0;
		$data = array();
		
		foreach ($authors as $row):
			
			$data[$c][] = HTML_Element::makeXmlSafe($row->forename). ' ' . HTML_Element::makeXmlSafe($row->surname);
				
			$data[$c][] = '<a href="/ushop/products/action-edit_attribute/attr-author/id-'.$row->author_id.'"  style="text-decoration:none;" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/24x24/Edit3.png" class="Tips" title="Edit Author" rel="Click to edit this author." /></a>';
			$data[$c][] = '<a href="/ushop/products/action-delete_attribute/attr-author/id-'.$row->author_id.'" ><img src="/templates/'.$this->get('admin_config.site.template').'/images/24x24/Delete.png" class="Tips" title="Delete Author" rel="Click to delete this author" /></a>';
			
			$c++;
		endforeach;
		
		$header = array('Author', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$data = $table->toHtml();
	else:
		
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
		
		$products = $this->message(array('MESSAGE' => '<h2>First define some authors.</h2>', 'TYPE' => 'info'));
		
		//$tab_array['products'] = $products;
	endif;
	
	if (isset($params)) $authors = $this->message($params);
	
	$productsBar['new_author'] = '/ushop/products/action-new_attribute/attr-author';
	
	$tab_array['authors'] = $authors;
	
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
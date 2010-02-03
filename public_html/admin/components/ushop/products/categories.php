<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {

	if (isset($params)) unset($params);
	
	$tree = new NestedTree($ushop->db_name.'product_categories', null, 'category');
	
	if ($num = $tree->numTree()) {
		
		$c = 0;
		$data = array();
		$base_dir = __SITE_PATH . "/../components/ushop/images/products/";
		
		$display = $ushop->getDisplay('category');
		
		$start = (isset($this->registry->params['cstart']) ? $this->registry->params['cstart'] : 0);
		
		if ($num > $display):
			$paginate = new HTML_Paginate('categories', $start, '/ushop/products/cstart-{start}#categories', $num, $display, false);
			$this->content .= $paginate->toHTML();
		endif;
		
		//$ftp = new File_FTP($this->registry);
		
		//$ftp->cd($ftp->public_html.'/components/ushop/images/products');
		
		foreach ($tree->getTree("$start, $display") as $row) {
		
			//$ftp->mkdir(str_replace(' ', '_', $row['category']));
			
			if ($row['category_image_status'] == 1) {
	
				if (file_exists($base_dir.str_replace(' ', '_', $row['category']).'/'.$row['category_image']) && $row['category_image'] != null) {
					$img_file = '<img src="/templates/'.$this->registry->template.'/images/24x24/OK.png" />';
		
				} else {
					$img_file = '<img src="/templates/'.$this->registry->template.'/images/24x24/DeleteRed.png" />';
				}
			} else {
				$img_file = "IMAGE OFF";
			}
			
			if ($row['depth'] > 0) {
				$r = str_repeat(str_repeat('&nbsp;', 4),($row['depth']));
				$r .= "&bull;&nbsp;".htmlentities(htmlspecialchars($row['category']));
				$data[$c][] = $r;
			} else {
				$data[$c][] = htmlentities(htmlspecialchars($row['category']));
			}
			
			$data[$c][] = $img_file;
				
			$data[$c][] = '<a href="/ushop/products/action-edit_category/id-'.$row['category_id'].'"  style="text-decoration:none;" ><img src="/templates/'.$this->registry->template.'/images/24x24/Edit3.png" class="Tips" title="Edit Category" rel="Click to edit this category." /></a>';
			$data[$c][] = '<a href="/ushop/products/action-delete_category/id-'.$row['category_id'].'" ><img src="/templates/'.$this->registry->template.'/images/24x24/Delete.png" class="Tips" title="Delete Category" rel="Click to delete this category" /></a>';
			
			$c++;
			
		}
		
		$header = array('Category', 'image', '', '');
		
		$table = $this->dataTable($data, $header);
		
		$categories = $table->toHtml();
		
	} else {
			
		$params['TYPE'] = 'info';
		
		$params['MESSAGE'] = '<h2>There are currently no records.</h2>';
		
	}
	
	if (isset($params)) {
		
		$categories = $this->message($params);
	}
	
	$productsBar['new_category'] = '/ushop/products/action-new_category';
	
	$tab_array['categories'] = $categories;
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
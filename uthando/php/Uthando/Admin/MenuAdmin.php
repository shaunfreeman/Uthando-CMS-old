<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class MenuAdmin extends HTML_Menu {
	
	public function __construct($registry, $params) {
		parent::__construct($registry, $params);
		$this->admin = true;
	}
	
	protected function returnLink ($row, $class, $children) {
		
		if ($children > 0) {
			$span_start = "<span class=\"accordion_toggler_" . ($row['depth'] + 1) . "\">";
		} else {
			$span_start = "<span>";
		}
		
		$span_end = "</span>";
		
		$menu = null;
		if (!$row['url']) $row['url'] == '/';
		switch ($row['status']) {
			
			case "LI":
				if ($this->status == "LI")
					$menu = "<a $class href=\"".$this->registry->admin_config->get('admin_url', 'SERVER')."/{$row['url']}\">".$span_start . $row['item'] . $span_end."</a>";
				break;
		}
		return $menu;
	}
	
	private function menuBar($menu_id, $menu)
	{
		if ($this->admin) {
					$curr = $row[$key]['item'];
				} else {
					
					if ($row[$key]['page_id']) {
						$curr = $row[$key]['page'];
					} else {
						$curr =  $row[$key]['url'];
					}
				}
	}
	
}
?>

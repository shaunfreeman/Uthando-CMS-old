<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class HTML_Menu extends DOMDocument
{
	
	private $type;
	private $menu;
	private $menu_id;
	private $class_sfx = NULL;
	private $moduleclass_sfx = NULL;
	protected $registry;
	protected $status;
	protected $admin = false;
	
	public function __construct ($registry, $params)
	{
		$this->registry = $registry;
		
		$this->class_sfx = $params['class_sfx'];
		$this->moduleclass_sfx = $params['moduleclass_sfx'];
		$this->menu_id = $params['item_id'];
		
		$this->db_table = $this->registry->db_default;
		
		$this->status = $this->getStatus();
		parent::__construct();
	}
	
	private function getStatus()
	{
		if (isset($_SESSION['user_id'])):
			return $status = "LI";
		else:
			return $status = "LO";
		endif;
	}
	
	public function getMenu ($menu_id, $menu, $menu_type)
	{
		$this->type = $menu_type;
		$this->menuBar($menu_id, $menu);
		return $this->menu;
	}
	
	private function getMenuHeader($menu)
	{
		if ($this->type == 'horizontal'):
			$class = 'class="mainmenu"'; //mainmenu
			$div_class = 'class="moduletable"';
			$ulid = 'id="mainlevel'.$this->class_sfx.'"';
		else:
			$class = 'class="menu"';
			
			$div_class = 'class="moduletable'.$this->moduleclass_sfx.'"';
			$ulid = null;
		endif;
		$s .= "<div id=\"$menu\" $div_class><ul $ulid $class>";
		return $s;
	}
	
	private function getMenuFooter()
	{
		$s = "\r\n</ul></div>";
		return $s;
	}
	
	protected function returnLink ($row, $class, $children)
	{
		if ($children > 0):
			$span_start = "<span class=\"accordion_toggler_" . ($row['depth'] + 1) . "\">";
		else:
			$span_start = "<span>";
		endif;
		
		$span_end = "</span>";
		
		$menu = null;
		if (!$row['url']) $row['url'] == '/';
		
		if ($row['enssl']):
			$host = $this->registry->config->get('ssl_url', 'SERVER');
		else:
			$host = $this->registry->config->get('web_url', 'SERVER');
		endif;
		
		switch ($row['status']):
			case "LI":
				if ($this->status == "LI")
					$menu = "<a $class href=\"".$host."/{$row['url']}\">".$span_start . htmlentities($row['item']) . $span_end."</a>";
				break;
			
			case "LO":
				if ($this->status == "LO")
					$menu = "<a $class href=\"".$host."/{$row['url']}\">".$span_start . htmlentities($row['item']) . $span_end."</a>";
				break;
				
			case "A":
				$menu = "<a $class href=\"".$host."/{$row['url']}\">".$span_start . htmlentities($row['item']) . $span_end."</a>";
				break;
		endswitch;
		return $menu;
	}
	
	// Navigaion bar function.
	private function menuBar($menu_id, $menu)
	{
		$this->menu = $this->getMenuHeader(str_replace(" ", "", $menu));
		
		// Retrieve all children
		$row = $this->queryMenu($menu_id);
		
		if ($row) {
			// Display each menu item.
			foreach ($row as $key => $value) {
				
				$children = (($row[$key]['rgt'] - $row[$key]['lft']) - 1) / 2;
				
				if ($this->type == 'vertical') {
					if ($row[$key]['depth'] > 0) {
						$class = "class=\"sublevel\"";
					} else {
						$class = "class=\"mainlevel\"";
					}
				} else {
					$class = "class=\"mainlevel".$this->class_sfx."\"";
				}
				
				if ($this->admin) {
					$curr = $row[$key]['item'];
				} else {
					
					if ($row[$key]['page_id']) {
						$curr = $row[$key]['page'];
					} else {
						$curr =  $row[$key]['url'];
					}
				}
				
				if ($curr == $this->registry->page_title && $this->type == 'vertical') {
					$active = 'class="active"';
					$current = 'id="current"';
				} else {
					$active = null;
					$current = null;
				}
				
				$this->menu .= "<li $current $active>\n";
				
				$this->menu .= $this->returnLink($row[$key], $class, $children);
				
				if ($children > 0) $this->menu .= "<ul class=\"accordion_content_".($row[$key]['depth'] + 1)."\">\n";
				
				if ($row[$key]['depth'] > 0) {
				
					// find the end of the array.
					$end = end($row);
				
					if ($row[$key]['item_id'] == $end['item_id']) {
						$this->menu .= str_repeat("</li></ul>\n", $row[$key]['depth']);
						$this->menu .= "</li>\n";
					} else if ($row[$key + 1]['depth'] < $row[$key]['depth']) {
						$this->menu .= str_repeat("</li></ul>\n", ($row[$key]['depth'] - $row[$key + 1]['depth']));
						$this->menu .= "</li>\n";
					} else {
						if ($children == 0) $this->menu .= "</li>\n";
					}	
				} else {	
					if ($children == 0) $this->menu .= "</li>\n";
				}
			}
		}
		$this->menu .= $this->getMenuFooter();
	}
	
	private function queryMenu ($menu_id)
	{
		$menu = array();
		
		if ($this->status == "LI"):
			$status = "LO";
		else:
			$status = "LI";
		endif;
		
		$tree = new NestedTree($this->db_table.'menu_items', $menu_id, 'item');
		
		$decendants = $tree->getDecendants(true);
		
		if ($decendants):
		
			foreach ($decendants as $key => $value):
				$search_categories .= $decendants[$key]['item_id'] . ',';
			endforeach;
		
			$search_categories = substr ($search_categories, 0, -1);
			
			$fields = 'item_id, item, status, url, enssl, page_id';
			$join = array(
				$this->registry->core.'menu_link_status',
				$this->db_table.'menu_urls'
			);
			
			$result = $this->registry->db->getResult(
				$fields,
				'menu_items',
				$join,
				array (
					'where' => "status != '".$status."'",
					'and' => 'item_id IN ('.$search_categories.')',
					'order by' => 'lft ASC'
				)
			);
		else:
			$result = false;
		endif;
		
		if ($result):
			foreach ($result as $row) $menu[] = Uthando::objectToArray($row);
			
			foreach ($menu as $key => $value):
				$return_menu[$key] = $value;
				if (is_numeric($value['page_id'])):
					$page = $this->registry->db->getResult('page',$this->db_table.'pages',null, array('where' => 'page_id='.$value['page_id']),false);
					$return_menu[$key]['page'] = $page->page;
				endif;
				$return_menu[$key]['lft'] = $decendants[$key]['lft'];
				$return_menu[$key]['rgt'] = $decendants[$key]['rgt'];
				$return_menu[$key]['depth'] = $decendants[$key]['depth'] - 1;
			endforeach;
			
			if($return_menu):
				foreach ($return_menu AS $key => $value) $category[$key]  = $value['lft'];
	
				array_multisort($category, SORT_ASC, $return_menu);
			endif;
			
			return $return_menu;
		else:
			return false;
		endif;	
	}
}
?>

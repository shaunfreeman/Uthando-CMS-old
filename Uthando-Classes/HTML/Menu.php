<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class HTML_Menu
{
	
	protected $type;
	protected $menu;
	protected $menu_id;
	protected $class_sfx = NULL;
	protected $moduleclass_sfx = NULL;
	protected $doc;
	protected $registry;
	protected $status;
	protected $admin = false;
	//protected $vars = array();
	
	public function __construct ($registry, $params)
	{
		$this->registry = $registry;
		
		$this->class_sfx = $params['class_sfx'];
		$this->moduleclass_sfx = $params['moduleclass_sfx'];
		$this->menu_id = (isset($params['item_id'])) ? $params['item_id'] : null;
		
		$this->db_table = $this->registry->db_default;
		
		$this->status = $this->getStatus();
		$this->doc = $this->registry->template->doc;
	}
	/*
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		if (array_key_exists($index, $this->vars)) return $this->vars[$index];
        return null;
	}
	*/
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
	
	protected function getMenuWrap($menu)
	{
		if ($this->type == 'horizontal'):
			$div_attrs = array('class' => 'moduletable');
			$ul_attrs = array(
				'id' => 'mainlevel'.$this->class_sfx,
				'class' => 'mainmenu'
			);
		else:
			$div_attrs = array(
				'id' => $menu,
				'class' => 'moduletable'.$this->moduleclass_sfx
			);
			$ul_attrs = array('class'=> 'menu');
		endif;
		$this->menu = $this->doc->createElement('div', null, $div_attrs);
		return $ul_attrs;
	}
	
	protected function returnLink ($row, $attrs, $children)
	{
		if ($children > 0):
			$span_attrs = array('class' => 'accordion_toggler_'. ($row['depth'] + 1));
		else:
			$span_attrs = null;
		endif;
		
		if (!$row['url']) $row['url'] == '/';
		
		if ($row['enssl']):
			$host = $this->registry->get('config.server.ssl_url').'/';
		else:
			$host = $this->registry->get('config.server.web_url').'/';
		endif;
		
		switch ($row['status']):
			case "LI":
				if ($this->status == "LI") $attrs['href'] = $host.$row['url'];
				break;
			
			case "LO":
				if ($this->status == "LO") $attrs['href'] = $host.$row['url'];
				break;
				
			case "A":
				$attrs['href'] = $host.$row['url'];
				break;
		endswitch;
		
		$span = $this->doc->createElement('span', null, $span_attrs);
		$link = $this->doc->createElement('a', htmlentities($row['item']), $attrs);
		$span->appendChild($link);
		return $span;
	}
	
	// Navigaion bar function.
	protected function menuBar($menu_id, $menu)
	{
		$parents = array();
		$submenus = array();
		
		$ul_attrs = $this->getMenuWrap(str_replace(" ", "", $menu));
		
		$root = $this->doc->createElement('ul', null , $ul_attrs);
		
		// Retrieve all children
		$list_items = $this->queryMenu($menu_id);
		
		if ($list_items):
			// Display each menu item.
			foreach ($list_items as $key => $item):
			
				$children = (($item['rgt'] - $item['lft']) - 1) / 2;
				
				if ($this->type == 'vertical'):
					if ($item['depth'] > 0):
						$a_attrs['class'] = 'sublevel';
					else:
						$a_attrs['class'] = 'mainlevel';
					endif;
				else:
					$a_attrs['class'] = 'mainlevel'.$this->class_sfx;
				endif;
				
				$curr = ($item['page_id']) ? $item['page'] : $item['url'];
				print_rr($this->registry);
				$li_attrs = ($curr == $this->registry->page_title && $this->type == 'vertical') ? array('id' => 'current', 'class' => 'active') : null;
				
				$a = $this->returnLink($list_items[$key], $a_attrs, $children);
				$li = $this->doc->createElement('li',null, $li_attrs);
				$li->appendChild($a);
				
				// if item has no submenus just add it to the root, otherwise start making the submenus.
				if ($item['depth'] == 0 && !$children):
					$root->appendChild($li);
				else:
					
					// if next item is the same level append to submenu
					$submenus[$item['depth']][$key] = $li;
					
					// if next item is a submenu of this item, add this item to the parents array.
					if ($list_items[$key + 1]['depth'] > $item['depth']) $parents[] = $key;
					
					// if we are at the end of a submenu add it now to its parent.
					for ($i = $item['depth']; $i > $list_items[$key + 1]['depth']; $i-- ):
						$ul = $this->doc->createElement('ul', null, array('class' => 'accordion_content_'.$i));
					
						foreach ($submenus[$i] as $subitem) $ul->appendChild($subitem);
					
						unset($submenus[$i]);
					
						// attach submenu to its parent.
						$parent = array_pop($parents);
						$submenus[$i - 1][$parent]->appendChild($ul);
					endfor;
					
					// if we are back at root level add all submenus to it.
					if ($list_items[$key + 1]['depth'] == 0):
						$root->appendChild($submenus[0][$parent]);
						unset($submenus[0]);
					endif;
				endif;
			endforeach;
		endif;
		
		$this->menu->appendChild($root);
		$this->doc->appendChild($this->menu);
	}
	
	protected function queryMenu ($menu_id)
	{
		$menu = array();
		
		if ($this->status == "LI"):
			$status = "LO";
		else:
			$status = "LI";
		endif;
		
		$tree = new NestedTree($this->db_table.'menu_items', $menu_id, 'item');
		
		$decendants = $tree->getDecendants(true);
		
		$search_categories = null;
		
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
					'WHERE' => "status != '".$status."'",
					'AND' => 'item_id IN ('.$search_categories.')',
					'ORDER BY' => 'lft ASC'
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
					$page = $this->registry->db->getResult('page',$this->db_table.'pages',null, array('WHERE' => 'page_id='.$value['page_id']),false);
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

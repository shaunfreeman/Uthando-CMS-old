<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Admin_Menu extends HTML_Menu
{
	
	protected function returnLink ($row, $class, $children) {
		
		if ($children > 0):
			$span_attrs = array('class' => 'accordion_toggler_'. ($row['depth'] + 1));
		else:
			$span_attrs = null;
		endif;
		
		$host = $this->registry->get('admin_config.server.admin_url').'/';
		
		if (!$row['url']) $row['url'] == '/';
		
		switch ($row['status']):
			case "LI":
				if ($this->status == "LI") $attrs['href'] = $host.$row['url'];
				break;
		endswitch;
		
		$span = $this->doc->createElement('span', null, $span_attrs);
		$link = $this->doc->createElement('a', htmlentities($row['item']), $attrs);
		$span->appendChild($link);
		return $span;
	}
	
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
				
				$curr = $item[$key]['item'];
				
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
}
?>

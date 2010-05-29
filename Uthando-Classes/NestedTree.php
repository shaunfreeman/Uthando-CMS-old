<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class NestedTree {
	
	protected $vars = array();
	
	public function __construct ($table, $id=NULL, $field) {
		$this->uthando = $GLOBALS['uthando'];
		$this->registry = $GLOBALS['registry'];
		$this->table = $table;
		$this->id = $id;
		$this->category_field = $field;
	}
	
	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}
	
	public function __get($index) {
		return $this->vars[$index];
	}
	
	protected function objectToArray($obj) {
		foreach ($obj as $key => $value) {
			$return_array[$key] = $value;
		}
		return $return_array;
	}
	
	public function listToMultiArray( $arrs, $depth_key = 'depth' )
	{
		$nested = array();
		$depths = array();
		
		foreach( $arrs as $key => $arr ) {
			if( $arr[$depth_key] == 0 ) {
				$nested[$key] = $arr;
			} else {
				$parent =& $nested;
				for( $i = 1; $i <= ( $arr[$depth_key] ); $i++ ) {
					$parent =& $parent[$depths[$i]];
				}
				$parent[$key] = $arr;
			}
			$depths[$arr[$depth_key] + 1] = $key;
		}
		return $nested;
	}
	/*

	SELECT child.*, (COUNT(parent.category) - 1) AS depth, COUNT(product_id) AS num_product
	FROM uthando_core.ushop_product_categories AS child, uthando_core.ushop_product_categories AS parent, uthando_core.ushop_products AS product
	WHERE child.lft BETWEEN parent.lft AND parent.rgt
	AND child.category_id = product.category_id
	GROUP BY category_id
	ORDER BY child.lft
	*/
	
	// returns the tree and it's depth.
	protected function queryTree ($limit=NULL) {
		
		// reset the tree array.
		$this->full_tree = null;
		
		$filter['WHERE'] = 'child.lft BETWEEN parent.lft AND parent.rgt';
		$filter['GROUP BY'] = $this->category_field.'_id';
		if ($this->top_level) $filter['HAVING'] = 'depth=0';
		$filter['ORDER BY'] = 'child.lft';
		if ($limit) $filter['limit'] = $limit;
		
		$result = $this->uthando->getResult(
			'child.*, (COUNT(parent.'.$this->category_field.') - 1) AS depth' . $linked_array['fields'],
			$this->table.' AS child, '.$this->table.' AS parent' . $linked_array['tables'],
			null,
			$filter
		);
		
		if ($result) {
			foreach ($result as $row) {
				$full_tree[] = $this->objectToArray($row);
			}
			$this->full_tree = $full_tree;
		}
	}
	
	public function getTopLevelTree($limit=NULL) {
		$this->top_level = true;
		if (!$this->full_tree || $limit != NULL) $this->queryTree($limit);
		$this->top_level = false;
		return $this->full_tree;
	}
	
	// returns the tree as an array and it's depth.
	public function getTree ($limit=NULL) {
		if (!$this->full_tree || $limit != NULL) $this->queryTree($limit);
		return $this->full_tree;
	}
	
	// returns number of rows returned by tree query.
	public function numTree ($limit=NULL) {
		if (!$this->full_tree || $limit != NULL) $this->queryTree($limit);
		$c = count ($this->full_tree);
		return $c;
	}
	
	// find pathway of a category.
	public function pathway ($id) {
		
		$result = $this->uthando->getResult(
			'parent.'.$this->category_field.'_id, parent.' . $this->category_field,
			$this->table.' AS child, '.$this->table.' AS parent',
			null,
			array(
				'WHERE' => 'child.lft BETWEEN parent.lft AND parent.rgt',
				'AND' => 'child.'.$this->category_field.'_id='.$id,
				'ORDER BY' => 'parent.lft'
			)
		);
		
		if ($result) {
			foreach ($result as $row) {
				$pathway[] = $this->objectToArray($row);
			}
			return $pathway;
		} else {
			return false;
		}

	}
	
	// set field id.
	public function setId ($id) {
		$this->id = $id;
	}
	
	// makes a query on the category database.
	public function getCategory ($id=NULL) {
		
		if ($id == NULL) $id = $this->id;
			
		if (is_numeric ($id)) {
			$filter['WHERE'] = 'child.'.$this->category_field."_id=".$id;
		} else {
			$filter['WHERE'] = 'child.'.$this->category_field."='".$id."'";
		}
		
		$result = $this->uthando->getResult(
			'child.*' . $linked_array['fields'],
			$this->table . ' AS child' . $linked_array['tables'],
			null,
			$filter
		);
		
		if ($result) {
			foreach ($result as $row) {
				$this->category = $this->objectToArray($row);
			}
			
			return $this->category;
		} else {
			return false;
		}
		
	}
	
	// returns a category field.
	public function getField ($field) {
		if (!$this->category) $this->getCategory();
		return $this->category[$field];
	}
	
	// returns the tree as an array and it's depth.
	public function getDecendants ($immediate_sub=FALSE) {
		$this->queryDecendants ($immediate_sub);
		return $this->decendants;
	}
	
	// returns number of rows returned by decendant query.
	public function numDecendants ($immediate_sub=FALSE) {
		$this->queryDecendants ($immediate_sub);
		$c = count ($this->decendants);
		return $c;
	}
	
	// returns all decendants and thier depth.
	protected function queryDecendants ($immediate_sub) {
		
		// reset the decendants array.
		$this->decendants = array();
		
		$filter = array(
			'WHERE' => 'child.lft BETWEEN parent.lft AND parent.rgt',
			'AND' => array(
				'child.lft BETWEEN sub_parent.lft AND sub_parent.rgt',
				'sub_parent.'.$this->category_field.'= sub_tree.'.$this->category_field
			),
			'GROUP BY' => 'child.'.$this->category_field
		);
		
		if ($immediate_sub) $filter['HAVING'] = 'depth>=1';
		$filter['ORDER BY'] = 'child.lft';
		
		$result = $this->uthando->getResult(
			'child.*, (COUNT( parent.'.$this->category_field.' ) - ( sub_tree.depth + 1 )) AS depth',
			$this->table.' AS child, '.$this->table.' AS parent, '.$this->table.' AS sub_parent, (
				SELECT child.'.$this->category_field.', (COUNT( parent.'.$this->category_field.') - 1) AS depth
				FROM '.$this->table.' AS child, '.$this->table.' AS parent
				WHERE child.lft BETWEEN parent.lft AND parent.rgt
				AND child.'.$this->category_field.'_id='.$this->id.'
				GROUP BY child.'.$this->category_field.'
				ORDER BY child.lft
			) AS sub_tree',
			null,
			$filter
		);
		
		if ($result) {
			foreach ($result as $row) {
				$decendants[] = $this->objectToArray($row);
			}
			$this->decendants = $decendants;
		}
	}
}
?>
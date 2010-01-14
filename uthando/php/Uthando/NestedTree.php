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
	
	public function __destruct () {
		unset($this);
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
	
	private function format_link_query() {
		
		$linked_array = array(
			'fields' => null,
			'tables' => null,
			'filter' => null
		);
		
		foreach ($this->linked_columns as $key => $value) {
			$linked_array['fields'] .= ', '.$key;
			$linked_array['tables'] .= ', '.$value;
			$linked_array['filter'][] .= 'child.'.$key.'_id = '.$value.'.'.$key.'_id';
		}
		
		return $linked_array;
		
	}
	
	// returns the tree and it's depth.
	protected function queryTree ($limit=NULL) {
		
		// reset the tree array.
		$this->full_tree = null;
		
		if ($this->linked_columns) $linked_array = $this->format_link_query();
		
		$filter['where'] = 'child.lft BETWEEN parent.lft AND parent.rgt';
		if ($this->linked_columns) $filter['and'] = $linked_array['filter'];
		$filter['group by'] = $this->category_field.'_id';
		if ($this->top_level) $filter['having'] = 'depth=0';
		$filter['order by'] = 'child.lft';
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
				'where' => 'child.lft BETWEEN parent.lft AND parent.rgt',
				'and' => 'child.'.$this->category_field.'_id='.$id,
				'order by' => 'parent.lft'
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
			$filter['where'] = 'child.'.$this->category_field."_id=".$id;
		} else {
			$filter['where'] = 'child.'.$this->category_field."='".$id."'";
		}
		
		if ($this->linked_columns) $linked_array = $this->format_link_query();
		if ($this->linked_columns) $filter['and'] = $linked_array['filter'];
		
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
			'where' => 'child.lft BETWEEN parent.lft AND parent.rgt',
			'and' => array(
				'child.lft BETWEEN sub_parent.lft AND sub_parent.rgt',
				'sub_parent.'.$this->category_field.'= sub_tree.'.$this->category_field
			),
			'group by' => 'child.'.$this->category_field
		);
		
		if ($immediate_sub) $filter['having'] = 'depth>=1';
		$filter['order by'] = 'child.lft';
		
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
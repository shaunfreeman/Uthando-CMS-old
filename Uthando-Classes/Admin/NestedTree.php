<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Admin_NestedTree extends NestedTree {
	
	private function updateLeft ($lft, $option, $offset) {
		
		switch ($option) {
			
			case 'add':
				$value = "lft+$offset";
				break;
			
			case 'minus':
				$value = "lft-$offset";
				break;
		}
		
		$result = $this->uthando->update(
			array('lft' => $value),
			$this->table,
			array(
				'where' => 'lft>'.$lft
			),
			false
		);
		
	}
	
	private function updateRight ($rgt, $option, $offset) {
	
		switch ($option) {
			
			case 'add':
				$value = "rgt+$offset";
				break;
			
			case 'minus':
				$value = "rgt-$offset";
				break;
		}
		
		$result = $this->uthando->update(
			array('rgt' => $value),
			$this->table,
			array(
				'where' => 'rgt>'.$rgt
			),
			false
		);
	
	}
	
	private function getPosition ($id, $option) {
		
		switch ($option) {
		
			case 'left':
				$select = "lft";
				break;
			
			case 'right':
				$select = "rgt";
				break;
			
			case 'both':
				$select = "lft, rgt";
				break;
		}
		
		$result = $this->uthando->getResult(
			$select . ', rgt - lft + 1 AS width',
			$this->table,
			$join=null,
			array(
				'where' => $this->category_field.'_id='.$id
			)
		);
		
		if ($result) {
			foreach ($result as $row) {
				$return_row = $this->objectToArray($row);
			}
			return $return_row;
		} else {
			return false;
		}
	
	}
	
	private function addCategory ($lft_rgt, $update) {
		
		$update['lft'] = $lft_rgt + 1;
		$update['rgt'] = $lft_rgt + 2;
		
		$result = $this->uthando->insert($update, $this->table);
		
		if ($result) {
			return $this->registry->db->lastInsertID();
		} else {
			return false;
		}

	}
	
	public function insert ($id, $update, $position) {
		
		$this->queryTree();
		
		if ($this->numTree() > 0) {
			$num = TRUE;
		} else {
			$num = FALSE;
		}
		
		switch ($position) {
			case 'new child':
 				if ($num == TRUE && $id != 0) {
					$row = $this->getPosition ($id, 'left');
				} else {
					$row['lft'] = 0;
				}
				$insert_id = $this->insertBefore ($row, $update);
				break;
				
			case 'after child':
				if ($num == TRUE && $id != 0) {
					$row = $this->getPosition ($id, 'right');
				} else {
					$row['rgt'] = 0;
				}
				$insert_id = $this->insertAfter ($row, $update);
				break;
		}
		return $insert_id;
	}
	
	private function insertBefore ($row, $update) {
		$this->updateRight ($row['lft'], 'add', 2);
		$this->updateLeft ($row['lft'], 'add', 2);
		$insert_id = $this->addCategory ($row['lft'], $update);
		return $insert_id;
	}
	
	private function insertAfter ($row, $update) {
		$this->updateRight ($row['rgt'], 'add', 2);
		$this->updateLeft ($row['rgt'], 'add', 2);
		$insert_id = $this->addCategory ($row['rgt'], $update);
		return $insert_id;
	}
	
	// delete a record.
	public function remove($id) {
		$row = $this->getPosition ($id, 'both');
		$result = $this->uthando->remove($this->table, 'lft BETWEEN '.$row['lft'].' AND '.$row['rgt']);
		if ($result) {
			$this->updateRight ($row['rgt'], 'minus', $row['width']);
			$this->updateLeft ($row['rgt'], 'minus', $row['width']);
			return true;
		} else {
			return false;
		}
	}
}
?>
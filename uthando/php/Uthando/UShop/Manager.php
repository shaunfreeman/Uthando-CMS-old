<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UShop_Manager
{
	protected $registry;
	protected $options = array();
	protected $get;
	protected $post;
	protected $dom;
	protected $select;
	
	public function __construct($registry, $options=array())
	{
		$this->registry = $registry;
		$this->options = array_merge($this->options, $options);
		$this->post = $_POST;
		$this->get = $_GET;
	}
	
	public function fireEvent($event)
	{
		if (!$event || !method_exists($this, $event)) return;
		$this->{$event}();
	}
	
	private function addAttributeList()
	{
		
		$attrs = $this->registry->db->query('
			SELECT *
			FROM '.$this->registry->core.'ushop_product_attributes
		');
		
		$this->dom = new HTML_Element();
		
		$root = $this->dom->createElement('div');
		
		$this->select = $this->dom->createElement('select', null, array('id' => 'attr_select'));
		$this->select->appendChild($this->dom->createElement('option', 'Select One'));
		$this->select->appendChild($this->dom->createElement('option', 'New Attribute', array('id' => 'new_attr')));
		
		$this->getDropDownBox($attrs);
		
		$new_attr = $this->dom->createElement('div', null, array('id' => 'add_new_attr', 'style' => 'display:none;'));
		$new_attr->appendChild($this->dom->createElement('input', null, array('id' => 'attr', 'type' => 'text', 'class' => 'valign')));
		$new_attr->appendChild($this->dom->createElement('button', 'Add Attribute', array('id' => 'add_attr_button', 'class' => 'valign')));
		
		$root->appendChild($this->select);
		$root->appendChild($new_attr);
		$this->dom->appendChild($root);
		
		print $this->dom->toHTML();
	}
	
	private function newAttribute()
	{
		$res = $this->registry->db->insert(array('attribute' => $this->post['attr']), $this->registry->core.'ushop_product_attributes');
	}
	
	private function getDropDownBox($array)
	{
		if (count($array) == 0) return;
		foreach ($array as $value):
			$this->select->appendChild($this->dom->createElement('option', $value->attribute, array('value' => $value->attribute_id)));
		endforeach;
	}
}

?>
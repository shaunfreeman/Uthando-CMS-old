<?php

defined( 'PARENT_FILE' ) or die( 'Restricted access' );

HTML_List extends HTML_Element
{
	public $list;
	public $list_items;
	public $list_type = 'ul';
	
	public function __construct($list=null)
	{
		parent::__construct();
		
		if ($list && is_array($list)) $this->list_items = $list;
	}
	
	public function makeList($list=null)
	{
		if (!$list) $list = $this->list_items;
		$list = $this->createElement($this->list_type, null, array('class' => ''));
		foreach ($list as $key => $value):
			if (is_array($value)) $this->makeList($value);
			$li = $this->createElement('li', $value, array('class' => ''));
			$list->appendChild($li);
		endforeach;
		return $list;
	}
}

?>
<?php

defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class HTML_Tabs extends HTML_Element
{
	private $root;
	private $tabs_only;
	
	public function __construct($data, $tabs_only=false)
	{
		parent::__construct();
		
		$this->tabs_only = $tabs_only;
		
		$this->root = $this->createElement('div', null, array('id' => 'morphTabs'));
		$this->createTabs($data);
		$this->appendChild($this->root);
	}
	
	public function addPanels($data)
	{
		$panel_set = $this->createDocumentFragment($data, array('id' => 'morphtabs_panelwrap'));
		$this->root->appendChild($panel_set);
	}
	
	private function getTabs($data)
	{
		$tabs = $this->createElement('ul', null, array('class' => 'morphtabs_title'));
		foreach ($data as $tab):
			$li = $this->createElement('li', null, array('class' => 'gradient', 'title' => $tab));
			$a = $this->createElement('a', ucwords(str_replace('_', ' ', $tab)), array('href' => '#'.$tab));
			$li->appendChild($a);
			$tabs->appendChild($li);
		endforeach;
		$this->root->appendChild($tabs);
	}
	
	private function getTabPanels($data)
	{
		$panel_set = $this->createElement('div', null, array('id' => 'morphtabs_panelwrap'));
		foreach ($data as $tab => $div):
			$panel_set->appendChild($this->createDocumentFragment($div, array('id' => $tab, 'class' => 'morphtabs_panel')));
		endforeach;
		$this->root->appendChild($panel_set);
	}
	
	private function createTabs($data)
	{
		$this->getTabs(array_keys($data));
		if (!$this->tabs_only) $this->getTabPanels($data);
	}
}

class TabsException extends Uthando_Exception {}

?>
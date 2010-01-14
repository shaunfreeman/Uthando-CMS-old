<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (is_readable($this->file . "/action/" . $this->registry->action . ".php") == false || $this->registry->action == "index") {
	$this->registry->Error('404 Page NOT Found', $this->registry->path);
} else {
	$title = ucwords(str_replace("_", " ", $this->registry->action));
	$this->registry->page_title = $title;
	$this->setTitle($title . ' | ' . $this->registry->config->get('site_name', 'SERVER'));

	$table_attrs = array('class' => 'contentpaneopen');
	$rowAttrs = array('class' => 'contentheading', 'width' => '100%');
	$table = new HTML_Table($table_attrs);
	$table->setCellContents(0, 0, $this->registry->page_title);
	$table->setColAttributes(0, $rowAttrs);
	
	$this->addContent($table->toHTML());
	
	require_once('action/'.$this->registry->action.'.php');

}

?>
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class AjaxContent extends Uthando {
	
	protected $registry;
	
	public $script = array();
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->registry->path = $_GET['path'];
		
		$this->registry->registerPath();
		
		parent::__construct($this->registry);
		
	}
	
	public function __destruct() {
		unset ($this);
	}
	
	public function AddScript($variable, $value, $set=FALSE) {
		if ($set) {
			$this->script[$variable] .= $value;
		} else {
			$script = "$('". strtolower($variable) ."').empty();\n";
			$script .= "$('". strtolower($variable) ."').set('text', '". $value ."');\n";
			$this->script[$variable] .= $script;
		}
	}
	
	public function setTitle($title) {
		$title = "document.title='".$title."';\n";
		$this->AddScript('TITLE', $title, TRUE);
	}
	
	public function display() {
		
		$this->html = $this->templateParser($this->html, $this->script, '/*{', '}*/');

		if ($this->registry->compress_files):
			print $this->compress_page(html_entity_decode($this->CreateBody()));
		else:
			print html_entity_decode($this->CreateBody());
		endif;
	}
}
?>
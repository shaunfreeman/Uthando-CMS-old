<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class AjaxContentAdmin extends UthandoAdmin {

	protected $registry;
	
	public $script = array();
	
	public function __construct($registry) {
		$this->registry = $registry;
		
		$this->registry->path = (isset($_GET['path'])) ? ($_GET['path']) : $_POST['path'];
		$this->registry->sessionId = (isset($_GET['session'])) ? $_GET['session'] : $_POST['session'];
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
		
		print $this->CreateBody();
	}
}

?>
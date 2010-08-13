<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class AjaxContent {
	
	private $vars = array();
	protected $parameters = array('content' => array(null));
	protected $modules = array();
	protected $registry;
	
	public $script = array();
	
	public function __construct($registry)
	{
		$this->registry = $registry;
		$this->doc = new HTML_Element('1.0', $this->charset);
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		if (array_key_exists($index, $this->vars)) return $this->vars[$index];
        return null;
	}
	
	public function AddScript($variable, $value, $set=false)
	{
		if ($set) {
			$this->script[$variable] .= $value;
		} else {
			$script = "$('". strtolower($variable) ."').empty();\n";
			$script .= "$('". strtolower($variable) ."').set('text', '". $value ."');\n";
			$this->script[$variable] .= $script;
		}
	}
	
	public function setTitle($title)
	{
		$title = "document.title='".$title."';\n";
		$this->AddScript('title', $title, true);
	}
	
	public function setTemplate($template=null)
	{
		$this->html = file_get_contents($template);
	}
	
	public function addModules($value)
	{
		$this->modules = $value;
	}
	
	public function addParameter($variable, $value)
	{
		$this->parameters[$variable][] = $value;
	}
	
	public function addContent($content)
	{
		$this->addParameter('content', $content);
	}
	
	public function display()
	{
		$this->html = HTML_Template::templateParser($this->html, $this->script, '/*{', '}*/');
		
		$content = array();
		foreach ($this->parameters['content'] as $value):
			$content['content'] .= $value;
		endforeach;
		
		$this->html = HTML_Template::templateParser($this->html, $content, '<!--{', '}-->');
		
		echo html_entity_decode($this->html);
	}
}
?>
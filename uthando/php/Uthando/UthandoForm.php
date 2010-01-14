<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UthandoForm extends HTML_QuickForm_Renderer_Default {
	
	private $template = NULL;
	public $_requiredNoteTemplate = '<p class="formRequiredNote">{requiredNote}</p>';
	
	public function __construct ($template) {
		$this->template = $template;
	}
	
	private function getTemplate($template) {
		$tpl = $this->template . '/form/' . $template . '.php';
		
		return implode ("", (file($tpl)));
	}
	
	public function setElementTemplate($template, $element = null) {
		$html = $this->getTemplate($template);
		if (is_null($element)) {
			$this->_elementTemplate = $html;
		} else {
			$this->_templates[$element] = $html;
		}
	}
	
	public function setGroupTemplate($template, $group) {
		$html = $this->getTemplate($template);
		$this->_groupWraps[$group] = $html;
	}
	
	public function setGroupElementTemplate($template, $group) {
		$html = $this->getTemplate($template);
		$this->_groupTemplates[$group] = $html;
	}
	
	function setHeaderTemplate($template) {
		$html = $this->getTemplate($template);
		$this->_headerTemplate = $html;
	}
	
	public function setFormTemplate($template) {
		$html = $this->getTemplate($template);
		$this->_formTemplate = $html;
	}
	
	public function setRequiredNoteTemplate($template) {
		$html = $this->getTemplate($template);
		$this->_requiredNoteTemplate = $html;
	}
}
?>
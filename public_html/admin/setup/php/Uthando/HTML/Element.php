<?php

defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class HTML_Element extends DOMDocument
{
	private $html_entities = array("/> </" => "><");
	
	public function __construct($version='1.0', $encoding='utf-8')
	{
		parent::__construct($version, $encoding);
		$this->preserveWhiteSpace = false;
		$this->formatOutput = true;
		$this->strictErrorChecking = false;
		$this->parse_entities();
	}
	
	private function parse_entities()
	{
		$obj = new ArrayObject (parse_ini_file(pathinfo(__FILE__, PATHINFO_DIRNAME).'/entities.ini'));
		$it = $obj->getIterator();
		while ($it->valid()):
			$this->html_entities['/&'.$it->key().';/'] = '&#'.$it->current().';';
    		$it->next();
		endwhile;
	}
	
	public function createDocumentFragment($fragment, $attrs=null, $js=false, $fragment_wrap='div')
	{
		$wrap = $this->createElement($fragment_wrap, null, $attrs);
		if ($js):
			$fragment = $this->removeJS($fragment);
			$javaScript = $fragment[1];
			$fragment = $this->entityDecode($fragment[0]);
		else:
			$fragment = $this->entityDecode($fragment);
		endif;
		$nodes = parent::createDocumentFragment();
		$nodes->appendXML($fragment);
		$wrap->appendChild($nodes);
		if ($js) $this->replaceJS($wrap, $javaScript);
		return $wrap;
	}
	
	public function createElement($tagName, $value=null, $attrs=null)
	{
		$node = ($value != null) ? parent::createElement($tagName, $this->entityDecode($value)) : parent::createElement($tagName);
		if (is_array($attrs)):
			foreach ($attrs as $key => $value):
				$node->setAttribute($key, $value);
			endforeach;
		endif;
		return $node;
	}
	
	public function saveXML($xmlProlog=false)
	{
		$xml = null;
		if ($xmlProlog):
			$xml = parent::saveXML();
		else:
			foreach ($this->childNodes as $node) $xml .= parent::saveXML($node);
		endif;
		return $xml;
	}
	
	public function toHTML()
	{
		return $this->saveXML();
	}
	
	private function replaceJS($nodes, $js)
	{
		$scripts = $nodes->getElementsByTagName('script');
		foreach ($scripts as $key => $value):
			$cm = $this->createTextNode(end($js[$key]));
			$value->appendChild($cm);
		endforeach;
	}
	
	private function removeJS($fragment)
	{
		preg_match_all('/<script(.*?)>(.*?)<\/script>/', $fragment, $js, PREG_SET_ORDER);
		$this->html_entities['/<script(.*?)>(.*?)<\/script>/'] = '<script></script>';
		return array($fragment, $js);
	}
	
	private function entityDecode($value)
	{
		return preg_replace(array_keys($this->html_entities), array_values($this->html_entities), $value);
	}
	
	public static function makeXmlSafe($value, $special=null)
	{
		return  ($special) ? htmlentities(htmlspecialchars($value)) : htmlentities($value);
	}
}

class HTMLElementException extends Uthando_Exception {}

?>
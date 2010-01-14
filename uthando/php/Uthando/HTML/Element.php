<?php

defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class HTML_Element extends DOMDocument
{
	private $html_entities = array(
		'/&quot;/' => '&#34;',
		'/&amp;/' => '&#38;',
		'/&apos;/' => '&#39;',
		'/&lt;/' => '&#60;',
		'/&gt;/' => '&#62;',
		'/&hellip;/' => '&#133;',
		'/&rsquo;/' => '&#146;',
		'/&ldquo;/' => '&#147;',
		'/&rdquo;/' => '&#148;',
		'/&bull;/' => '&#149;',
		'/&nbsp;/' => '&#160;',
		'/&pound;/' => '&#163;',
		'/&copy;/' => '&#169;',
		'/&laquo;/' => '&#171;',
		'/&reg;/' => '&#174;',
		'/&raquo;/' => '&#187;',
		'/&frac12;/' => '&#189;',
		'/&trade;/' => '&#8482;'
	);
	
	public function __construct($version='1.0', $encoding='utf-8')
	{
		parent::__construct($version, $encoding);
		$this->preserveWhiteSpace = false;
		$this->formatOutput = true;
		$this->strictErrorChecking = false;
	}
	
	public function createDocumentFragment($fragment, $attrs=null, $js=false)
	{
		$wrap = $this->createElement('div', null, $attrs);
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
		$node = ($value != null) ? parent::createElement($tagName, $value) : parent::createElement($tagName);
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
			foreach ($this->childNodes as $node) $xml .= parent::saveXML($node)."\n";
		endif;
		return html_entity_decode($xml);
	}
	
	public function toHTML($xmlProlog=false)
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
}

class HTMLElementException extends Uthando_Exception {}

?>
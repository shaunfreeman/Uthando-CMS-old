<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

define('PAGE_APPEND',  0);
define('PAGE_PREPEND', 1);
define('PAGE_REPLACE', 2);

class HTML_Page
{
	public $doc;
	protected $body = array();
	private $bodyAttributes = array();
	private $doctype = array('type'=>'xhtml','version'=>'1.0','variant'=>'strict');
	private $links = array();
	private $metaTags = array('standard' => array ('Generator' => 'Uthano CMS'));
	private $scripts = array();
	private $script = array();
	private $style = array();
	private $styleSheets = array();
	private $charset = 'utf-8';
	private $language = 'en';
	private $mime = 'text/html';
	private $simple = false;
	public $xmlProlog = true;

	public function __construct($attributes = array())
	{
		if (isset($attributes['charset'])) $this->setCharset($attributes['charset']);
		
		if (isset($attributes['doctype'])):
			if ($attributes['doctype'] == 'none'):
				$this->simple = true;
			elseif ($attributes['doctype']):
				$this->setDoctype($attributes['doctype']);
			endif;
		endif;
		
		if (isset($attributes['language'])) $this->setLang($attributes['language']);
		if (isset($attributes['mime'])) $this->setMimeEncoding($attributes['mime']);
		if (isset($attributes['namespace'])) $this->setNamespace($attributes['namespace']);
		if (isset($attributes['profile'])) $this->setHeadProfile($attributes['profile']);
		if (isset($attributes['cache'])) $this->setCache($attributes['cache']);
		if (isset($attributes['prolog'])) $this->xmlProlog = $attributes['prolog'];
		
		$this->doc = new HTML_Element('1.0', $this->charset);
	}

	private function generateHead()
	{
		$head = $this->doc->createElement('head');
		if ($this->profile) $head->setAttribute('profile', $this->profile);
		
		// Generate META tags
		foreach ($this->metaTags as $type => $tag):
			foreach ($tag as $name => $content):
				$attrs = null;
				if ($type == 'http-equiv'):
					$attrs['http-equiv'] = $name;
				elseif ($type == 'standard'):
					$attrs['name'] = $name;
				endif;
				$attrs['content'] = $content;
				$metahttp = $this->doc->createElement('meta', null, $attrs);
				$head->appendChild($metahttp);
			endforeach;
		endforeach;
		
		// Generate the title tag.
		$title = $this->doc->createElement('title', $this->getTitle());
		$head->appendChild($title);
		
		// Generate link declarations
		foreach ($this->links as $link) $head->appendChild($link);
		
		// Generate stylesheet links
		foreach ($this->styleSheets as $link) $head->appendChild($link);
		
		// Generate stylesheet declarations
		foreach ($this->style as $styledecl):
			foreach ($styledecl as $type => $content):
				$ct = $this->doc->createTextNode("\n" . $content . "\n");
				$style = $this->doc->createElement('style', null, array('type' => $type));
				$style->appendChild($ct);
				$head->appendChild($style);
			endforeach;
		endforeach;
		
		// Generate script file links
		foreach ($this->scripts as $script) $head->appendChild($script);
		
		// Generate script declarations
		foreach ($this->script as $script):
			foreach ($script as $type => $content):
				$cm = $this->doc->createTextNode("\n//");
				$ct = $this->doc->createCDATASection("\n" . $content . "\n//");
				$script = $this->doc->createElement('script', null, array('type' => $type));
				$script->appendChild($cm);
				$script->appendChild($ct);
				$head->appendChild($script);
			endforeach;
		endforeach;
		
		return $head;
	}

	private function generateBody()
	{
		$body = $this->doc->createElement('body', null, $this->bodyAttributes);
		foreach ($this->body as $value):
			if (is_string($value)) $value = $this->doc->createDocumentFragment($value, null, true);
			$body->appendChild($value);
		endforeach;
		return $body;
	}

	private function getDoctype()
	{
		require('HTML/Page/Doctypes.php');

		if (isset($this->doctype['type'])) $type = $this->doctype['type'];
		if (isset($this->doctype['version'])) $version = $this->doctype['version'];
		if (isset($this->doctype['variant'])) $variant = $this->doctype['variant'];
		
		$strDoctype = '';
		
		if (isset($variant)):
			if (isset($doctype[$type][$version][$variant][0])):
				foreach ( $doctype[$type][$version][$variant] as $string) $strDoctype .= $string."\n";
			endif;
		elseif (isset($version)):
			if (isset($doctype[$type][$version][0])):
				foreach ( $doctype[$type][$version] as $string) $strDoctype .= $string."\n";
			else:
				if (isset($default[$type][$version][0])):
					$this->doctype = $this->parseDoctypeString($default[$type][$version][0]);
					$strDoctype = $this->getDoctype();
				endif;
			endif;
		elseif (isset($type)):
			if (isset($default[$type][0])):
				$this->doctype = $this->parseDoctypeString($default[$type][0]);
				$strDoctype = $this->getDoctype();
			endif;
		else:
			$this->doctype = $this->_parseDoctypeString($default['default'][0]);
			$strDoctype = $this->getDoctype();
		endif;
		
		try
		{
			if ($strDoctype):
				$strDoctype = split("\n", $strDoctype);
				return DOMImplementation::createDocumentType($strDoctype[0], $strDoctype[1], $strDoctype[2]);
			else:
				throw new UthandoHTMLException('Error: "'.$this->getDoctypeString().'" is an unsupported or illegal document type.');
			endif;
		}
		catch (HTMLException $e)
		{
			echo "Caught UthandoHTMLException ('{$e->getMessage()}')\n{$e}\n";
			$this->simple = true;
			return false;
		}
	}

	private function getNamespace()
	{
		require('HTML/Page/Namespaces.php');
		
		if (isset($this->doctype['type'])) $type = $this->doctype['type'];
		if (isset($this->doctype['version'])) $version = $this->doctype['version'];
		if (isset($this->doctype['variant'])) $variant = $this->doctype['variant'];
		
		$strNamespace = '';
		
		if (isset($variant)):
			if (isset($namespace[$type][$version][$variant][0]) && is_string($namespace[$type][$version][$variant][0])):
				$strNamespace = $namespace[$type][$version][$variant][0];
			elseif (isset($namespace[$type][$version][0]) && is_string($namespace[$type][$version][0]) ):
				$strNamespace = $namespace[$type][$version][0];
			elseif (isset($namespace[$type][0]) && is_string($namespace[$type][0]) ):
				$strNamespace = $namespace[$type][0];
			endif;
		elseif (isset($version)):
			if (isset($namespace[$type][$version][0]) && is_string($namespace[$type][$version][0]) ):
				$strNamespace = $namespace[$type][$version][0];
			elseif (isset($namespace[$type][0]) && is_string($namespace[$type][0]) ):
				$strNamespace = $namespace[$type][0];
			endif;
		else:
			if (isset($namespace[$type][0]) && is_string($namespace[$type][0]) ) $strNamespace = $namespace[$type][0];
		endif;
		
		if ($strNamespace):
			return $strNamespace;
		else:
			PEAR::raiseError('Error: "' . $this->getDoctypeString() . '" does not have a default namespace.' . ' Use setNamespace() to define your namespace.', 0, PEAR_ERROR_TRIGGER);
			return false;
		endif;
	}
	
    private function parseDoctypeString($string)
    {
        $split = explode(' ',strtolower($string));
        $elements = count($split);
		
        if (isset($split[2])):
			$array = array('type'=>$split[0],'version'=>$split[1],'variant'=>$split[2]);
		elseif (isset($split[1])):
			$array = array('type'=>$split[0],'version'=>$split[1]);
        else:
			$array = array('type'=>$split[0]);
        endif;
		
        return $array;
    }

	public function addBodyContent($content, $flag = PAGE_APPEND)
	{
		if ($flag == PAGE_REPLACE):
			$this->unsetBody();
			$this->body[] =& $content;
		elseif ($flag == PAGE_PREPEND):
			array_unshift($this->body, $content);
		else:
			$this->body[] =& $content;
		endif;
	}

	public function addScript($url, $type="text/javascript")
	{
		$script = $this->doc->createElement('script');
		$script->setAttribute('src', $url);
		$script->setAttribute('type', $type);
		$this->scripts[] = $script;
	}

	public function addScriptDeclaration($content, $type = 'text/javascript')
	{
		$this->script[][strtolower($type)] =& $content;
	}

	public function addStyleSheet($url, $type = 'text/css', $media = null)
	{
		$link = $this->addLink($url, $type, 'stylesheet');
		if (!is_null($media)) $link->setAttribute('media', $media);
		if ($this->styleSheets instanceof ArrayObject):
			$this->styleSheets->append($link);
		else:
			$this->styleSheets = new ArrayObject(array($link));
		endif;
	}

	public function addStyleDeclaration($content, $type = 'text/css')
	{
		$this->style[][strtolower($type)] =& $content;
	}

	public function addFavicon($href, $type = 'image/x-icon', $relation = 'shortcut icon') {
		$link = $this->addLink($href, $type, $relation);
		$this->links[] = $link;
	}

	function addHeadLink($href, $relation, $relType = 'rel', $attributes = array())
	{
		$link = $this->addLink($href, null, null);
		$link->setAttribute($relType, $relation);
		foreach ($attributes as $key => $value) $link->setAttribute($key, $value);
		$this->links[] = $link;
	}

	public function addLink($href, $type, $relation)
	{
		$link = $this->doc->createElement('link');
		$link->setAttribute('href', $href);
		if (!is_null($relation)) $link->setAttribute('rel', $relation);
		if (!is_null($type)) $link->setAttribute('type', $type);
		return $link;
	}

	public function getCharset()
	{
		return $this->charset;
	}

	public function getDoctypeString()
	{
		$strDoctype = strtoupper($this->doctype['type']);
		$strDoctype .= ' '.ucfirst(strtolower($this->doctype['version']));
		if ($this->doctype['variant']) $strDoctype .= ' ' . ucfirst(strtolower($this->doctype['variant']));
		return trim($strDoctype);
	}

	function getLang()
	{
		return $this->language;
	}

	public  function getTitle()
	{
		if (!$this->title):
			if ($this->simple):
				return 'New Page';
			else:
				return 'New '. $this->getDoctypeString() . ' Compliant Page';
			endif;
		else:
			return $this->title;
		endif;
	}

	public function prependBodyContent($content)
	{
		$this->addBodyContent($content, PAGE_PREPEND);
	}

	public function setBody($content)
	{
		$this->addBodyContent($content, PAGE_REPLACE);
	}

	public function unsetBody()
	{
		$this->body = array();
	}

	public function setBodyAttributes($attributes)
	{
		$this->bodyAttributes($attributes);
	}

	public function setCache($cache = 'false')
	{
		if ($cache == 'true'):
			$this->cache = true;
		else:
			$this->cache = false;
		endif;
	}
	
	public function setCharset($type = 'utf-8')
	{
		$this->charset = $type;
	}

	public function setDoctype($type = "XHTML 1.0 Transitional")
	{
		$this->doctype = $this->parseDoctypeString($type);
	}

	public function setHeadProfile($profile = '')
	{
		$this->profile = $profile;
	}

	public function setLang($lang = "en")
	{
		$this->language = strtolower($lang);
	}

	public function setMetaData($name, $content, $http_equiv = false)
	{
		if ($content == ''):
			$this->unsetMetaData($name, $http_equiv);
		else:
			if ($http_equiv == true):
				$this->metaTags['http-equiv'][$name] = $content;
			else:
				$this->metaTags['standard'][$name] = $content;
			endif;
		endif;
	}

	public function unsetMetaData($name, $http_equiv = false)
	{
		if ($http_equiv == true):
			unset($this->metaTags['http-equiv'][$name]);
		else:
			unset($this->metaTags['standard'][$name]);
		endif;
	}

	public function setMetaContentType()
	{
		$this->setMetaData('Content-Type', $this->mime . '; charset=' . $this->charset , true );
	}

	public function setMetaRefresh($time, $url = 'self', $https = false)
	{
		if ($url == 'self'):
			if ($https):
				$protocol = 'https://';
			else:
				$protocol = 'http://';
			endif;
			$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		endif;
		$this->setMetaData("Refresh", "$time; url=$url", true);
	}

	public function setMimeEncoding($type = 'text/html')
	{
		$this->mime = strtolower($type);
	}

	public function setNamespace($namespace = '')
	{
		if (isset($namespace)):
			$this->namespace = $namespace;
		else:
			$this->namespace = $this->getNamespace();
		endif;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function display()
	{
		print $this->toHTML();
	}

	public function toHTML()
	{
		$this->doc->appendChild($this->getDoctype());

		$html = $this->doc->createElement('html');
		
		if ($this->doctype['type'] == 'xhtml') $html->setAttribute('xml:lang', $this->getLang());

		$this->doc->appendChild($html);
		
		$html->appendChild($this->generateHead());
		$html->appendChild($this->generateBody());
		
		return $this->doc->saveXML($this->xmlProlog);
	}
}

class UthandoHTMLException extends Uthando_Exception {}

?>
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class HTML_Template extends HTML_Page
{
	private $vars;
	protected $parameters = array('content' => array('<span>&nbsp;</span>'));
	protected $modules = array();
	protected $registry;
	
	public function __construct($registry, $template)
	{
		parent::__construct();
		$this->registry = $registry;
		$this->settings = parse_ini_file(SETUP_PATH.'/template/ini/template.ini.php', true);
		$this->setTemplate();
		
		$this->setCache(true);
		$this->xmlProlog = $this->settings['general']['xmlProlog'];
		$this->setDoctype($this->settings['general']['doctype']);
		
		$this->addFavicon('/Common/images/favicon.ico');
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
	
	private function loadScript($script)
	{
		if (!is_array($script)) return false;
		foreach ($script as $value):
			if ($this->settings['general']['load_cache'] || $this->settings['general']['dbug'] || is_file($_SERVER['DOCUMENT_ROOT'].$value)):
				$this->addScript($value);
			else:
				$this->addScriptDeclaration($value);
			endif;
		endforeach;
	}
	
	public function loadJavaScript($scripts)
	{
		$this->loadScript($scripts);
	}
	
	private function addStyle($style)
	{
		$this->addStyleSheet($style[0], $style[1], $style[2]);
	}
	
	public function loadStyles($styles)
	{
		if (is_array($styles)):
			foreach ($styles as $style):
				if (is_array($style)):
					$this->addStyle($style);
				else:
					if ($this->registry->compress_files) $style = $this->compress_styles($style);
					$this->addStyleDeclaration($style);
				endif;
			endforeach;
		endif;
	}
	
	public function compressCSS($buffer)
	{
		// remove comments, tabs, spaces, newlines, etc.
		$search = array(
			"/\/\*(.*?)\*\/|[\t\r\n]/s" => "",
			"/ +\{ +|\{ +| +\{/" => "{",
			"/ +\} +|\} +| +\}/" => "}",
			"/ +: +|: +| +:/" => ":",
			"/ +; +|; +| +;/" => ";",
			"/ +, +|, +| +,/" => ","
		);
		$buffer = preg_replace(array_keys($search), array_values($search), $buffer);
		return $buffer;
	}
	
	public function compress($buffer)
	{
		// remove comments, tabs, spaces, newlines, etc.
		$search = array(
			"/ +/" => " ",
			"/<!--\{(.*?)\}-->|<!--(.*?)-->|[\t\r\n]|<!--|-->|\/\/ <!--|\/\/ -->|<!\[CDATA\[|\/\/ \]\]>|\]\]>|\/\/\]\]>|\/\/<!\[CDATA\[/" => ""
		);
		$buffer = preg_replace(array_keys($search), array_values($search), $buffer);
		return $buffer;
	}

	public function setTemplate($template=null)
	{
		$template = ($template) ? $template : SETUP_PATH . '/template/index.html';
		$this->setBody($this->doc->createDocumentFragment($this->compress(file_get_contents($template)), null, true));
	}

	public function setMetaTags($meta_tags)
	{
		if (is_array($meta_tags)):
			foreach ($meta_tags as $key => $value):
				if (is_array($value)):
					$this->setMetaData($key, $value[0], $value[1]);
				else:
					$this->setMetaData($key, $value);
				endif;
			endforeach;
		endif;
	}
	
	public function deleteParameter($variable)
	{
		unset ($this->parameters[$variable]);
	}
	
	public function addParameter($variable, $value)
	{
		$this->parameters[$variable][] = $value;
	}
	
	public function addModules($value)
	{
		$this->modules = $value;
	}
	
	public function templateParser($template, $params, $key_start, $key_end)
	{
		// Loop through all the parameters and set the variables to values.
		foreach ($params as $key => $value):
			$template_name = $key_start . $key . $key_end;
			$template = str_replace ($template_name, $value, $template);
		endforeach;
		return $template;
	}
	
	public function addContent($content)
	{
		$this->addParameter('content', $content);
	}
	
	private function parseElements()
	{
		$elements = $this->body[0]->getElementsByTagName('element');
		$i = $elements->length - 1;
		while ($i > -1) {
			$element = $elements->item($i);
			$attrs = array(
				'id' => $element->getAttribute('id'),
				'src' => '/userfiles/'.$this->registry->settings['resolve'].'/images/'.$this->settings['elements'][$element->getAttribute('param')]
			);
			$newelement = $this->doc->createElement($element->getAttribute('name'), null, $attrs);
			$element->parentNode->replaceChild($newelement, $element);
			$i--;
		}
	}
	
	private function parseModules()
	{
		$elements = $this->body[0]->getElementsByTagName('module');
		
		if ($elements):
			$i = $elements->length - 1;
			while ($i > -1):
				$element = $elements->item($i);
				if ($this->modules[$element->getAttribute('name')]):
					$newelement = $this->doc->createElement('div');
					foreach ($this->modules[$element->getAttribute('name')] as $el):
						if (!$el) continue;
						$newelement->appendChild($el);
					endforeach;
					$element->parentNode->replaceChild($newelement, $element);
				else:
					$element->parentNode->removeChild($element);
				endif;
				$i--;
			endwhile;
		endif;
	}
	
	private function parseParameters()
	{
		$elements = $this->body[0]->getElementsByTagName('param');
		$i = $elements->length - 1;
		while ($i > -1):
			$newelement = null;
			$element = $elements->item($i);
			if ($this->parameters[$element->getAttribute('name')]):
				foreach ($this->parameters[$element->getAttribute('name')] as $key => $content):
					if (!$content) continue;
					if (is_string($content)) {
						$newelement .= $content;
					} else if ($content instanceof DOMElement) {
						$newelement = $content;
					}
				endforeach;
				$newelement = $this->doc->createDocumentFragment($this->compress($newelement),array('id' => $element->getAttribute('name')),true,'span');
				$element->parentNode->replaceChild($newelement, $element);
			else:
				$element->parentNode->removeChild($element);
			endif;
			$i--;
		endwhile;
	}
	
	private function errorCheck()
	{
		if ($this->registry->errors):
			
			if (is_file(__SITE_PATH.'/templates/' . $this->settings['general']['name'] . '/html/errors.html')):
				
				$message = file_get_contents(__SITE_PATH.'/templates/' . $this->settings['general']['name'] . '/html/errors.html');
				
				$message = $this->templateParser($message, array('ERROR' => $this->registry->errors), '<!--{', '}-->');
				
				$this->registry->errors = $message;
			endif;
			
			$this->addParameter('error', $this->registry->errors);
		endif;
	}
	
	// This function does the bulk of the work.
	public function __toString()
	{
		// check php errors.
		$this->errorCheck();
		$this->parseElements();
		//$this->parseModules();
		$this->parseParameters();
		// set page metadata.
		$this->setMetaTags($this->settings['metadata']);
		// load CSS Styles
		$css_files = $this->settings['css'];
		
		if ($this->registry->component_css) $css_files = array_merge($css_files, $this->registry->component_css);
			
		foreach ($css_files as $filename):
			if (!$this->settings['general']['dbug'] && !$this->settings['general']['cache']):
				$styles[] = file_get_contents(__SITE_PATH.$filename);
			else:
				$styles[] = array($filename, 'text/css' ,null);
			endif;
		endforeach;
		$this->loadStyles($styles);
		
		// load in JavaScript
		$js = new JsLoader($this->registry);
		
		$js_end_files = $this->settings['js'];
		
		// add any component javascript.
		if ($this->registry->component_js):
			$js_end_files = array_merge($js_end_files, $this->registry->component_js);
		endif;
		
		if ($js_end_files):
			foreach ($js_end_files as $key => $files):
				$js_end_files[$key] = $this->registry->host.$files;
			endforeach;
		endif;
		
		if ($this->settings['general']['cache']):
			$js->dbug = true;
			$js->scripts = array($this->registry->host.$this->settings['cacheJS']);
		else:
			$js->scripts = $this->settings['mootools'];
			if ($js->scripts):
				foreach ($js->scripts as $key => $files):
					$js->scripts[$key] =  $this->registry->get('config.server.web_url').$files;
				endforeach;
			endif;
		endif;
		
		if ($js_end_files) $js->scripts = array_merge($js->scripts,$js_end_files);
		
		$this->loadJavaScript($js->load_js());
		//$this->addScriptDeclaration("if (!Uthando) var Uthando = $H({}); Uthando.server = '".$registry->server."';");
		
		//adjust page columns
		$columns = $this->body[0]->getElementsByTagName('section');
		foreach ($columns as $col):
			if ($col->getAttribute('id') == $this->cols):
				 $col->parentNode->removeChild($col);
				 break;
			endif;
		endforeach;
		
		return $this->toHTML();
	}
}

?>
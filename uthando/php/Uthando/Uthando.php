<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Uthando extends HTML_Page {
	
	// Set the attributes.
	public $html;
	protected $parameters = array('ERROR' => null, 'MERCHANT_NAME' => null);
	protected $vars = array(); 
	protected $registry; // registry
	public $striptags = false;
			
	public function __construct ($registry) {
		$this->registry = $registry;
		parent::__construct();
		$this->addParameter('SITE_FOLDER', $this->registry->settings['resolve']);
		$this->addParameter('SITE_LOGO', $this->registry->config->get('logo', 'SERVER'));
	}
	
	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}
	
	public function __get($index) {
		return $this->vars[$index];
	}
	
	private function loadScript($script) {
		if (!is_array($script)) return false;
		foreach ($script as $value):
			if ($this->registry->load_cache || $this->registry->dbug || is_file($_SERVER['DOCUMENT_ROOT'].$value)):
				$this->addScript($value);
			else:
				$this->addScriptDeclaration($value);
			endif;
		endforeach;
	}
	
	public function loadJavaScript($scripts) {
		$this->loadScript($scripts);
	}
	
	private function addStyle($style) {
		$this->addStyleSheet($style[0], $style[1], $style[2]);
	}
	
	public function loadStyles($styles) {
		
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
	
	private function compress_styles($buffer) {
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
	
	public function compress_page($buffer) {
		// remove comments, tabs, spaces, newlines, etc.
		$search = array(
			"/ +/" => " ",
			"/<!--\{(.*?)\}-->|<!--(.*?)-->|[\t\r\n]|<!--|-->|\/\/ <!--|\/\/ -->|<!\[CDATA\[|\/\/ \]\]>|\]\]>|\/\/\]\]>|\/\/<!\[CDATA\[/" => ""
		);
		$buffer = preg_replace(array_keys($search), array_values($search), $buffer);
		return $buffer;
	}

	public function setTemplate($template) {
		//$this->template = $template;
		$this->html = file_get_contents($template);
	}

	public function setMetaTags($meta_tags) {
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
	
	public function deleteParameter($variable) {
		unset ($this->parameters[$variable]);
	}
	
	public function addParameter($variable, $value) {
		$this->parameters[$variable] .= $value;
	}
	
	public function templateParser($template, $params, $key_start, $key_end) {
		// Loop through all the parameters and set the variables to values.
		foreach ($params as $key => $value):
			$template_name = $key_start . $key . $key_end;
			$template = str_replace ($template_name, $value, $template);
		endforeach;
		return $template;
	}
	
	// This function does the bulk of the work.
	public function CreateBody() {
		// check php errors.
		$this->ErrorCheck();
		//print_r($this->parameters);
		$this->html = $this->templateParser($this->html, $this->parameters, '<!--{', '}-->');
		return $this->compress_page($this->html);
	}
	
	public function addContent($content) {
		$this->AddParameter ('CONTENT', $content);
	}
	
	public function loadComponent() {
		
		$this->file = __SITE_PATH . '/components/' . $this->registry->component;
		
		if (is_readable($this->file . "/index.php") == false):
			$this->registry->Error('404 Page NOT Found', $this->registry->path);
		else:
			$load = $this->getResult('enabled', $this->registry->db_default.'components', null, array('where' => "component='".$this->registry->component."'"), false);
		endif;
		
		if ($load->enabled):
			include ($this->file. "/index.php");
			$this->addContent($this->content);
		else:
			$this->addContent('<p>Component is not enabled.</p>');
		endif;
	}
	
	public function addModules() {
		// Get Modules and add them.
		$this->getModules();
	}
	
	private function getModules() {
		
		$result = $this->getResult('position_id, position', 'modules_position', null, null, true);
		
		$cols = 2;
		
		if ($result):
		
			foreach ($result as $mod):
			
				if ($mod->position == 'right') $cols = 3;
				
				$module_position = 'MODULE['.$mod->position.']';
				
				$modules = $this->getResult(
					'module_id, module_name, module, show_title, params, html',
					'modules',
					'module_names',
					array(
						'WHERE' => "position_id='".$mod->position_id."'",
						'AND' => 'enabled=1',
	  					'ORDER BY' => 'sort_order ASC'
					)
				);
				
				if ($modules):
					
					$value = null;
					foreach ($modules as $mod):
						$module = new Module($this->registry);
						$value .= $module->makeModule($mod);
						unset($module);
					endforeach;
					
					$this->AddParameter ($module_position, $value);
				endif;
			endforeach;
		endif;
		
		$this->html = $this->removeSection($cols.'_col', $this->html);
	}
	
	public function removeSection($type, $html) {
		return preg_replace("/<!--".$type."_start-->(.*?)<!--".$type."_end-->/s", "", $html);
	}
	
	// form functions
	public function escape_db_data ($data) {
		if (ini_get('magic_quotes_gpc')) $data = stripslashes($data);
		if ($this->striptags) $data = strip_tags($data);
		
		return $this->registry->db->escape(trim($data));
	}
	
	public function formValues($values) {
		foreach ($values as $key => $value):
			if (is_array($value)):
				$values[$key] = $this->formValues($value);
			else:
				$values[$key] = $this->escape_db_data($value);
			endif;
		endforeach;
		return $values;
	}
	
	public function returnFormValues($values) {
		return $values;
	}

	// sql functions. here for compatability, will be removed later.
	public function remove($table, $where)
	{
		return $this->registry->db->remove($table, $where);
	}
	
	public function update($update, $table, $filter, $quote=true)
	{
		return $this->registry->db->update($update, $table, $filter, $quote);
	}
	
	public function insert($insert, $table, $quote=true)
	{
		return $this->registry->db->insert($insert, $table, $quote);
	}
	
	public function getResult($values, $table, $join=null, $filter=null, $array_mode=true)
	{
		return $this->registry->db->getResult($values, $table, $join, $filter, $array_mode);
	}
	
	public function objectToArray($object) {
		$array = array();
		if (is_object($object)) $array = get_object_vars($object);
		return $array;
	}

	function arrayToObject($array) {
		$object = new stdClass();
		if (is_array($array) && count($array) > 0):
			foreach ($array as $name=>$value):
				$name = strtolower(trim($name));
				if (!empty($name)) $object->$name = $value;
			endforeach;
		endif;
		return $object;
	}
	
	public function dataTable($data, $header=null, $class=null) {
		
		$table = new HTML_Table();
		$table->setAutoGrow(true);
		$table->setAutoFill('');
	
		$hrAttrs = ($class) ? array('class' => $class) : null;
		
		for ($nr = 0; $nr < count($data); $nr++):
			$table->setHeaderContents($nr+1, 0, (string)$data[$nr][0]);
			for ($i = 1; $i < count($data[$nr]); $i++):
				if ('' != $data[$nr][$i]) $table->setCellContents($nr+1, $i, $data[$nr][$i]);
				$table->setRowAttributes($nr+1, $hrAttrs, true);
			endfor;
		endfor;
		
		for ($i = 0; $i < count($header); $i++) $table->setHeaderContents(0, $i, $header[$i]);
		
		return $table;
	}
	
	private function contentpaneHeading($heading) {
		$table = new HTML_Table(array('class' => 'contentpaneopen'));
		$table->setCellContents(0, 0, stripslashes($heading));
		$table->setColAttributes(0, array('class' => 'contentheading'));
		return $table->toHTML();
	}
	
	private function getCdate($date) {
		return '<div class="createdate">'.$date.'</div>';
	}
	
	private function getMdate($date) {
		return  '<div class="modifydate">Last Updated ( '.$date.' )</div><span class="article_separator"></span>';
	}
	
	public function displayContentpane($data, $heading=null, $cdate=null, $mdate=null) {
		$pane = null;
		if ($heading) $pane .= $this->contentpaneHeading($heading);
		if ($cdate) $pane .= $this->getCdate($cdate);
		$pane .= '<div class="contentpaneopen">'.$data.'</div>';
		if ($mdate) $pane .= $this->getMdate($mdate);
		return $pane;
	}
	
	public function message($params) {
		$message = file_get_contents(__SITE_PATH.'/templates/' . $this->registry->template . '/html/message.html');
		return $this->templateParser($message, $params, '<!--{', '}-->');
	}
	
	public function array_flatten(array $array){
		if($array):
			$flat = array();
			foreach(new RecursiveIteratorIterator(new RecursiveArrayIterator($array), RecursiveIteratorIterator::SELF_FIRST) as $key=>$value) if(!is_array($value)) $flat[] = $value;
			return $flat;
		else:
			return false;
		endif;
	}
	
	public function ErrorCheck() {
		
		if ($this->registry->errors):
			
			if (is_file(__SITE_PATH.'/templates/' . $this->registry->template . '/html/errors.html')):
				
				$message = file_get_contents(__SITE_PATH.'/templates/' . $this->registry->template . '/html/errors.html');
				
				$message = $this->templateParser($message, array('ERROR' => $this->registry->errors), '<!--{', '}-->');
				
				$this->registry->errors = $message;
			endif;
			
			$this->AddParameter ('ERROR', $this->registry->errors);
		endif;
	}
}
?> 
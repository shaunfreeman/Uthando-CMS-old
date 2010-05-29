<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Uthando
{
	// Set the attributes.
	protected $vars = array(); 
	protected $registry; // registry
	public $striptags = false;
			
	public function __construct ($registry)
	{
		$this->registry = $registry;
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
	
	// Function for browser redirection.
	public static function go($go=null)
	{
		header ('Location: ' . SCHEME . HOST . $go);
		ob_end_clean();
		exit;
	}
	
	// Function for setting the referer url.
	public static function referer()
	{
		$_SESSION['referer_link'] = SCHEME . HOST . REQUEST_URI;
	}
	
	public function loadComponent()
	{
		$this->file = COMPONENTS . $this->registry->component;
		
		if (is_readable($this->file . "/index.php") == false):
			$this->registry->Error('404 Page NOT Found', $this->registry->path);
		else:
			$load = $this->getResult('enabled', $this->registry->core.'components', null, array('where' => "component='".$this->registry->component."'"), false);
		endif;
		
		if ($load->enabled):
			include ($this->file. "/index.php");
			$this->registry->template->addContent($this->content);
		else:
			$this->registry->template->addContent('<p>Component is not enabled.</p>');
		endif;
	}
	
	public function addModules()
	{
		// Get Modules and add them.
		$this->getModules();
	}
	
	private function getModules()
	{
		$result = $this->getResult('position_id, position', 'modules_position', null, null, true);
		
		$cols = 2;
		if ($result):
		
			foreach ($result as $mod):
			
				if ($mod->position == 'right') $cols = 3;
				
				$module_position = $mod->position;
				
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
					foreach ($modules as $mod):
						$module = new Module($this->registry);
						$value[$module_position][] = $module->makeModule($mod);
						unset($module);
					endforeach;
				endif;
			endforeach;
		endif;
		$this->registry->template->addModules($value);
		$this->registry->template->cols = $cols.'col';
	}
	
	public function removeSection($type, $html)
	{
		return preg_replace("/<!--".$type."_start-->(.*?)<!--".$type."_end-->/s", "", $html);
	}
	
	// form functions
	public function escape_db_data ($data)
	{
		if (ini_get('magic_quotes_gpc')) $data = stripslashes($data);
		if ($this->striptags) $data = strip_tags($data);
		
		return $this->registry->db->escape(trim($data));
	}
	
	public function formValues($values)
	{
		foreach ($values as $key => $value):
			if (is_array($value)):
				$values[$key] = $this->formValues($value);
			else:
				$values[$key] = $this->escape_db_data($value);
			endif;
		endforeach;
		return $values;
	}
	
	public function returnFormValues($values)
	{
		return $values;
	}
	
	public function objectToArray($object)
	{
		$array = array();
		if (is_object($object)) $array = get_object_vars($object);
		return $array;
	}

	function arrayToObject($array)
	{
		$object = new stdClass();
		if (is_array($array) && count($array) > 0):
			foreach ($array as $name=>$value):
				$name = strtolower(trim($name));
				if (!empty($name)) $object->$name = $value;
			endforeach;
		endif;
		return $object;
	}
	
	public function dataTable($data, $header=null, $class=null)
	{
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
	
	private function contentpaneHeading($heading)
	{
		$table = new HTML_Table(array('class' => 'contentpaneopen'));
		$table->setCellContents(0, 0, stripslashes($heading));
		$table->setColAttributes(0, array('class' => 'contentheading'));
		return $table->toHTML();
	}
	
	private function getCdate($date)
	{
		return '<div class="createdate">'.$date.'</div>';
	}
	
	private function getMdate($date) {
		return  '<div class="modifydate">Last Updated ( '.$date.' )</div><span class="article_separator"></span>';
	}
	
	public function displayContentpane($data, $heading=null, $cdate=null, $mdate=null)
	{
		$pane = null;
		if ($heading) $pane .= $this->contentpaneHeading($heading);
		if ($cdate) $pane .= $this->getCdate($cdate);
		$pane .= '<div class="contentpaneopen">'.$data.'</div>';
		if ($mdate) $pane .= $this->getMdate($mdate);
		return $pane;
	}
	
	public function message($params)
	{
		$message = file_get_contents(SITE_PATH.'/templates/' . $this->get('config.site.template') . '/html/message.html');
		return $this->templateParser($message, $params, '<!--{', '}-->');
	}
	
	public function array_flatten(array $array)
	{
		if($array):
			$flat = array();
			foreach(new RecursiveIteratorIterator(new RecursiveArrayIterator($array), RecursiveIteratorIterator::SELF_FIRST) as $key=>$value) if(!is_array($value)) $flat[] = $value;
			return $flat;
		else:
			return false;
		endif;
	}
	
	// shortcut functions for the modules and components.
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
	
	public function getRow($sql, $bind=null)
	{
		return $this->registry->db->getRow($sql, $bind);
	}
	
	public function addContent($value)
	{
		$this->registry->template->addContent($value);
	}
	
	public function addParameter($variable, $value)
	{
		$this->registry->template->addParameter($variable, $value);
	}
	
	public function deleteParameter($variable)
	{
		$this->registry->template->deleteParameter($variable);
	}
	
	public function setTitle($title)
	{
		$this->registry->template->setTitle($title);
	}
	
	public function addScriptDeclaration($value)
	{
		$this->registry->template->addScriptDeclaration($value);
	}
	
	public function loadJavaScript($scripts)
	{
		$this->registry->template->loadJavaScript($scripts);
	}
	
	private function compressCSS($buffer)
	{
		return HTML_Template::compressStyles($buffer);
	}
	
	public function compress($buffer)
	{
		return HTML_Template::compress($buffer);
	}
	
	public function templateParser($template, $params, $key_start, $key_end)
	{
		return HTML_Template::templateParser($template, $params, $key_start, $key_end);
	}
	
	public function get($key=null)
	{
		return $this->registry->get($key);
	}
}
?> 
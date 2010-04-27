<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class JsLoader {
	
	public $scripts = array();
	private $path = array();
	private $vars = array(
		'cache' => false,
		'cache_dir' => '/Common/javascript/',
		'dbug' => true,
		'compress_file' => false,
		'source_root' => '/Common/javascript/Source/',
		'json_file' => array('mootools-core', 'mootools-more', 'clientcide', 'uthando'),
		'includes' => array(),
		'add_at_end' => array(),
		'libs' => array()
	);
	protected $registry;
	
	public function __construct($registry)
	{
		$this->dbug = $registry->template->settings['general']['dbug'];
		$this->compress_file = $registry->template->settings['general']['compress_files'];
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
	
	public function load_js()
	{
		if (!$this->dbug):
			return $this->compile_files();
		else:
			return $this->scripts;
		endif;
	}
	
	private function compile_files()
	{
		foreach ($this->scripts as $value):
			$script = file_get_contents($value);
			if ($this->compress_file):
				$packer = new JavaScriptPacker($script, 'None', false, false);
				$script = $packer->pack();
			endif;
			$scripts[] = $script;
		endforeach;
		return $scripts;
	}
	
	public function load_json($parse=false)
	{
		foreach($this->json_file as $file):
			
			$js = file_get_contents($this->source_root.$file.'/scripts.json');
			$libs[$file] = json_decode($js, true);
			
			foreach ($libs[$file] as $key1 => $value1):
				foreach ($value1 as $key2 => $value2):
					array_push($this->path, $file."/".$key1."/".$key2);
				endforeach;
			endforeach;
		endforeach;
		$this->libs = $libs;
		if ($parse) $this->parse_list();
	}
	
	private function parse_list()
	{
		$sections = Uthando::array_flatten($this->includes);
		
		foreach ($this->path as $value):
			$folder = split('/', $value);
			foreach ($sections as $file):
				if ($file == $folder[1]):
					array_push($this->scripts, $this->source_root.$value.'.js');
					continue;
				endif;
			endforeach;
		endforeach;
		
		if ($this->add_at_end):
			if (is_array($this->add_at_end)):
				foreach ($this->add_at_end as $file):
					array_push($this->scripts, $file);
				endforeach;
			else:
				array_push($this->scripts, $this->add_at_end);
			endif;
		endif;
		
	}
	
}

?>
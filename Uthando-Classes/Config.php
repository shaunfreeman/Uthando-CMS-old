<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Config
{
	public $path = null;
	public $process_sections = true;
	protected $registry;
	public $vars = array();
	
	public function __construct($registry, $options=null)
	{
		$this->registry = $registry;
		if ($options['path'] && is_string($options['path'])) $this->path = $options['path'];
		if ($options['process_sections'] && is_bool($options['process_sections'])) $this->process_sections = $options['process_sections'];
		
		if ($this->path) $this->load();
	}
	
	public function get($key=null, $section=null)
	{
		if ($section):
			$value = $this->vars[$section][$key];
		else:
			$value = $this->vars[$key];
		endif;
		return ($value===false) ? null : $value;
	}
	
	public function load()
	{
		try
		{
			if (!is_file($this->path)) throw new ConfigException("ConfigMagik::load() - Path('$path') is invalid, nothing loaded.");
			$this->vars = parse_ini_file($this->path, $this->process_sections);
			return true;
		}
		catch (ConfigException $e)
		{
			$this->registry->Error($e->getMessage());
			return false;
		}
	}
	
	public function listKeys($section=null) {
		try
		{
			// check if section was passed
			if ($section!==null):
				// check if passed section exists
				$sections = $this->listSections();
				if (in_array ($section, $sections)===false) throw new ConfigException("ConfigMagik::listKeys() - Section('$section') could not be found.");
				
				// list all keys in given section
				$list = array();
				$all = array_keys( $this->vars[$section]);
				foreach ($all as $possible_key):
					array_push( $list, $possible_key);
				endforeach;
				return $list;
			else:
				// list all keys (section-less)
				return array_keys($this->vars);
			endif;
		}
		catch (ConfigException $e)
		{
			$this->registry->Error($e->getMessage());
			return false;
		}
	}
	
	public function listSections(){
		$list = array();
		// separate sections from normal keys
		$all = array_keys($this->vars);
		foreach ( $all as $possible_section){
			if (is_array( $this->vars[$possible_section])) {
				array_push( $list, $possible_section);
			}
		}
		return $list;
	}
}

class ConfigException extends UthandoException {}

?>
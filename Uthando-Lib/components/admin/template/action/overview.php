<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$content = null;
	
	if (isset($_POST['tmpl'])):
		$template = explode(':', $_POST['tmpl']);
		
		$path = ($template == 'administration') ? $this->registry->ini_dir.'/uthandoAdmin.ini.php' : $this->registry->ini_dir.'/uthando.ini.php';
		
		$config = new Admin_Config($this->registry, array('path' => $path));
		
		$config->set('template',$template[1],'site');
		$config->save();
	endif;
	
	foreach ($dirs as $key => $value):
		$iterator = new DirectoryIterator($value);
		foreach ($iterator as $fileinfo):
			if (!$fileinfo->isDot()):
				if ($fileinfo->isDir()):
					$templates[$key][] = $fileinfo->getFilename();
				endif;
			endif;
		endforeach;
		sort($templates[$key]);
		unset($iterator);
	endforeach;
	
	// create the tabs.
	foreach($templates as $key => $value):
		$c = 0;
		$data = array();
		
		$default = ($key == 'site') ? $this->get('config.site.template') : $this->get('admin_config.site.template');
		
		foreach($value as $tmpl_name):
			$data[$c][] = '<input type="radio" name="tmpl" id="'.$tmpl_name.'_radio" value="'.$key.':'.$tmpl_name.'" />';
			$data[$c][] = $tmpl_name;
			$data[$c][] = ($default == $tmpl_name) ? '<img src="/templates/'.$this->get('admin_config.site.template').'/images/16x16/Favorites.png" />' : '';
			$c++;
		endforeach;
		
		$header = array('', 'Template Name', 'Default');
		$table = $this->dataTable($data, $header);
		$tab_array[$key] = $table->toHtml();
	endforeach;
	
	$menuBar = array(
		'back' => '/admin/overview',
		'default' => null,
		'edit' => null
	);
	
	$content .= $this->makeToolbar($menuBar, 24);
	$content .= '<form id="template" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
	
	$tabs = new HTML_Tabs($tab_array);
	$content .= $tabs->toHtml();
	
	$content .= '</form>';
	
	$this->addContent($content);
	
	$this->registry->component_js = array(
		'/components/template/js/template.js'
	);
endif;
?>
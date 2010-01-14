<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($_POST['tmpl'])):
		$template = explode(':', $_POST['tmpl']);
		
		if ($template == 'administration'):
			$this->registry->admin_config->set('admin_template',$template[1],'SERVER');
			$this->registry->admin_config->save();
		else:
			$this->registry->config->set('site_template',$template[1],'SERVER');
			$this->registry->config->save();
		endif;
	endif;
	
	foreach ($dirs as $key => $value){
		$iterator = new DirectoryIterator($value);
		foreach ($iterator as $fileinfo) {
			if (!$fileinfo->isDot()) {
				if ($fileinfo->isDir()) {
					$templates[$key][] = $fileinfo->getFilename();
				}
			}
		}
		sort($templates[$key]);
		unset($iterator);
	}
	
	// create the tabs.
	foreach($templates as $key => $value):
		$c = 0;
		$data = array();
		
		$default = ($key == 'site') ? $this->registry->config->get('site_template', 'SERVER') : $this->registry->admin_config->get ('admin_template', 'SERVER');
		
		foreach($value as $tmpl_name):
			$data[$c][] = '<input type="radio" name="tmpl" id="'.$tmpl_name.'_radio" value="'.$key.':'.$tmpl_name.'" />';
			$data[$c][] = $tmpl_name;
			$data[$c][] = ($default == $tmpl_name) ? '<img src="/templates/'.$this->registry->template.'/images/16x16/Favorites.png" />' : '';
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
	
	$this->addContent($this->makeToolbar($menuBar, 24));
	$this->addContent('<form id="template" method="post" action="'.$_SERVER['REQUEST_URI'].'">');
	
	$tabs = new HTML_Tabs($tab_array);
	$this->addContent($tabs->toHtml());
	
	$this->addContent('</form>');
	
	$this->registry->component_js = array(
		'/components/template/js/template.js'
	);
	
else:
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
endif;
?>
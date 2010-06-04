<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {

	$confirm = file_get_contents(__SITE_PATH.'/templates/' . $this->registry->template . '/html/confirm.html');

	$js = new JsLoader($this->registry);

	$js->source_root = $this->registry->config->get('web_url', 'SERVER').'/Common/javascript/Source/';
	
		
	$dirs = array($_SERVER['DOCUMENT_ROOT'].'/templates/', $_SERVER['DOCUMENT_ROOT'].'/../templates/');
	foreach ($dirs as $dir){
		$iterator = new DirectoryIterator($dir);
		$path = $iterator->getPath();
		foreach ($iterator as $fileinfo) {
			if (!$fileinfo->isDot()) {
				if ($fileinfo->isDir()) {
					$templates[$fileinfo->getFilename()] = $path.'/'.$fileinfo->getFilename();
				}
			}
		}
		unset($iterator);
	}
	
	ksort($templates);
	
	if(isset($_POST['template'])) {
		$template = $templates[$_POST['template']];
		$template_name = $_POST['template'];
	} else {
		$template = $templates[$this->registry->admin_config->get ('admin_template', 'SERVER')];
		$template_name = $this->registry->admin_config->get ('admin_template', 'SERVER');
	}
	
	$template_files = new Admin_Config($this->registry, array('path' => $template . '/ini/template.ini.php'));
	
	$template_files->public_html = true;
	
	//print_rr($template_files);
	
	if (isset($_POST['files'])) {
		$c = 0;
		
		$ini = array(
			'cache' => $template_files->get('cache'),
			'css' => $template_files->get('css'),
			'js_ini_files' => $template_files->get('js_ini_files')
		);
		
		$template_files->removeAllSections();
		
		foreach ($ini as $section => $value):
			foreach ($value as $key => $value):
				$template_files->set($key,$value,$section);
			endforeach;
		endforeach;
		
		foreach ($_POST['files'] as $file) {
			$file = split('/', $file);
			$files[$file[1]][] = $file[2];
			
			$template_files->set($c,'/Common/javascript/Source/'.$file[0].'/'.$file[1].'/'.$file[2],'mootools_js');
				
			$c++;
		}
		
		foreach ($files as $section => $values) {
			
			foreach ($values as $key => $value) {
				
				$value = str_replace('.js', '', $value);
				$template_files->set($key,$value,$section);
				
			}
		}
		$template_files->save();
		
		$js->scripts = $template_files->get('mootools_js');

		foreach ($js->scripts as $key => $files):
			$js->scripts[$key] = $this->registry->config->get('web_url', 'SERVER').$files;
		endforeach;

		$js->dbug = false;
		$js->compress_file = true;

		$cache_file = $_SERVER['DOCUMENT_ROOT'].'/Common/tmp/UthandoJsCache.js';
		
		$ftp = new File_FTP($this->registry);

		$script = $js->load_js();

		file_put_contents($cache_file, $script);

		if ($template_name == 'admin') {
			$dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
			$ftp->put($cache_file, $ftp->public_html.'/'.end($dir).'/templates/'.$template_name.'/js/UthandoJsCache.js', true, FTP_ASCII);
		} else {
			$ftp->put($cache_file, $ftp->public_html.'/templates/'.$template_name.'/js/UthandoJsCache.js', true, FTP_ASCII);
		}

		$ftp->disconnect();
		
		unlink($cache_file);
		
	}
	
	$menuBar = array(
		'cancel' => '/admin/overview',
		'save' => ''
	);
	
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$this->content .= '<form id="mooTemplate" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
	
	$this->content .= '<select id="template_select" name="template">';
	
	foreach ($templates as $k => $t) {
		if ($template_name == $k) {
			$selected = 'selected="selected"';
		} else {
			$selected = null;
		}
		$this->content .= '<option value="'.$k.'" '.$selected.'>'.$k.'</option>';
	}
	
	$this->content .= '</select>';
	$this->content .= '</form>';
	
	$js->load_json();
	
	$json = null;
	
	$json .= '<div id="download" class="download">';
	
	$json .= '<form id="mootools_edit" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
	
	$json .= '<input type="hidden" name="template" value="'.$template_name.'" />';
	
	//$json .= '<ul class="tabs">';
	foreach ($js->libs as $key => $value) {
		//$json .= '<li class="gradient"><a href="#'.$key.'">'.$key.'</a></li>';
		$tab_array[$key] = null;
	}
	//$json .= '</ul>';
	
	//$json .= '<div id="panelSet">';
	
	$sections = $template_files->listSections();
	unset($sections[0], $sections[1]);
	$panels = null;
	
	foreach ($js->libs as $key => $value) {
		$panels .= '<div id="'.$key.'" class="morphtabs_panel">';
		$fldr = $key;
		$panels .= '<table class="download">';
		foreach ($value as $key => $value) {
		
			$panels .= '<th colspan="3">'.$key.'</th>';
			
			$folder = $fldr . '/'.$key;
		
			foreach ($value as $key => $value) {
			
				$deps = null;
			
				foreach($value['deps'] as $dep) {
					$deps .= $dep.',';
				}
				
				$checked = null;
				
				foreach ($sections as $section) {
					$f = explode('/', $folder);
					if ($section == end($f)) {
						foreach($template_files->get(end($f)) as $file) {
							if ($file == $key) {
								$checked = 'checked="checked"';
							}
						}
					}
				}
			
				$panels .= '<tr class="option file">
						<td class="check">
						<div class="check" id="'.$key.'" deps="'.substr($deps,0,-1).'">
						<input type="checkbox" name="files[]" value="'.$folder.'/'.$key.'.js" '.$checked.' />
						</div>
						</td>
						<td class="name">'.$key.'</td>
						<td class="description">
						<p>'.$value['desc'].'</p>
						</td>
						</tr>';
			}
		
		}
	
		$panels .= '</table>';
		
		$panels .= '</div>';
	}
	
	//$json .= '</div>';
	
	$tabs = new HTML_Tabs($tab_array, true);
	$tabs->addPanels($panels);
	$json .= $tabs->toHtml();
	
	$json .= '</form>';
	
	$json .= '</div>';
	
	$this->content .= $json;
	
	$this->registry->component_js = array(
		'/components/template/js/mootools.js'
	);
	
} else {
	header("Location:" . $registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
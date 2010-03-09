<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$paramsBar = array(
		'back' => '/ushop/overview',
		'cancel' => '/ushop/overview',
		'save' => ''
	);
		
	$this->content .= $this->makeToolbar(array_merge($paramsBar,$menuBar), 24);
	
	$menuBar = array();
	
	$form = new HTML_QuickForm('edit_params', 'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
	
	$form->addElement('html', '<div id="information" class="morphtabs_panel"><div class="panel_content">');
	
	require_once('ushop/params/information.php');
	
	$form->addElement('html', '</div></div>');
	
	$form->addElement('html', '<div id="configuration" class="morphtabs_panel"><div class="panel_content">');
	
	require_once('ushop/params/global.php');
	require_once('ushop/params/paypal.php');
	
	$form->addElement('html', '</div></div>');
	
	$form->addElement('html', '<div id="display" class="morphtabs_panel"><div class="panel_content">');
	
	require_once('ushop/params/frontend_display.php');
	require_once('ushop/params/admin_display.php');
	
	$form->addElement('html', '</div></div>');
	
	if ($form->validate()):
			
		// Apply form element filters.
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'));
		
		$ushop_ini = new Admin_Config($this->registry, array('path' => $this->registry->ini_dir . '/ushop.ini.php'));
		
		if ($values['information']):
			$ftp = new File_FTP($this->registry);
			foreach ($values['information'] as $key => $value):
				$message = file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/Common/tmp/'.$key.'.html',stripslashes(str_replace('\r\n', '', $value)));
				$ftp->put($_SERVER['DOCUMENT_ROOT'] . '/Common/tmp/'.$key.'.html', $login['public_html'].'/components/ushop/html/'.$key.'.html', true);
				unlink($_SERVER['DOCUMENT_ROOT'] . '/Common/tmp/'.$key.'.html');
			endforeach;
			unset($values['information']);
			$ftp->disconnect();
		endif;
		
		foreach($values as $section => $value):
			foreach ($value as $key => $value):
				$ushop_ini->set($key,$value,$section);
			endforeach;
		endforeach;
		
		$saved = $ushop_ini->save();
		
		$menuBar['back'] = '/ushop/overview';
			
		//check then enter the record.
			
		if ($saved):
			$params['TYPE'] = 'pass';
			$params['MESSAGE'] = '<h2>Params was successfully updated.</h2>';
		else:
			$params['TYPE'] = 'error';
			$params['MESSAGE'] = '<h2>Params could not be updated.</h2>';
		endif;
		// done!
	else:
		
		$tab_array = array('information' => null, 'configuration' => null, 'display' => null);
		
		$info = array(
			'terms' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/../components/ushop/html/terms.html'),
			'offline_message' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/../components/ushop/html/offline_message.html')
		);
		
		$ushop->information = $info;
			
		$form->setDefaults($ushop->getSettings());
		
		$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $template);
			
		$renderer->setFormTemplate('form');
		$renderer->setHeaderTemplate('header');
		$renderer->setElementTemplate('element');
		
		$form->accept($renderer);
		
		// output the form
		$tabs = new HTML_Tabs($tab_array, true);
		$tabs->addPanels($renderer->toHtml());
		$this->content .= $tabs->toHtml();
		
		$js = file_get_contents(__SITE_PATH.'/components/media/js/filemanager.js');

		$manager_params = array(
			'SESSION_ID' => session_id(),
			'FOLDER' => 'userfiles/image',
			'SELCETABLE' => true,
			'FILTER' => "'image'"
		);
			
		$this->content .= ('<script>'.$this->templateParser($js, $manager_params, '/*{', '}*/').'</script>');
		
		$this->loadJavaScript(array(
			'/Common/editor/tiny_mce/tiny_mce_gzip.js',
			'/Common/js/tinyMCEGz.js'
		));

		$this->registry->component_js = array(
			'/components/ushop/js/params.js'
		);
		
		$this->registry->component_css = array(
			'/templates/'.$template.'/css/FileManager.css',
			'/templates/'.$template.'/css/Additions.css'
		);
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>
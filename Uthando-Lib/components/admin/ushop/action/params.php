<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$offline_message = '/home/'.$this->registry->get('settings.dir').'/Public/'.$this->registry->get('settings.resolve').'/template_files/html/offline_message.html';
	$terms = '/home/'.$this->registry->get('settings.dir').'/Public/'.$this->registry->get('settings.resolve').'/template_files/html/terms.html';
	
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
		
		$menuBar = array();
			
		// Apply form element filters.
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'));
		
		$ushop_ini = new Admin_Config($this->registry, array('path' => $this->registry->ini_dir . '/ushop.ini.php'));
		
		if ($values['information']):
			$ftp = new File_FTP($this->registry);
			foreach ($values['information'] as $key => $value):
				$message = file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/tmp/'.$key.'.html',stripslashes(str_replace('\r\n', '', $value)));
				$ftp->put($_SERVER['DOCUMENT_ROOT'] . '/tmp/'.$key.'.html', $ftp->public_html.'/'.$this->registry->get('settings.resolve').'/template_files/html/'.$key.'.html', true);
				unlink($_SERVER['DOCUMENT_ROOT'] . '/tmp/'.$key.'.html');
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
		
		$paramsBar = array(
			'back' => '/ushop/overview',
			'cancel' => '/ushop/overview',
			'save' => ''
		);
			
		$this->content .= $this->makeToolbar(array_merge($paramsBar,$menuBar), 24);
		
		$tab_array = array('information' => null, 'configuration' => null, 'display' => null);
		
		$info = array(
			'terms' => (file_exists($terms)) ? file_get_contents($terms) : '',
			'offline_message' => (file_exists($offline_message)) ? file_get_contents($offline_message) : ''
		);
		
		$ushop->information = $info;
			
		$form->setDefaults($ushop->getSettings());
		$renderer = new UthandoForm(TEMPLATES . $template);
			
		$renderer->setFormTemplate('form');
		$renderer->setHeaderTemplate('header');
		$renderer->setElementTemplate('element');
		
		$form->accept($renderer);
		
		// output the form
		$tabs = new HTML_Tabs($tab_array, true);
		$tabs->addPanels($renderer->toHtml());
		$this->content .= $tabs->toHtml();
		
		$session = Utility::encodeString(session_id());
		$this->addScriptDeclaration("UthandoAdmin.sid = ['" . $session[0] . "','" . $session[1] . "'];");
		
		$this->loadJavaScript(array(
			'/editors/tiny_mce/tiny_mce_gzip.js',
			'/uthando-js/uthando/admin/tinyMCEGz.js'
		));

		$this->addComponentJS('params');
		
		$this->addComponentCSS(array('FileManager','Additions'));
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
else:
	Uthando::go();
endif;
?>
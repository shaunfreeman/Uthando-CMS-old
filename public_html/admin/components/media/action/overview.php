<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array(
		'back' => '/admin/overview'
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);

	$js = file_get_contents(__SITE_PATH.'/components/media/js/filemanager.js');
	
	$manager_params = array(
		'SESSION_ID' => session_id(),
		'FOLDER' => $this->registry->settings['resolve'],
		'SELCETABLE' => 'false',
		'FILTER' => 'null',
		'MANAGER_INIT_CODE' => 'UthandoAdmin.manager.show();'
	);
		
	$this->addScriptDeclaration($this->templateParser($js, $manager_params, '/*{', '}*/'));

	$this->registry->component_css = array(
		'/templates/'.$this->get('admin_config.site.template').'/css/FileManager.css',
		'/templates/'.$this->get('admin_config.site.template').'/css/Additions.css'
	);
endif;
?>
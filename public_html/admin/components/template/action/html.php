<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$opts = $this->registry->params;
	
	$this->addContent('<div id="codeWrap"><textarea id="code">');
	
	if ($opts['type'] == 'site'):
		$file = realpath($dirs['site'].$opts['id'].'/index.html');
	else:
		//$file = file_get_contents($dirs['administration']);
	endif;
	
	$this->addContent($opts['type'].':'.$opts['id']);
	$this->addContent('</textarea></div>');
	
	//$this->registry->component_css = array('/Common/editor/CodeMirror/css/.css');
	
	$this->loadJavaScript(array(
		'/Common/editor/CodeMirror/js/codemirror.js'
	));
	
	$this->registry->component_js = array(
		'/components/template/js/html.js'
	);
}

?>
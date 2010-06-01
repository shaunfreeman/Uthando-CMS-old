<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$opts = $this->registry->params;
	$opt = null;
	
	foreach ($opts as $key => $value):
		if (is_numeric($key)):
			$opt .= $value.'/';
		else:
			$opt .= $key.'-'.$value.'/';
		endif;
	endforeach;
	
	$opt = substr($opt,0,-1);
	
	$menuBar = array(
		'back' => '/template/edit/'.$opt
	);
	
	$this->content .= ($this->makeToolbar($menuBar, 24));
	
	$this->content .= ('<div id="codeWrap"><textarea id="code">');
	
	if ($opts['type'] == 'site'):
		$file = realpath($dirs['site'].$opts['id'].'/index.html');
	else:
		$file = realpath($dirs['administration'].$opts['id'].'/index.html');
	endif;
	
	$this->content .= ($opts['type'].':'.$opts['id']);
	$this->content .= ('</textarea></div>');
	
	//$this->registry->component_css = array('/Common/editor/CodeMirror/css/.css');
	
	$this->loadJavaScript(array(
		'/Common/editor/CodeMirror/js/codemirror.js'
	));
	
	$this->registry->component_js = array(
		'/components/template/js/html.js'
	);
endif;

?>
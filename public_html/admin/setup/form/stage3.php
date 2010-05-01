<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$form = new HTML_QuickForm('setupForm', 'post', $_SERVER['REQUEST_URI']);
$form->removeAttribute('name');

// stage 3 - FTP settings
$form->addElement('html', '<div id="stage3" class="table-cell"><fieldset>');

$form->addElement('header',null,'Stage 3 | FTP Settings');
	
$form->addElement('text', 'port', 'Port:', array('size' => 4, 'value' => '21'));
$form->addElement('text', 'host', 'Host:', array('size' => 30, 'value' => 'localhost'));
$form->addElement('text', 'username', 'Username:', array('size' => 30, 'maxlength' => 100));

$form->addElement('password', 'password', 'Password:', array('size' => 30, 'maxlength' => 20));
		
$form->addElement('html', '</fieldset>');

if ($form->validate()):
	
	//Check FTP Settings.
	try{
		$ftp = new File_FTP($registry, false);
		foreach ($post as $key => $value) $ftp->{$key} = $value;
		$ftp->login();
		if ($registry->errors) throw new SettingsException();
		
	} catch (SettingsException $e) {
		$message = $registry->errors;
		$message .= "<script>setup.error = 'stage3';</script>";
	}
	
	print $message;

else:
	
	$form->addElement('html', '<fieldset class="formFooters"><p id="submit" class="next">Submit</p><p id="previous" class="previous">Previous</p></fieldset></div>');
	
	$renderer = new UthandoForm(SETUP_PATH . '/template');
		
	$renderer->setFormTemplate('form');
	$renderer->setHeaderTemplate('header');
	$renderer->setElementTemplate('element');
	$renderer->setElementTemplate('footer', 'submit');
			
	$form->accept($renderer);
	
	// output the form
	
	print $renderer->toHtml();
endif;

?>
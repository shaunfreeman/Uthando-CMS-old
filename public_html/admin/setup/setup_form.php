<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$form = new HTML_QuickForm('setupForm', 'post');
$form->removeAttribute('name');
	
// stage 1 - Server settings
$form->addElement('html', '<div id="stage1"><fieldset>');

$form->addElement('header',null,'Stage 1 | Licence');
	
$licence = file_get_contents('./licence.php');
	
$form->addElement('html', '<div id="licence">'.$licence.'</div>');
	
$form->addElement('html', '</fieldset>');
	
$form->addElement('html', '<fieldset class="formFooters"><p id="licence_accept" class="next">I Accept the Licence</p><p class="previous">Previous</p></fieldset></div>');
		
$renderer = new UthandoForm(SETUP_PATH . '/template');
		
$renderer->setFormTemplate('form');
$renderer->setHeaderTemplate('header');
$renderer->setElementTemplate('element');
$renderer->setElementTemplate('footer', 'submit');
		
$form->accept($renderer);

// output the form

$uthando->addContent($renderer->toHtml());

?>
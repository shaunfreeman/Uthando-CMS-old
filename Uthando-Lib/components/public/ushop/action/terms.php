<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$title .= htmlentities('Terms & Conditions');

$content = file_get_contents('/home/'.$this->registry->get('settings.dir').'/Public/'.$this->registry->get('settings.resolve').'/file/terms.html');

$this->addContent($this->displayContentpane($content, htmlentities('Terms & Conditions of Sale')));
?>
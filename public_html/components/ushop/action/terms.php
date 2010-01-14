<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$title .= htmlentities('Terms & Conditions');

$content = file_get_contents('ushop/html/terms.html', true);

$this->addContent($this->displayContentpane($content, htmlentities('Terms & Conditions of Sale')));
?>
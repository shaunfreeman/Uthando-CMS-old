<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$mod_data = $this->registry->template->doc->createDocumentFragment(htmlspecialchars(HTML_Template::compress($this->params->html)));
$this->module_wrap->appendChild($mod_data);

?>
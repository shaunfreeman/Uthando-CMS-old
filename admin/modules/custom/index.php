<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$mod_data = $this->createDocumentFragment(htmlentities(htmlspecialchars($this->params->html)));
$this->module_wrap->appendChild($mod_data);

?>
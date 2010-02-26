<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$route = split("/", $this->registry->get('config.site.default_page'));

$this->registry->action = $route[0];
unset($route[0]);

foreach ($route as $value) {
	$value = split("-",$value);
	$params[$value[0]] = $value[1];
	
}
$this->registry->params = $params;

require_once('content/action/'.$this->registry->action.'.php');

?>
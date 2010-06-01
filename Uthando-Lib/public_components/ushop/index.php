<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (is_file($this->file.DS.'action'.DS.$this->registry->action.EXT) == false) $this->registry->action = 'browse';

set_include_path(get_include_path() . PS . COMPONENTS.'ushop'.DS.'action'.DS . PS . COMPONENTS.'ushop'.DS.'user'.DS);

$title = ucwords($this->registry->component) . " " . ucwords($this->registry->action);

$this->registry->component_css = array('ushop_css' => '/uthando-css/ushop/public/ushop.css');

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
define( 'SHOP_PARENT_FILE', 1 );

$title .= " : ";

$this->ushop = new UShop_Core();
	
require_once($this->registry->action.EXT);

$this->setTitle($title . ' | ' . $this->get('config.server.site_name'));
	
$this->addParameter ('page',  $title);

?>
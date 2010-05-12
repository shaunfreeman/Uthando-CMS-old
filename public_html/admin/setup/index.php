<?php

ob_start('ob_gzhandler');

// Set flag that this is a parent file
define( 'PARENT_FILE', 1 );

$site_path = realpath('../');
define ('__SITE_PATH', $site_path);
define ('SETUP_PATH', realpath(dirname(__FILE__)));

/*{START_PHP_INI_PATH}*/
define ('__PHP_PATH', realpath(SETUP_PATH.'/php'));
/*{END_PHP_INI_PATH}*/

// Set include paths.
$ini_path = ini_get('include_path') .
	PATH_SEPARATOR . __PHP_PATH .
	PATH_SEPARATOR . __PHP_PATH . '/functions' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando';

ini_set('include_path', $ini_path);

// Include functions.
require_once('functions.php');
require_once('admin_functions.php');

$registry = new Registry();

$uthando = new Uthando($registry);
$registry->template = new HTML_Template($registry, null);

echo $registry->template;
unset($registry);

ob_end_flush();
?>
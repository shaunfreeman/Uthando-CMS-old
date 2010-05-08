<?php

ob_start('ob_gzhandler');
session_start();

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
	PATH_SEPARATOR . __PHP_PATH . '/PEAR' .
	PATH_SEPARATOR . __PHP_PATH . '/functions' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando';

ini_set('include_path', $ini_path);

// Include functions.
require_once('functions.php');
require_once('admin_functions.php');

$registry = new Registry();

$uthando = new Uthando($registry);

class SettingsException extends Uthando_Exception {}

// clean Post values and assign the to an array.
foreach ($_POST as $key => $value) $post[$key] = escape_data($value);

// error function.
function getError($message)
{
	return '<p class="fail">' . $message . '</p>';
}

function getPass($message)
{
	return '<p class="pass">' . $message . '</p>';
}

$message = false;
$pass = false;

$stage = (isset($_GET['stage']) && is_numeric($_GET['stage'])) ? 'stage'.$_GET['stage'] : 'stage1';

require_once ("form/".$stage.".php");

unset($registry);

ob_end_flush();
?>
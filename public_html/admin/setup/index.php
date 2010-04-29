<?php

ob_start('ob_gzhandler');

// Set flag that this is a parent file
define( 'PARENT_FILE', 1 );

$site_path = realpath('../');
define ('__SITE_PATH', $site_path);
define ('SETUP_PATH', realpath(dirname(__FILE__)));

/*{START_PHP_INI_PATH}*/
define ('__PHP_PATH', realpath(__SITE_PATH.'/../../uthando/php'));
/*{END_PHP_INI_PATH}*/

// Set include paths.
$ini_path = ini_get('include_path') .
	PATH_SEPARATOR . __PHP_PATH .
	PATH_SEPARATOR . __PHP_PATH . '/PEAR' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __SITE_PATH . '/setup/php' .
	PATH_SEPARATOR . __SITE_PATH . '/setup/components';

ini_set('include_path', $ini_path);

// Include functions.
require_once('functions.php');
require_once('admin_functions.php');
require_once(__PHP_PATH.'/Uthando/JsLoader.php');
require_once(__PHP_PATH.'/Uthando/Uthando.php');
require_once(__PHP_PATH.'/Uthando/UthandoForm.php');
require_once(__PHP_PATH.'/Uthando/Session.php');
require_once(__PHP_PATH.'/Uthando/UthandoUser.php');
require_once(__PHP_PATH.'/Uthando/Utility.php');

$registry = new Registry();

$uthando = new Uthando($registry);
$registry->template = new HTML_Template($registry, null);

//$registry->session = new Session($registry);
//UthandoUser::setUserInfo();
	
// Load component.
//$uthando->loadComponent();
require_once ("setup_form.php");

echo $registry->template;
unset($registry);

ob_end_flush();
?>
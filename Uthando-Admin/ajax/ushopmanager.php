<?php

ob_start('ob_gzhandler');
	
// Set flag that this is a parent file.
define( 'PARENT_FILE', 1 );

$site_path = realpath('../../');
define ('__SITE_PATH', $site_path);

/*{START_PHP_INI_PATH}*/
define ('__PHP_PATH', realpath(__SITE_PATH.'/../../uthando/php'));
/*{END_PHP_INI_PATH}*/

// Set include paths.
$ini_path = ini_get('include_path') .
	PATH_SEPARATOR . __PHP_PATH .
	PATH_SEPARATOR . __PHP_PATH . '/PEAR' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/Admin' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/Admin/FileManager' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __SITE_PATH . '/modules' .
	PATH_SEPARATOR . __SITE_PATH . '/components';

set_include_path($ini_path);

// Include functions.
require_once('functions.php');

$registry = new Admin_Registry(true);

$registry->setSite(realpath(__SITE_PATH.'/../../uthando/ini/uthandoSites.ini.php'));
$registry->loadIniFiles(array('admin_config' => 'uthandoAdmin', 'config' => 'uthando'));
$registry->setDefaults();

if (isset($_POST['session'])):
	$pwd = $_POST['session'][0];
	$iv = $_POST['session'][1];
endif;

$registry->sessionId = Utility::decodeString($pwd, $iv);

$uthando = new UthandoAdmin($registry);

try
{
	$registry->db = new DB_Admin($registry);
	$registry->session = new Session($registry);
	
	UthandoUser::setUserInfo();
	
	if ($uthando->authorize()):
		$ushop = new UShop_Manager($registry);
		$ushop->fireEvent(!empty($_POST['action']) ? $_POST['action'] : null);
	endif;
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
	print_rr($e->getMessage());
}

$registry->db = null;
	
unset ($uthando, $registry);
	
ob_end_flush();

?>
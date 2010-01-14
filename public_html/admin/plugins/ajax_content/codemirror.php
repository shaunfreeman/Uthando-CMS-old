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

$registry = new Admin_Registry();

/*{START_INI_DIR}*/
$registry->ini_dir = realpath(__SITE_PATH.'/../../uthando/ini');
/*{END_INI_DIR}*/

$registry->config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthando.ini.php'));

$registry->admin_config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthandoAdmin.ini.php'));

$registry->db_default = $registry->admin_config->get('database', 'DATABASE').'.';
$registry->core = $registry->config->get('core', 'DATABASE').'.';
$registry->user = $registry->config->get('user', 'DATABASE').'.';

if (isset($_GET['session'])) {
	$registry->sessionId = $_GET['session'];
} else if (isset($_POST['session'])) {
	$registry->sessionId = $_POST['session'];
}

$uthando = new UthandoAdmin($registry);
	
try
{
		
	$registry->db = new UthandoDB($registry);

	$registry->session = new Session($registry);
	UthandoUser::setUserInfo();
	
	if (isset($_POST['url']) && $uthando->authorize()):
		// Load component.
		$dirs = array('site' => $_SERVER['DOCUMENT_ROOT'].'/../templates/', 'admin' => $_SERVER['DOCUMENT_ROOT'].'/templates/');
		
		$opts = explode(':', $_POST['url']);
		$file = realpath($dirs[$opts[0]].$opts[1].'/index.html');
		
		$file = file_get_contents($file);
		print($file);
	endif;
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
}

$registry->db = null;
	
unset ($uthando, $registry);
	
ob_end_flush();

?>
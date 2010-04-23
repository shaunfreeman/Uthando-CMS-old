<?php

ob_start('ob_gzhandler');

// Set flag that this is a parent file
define( 'PARENT_FILE', 1 );

$site_path = realpath(dirname(__FILE__));
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
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __SITE_PATH . '/modules' .
	PATH_SEPARATOR . __SITE_PATH . '/components';

ini_set('include_path', $ini_path);

// Include functions.
require_once('functions.php');
require_once('admin_functions.php');

$timer = new Benchmark_Timer();
$timer->start();

$registry = new Admin_Registry();

$registry->setSite(realpath(__SITE_PATH.'/../../uthando/ini/uthandoSites.ini.php'));
$registry->loadIniFiles(array('admin_config' => 'uthandoAdmin', 'config' => 'uthando'));
$registry->setDefaults();

$uthando = new UthandoAdmin($registry);
$registry->template = new HTML_Template($registry, $registry->get('admin_config.site.template'));

require('Dbug/FirePHP.class.php');

$registry->firephp = FirePHP::getInstance(true);
	
try
{
	$registry->db = new DB_Admin($registry);

	$registry->session = new Session($registry);
	UthandoUser::setUserInfo();
	
	if ($uthando->authorize()):
		
		$registry->template->addParameter('login_status', 'You are logged in as: '.$_SESSION['username']);
		
		// Load component.
		$uthando->loadComponent();

		// Get Modules and add them.
		$uthando->addModules();
	
	else:
		// set action and path.
		if ($uthando->getPath() != "/user/login"):
			header("Location:" . $registry->get('admin_config.server.admin_url') . "/user/login");
			exit();
		else:
			// Load component.
			$uthando->loadComponent();
		endif;
	endif;
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
}

$timer->stop();
$timer_result = $timer->getProfiling();

$registry->template->addParameter('benchmark', "Page generated in {$timer_result[1]['total']} seconds.");

$registry->firephp->log($_SESSION);
//$registry->firephp->log($uthando);
$registry->firephp->log($registry);
$registry->firephp->log($_SERVER);

echo $registry->template;
unset($registry);

ob_end_flush();
?>
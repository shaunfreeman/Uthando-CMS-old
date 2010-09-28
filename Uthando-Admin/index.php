<?php

ob_start();

// Set flag that this is a parent file
define( 'PARENT_FILE', 1 );

define ('PS', PATH_SEPARATOR);
define ('DS', DIRECTORY_SEPARATOR);
define ('EXT', '.php');

define ('BASE', dirname(dirname(__FILE__)));
define ('PUB', BASE.DS.'Public'.DS);
define ('ADMIN', BASE.DS.'Uthando-Admin'.DS);
define ('CLASSES', BASE.DS.'Uthando-Classes'.DS);
define ('MODULES', BASE.DS.'Uthando-Lib'.DS.'modules'.DS);
define ('COMPONENTS', BASE.DS.'Uthando-Lib'.DS.'components'.DS.'admin'.DS);
define ('LANG', BASE.DS.'Uthando-Lib'.DS.'langs'.DS);
define ('FUNCS', BASE.DS.'Uthando-Lib'.DS.'functions'.DS);
define ('TEMPLATES', BASE.DS.'Uthando-Templates'.DS);
define ('JS', BASE.DS.'Uthando-JS'.DS);
define ('CSS', BASE.DS.'Uthando-CSS'.DS);
define ('IMAGE', BASE.DS.'Uthando-Images'.DS);

define ('SCHEME', (isset ($_SERVER['HTTPS'])) ? 'https://' : 'http://');
define ('HOST', $_SERVER['HTTP_HOST']);
define ('REQUEST_URI', $_SERVER['REQUEST_URI']);

// Set include paths.
$ini_path = get_include_path() .
	PS . CLASSES .
	PS . FUNCS .
	PS . MODULES .
	PS . COMPONENTS;

set_include_path($ini_path);

// Include functions.
require_once('functions.php');
require_once('admin_functions.php');

$timer = new Benchmark_Timer();
$timer->start();

$registry = new Admin_Registry();

$registry->setSite(BASE.DS.'Uthando-ini'.DS.'.UthandoSites.ini'.EXT);
$registry->loadIniFiles(array('admin_config' => 'uthandoAdmin', 'config' => 'uthando'));
$registry->setDefaults();

$uthando = new Admin_Uthando($registry);
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
			 $registry->path = "/user/login";
			 $registry->component = "user";
			 $registry->action = "login";
		endif;
		$uthando->loadComponent();
	endif;
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
}

$timer->stop();
$timer_result = $timer->getProfiling();

$registry->template->addParameter('benchmark', "Page generated in {$timer_result[1]['total']} seconds.");

if (($_SERVER['REMOTE_ADDR'] && $_SERVER['SERVER_ADDR']) == '127.0.0.1'):
	$registry->firephp->log($_SESSION);
	//$registry->firephp->log($uthando);
	$registry->firephp->log($registry);
	$registry->firephp->log($_SERVER);
endif;

echo $registry->template;
unset($registry);

ob_end_flush();
?>
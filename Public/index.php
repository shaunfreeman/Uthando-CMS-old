<?php

ob_start();

// Set flag that this is a parent file.
define( 'PARENT_FILE', 1 );

$site_path = realpath(dirname(__FILE__));
define ('SITE_PATH', $site_path);
define ('ROOT_PATH', realpath(SITE_PATH.'/../').'/');
define ('PHP_PATH', ROOT_PATH.'Uthando-Classes/');
define ('MODULES', ROOT_PATH.'Uthando-Lib/public/modules/');
define ('COMPONENTS', ROOT_PATH.'Uthando-Lib/public/components/');
define ('FUNCS', ROOT_PATH.'Uthando-Lib/functions/');
define ('TEMPLATES', ROOT_PATH.'Uthando-Templates/');

define ('SCHEME', (isset ($_SERVER['HTTPS'])) ? 'https://' : 'http://');
define ('HOST', $_SERVER['HTTP_HOST']);
define ('REQUEST_URI', $_SERVER['REQUEST_URI']);

// Set include paths.
$ini_path = get_include_path() .
	PATH_SEPARATOR . PHP_PATH .
	PATH_SEPARATOR . FUNCS .
	PATH_SEPARATOR . MODULES .
	PATH_SEPARATOR . COMPONENTS;

set_include_path($ini_path);

// Include functions.
require_once('functions.php');

$timer = new Benchmark_Timer();
$timer->start();

$registry = new Registry();
// require('Dbug/FirePHP.class.php');

// $registry->firephp = FirePHP::getInstance(true);

$registry->setSite(realpath(ROOT_PATH.'Uthando-ini/.UthandoSites.ini.php'));
$registry->loadIniFile('uthando', 'config');
$registry->setDefaults();

if ($registry->get('config.server.compat_router')) require_once('includes/CompatRouter.php');

$uthando = new Uthando($registry);
$registry->template = new HTML_Template($registry, $registry->get('config.site.template'));


$registry->template->addParameter ('merchant_name', $registry->get('config.server.site_name'));

$registry->session = new Session($registry);
UthandoUser::setUserInfo();

if (UthandoUser::authorize()):
	$registry->loggedInUser = true;
	$uthando->addParameter('login_status', "<p>You are logged in as: ".$_SESSION['name']."</p>");
else:
	$registry->loggedInUser = false;
endif;

try
{
	$registry->db = new DB_Core($registry);
	
	// Load component.
	$uthando->loadComponent();

	// Get Modules and add them.
	$uthando->addModules();
	
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
}

$registry->template->addParameter ('date', date("Y"));

$timer->stop();
$timer_result = $timer->getProfiling();

$registry->template->addParameter('benchmark', "Page generated in {$timer_result[1]['total']} seconds.");

echo $registry->template;
unset($registry);

ob_end_flush();
?>
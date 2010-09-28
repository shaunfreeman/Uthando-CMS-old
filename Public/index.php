<?php

ob_start();

// Set flag that this is a parent file.
define( 'PARENT_FILE', 1 );

define ('PS', PATH_SEPARATOR);
define ('DS', DIRECTORY_SEPARATOR);
define ('EXT', '.php');

define ('BASE', dirname(dirname(__FILE__)));
define ('PUB', BASE.DS.'Public'.DS);
define ('CLASSES', BASE.DS.'Uthando-Classes'.DS);
define ('MODULES', BASE.DS.'Uthando-Lib'.DS.'modules'.DS);
define ('COMPONENTS', BASE.DS.'Uthando-Lib'.DS.'components'.DS.'public'.DS);
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

$timer = new Benchmark_Timer();
$timer->start();

$registry = new Registry();
// require('Dbug/FirePHP.class.php');

// $registry->firephp = FirePHP::getInstance(true);

$registry->setSite(BASE.DS.'Uthando-ini'.DS.'.UthandoSites.ini'.EXT);
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
//print_rr($registry);
echo $registry->template;
unset($registry);

ob_end_flush();
?>
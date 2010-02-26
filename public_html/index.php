<?php

ob_start('ob_gzhandler');

// Set flag that this is a parent file.
define( 'PARENT_FILE', 1 );

$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

/*{START_PHP_INI_PATH}*/
define ('__PHP_PATH', realpath(__SITE_PATH.'/../uthando/php'));
/*{END_PHP_INI_PATH}*/

// Set include paths.
$ini_path = '.' .
	PATH_SEPARATOR . __PHP_PATH .
	PATH_SEPARATOR . __PHP_PATH . '/PEAR' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __SITE_PATH . '/modules' .
	PATH_SEPARATOR . __SITE_PATH . '/components';

set_include_path($ini_path);

// Include functions.
require_once('functions.php');

$timer = new Benchmark_Timer();
$timer->start();

$registry = new Registry();

$registry->setSite(realpath(__SITE_PATH.'/../uthando/ini/uthandoSites.ini.php'));
$registry->loadIniFile('uthando', 'config');
$registry->setDefaults();

//print_rr(md5($registry->server));
//print_rr($registry);

if ($registry->get('config.server.compat_router')) require_once('includes/CompatRouter.php');

$uthando = new Uthando($registry);
$registry->template = new HTML_Template($registry);


$registry->template->AddParameter ('merchant_name', $registry->get('config.server.site_name'));

$registry->session = new Session($registry);
UthandoUser::setUserInfo();

if (UthandoUser::authorize()):
	$registry->loggedInUser = true;
	$uthando->AddParameter ('login_status', "<p>You are logged in as: ".$_SESSION['name']."</p>");
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

$registry->template->AddParameter ('date', date("Y"));

$timer->stop();
$timer_result = $timer->getProfiling();

$registry->template->AddParameter ('benchmark', "Page generated in {$timer_result[1]['total']} seconds.");
/*
$uthando->addBodyContent($uthando->CreateBody());

if (!$registry->compress_files):
	$uthando->display();
else:
	print $uthando->compress_page($uthando->toHtml());
endif;
*/
//print_rr($registry->template);
echo $registry->template;
$registry = null;

ob_end_flush();

?>
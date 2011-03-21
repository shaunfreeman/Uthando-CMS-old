<?php

ob_start();
	
// Set flag that this is a parent file.
define( 'PARENT_FILE', 1 );

define ('PS', PATH_SEPARATOR);
define ('DS', DIRECTORY_SEPARATOR);
define ('EXT', '.php');

define ('BASE', dirname(dirname(dirname(__FILE__))));
define ('PUB', BASE.DS.'Public'.DS);
define ('CLASSES', BASE.DS.'Uthando-Classes'.DS);
define ('MODULES', BASE.DS.'Uthando-Lib'.DS.'modules'.DS);
define ('COMPONENTS', BASE.DS.'Uthando-Lib'.DS.'components'.DS.'public'.DS);
define ('FUNCS', BASE.DS.'Uthando-Lib'.DS.'functions'.DS);
define ('TEMPLATES', BASE.DS.'Uthando-Templates'.DS);

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

$registry = new Registry($_GET['path']);

$registry->setSite(BASE.DS.'Uthando-ini'.DS.'UthandoSites.ini'.EXT);
$registry->loadIniFile('uthando', 'config');
$registry->setDefaults();

$uthando = new Uthando($registry);

$uthando->timer = new Benchmark_Timer();
$uthando->timer->start();

$registry->template = new AjaxContent($registry);
	
$registry->template->setTemplate('/home/'. $registry->get('settings.dir') .'/Public/'. $registry->get('settings.resolve') .'/template_files/html/ajax_content.php');
	
$registry->template->addParameter('merchant_name', $registry->get('config.server.site_name'));

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
	$registry->Error ($e->getMessage(), $e);
}

if ($registry->component_css) {
	
	foreach ($registry->component_css as $id => $filename) {
		$uthando->AddScript('css', 'if (!$defined($("'.$id.'"))) new Asset.css("'.$filename.'", {id: "'.$id.'"});', true);
	}
}

$uthando->timer->stop();
$timer_result = $uthando->timer->getProfiling();

$registry->template->AddScript('benchmark', "Page generated in {$timer_result[1]['total']} seconds.");

$registry->template->display();

$registry->db = null;
	
unset ($uthando, $registry);
	
ob_end_flush();

?>
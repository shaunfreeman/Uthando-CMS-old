<?php

ob_start();
	
// Set flag that this is a parent file.
define( 'PARENT_FILE', 1 );

$site_path = realpath($_SERVER['DOCUMENT_ROOT']);
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

$registry = new Registry();

/*{START_INI_DIR}*/
$registry->ini_dir = realpath(__SITE_PATH.'/../uthando/ini');
/*{END_INI_DIR}*/

$registry->config = new Config($registry, array('path' => $registry->ini_dir.'/uthando.ini.php'));

$registry->db_default = $registry->config->get('core','DATABASE').'.';
$registry->core = $registry->config->get('core', 'DATABASE').'.';
$registry->user = $registry->config->get('user', 'DATABASE').'.';
$registry->sessions = $registry->config->get('session', 'DATABASE').'.';

$registry->dbug = $registry->config->get ('dbug', 'SERVER');
$registry->compress_files = $registry->config->get ('compress_files', 'SERVER');

$uthando = new AjaxContent($registry);

$uthando->timer = new Benchmark_Timer();
$uthando->timer->start();
	
$registry->template = $registry->config->get ('site_template', 'SERVER');
	
$uthando->setTemplate(__SITE_PATH . '/templates/' . $registry->template . '/ajax_content.php');
	
$uthando->AddParameter ('MERCHANT_NAME', $registry->config->get('site_name', 'SERVER'));

$registry->session = new Session($registry);
UthandoUser::setUserInfo();

if (UthandoUser::authorize()):
	$registry->loggedInUser = true;
	$uthando->AddParameter ('LOGIN_STATUS', "<p>You are logged in as: ".$_SESSION['name']."</p>");
else:
	$registry->loggedInUser = false;
endif;

try
{

	$registry->db = new UthandoDB($registry);
	
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
		$uthando->AddScript('CSS', 'if (!$defined($("'.$id.'"))) new Asset.css("'.$filename.'", {id: "'.$id.'"});', true);
	}
}

$uthando->timer->stop();
$timer_result = $uthando->timer->getProfiling();

$uthando->AddScript('BENCHMARK', "Page generated in {$timer_result[1]['total']} seconds.");

$uthando->display();

$registry->db = null;
	
unset ($uthando, $registry);
	
ob_end_flush();

?>
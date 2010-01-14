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
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/Admin' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __SITE_PATH . '/modules' .
	PATH_SEPARATOR . __SITE_PATH . '/components';

set_include_path($ini_path);

// Include functions.
require_once('functions.php');
require_once('admin_functions.php');

$registry = new Admin_Registry();

if ($_SERVER['DOCUMENT_ROOT'] == __SITE_PATH) {
	$registry->admin_dir = NULL;
} else {
	$admin_path = split("/", __SITE_PATH);
	$registry->admin_dir = '/'.$admin_path[count($admin_path) - 1];
}

/*{START_INI_DIR}*/
$registry->ini_dir = realpath(__SITE_PATH.'/../../uthando/ini');
/*{END_INI_DIR}*/

$registry->config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthando.ini.php'));

$registry->dbug = $registry->config->get ('dbug', 'SERVER');
$registry->compress_files = $registry->config->get ('compress_files', 'SERVER');

$registry->admin_config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthandoAdmin.ini.php'));

$registry->db_default = $registry->admin_config->get('database', 'DATABASE').'.';
$registry->core = $registry->config->get('core', 'DATABASE').'.';
$registry->user = $registry->config->get('user', 'DATABASE').'.';

date_default_timezone_set($registry->config->get('timezone', 'SERVER'));

$uthando = new AjaxContentAdmin($registry);

$uthando->timer = new Benchmark_Timer();
$uthando->timer->start();
	
$registry->template = $registry->admin_config->get ('admin_template', 'SERVER');
	
$uthando->setTemplate(__SITE_PATH . '/templates/' . $registry->template . '/ajax_content.php');
	
$uthando->AddParameter ('MERCHANT_NAME', $registry->config->get('site_name', 'SERVER'));

$registry->db = MDB2::factory($registry->admin_config->get ('DATABASE'), $options);

$registry->session = new Session($registry);
$uthando->setUserInfo();
	
$registry->db = MDB2::factory($registry->admin_config->get ('DATABASE'), $options);

if (PEAR::isError($registry->db)) {
	
	$registry->Error ($registry->db->getMessage(), $registry->db->getDebugInfo ());
	
} else {
		
	$registry->db->setFetchMode(MDB2_FETCHMODE_OBJECT);
	$registry->db->loadModule('Extended');
	
	// Load component.
	$uthando->loadComponent();
}

if ($registry->component_css) {
	
	foreach ($registry->component_css as $id => $filename) {
		$uthando->AddScript('CSS', 'if (!$defined($("'.$id.'"))) new Asset.css("'.$filename.'", {id: "'.$id.'"})', true);
	}
}

$uthando->timer->stop();
$timer_result = $uthando->timer->getProfiling();

$uthando->AddScript('BENCHMARK', "Page generated in {$timer_result[1]['total']} seconds.");

$uthando->display();

$registry->db->disconnect();
	
unset ($uthando, $registry);
	
ob_end_flush();

?>
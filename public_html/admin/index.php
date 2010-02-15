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

$registry = new Admin_Registry();

if ($_SERVER['DOCUMENT_ROOT'] == __SITE_PATH) {
	$registry->admin_dir = NULL;
} else {
	$admin_path = split("/", __SITE_PATH);
	$registry->admin_dir = '/'.$admin_path[count($admin_path) - 1];
}

$server = explode('.', $_SERVER['SERVER_NAME']);
$registry->server = $server[1];

/*{START_INI_DIR}*/
$registry->ini_dir = realpath(__SITE_PATH.'/../../uthando/ini/'.$registry->server);
/*{END_INI_DIR}*/

$registry->config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthando.ini.php'));

$registry->dbug = $registry->config->get ('dbug', 'SERVER');
$registry->compress_files = $registry->config->get ('compress_files', 'SERVER');

$registry->admin_config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthandoAdmin.ini.php'));

$registry->db_default = $registry->admin_config->get('database', 'DATABASE').'.';
$registry->core = $registry->config->get('core', 'DATABASE').'.';
$registry->user = $registry->config->get('user', 'DATABASE').'.';

date_default_timezone_set($registry->config->get('timezone', 'SERVER'));

$uthando = new UthandoAdmin($registry);

$uthando->timer = new Benchmark_Timer();
$uthando->timer->start();

$registry->template = $registry->admin_config->get ('admin_template', 'SERVER');

$site = $registry->config->get ('web_url', 'SERVER');

$uthando->AddParameter('SITE_URL', $site);
$uthando->AddParameter('ADMIN_URL', $registry->admin_config->get ('admin_url', 'SERVER'));

$uthando->xmlProlog = false;
$uthando->setDoctype("XHTML 1.0 Strict");

$uthando->addFavicon($site.'/Common/images/favicon.ico');

// load in template files.
$template_files = new Config($registry, array('path' => __SITE_PATH.'/templates/' . $registry->template.'/ini/template.ini.php'));

$registry->load_cache = $template_files->get('load', 'cache');
	
try
{
	$registry->db = new DB_Admin($registry);

	$registry->session = new Session($registry);
	UthandoUser::setUserInfo();
	
	if ($uthando->authorize()) {
		
		$uthando->setTemplate(__SITE_PATH.'/templates/' . $registry->template . '/index.php');
		
		$uthando->AddParameter ('LOGIN_STATUS', '<p class="alignRight">You are logged in as: '.$_SESSION['username'].'</p>');
		
		// Load component.
		$uthando->loadComponent();

		// Get Modules and add them.
		$uthando->addModules();
	
	} else {
		// set action and path.
		if ($uthando->getPath() != "/user/login") {
			header("Location:" . $registry->admin_config->get('admin_url', 'SERVER') . "/user/login");
			exit();
		} else {
			
			// Load component.
			$uthando->loadComponent();
			
		}
		
	}
	
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
}

$uthando->setCache(true);

// load in JavaScript
$js = new JsLoader($registry);

$js_end_files = $template_files->get('js_ini_files');

// add any component javascript.
if ($registry->component_js) {
	$js_end_files = array_merge($js_end_files, $registry->component_js);
}

foreach ($js_end_files as $key => $files):
	$js_end_files[$key] = $registry->admin_config->get ('admin_url', 'SERVER').$files;
endforeach;

if ($registry->load_cache):

	$js->dbug = true;
	$js->scripts = array($registry->admin_config->get('admin_url', 'SERVER').$template_files->get('js', 'cache'));
	
else:

	$js->scripts = $template_files->get('mootools_js');

	foreach ($js->scripts as $key => $files):
		$js->scripts[$key] = $registry->config->get('web_url', 'SERVER').$files;
	endforeach;

endif;

$js->scripts = array_merge($js->scripts,$js_end_files);

$registry->scripts = $js->load_js();

$uthando->loadJavaScript($registry->scripts);

// load CSS Styles
$css_files = $template_files->get('css');

if ($registry->component_css) {
	$css_files = array_merge($css_files, $registry->component_css);
}

foreach ($css_files as $filename) {
	if (!$registry->dbug && !$registry->load_cache) {
		$styles[] = file_get_contents(__SITE_PATH.$filename);
	} else {
		$styles[] = array($registry->admin_config->get('admin_url', 'SERVER').$filename, 'text/css' ,null);
	}
}

$uthando->loadStyles($styles);

$uthando->timer->stop();
$uthando->timer_result = $uthando->timer->getProfiling();

$uthando->AddParameter ('PAGE_GENERATED', "Page generated in {$uthando->timer_result[1]['total']} seconds.");

$uthando->addBodyContent($uthando->CreateBody());

if (!$registry->compress_files) {
	$uthando->display();
} else {
	print $uthando->compress_page($uthando->toHtml());
}

//print_rr($registry);

$registry->db = null;

ob_end_flush();

?>
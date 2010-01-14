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

$registry = new Registry();

/*{START_INI_DIR}*/
$registry->ini_dir = realpath(__SITE_PATH.'/../uthando/ini');
/*{END_INI_DIR}*/

$registry->config = new Config($registry, array('path' => $registry->ini_dir.'/uthando.ini.php'));

if (isset ($_SERVER['HTTPS'])):
	$registry->host = $registry->config->get('ssl_url', 'SERVER');
else:
	$registry->host = $registry->config->get('web_url', 'SERVER');
endif;

$registry->db_default = $registry->config->get('core','DATABASE').'.';
$registry->core = $registry->config->get('core', 'DATABASE').'.';
$registry->user = $registry->config->get('user', 'DATABASE').'.';
$registry->sessions = $registry->config->get('session', 'DATABASE').'.';

$registry->dbug = $registry->config->get ('dbug', 'SERVER');
$registry->compress_files = $registry->config->get ('compress_files', 'SERVER');

if ($registry->config->get ('compat_router', 'SERVER')) {
	require_once('includes/CompatRouter.php');
}

$uthando = new Uthando($registry);

$uthando->timer = new Benchmark_Timer();
$uthando->timer->start();

$registry->template = $registry->config->get ('site_template', 'SERVER');
	
$uthando->setTemplate(__SITE_PATH . '/templates/' . $registry->template . '/index.html');

if (is_file(__SITE_PATH.'/userfiles/image/favicon.ico')) {
	$uthando->addFavicon('/userfiles/image/favicon.ico');
} else {
	$uthando->addFavicon('/Common/images/favicon.ico');
}

$uthando->xmlProlog = false;
$uthando->setDoctype("XHTML 1.0 Strict");

$registry->meta_tags = $registry->config->get('METADATA');

$uthando->AddParameter ('MERCHANT_NAME', $registry->config->get('site_name', 'SERVER'));

$registry->session = new Session(&$registry);
UthandoUser::setUserInfo();

if (UthandoUser::authorize()):
	$registry->loggedInUser = true;
	$uthando->AddParameter ('LOGIN_STATUS', "<p>You are logged in as: ".$_SESSION['name']."</p>");
else:
	$registry->loggedInUser = false;
endif;

// load in template files.
$template_files = new Config($registry, array('path' => __SITE_PATH.'/templates/' . $registry->template.'/ini/template.ini.php'));
$registry->load_cache = $template_files->get('load', 'cache');

try
{

	$registry->db = new UthandoDB(&$registry);
	
	// Load component.
	$uthando->loadComponent();

	// Get Modules and add them.
	$uthando->addModules();
	
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
}

$uthando->setCache(true);

// load in JavaScript
$js = new JsLoader(&$registry);

$js_end_files = $template_files->get('js_ini_files');

// add any component javascript.
if ($registry->component_js):
	$js_end_files = array_merge($js_end_files, $registry->component_js);
endif;

foreach ($js_end_files as $key => $files):
	$js_end_files[$key] = $registry->host.$files;
endforeach;

if ($registry->load_cache):

	$js->dbug = true;
	$js->scripts = array($registry->host.$template_files->get('js', 'cache'));
	
else:

	$js->scripts = $template_files->get('mootools_js');

	foreach ($js->scripts as $key => $files):
		$js->scripts[$key] = $registry->host.$files;
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
	if (!$registry->dbug && !$template_files->get('load', 'cache')) {
		$styles[] = file_get_contents(__SITE_PATH.$filename);
	} else {
		$styles[] = array($filename, 'text/css' ,null);
	}
}

$uthando->loadStyles($styles);

// set page metadata.
$uthando->setMetaTags($registry->meta_tags);

$uthando->AddParameter ('DATE', date("Y"));

$uthando->timer->stop();
$timer_result = $uthando->timer->getProfiling();

$uthando->AddParameter ('BENCHMARK', "Page generated in {$timer_result[1]['total']} seconds.");

$uthando->addBodyContent($uthando->CreateBody());

if (!$registry->compress_files):
	$uthando->display();
else:
	print $uthando->compress_page($uthando->toHtml());
endif;

$registry->db = null;

ob_end_flush();

?>

<?php

session_start();
ob_start('ob_gzhandler');

// Set flag that this is a parent file
define( 'PARENT_FILE', 1 );

$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

/*{START_PHP_INI_PATH}*/
define ('__PHP_PATH', $_SERVER['DOCUMENT_ROOT'].'/Common/php');
/*{END_PHP_INI_PATH}*/

$debug = TRUE;

// Set include paths.
$ini_path = ini_get('include_path') .
	PATH_SEPARATOR . __PHP_PATH .
	PATH_SEPARATOR . __PHP_PATH . '/PEAR' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/Admin' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/includes';

ini_set('include_path', $ini_path);

// Include functions.
require_once('functions.php');

$registry = new UthandoRegistry();

//$registry->admin = TRUE;
$registry->setup = TRUE;

$admin_path = split("/", __SITE_PATH);
$registry->admin_dir = $admin_path[count($admin_path) - 1];

$uthando = new Uthando($registry);

$registry->dbug = true;
$registry->compress_files = false;

$uthando->timer = new Benchmark_Timer();
$uthando->timer->start();

$registry->template = 'template';

$uthando->disableXmlProlog();
$uthando->setDoctype("XHTML 1.0 Strict");
	
$uthando->setTitle('Setup | Uthando CMS');

// load in template files.
$template_files = new ConfigMagik($registry, array('path' => __SITE_PATH . "/" . $registry->template . '/ini/template.ini.php'));

$sections = $template_files->listSections();

foreach ($sections as $value) {
	switch ($value) {
		case 'js_ini_files':
			$ini_js = $template_files->get($value);
			foreach ($ini_js as $file) {
				$js_end_files[] = 'http://'.$_SERVER['HTTP_HOST'].$file;
			}
			break;
			
		case 'css':
			// set default CSS styles.
			$css_files = $template_files->get($value);
			break;
			
		default:
			$js_includes[$value] = $template_files->get($value);
			break;
	}
}

// load in JavaScript
$js = new JsLoader($registry);

$js->source_root = 'http://'.$_SERVER['HTTP_HOST'].'/Common/javascript/uthando/Source/';

$js->add_at_end = $js_end_files;

// add any component javascript.
if ($registry->component_js) {
	$js->add_at_end = array_merge($js->add_at_end, $registry->component_js);
}

$js->load_json();
$js->get_deps($js_includes);

$registry->scripts = $js->load_js();

$uthando->loadJavaScript($registry->scripts);

// load CSS Styles
foreach ($css_files as $filename) {
	if (!$registry->dbug) {
		$styles[] = file_get_contents($_SERVER['DOCUMENT_ROOT'].$filename);
	} else {
		$styles[] = array($filename, 'text/css' ,null);
	}
}

$uthando->loadStyles($styles);
$uthando->setTemplate(__SITE_PATH . "/" . $registry->template . '/index.php');

$uthando->addFavicon('/Common/images/favicon.ico');

require_once ("setup_form.php");


$uthando->timer->stop();
$uthando->timer_result = $uthando->timer->getProfiling();

$uthando->AddParameter ('PAGE_GENERATED', "Page generated in {$uthando->timer_result[1]['total']} seconds.");

$uthando->addBodyContent($uthando->CreateBody());

if (!$registry->compress_files) {
	$uthando->display();
} else {
	print $uthando->compress_page($uthando->toHtml());
}

ob_end_flush();

?>
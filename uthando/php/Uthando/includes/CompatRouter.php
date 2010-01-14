<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$set_route = false;

$router_config = new Config($registry, array('path' => $registry->ini_dir.'/CompatRouter.ini.php'));

$type = $router_config->get ('url_type', 'ROUTER');
$page = $router_config->get ('url_request', 'ROUTER');
switch ($type) {
	case 'get':
		if (isset($_GET[$page])) {
			$route = $router_config->get ($_GET[$page], 'URLS');
			$set_route = true;
		}
		break;
		
	case 'sef':
		$url = explode('/', $_SERVER['REQUEST_URI']);
		//print_rr($url[1]);
		//print_rr($page);
		if ($url[1] == $page){
			$route = $router_config->get ($url[2], 'URLS');
			//print_rr($route);
			$set_route = true;
		}
		break;
}

if ($set_route) {
	$registry->path = $route;
	$registry->registerPath();
}

?>
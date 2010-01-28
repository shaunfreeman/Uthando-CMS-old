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
	PATH_SEPARATOR . __PHP_PATH . '/Uthando' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/Admin' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/Admin/FileManager' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __SITE_PATH . '/modules' .
	PATH_SEPARATOR . __SITE_PATH . '/components';

set_include_path($ini_path);

// Include functions.
require_once('functions.php');

$registry = new Registry();

/*{START_INI_DIR}*/
$registry->ini_dir = realpath(__SITE_PATH.'/../../uthando/ini');
/*{END_INI_DIR}*/

$registry->config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthando.ini.php'));

$registry->admin_config = new Admin_Config($registry, array('path' => $registry->ini_dir.'/uthandoAdmin.ini.php'));

$registry->db_default = $registry->admin_config->get('database', 'DATABASE').'.';
$registry->core = $registry->config->get('core', 'DATABASE').'.';
$registry->user = $registry->config->get('user', 'DATABASE').'.';

if (isset($_GET['session'])) {
	$registry->sessionId = $_GET['session'];
} else if (isset($_POST['session'])) {
	$registry->sessionId = $_POST['session'];
}
	
try
{
		
	$registry->db = new UthandoDB($registry);

	$registry->session = new Session($registry);
	//$uthando->setUserInfo();
	
	// Load component.

	//user_agent|s:15:"Shockwave Flash";remote_addr|s:9:"127.0.0.1"
			
	function UploadIsAuthenticated($get){
			global $registry;
			if(!empty($get['session'])) {
				if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && $_SERVER['HTTP_USER_AGENT'] == 'Shockwave Flash') {

					$sql = "
						SELECT user_id
						FROM ".$registry->user."users
						WHERE user_id='".$_SESSION['user_id']."'
						AND username='".$_SESSION['username']."'
					";

					$res = $registry->db->query($sql);

					if (!$res) {
						return false;
					} else {
						if ($res->numRows() == 1) return true;
					}
				} else {
					return false;
				}
			}

			return false;
		}

		$browser = new File_Manager($registry, array(
			'baseURL' => $registry->config->get('web_url', 'SERVER').'/',
			'directory' => $_SERVER['DOCUMENT_ROOT'].'/../'.$_POST['folder'].'/',
			'assetBasePath' => $_SERVER['DOCUMENT_ROOT'].'/templates/admin/images/FileManager',
			'move' => true,
			'create' => true,
			'upload' => true,
			'destroy' => true,
			'filter' => (is_string($_POST['filter'])) ? $_POST['filter'].'/' : null
		));

		$browser->fireEvent(!empty($_GET['event']) ? $_GET['event'] : null);
}
catch (PDOException $e)
{
	$registry->Error ($e->getMessage());
}

$registry->db = null;
	
unset ($uthando, $registry);
	
ob_end_flush();

?>
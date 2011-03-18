<?php

ob_start();

// Set flag that this is a parent file
define( 'PARENT_FILE', 1 );

define ('PS', PATH_SEPARATOR);
define ('DS', DIRECTORY_SEPARATOR);
define ('EXT', '.php');

define ('BASE', dirname(dirname(dirname(__FILE__))));
define ('PUB', BASE.DS.'Public'.DS);
define ('ADMIN', BASE.DS.'Uthando-Admin'.DS);
define ('CLASSES', BASE.DS.'Uthando-Classes'.DS);
define ('MODULES', BASE.DS.'Uthando-Lib'.DS.'modules'.DS);
define ('COMPONENTS', BASE.DS.'Uthando-Lib'.DS.'components'.DS.'admin'.DS);
define ('LANG', BASE.DS.'Uthando-Lib'.DS.'langs'.DS);
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

$registry = new Admin_Registry(true);

$registry->setSite(BASE.DS.'Uthando-ini'.DS.'.UthandoSites.ini'.EXT);
$registry->loadIniFiles(array('admin_config' => 'uthandoAdmin', 'config' => 'uthando'));
$registry->setDefaults(true);

if (isset($_GET['session'])):
	$pwd = $_GET['session'][0];
	$iv = $_GET['session'][1];
elseif (isset($_POST['session'])):
	$pwd = $_POST['session'][0];
	$iv = $_POST['session'][1];
endif;

$registry->sessionId = Utility::decodeString($pwd, $iv);

try
{
	$registry->db = new DB_Admin($registry);
	$registry->session = new Session($registry);
	
	//user_agent|s:15:"Shockwave Flash";remote_addr|s:9:"127.0.0.1"
	
	function UploadIsAuthenticated($get)
	{
		global $registry;
		if(!empty($get['session'])):
			if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && $_SERVER['HTTP_USER_AGENT'] == 'Shockwave Flash'):
				// Query the database.
				$row = $registry->db->getResult(
					'user_id, username, user_group',
					$registry->user.'users',
					$registry->user.'user_groups',
					array(
						'where' =>'user_id='.$_SESSION['user_id'],
						'and' => array("username='".$_SESSION['username']."'", "user_group != 'registered'")
					),
					false
				);
				return (count($row) == 1) ? true : false;
			else:
				return false;
			endif;
		endif;
		return false;
	}

	$browser = new File_Manager($registry, array(
		'baseURL' => $registry->get('config.server.web_url').'/userfiles/',
		'directory' => DS.'home'.DS.$registry->settings['dir'].DS.'Public'.DS.$registry->settings['resolve'],
		'assetBasePath' => BASE.'/Uthando-Images/FileManager',
		'move' => true,
		'create' => true,
		'upload' => true,
		'destroy' => true,
		'filter' => (isset($_POST['filter']) && is_string($_POST['filter']) && !empty($_POST['filter'])) ? $_POST['filter'].'/' : null
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
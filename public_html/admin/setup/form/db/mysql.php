<?php
/*
 * Uthando CMS - Content management system.
 * Copyright (C) 2010  Shaun Freeman <shaun@shaunfreeman.co.uk>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$dsn = $values['general']['type'] . ":host=" . $values['general']['host'] . ";dbname=";
		
function testDBConnection($user, $db)
{
	global $dsn;
	foreach ($db as $value):
		$conStr = $dsn .$value;
		$instance = new PDO("$conStr", $user['username'], $user['password']);
		$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$instance = null;
	endforeach;
	$user=null;
}
		
$databases = $values['databases'];
testDBConnection($values['admin'],$databases);
unset($databases['admin']);
testDBConnection($values['user'],$databases);
testDBConnection($values['guest'],$databases);

$tmp = realpath(__SITE_PATH.'/../Common/tmp').'/database.ini.php';
file_put_contents($tmp, '');

$ftp = new File_FTP($registry);
$config = new Admin_Config($registry);

foreach ($values as $section => $values):
	foreach($values as $key => $value):
		$config->set($key, $value, $section);
	endforeach;
endforeach;

$ftp->put($tmp, $ftp->uthando_dir.'/ini/database.ini.php', true);
unlink($tmp);

$config->path = $registry->ini_dir.'/database.ini.php';
$config->save();

// load in sql data.
$conStr = $dsn.$config->get('admin','databases');
$db = new PDO("$conStr", $config->get('username','admin'), $config->get('password','admin'));
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($config->get('databases') as $key => $value):
	$data = "USE ".$value.";\n" . file_get_contents('./db/MySQL/uthando_'.$key.'.sql');
$res = $db->exec($data);
endforeach;
$db = null;

?>
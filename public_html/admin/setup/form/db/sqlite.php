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

$dsn = $values['general']['type'] . ':' . realpath(__SITE_PATH.'/../../uthando/ini/');

foreach ($values['databases'] as $value):
	$conStr = $dsn .'/'.$value.'.sqlite';
	$instance = new PDO("$conStr");
	$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$instance = null;
endforeach;
 
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
$db = new PDO("$conStr");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($config->get('databases') as $key => $value):
	$conStr = $dsn .'/'.$value.'.sqlite';
	$instance = new PDO("$conStr");
	$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$res = $instance->exec(file_get_contents('./db/SQLite/uthando_'.$key.'.sql'));
	$instance = null;
endforeach;


?>
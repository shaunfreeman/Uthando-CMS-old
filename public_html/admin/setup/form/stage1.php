<?php
/*
 * Uthando CMS - Content management system.
 * Copyright (C) 2010  Shaun Freeman
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

$required_exts = array(
	'php' => array('dom', 'ftp', 'gd', 'hash', 'json', 'libxml', 'mcrypt', 'pcre', 'PDO', 'pdo_mysql', 'session', 'SPL'),
	'apache' => array('mod_deflate', 'mod_expires', 'mod_rewrite')
);

$apache_mods = apache_get_modules();

$dom = new HTML_Element();

$wrapper = $dom->createElement('div', null, array('id' => 'stage1'));

$fs = $dom->createElement('fieldset');

$fs->appendChild($dom->createElement('legend', 'Stage 1 | Server Check'));
$div = $dom->createElement('div', null, array('id' => 'server_check'));

foreach ($required_exts as $key => $value):
	switch($key):
		case 'php':
			foreach ($value as $v):
				$error[$key] = (!extension_loaded($v)) ? true : false;
				$class = (!$error[$key]) ? 'pass' : 'fail';
				$div->appendChild($dom->createElement('p', (!$error[$key]) ? $v . ' is enabled.' : $v .' is not enabled.', array('class' => $class)));
			endforeach;
			break;
		case 'apache':
			foreach ($value as $v):
				$error[$key] = (!in_array($v, $apache_mods)) ? true : false;
				$class = (!$error[$key]) ? 'pass' : 'fail';
				$div->appendChild($dom->createElement('p', (!$error[$key]) ? $v . ' is enabled.' : $v .' is not enabled.', array('class' => $class)));
			endforeach;
			break;
	endswitch;
endforeach;

$err = false;

foreach ($error as $value) if ($value) $err = true;

$fs->appendChild($div);
$wrapper->appendChild($fs);

$fs = $dom->createElement('fieldset', null, array('class' => 'formFooters'));
if (!$err) $fs->appendChild($dom->createElement('fieldset', 'Next', array('id' => 'next', 'class' => 'next')));
$wrapper->appendChild($fs);

$dom->appendChild($wrapper);

print $dom->toHtml();

?>
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

$resolve = parse_ini_file($registry->ini_dir.'/.UthandoSites.ini.php', true);
$resolve = $resolve[$registry->server]['resolve'];
$registry->ini_dir = $registry->ini_dir . '/' . $resolve;

$form = new HTML_QuickForm('setupForm', 'post', $_SERVER['REQUEST_URI']);
$form->removeAttribute('name');

$drivers['mysql'] = 'mysql';
$drivers['sqlite'] = 'sqlite';

$display = (isset($_GET['general']['type']) && $_GET['general']['type'] == 'sqlite') ? true : false;

$class = ($display) ? null: ' class="sub"';

$form_names = array (
	'general' => array('html'=>'<fieldset class="sub">','header'=>'Stage 4 | Database Settings', 'select' => array('type'=>$drivers), 'text'=>'host'),
	'databases' => array('html'=>'<fieldset'.$class.'>','header'=>'Databases','text'=> array('admin','core','session','user'))
);

if(!$display):
	$form_names = $form_names + array(
		'admin' => array('html'=>'<fieldset class="sub">','header'=>'Admin Settings','text'=>'username','password'=>'password'),
		'user' => array('html'=>'<fieldset class="sub">','header'=>'User Settings','text'=>'username','password'=>'password'),
		'guest' => array('html'=>'<fieldset>','header'=>'Guest Settings','text'=>'username','password'=>'password')
	);
endif;

$form->setDefaults(array(
	'general[host]' => 'localhost',
	'general[type]' => (isset($_GET['general']['type'])) ? $_GET['general']['type'] : 'mysql',
	'databases[admin]' => 'uthando_admin',
	'databases[core]' => 'uthando_core',
	'databases[session]' => 'uthando_sessions',
	'databases[user]' => 'uthando_users',
	'admin[username]' => 'uthando_admin',
	'admin[password]' => 'password',
	'user[username]' => 'uthando_user',
	'user[password]' => 'password',
	'guest[username]' => 'uthando_guest',
	'guest[password]' => 'password'
));

// stage 4 - Database settings
$form->addElement('html', '<div id="stage4">');

foreach ($form_names as $key => $value):
	foreach ($value as $k => $v):
		switch ($k):
			case 'html': $form->addElement($k, $v); break;
			case 'header': $form->addElement($k,null,$v); break;
			case 'select':
				foreach ($v as $el => $opts):
					$s = $form->createElement($k, $key.'['.$el.']', ucwords($el).':');
					$s->loadArray($drivers);
					$form->addElement($s);
				endforeach;
				break;
			default:
				if (is_array($v)):
					foreach ($v as $el) $form->addElement($k, $key.'['.$el.']', ucwords($el).':', array('size' => 30));
				else:
					$form->addElement($k, $key.'['.$v.']', ucwords($v).':', array('size' => 30));
				endif;
				break;
		endswitch;
	endforeach;
	$form->addElement('html', '</fieldset>');
endforeach;

if (isset($_GET['general']['type']) && $_GET['general']['type'] == 'sqlite'):
	$form->removeElement('general[host]');
	$form->updateElementAttr(array('databases[admin]', 'databases[core]', 'databases[session]', 'databases[user]'), array('readonly' => 'true', 'style' => 'opacity: 0.5;'));
endif;

if ($form->validate()):
	
	$form->freeze();
	
	$values = $form->process(array($uthando, 'formValues'));
	
	//Check Database Settings.
	try {
		
		switch($values['general']['type']):
			case 'mysql': require_once('./form/db/mysql.php'); break;
			case 'sqlite': require_once('./form/db/sqlite.php'); break;
		endswitch;
		
		$message = '<p class="pass">database settings are correct.</p>';
		//$message .= "<script>setup.stage = 5;</script>";
		
	} catch (PDOException $e) {
		$message = '<p class="fail">'.$e->getMessage().'</p>';
		$message .= "<script>setup.error = true;</script>";
	} catch (FTPException $e) {
		$message = '<p class="fail">'.$e->getMessage().'</p>';
		$message .= "<script>setup.error = true;</script>";
	} catch (SettingsException $e) {
		$message = '<p class="fail">'.$e->getMessage().'</p>';
		$message .= "<script>setup.error = true;</script>";
	}

	print $message;

else:
	
	$form->addElement('html', '<fieldset class="formFooters"><p id="submit" class="next">Submit</p><p id="previous" class="previous">Previous</p></fieldset></div>');
	
	$renderer = new UthandoForm(SETUP_PATH . '/template');
		
	$renderer->setFormTemplate('form');
	$renderer->setHeaderTemplate('header');
	$renderer->setElementTemplate('element');
	$renderer->setElementTemplate('footer', 'submit');
			
	$form->accept($renderer);
	
	// output the form
	
	print $renderer->toHtml();
endif;

?>
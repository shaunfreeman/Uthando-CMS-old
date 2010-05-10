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

$form = new HTML_QuickForm('setupForm', 'post', $_SERVER['REQUEST_URI']);
$form->removeAttribute('name');

$form_names = array (
	'general' => array('html'=>'<fieldset class="sub">','header'=>'Stage 4 | Database Settings','text'=> array('type','host')),
	'databases' => array('html'=>'<fieldset class="sub">','header'=>'Databases','text'=> array('admin','core','session','user')),
	'admin' => array('html'=>'<fieldset class="sub">','header'=>'Admin Settings','text'=>'username','password'=>'password'),
	'user' => array('html'=>'<fieldset class="sub">','header'=>'User Settings','text'=>'username','password'=>'password'),
	'guest' => array('html'=>'<fieldset>','header'=>'Guest Settings','text'=>'username','password'=>'password')
);

$form->setDefaults(array(
	'general[host]' => 'localhost',
	'general[type]' => 'mysql',
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

// stage 3 - FTP settings
$form->addElement('html', '<div id="stage4">');

foreach ($form_names as $key => $value):
	foreach ($value as $k => $v):
		switch ($k):
			case 'html': $form->addElement($k, $v); break;
			case 'header': $form->addElement($k,null,$v); break;
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

if ($form->validate()):
	
	$form->freeze();
	
	$values = $form->process(array($uthando, 'formValues'));
	
	//Check Database Settings.
	try {
		
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
			$data = "USE ".$value.";\n" . file_get_contents('./sql/uthando_'.$key.'.sql');
			$res = $db->exec($data);
			if (file_exists('./sql/constraints/uthando_'.$key.'.sql')):
				$data = split(';',file_get_contents('./sql/constraints/uthando_'.$key.'.sql'));
				foreach ($data as $v):
					$res = $db->exec("USE ".$value.";\n".$v);
				endforeach;
			endif;
		endforeach;
		$db = null;
		
		$message = '<p class="pass">database settings are correct.</p>';
		$message .= "<script>setup.stage = 5;</script>";
		
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
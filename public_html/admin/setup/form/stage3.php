<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$form = new HTML_QuickForm('setupForm', 'post', $_SERVER['REQUEST_URI']);
$form->removeAttribute('name');

// stage 3 - FTP settings
$form->addElement('html', '<div id="stage3"><fieldset>');

$form->addElement('header',null,'Stage 3 | FTP Settings');

$form->addElement('text', 'ftp[port]', 'Port:', array('size' => 4, 'value' => '21'));
$form->addElement('text', 'ftp[host]', 'Host:', array('size' => 30, 'value' => 'localhost'));
$form->addElement('text', 'ftp[username]', 'Username:', array('size' => 30, 'maxlength' => 100));

$form->addElement('password', 'ftp[password]', 'Password:', array('size' => 30, 'maxlength' => 20));

$form->addElement('html', '</fieldset>');

if ($form->validate()):
	
	$form->freeze();
	$values = $form->process(array($uthando, 'formValues'));
	
	//Check FTP Settings.
	try{
		$ftp = new File_FTP($registry, false);
		foreach ($values['ftp'] as $key => $value) $ftp->{$key} = $value;
		$ftp->login();
		
		$public_html = realpath($_SERVER['DOCUMENT_ROOT'].'/../');
		
		// start testing for the public_html folder if not in the ftp root.
		function findPublicHtml()
		{
			global $ftp, $public_html;
			$r = $ftp->cd($public_html, false);
			
			if (!$r):
				$public_html = preg_replace('/\/(.*?)\//', '/', $public_html, 1);
				findPublicHtml($public_html, $ftp);
			endif;
		}
		
		findPublicHtml();
		$values['ftp']['timeout'] = $ftp->timeout;
		$values['ftp']['public_html'] = $public_html;
		$ftp->public_html = $public_html;
		
		$ftp->cd('../');
		$sysroot = $ftp->pwd();
		
		if (!$ftp->cd($sysroot.'/uthando')) throw new SettingsException('You need to upload the uthando directory to "'.$sysroot.'".');
		
		$values['ftp']['uthando_dir'] = $ftp->pwd();
		$ftp->uthando_dir = $values['ftp']['uthando_dir'];
		
		$config = new Admin_Config($registry);
		
		foreach ($values['ftp'] as $key => $value):
			$config->set($key, $value, 'ftp');
		endforeach;
		
		$ftp->mkdir($ftp->uthando_dir.'/ini');
		
		function getFTPPath($ftp_path, $file)
		{
			$matches = explode($ftp_path, $file);
			return $ftp_path.$matches[1];
		}
		
		$ftp->chmod(getFTPPath($ftp->public_html,realpath(__SITE_PATH.'/Common/tmp')), 0757);
		$ftp->chmod(getFTPPath($ftp->public_html,realpath(__SITE_PATH.'/../Common/tmp')), 0757);
		
		$tmp = realpath(__SITE_PATH.'/../Common/tmp').'/ftp.ini.php';
		file_put_contents($tmp, '');
		
		$ftp->put($tmp, $ftp->uthando_dir.'/ini/ftp.ini.php', true);
		unlink($tmp);
		
		$config->path = $registry->ini_dir.'/ftp.ini.php';
		$config->save($ftp);
		
		$message = '<p class="pass">ftp settings are correct.</p>';
		$message .= "<script>setup.stage = 4;</script>";
		
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
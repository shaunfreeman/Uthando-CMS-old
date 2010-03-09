<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (!UthandoUser::authorize()):
	
	$form = new HTML_QuickForm('reset_password', 'post', '/user/reminder');
	
	$user_config = new Config($registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
	
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
	
	$form->addElement('text', 'email', 'Enter your email address:', array('size' => 20, 'maxlength' => 100, 'class' => 'inputbox'));
	
	// Add form element rules.
	// email rules.
	$form->addRule('email','Please enter your email address','required');
	$form->addRule('email', 'Enter a valid email address.', 'email', null, 'server');
	
	// validate the form or just display it.
	if ($user_config->get('captcha_status', 'reminder') == 'on'):
		require_once('user/captcha/index.php');
	else:
		if ($form->validate()):
			require_once('user/validate/reminder.php');
		else:
			$form->addElement('submit', null, 'Send', array('class' => 'button'));
			// Output the form
			$this->content .= $form->toHtml();
		endif;
	endif;
endif;
?>
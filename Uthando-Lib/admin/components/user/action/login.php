<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (!$this->authorize()):
	
	$this->registry->template->setTemplate(__SITE_PATH.'/templates/' . $this->registry->get('admin_config.site.template') . '/login.html');
	
	$form = new HTML_QuickForm('adminLogin', 'post', $_SERVER['REQUEST_URI']);
	
	$user_config = new Config($this->registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
	
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
	
	// generate two random passwordboxes
	$num_chars = array('1' => '1<span class="super">st</span>','2' => '2<span class="super">nd</span>','3' => '3<span class="super">rd</span>','4' => '4<span class="super">th</span>','5' => '5<span class="super">th</span>','6' => '6<span class="super">th</span>','7' => '7<span class="super">th</span>','8' => '8<span class="super">th</span>');
	$rand_chars = array_rand($num_chars, 2);
	ksort($rand_chars);
	
	// Add form elements.
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','log_in','Login');
	$form->addElement('text', 'username', 'Username:', array('size' => 20, 'maxlength' => 20, 'class' => 'inputbox'));
	
	foreach ($rand_chars as $key => $value):
		$form->addElement('password', 'pwd'.$key, 'Enter the '.$num_chars[$value].' charactor of your password:', array('size' => 1, 'maxlength' => 1, 'class' => 'inputbox'));
		
		// password rules.
		$form->addRule('pwd'.$key, 'Please enter your password', 'required');
		$form->addRule('pwd'.$key, 'Enter a one character password', 'rangelength', array(1,1), 'server');
		$form->addRule('pwd'.$key, 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');
	endforeach;
	
	// add links for register and reset user account.
	//$form->addElement('link',null,'Forgot Password:',$this->registry->config->get('ssl_url', 'server').'/'.$this->registry->component.'/reminder', 'Click Here', 'id="reset_password" class="category"'); 
	
	$form->addElement('html', '</fieldset>');
		
	// Add form element rules.
	// email rules.
	$form->addRule('username', 'Please enter your username', 'required');
	
	// validate the form or just display it.
	if ($user_config->get('captcha_status', 'LOGIN') == 'on'):
		require_once('user/captcha/index.php');
	else:
		
		if ($form->validate() && $_SESSION['rand_chars']):
			require_once('user/validate/login.php');
		else:
			$_SESSION['rand_chars'] = $rand_chars;
			$form->addElement('submit', 'submit', 'Submit');
			
			// Output the form
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->get('admin_config.site.template'));
		
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
			$renderer->setElementTemplate('footer', 'submit');
		
			$form->accept($renderer);
			
			// output the form
			$this->content .= $renderer->toHtml();
		endif;
	endif;
	/*
	$user_config = new Config($this->registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
	$key = $user_config->get('key', 'cipher');
	$password = "password";
	$pwd = UthandoUser::encodePassword($password, $key);
	$this->registry->firephp->log($pwd);
	*/
else:
	goto();
endif;
?>
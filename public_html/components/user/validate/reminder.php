<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::checkUser() && !UthandoUser::authorize()) {
	
	// Apply form element filters.
	$form->applyFilter('__ALL__', 'escape_data');
	
	$email = $form->exportValue('email');
	
	$db = $this->registry->config->get('user','DATABASE');
	
	$sql = $this->registry->db->query("
		SELECT CONCAT(first_name, ' ', last_name) AS name, email, email_type, password, iv
		FROM ".$this->registry->user."users
		NATURAL JOIN ".$this->registry->core."email_type
		NATURAL JOIN ".$this->registry->user."user_groups
		WHERE email = :email
		AND user_group='registered'
	", array(':email' => $email));
		
	$num_rows = count($sql);

	if ($num_rows == 1) {

		$row = $sql[0];

		// decrypt password.
		$password = UthandoUser::decodePassword($row->password, $user_config->get('key', 'CIPHER'), $row->iv);

		// get mail config.
		$this->registry->mail_config = new Config($this->registry, array('path' => $this->registry->ini_dir.'/mail.ini.php'));

		// get mailer type and call class instance.
		$mailer = $this->registry->mail_config->get('type', 'mailer');

		$mail = new Mailer($mailer, $this->registry);

		// set some headers.
		$headers = array(
			'From' => $this->registry->mail_config->get('email', 'mailer'),
			'To' => $row->email,
			'Subject' => 'Password Reminder - ' . $this->registry->config->get('site_name', 'SERVER'),
			'MIME-Version' => "1.0",
			'X-Priority' => "1",
			'Content-Type' => 'text/'.$row->email_type.'; charset="utf-8"',
			'X-Mailer: PHP' => phpversion()
		);

		$mail->setHeaders($headers);

		$mail->setRecipients($row->email);

		$mail->setTemplate("password reminder");

		$mail->setEmailType($row->email_type);

		$sent_message = "<div><span class=\"smcap\"><p class=\"pass\"><img src=\"/Common/images/OKShield.png\" />Your login details have been sent to your registered email address.</p></span></div>";

		$params = array(
			'USER' => $row->name,
			'PASSWORD' => $password,
			'SITE' => $this->registry->config->get('site_name', 'SERVER'),
			'ADMINISTRATOR' => $this->registry->config->get('site_name', 'SERVER')
		);

		$sent_mail = $mail->send($params);

		if (PEAR::isError($sent_mail)) {
			$this->registry->Error ($sent_mail->getMessage(), 'email failed due to a system error');
		} else {
			$this->content .= $sent_message;
		}

	} else if ($num_row > 1) {

		$this->registry->Error ("Are you trying to hack this site?");

	} else {

		// no user found.
		$this->registry->Error ('The email entered does not match those on file.', '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');

	}
}

?>
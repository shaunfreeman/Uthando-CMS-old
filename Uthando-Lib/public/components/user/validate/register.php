<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::checkUser() && !UthandoUser::authorize()):
	
	// Apply form element filters.
	$form->applyFilter('__ALL__', 'escape_data');
	
	$name = $form->exportValue('name');
	$name['first'] = ucwords($name['first']);
	$name['last'] = ucwords($name['last']);
	$email = $form->exportValue('email1');
	$password = $form->exportValue('password1');
	
	// If user exists then display message otherwise register them..
	$sql = $this->registry->db->getRow("
		SELECT COUNT(user_id) as num_rows
		FROM ".$this->registry->user."users
		WHERE email = :email
	", array(':email' => $email));
	
	$num_rows = $sql->num_rows;

	if ($num_rows == 0):
		// lets now register the user

		// connect user to database.
		$dsn = array(
			'hostspec' => $this->get('config.database.hostspec'),
			'phptype' => $this->get('config.database.phptype'),
			'database' => $this->get('config.database.user')
		);

		$dsn = array_merge($dsn,$this->get('config.database_user'));

		$this->dsn = $dsn['phptype'] . ":host=" . $dsn['hostspec'] . ";dbname=" .$dsn['database'];
		
		$this->username = $dsn['username'];
		$this->password = $dsn['password'];

		$conn = new PDO($this->dsn, $this->username, $this->password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try
		{
			$conn->beginTransaction();
			
			// encrypt password.
			$user_config = new Config($this->registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
			$pwd = UthandoUser::encodePassword($password, $user_config->get('key', 'cipher'));
			
			// get user group for user.
			$stmt = $conn->prepare("
				SELECT user_group_id
				FROM ".$this->registry->user."user_groups
				WHERE user_group='registered'
			");
			
			$stmt->execute();
			$res = $stmt->fetch(PDO::FETCH_OBJ);
			
			$stmt = $conn->prepare("
				INSERT INTO users (user_group_id, first_name, last_name, username, email, password, iv, cdate)
				VALUES (:user_group_id, :first_name, :last_name, :email, :email, :password, :iv, NOW())
			");
			
			$stmt->execute(array(
				':user_group_id' => $res->user_group_id,
				':first_name' => $name['first'],
				':last_name' => $name['last'],
				':email' => $email,
				':password' => $pwd[0],
				':iv' => $pwd[1]
			));

			if ($conn->commit()):
				// mail user comfirmation.
				// get mail config.
				$this->registry->mail_config = new Config($this->registry, array('path' => $this->registry->ini_dir.'/mail.ini.php'));

				// get mailer type and call class instance.
				$mailer = $this->registry->mail_config->get('type', 'mailer');

				$mail = new Mailer($mailer, $this->registry);

				$email_type = 'html';

				// set some headers.
				$headers = array(
					'From' => $this->registry->mail_config->get('email', 'mailer'),
					'To' => $email,
					'Subject' => 'Login Details - ' . $this->get('config.server.site_name'),
					'MIME-Version' => "1.0",
					'X-Priority' => "1",
					'Content-Type' => 'text/'.$email_type.'; charset="utf-8"',
					'X-Mailer: PHP' => phpversion()
				);

				$mail->setHeaders($headers);

				$mail->setRecipients($email);

				$mail->setTemplate("register user");

				$email_type = 'html';
				$mail->setEmailType($email_type);

				$sent_message = "<div><span class=\"smcap\"><p class=\"pass\"><img src=\"/Common/images/OKShield.png\" />Your login details have been sent to your email address.</p></span></div>";

				$params = array(
					'USER' => implode(' ', $name),
					'PASSWORD' => $password,
					'SITE' => $this->get('config.server.site_name'),
					'ADMINISTRATOR' => $this->get('config.server.site_name')
				);

				$sent_mail = $mail->send($params);

				if (PEAR::isError($sent_mail)):
					$this->registry->Error ($sent_mail->getMessage(), 'email failed due to a system error');
				else:
					if (isset($_SESSION['http_referer'])):
						if ($this->get('config.server.enable_ssl')):
							$url = $this->get('config.server.ssl_url');
						else:
							$url = $this->get('config.server.web_url');
						endif;

						$page = urldecode($_SESSION['http_referer']);
						unset($_SESSION['http_referer']);
						
						$sql = $this->registry->db->query("
							SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, user_group
							FROM ".$this->registry->user."users
							NATURAL JOIN ".$this->registry->user."user_groups
							WHERE email = :email
							AND user_group='registered'
						", array(':email' => $email));
						
						$row = $sql[0];
						
						$_SESSION['user_id'] = $row->user_id;
						$_SESSION['name'] = $row->name;
						$_SESSION['username'] = $row->username;
						$_SESSION['user_group'] = $row->user_group;
						
						header ("Location: ". $url . $page);
						exit();
					else:
						$this->addcontent($sent_message);
					endif;
					
				endif;
			else:
				$this->registry->Error ("Sorry I could not register you due to a system error. Please try again later.");
			endif;
		}
		catch (PDOException $e)
		{
			$conn->rollBack();
			$registry->Error ($e->getMessage());
		}

		//$conn = null;

	elseif ($num_row > 1):
		$this->registry->Error ("Are you trying to hack this site?");
	else:
		// user found.
		$this->registry->Error ('The email entered already has been registered with us. Please use a different one.', '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');
	endif;
endif;
?>
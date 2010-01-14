<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::checkUser() && !UthandoUser::authorize()) {
	
	// Apply form element filters.
	$form->applyFilter('__ALL__', 'escape_data');
		
	$email = $form->exportValue('email');
			
	$rand_chars = $_SESSION['rand_chars'];
	unset($_SESSION['rand_chars']);
	
	foreach ($rand_chars as $key => $value) {
		$password[$value] = $form->exportValue('pwd'.$key);
	}
	
	// If user exists then login user else display form.
	$sql = $this->registry->db->query("
		SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, user_group, password, iv
		FROM ".$this->registry->user."users
		NATURAL JOIN ".$this->registry->user."user_groups
		WHERE email = :email
		AND user_group='registered'
	", array(':email' => $email));
	
	$num_rows = count($sql);

	if ($num_rows == 1) {
		// login user.
		$row = $sql[0];
		// decrypt password.
		$decrypted = UthandoUser::decodePassword($row->password, $user_config->get('key', 'CIPHER'), $row->iv);

		// split the password for checking.
		$decrypted = str_split($decrypted);

		// check password against the characters submitted
		foreach ($password as $key => $value) {
			if ($value == $decrypted[$key - 1]) {
				$pwd_validate[$key] = true;
			} else {
				$pwd_validate[$key] = false;
			}
		}
		// did it pass?
		$validated = true;
		
		foreach ($pwd_validate as $value) {
			if (!$value) $validated = false;
		}

		if ($validated) {
			session_regenerate_id();

			$_SESSION['user_id'] = $row->user_id;
			$_SESSION['name'] = $row->name;
			$_SESSION['user_group'] = $row->user_group;

			if ($this->registry->config->get('enable_ssl','SERVER')) {
				$url = $this->registry->config->get ('ssl_url', 'SERVER');
			} else {
				$url = $this->registry->config->get ('web_url', 'SERVER');
			}

			if (isset($_SESSION['http_referer'])):
				$page = urldecode($_SESSION['http_referer']);
				unset($_SESSION['http_referer']);
			else:
				$page = null;
			endif;
			
			header ("Location: ". $url . $page);
			exit();
		} else {
			// password didn't match.
			$this->registry->Error ('The password entered does not match that on file.', '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');
		}

	} else if ($num_row > 1) {

		$this->registry->Error ("Are you trying to hack this site?");

	} else {

		// no user found.
		$this->registry->Error ('The email entered does not match those on file.', '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');

	}
}

?>
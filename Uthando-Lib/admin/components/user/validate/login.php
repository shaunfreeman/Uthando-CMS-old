<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::checkUser() && !$this->authorize()):
	
	// Apply form element filters.
	$form->applyFilter('__ALL__', 'escape_data');
		
	$username = $form->exportValue('username');
			
	$rand_chars = $_SESSION['rand_chars'];
	unset($_SESSION['rand_chars']);
	
	foreach ($rand_chars as $key => $value) $password[$value] = $form->exportValue('pwd'.$key);
	
	// If user exists then login user else display form.
	$row = $this->registry->db->getRow("
		SELECT user_id, username, user_group, password, iv
		FROM {$this->registry->user}users
		NATURAL JOIN {$this->registry->user}user_groups
		WHERE username='$username'
		AND user_group != 'registered'
	");
	
	$num_rows = count($row);

	if ($num_rows == 1):

		// decrypt password.
		$decrypted = UthandoUser::decodePassword($row->password, $user_config->get('key', 'cipher'), $row->iv);

		// split the password for checking.
		$decrypted = str_split($decrypted);

		// check password against the characters submitted
		foreach ($password as $key => $value):
			$pwd_validate[$key] = ($value == $decrypted[$key - 1]) ? true : false;
		endforeach;
		// did it pass?
		$validated = TRUE;
		foreach ($pwd_validate as $value) if (!$value) $validated = FALSE;

		if ($validated):
			session_regenerate_id();

			$_SESSION['user_id'] = $row->user_id;
			$_SESSION['username'] = $row->username;
			$_SESSION['user_group'] = $row->user_group;
			
			goto();
		else:
			// password didn't match.
			$this->registry->Error('The password entered does not match that on file.', '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');
		endif;
	elseif ($num_row > 1):
		$this->registry->Error ("Are you trying to hack this site?");
	else:
		// no user found.
		$this->registry->Error('The username entered does not match those on file.', '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');
	endif;
	
	$this->addContent('&nbsp;');
endif;
?>
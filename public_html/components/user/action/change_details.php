<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::authorize()) {

	$form = new HTML_QuickForm('login', 'post', '/user/change_details');

	$sql = "
		SELECT email_type_id, first_name, last_name, email, password
		FROM ".$this->registry->user."users
		WHERE user_id=:user_id
	";
		
	$user = $this->registry->db->getRow($sql, array(
		':user_id' => $_SESSION['user_id']
	));
	
	$user_config = new Config($registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
	
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');

	// Add form elements.
	// Grouped elements
	$name['first'] = &HTML_QuickForm::createElement('text', 'first', null, array('size' => 20, 'class' => 'inputbox'));
	$name['last'] = &HTML_QuickForm::createElement('text', 'last', null, array('size' => 30, 'class' => 'inputbox'));
	
	$form->addGroup($name, 'name', 'Change your name (first, last):', '&nbsp;');
	
	$form->addElement('text', 'email', 'Change your email address:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));

	$form->addElement('password', 'password1', 'New password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
	$form->addElement('password', 'password2', 'Comfirm new password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
	
	// set up rules.
	// name rules
	// Define the rules for each element in the group
	$first_name_rule_1 = array('First Name is required','required');
	$first_name_rule_2 = array('Invalid First Name','minlength',3);
	$last_name_rule_1 = array('Last Name is required','required');
	$last_name_rule_2 = array('Invalid Last Name','maxlength',20);
	// Collect together the rules for each element
	$first_rules = array($first_name_rule_1, $first_name_rule_2);
	$last_rules = array($last_name_rule_1, $last_name_rule_2);
	// Add the rules to the group
	$form->addGroupRule('name',array($first_rules, $last_rules));
	// email rules
	$form->addRule('email', 'Please enter your email address', 'required');
	$form->addRule('email', 'Enter a valid email address.', 'email', null, 'server');

	// password rules
	$form->addRule('password1', 'Enter a valid password (bewteen 8 & 12 characters long)', 'rangelength', array(8,12), 'server');
	$form->addRule('password1', 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');

	$form->addRule('password2', 'Enter a valid password (bewteen 8 & 12 characters long)', 'rangelength', array(8,12), 'server');
	$form->addRule('password2', 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');

	// compare rules
	$form->addRule(array('password1', 'password2'),'Passwords do not match','compare');

	if ($form->validate()) {
			
		// Apply form element filters.
		$form->applyFilter('__ALL__', 'escape_data');

		$name = $form->exportValue('name');
		$update['first_name'] = ucwords($name['first']);
		$update['last_name'] = ucwords($name['last']);
		//$update['username'] = $form->exportValue('username');
		$update['email'] = $form->exportValue('email');
		$password = $form->exportValue('password1');

		if (!empty($password)) {
			$pwd = $this->encodePassword($password, $user_config->get('key', 'CIPHER'));
			$update['password'] = $pwd[0];
			$update['iv'] = $pwd[1];
		}

		$result = $this->registry->db->update($update, $this->registry->user."users", array('WHERE' => 'user_id='.$_SESSION['user_id']));

		if ($result) {
			$this->addContent("Update Succesful");
			
			$_SESSION['name'] = $update['first_name'] . " " . $update['last_name'];
			if (isset($_SESSION['http_referer'])):
				$page = urldecode($_SESSION['http_referer']);
				unset($_SESSION['http_referer']);
			else:
				$page = '/user/overview';
			endif;
			
			header ("Location: ". $url . $page);
			exit();
		} else {
			$this->addContent("Could not update your details due to a database error.");
		}
		
	} else {

		$form->setDefaults(array(
			'name' => array('first' => $user->first_name, 'last' => $user->last_name),
			//'username' => $user->username,
			'email' => $user->email
		));
			
		$form->addElement('submit', null, 'Send', array('class' => 'button'));
			
		// Output the form
		$this->addContent($form->toHtml());
	}
	
} else {
	
	goto ('../../index.php');
}

?>
<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$form = new HTML_QuickForm('addUser', 'post', $_SERVER['REQUEST_URI']);
		
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
		
	$menuBar = array(
		'cancel' => '/user/overview',
   		'save' => ''
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	// get user groups
	$groups = $this->registry->db->query("
		SELECT user_group_id, user_group
		FROM ".$this->registry->user."user_groups
		ORDER BY user_group_id ASC
	");
	
	// Add form elements.
	// Grouped elements
	$name['first'] = &HTML_QuickForm::createElement('text', 'first', null, array('size' => 20, 'class' => 'inputbox'));
	$name['last'] = &HTML_QuickForm::createElement('text', 'last', null, array('size' => 30, 'class' => 'inputbox'));
	
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','user_details','User Details');
	$form->addGroup($name, 'name', 'Name (first, last):', '&nbsp;');
	
	$form->addElement('text', 'username', 'Username:', array('size' => 20, 'maxlength' => 100, 'class' => 'inputbox'));
	$form->addElement('text', 'email', 'Email:', array('size' => 20, 'maxlength' => 100, 'class' => 'inputbox'));
	
	$form->addElement('password', 'password1', 'Password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
	$form->addElement('password', 'password2', 'Comfirm password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
	
	$s = $form->createElement('select', 'group', 'Group:');
	$opts[0] = 'Select One';
	
	if ($this->upid > 1) unset($groups[0]);
	if ($this->upid > 2) unset($groups[1], $groups[2]);
	
	foreach ($groups as $group) $opts[$group->user_group_id] = ucwords($group->user_group);
	
	$s->loadArray($opts);
	$form->addElement($s);
	
	$form->addElement('html', '</fieldset>');

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
	
	// username rules
	$form->addRule('username', 'Please enter a username', 'required');
	
	// email rules
	$form->addRule('email', 'Please enter a email address', 'required');
	$form->addRule('email', 'Enter a valid email address.', 'email', null, 'server');
	
	// password rules
	$form->addRule('password1', 'Please enter a password', 'required');
	$form->addRule('password1', 'Enter a valid password (bewteen 8 & 12 characters long)', 'rangelength', array(8,12), 'server');
	$form->addRule('password1', 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');
	
	$form->addRule('password2', 'Please comfirm the password', 'required');
	$form->addRule('password2', 'Enter a valid password (bewteen 8 & 12 characters long)', 'rangelength', array(8,12), 'server');
	$form->addRule('password2', 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');
	
	// compare rules
	$form->addRule(array('password1', 'password2'),'Passwords do not match','compare');
	
	// group rules
	$form->addRule('group','Please Select a group','nonzero');
	
	if ($form->validate()):
		
		// Apply form element filters.
		$form->applyFilter('__ALL__', 'escape_data');
		
		$name = $form->exportValue('name');
		$name['first'] = ucwords($name['first']);
		$name['last'] = ucwords($name['last']);
		$username = $form->exportValue('username');
		$email = $form->exportValue('email');
		$password = $form->exportValue('password1');
		$group = $form->exportValue('group');
		
		// If user exists then display message otherwise register them..	
		$sql = $this->registry->db->getRow("
			SELECT COUNT(user_id) AS num_rows
			FROM ".$this->registry->user."users
			WHERE email='$email'
			OR username='$username'
		");
		
		if ($sql->num_rows == 0):
			try{
				$conn = $this->registry->db->getConn();
				$conn->beginTransaction();
				
				$user_config = new Config($registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
				
				// get group id
				$stmt = $conn->prepare("
					SELECT user_group
					FROM ".$this->registry->user."user_groups
					WHERE user_group_id=:group
				");
				
				$stmt->execute(array(':group' => $group));
				$res = $stmt->fetch(PDO::FETCH_OBJ);
				
				if ($res->user_group == 'registered'):
					$key = array($user_config->get('key', 'cipher'), $this->get('config.server.web_url'));
				else:
					$key = $user_config->get('key', 'cipher');
				endif;
				
				$pwd = UthandoUser::encodePassword($password, $key);
				
				$stmt = $conn->prepare("
					INSERT INTO ".$this->registry->user."users (user_group_id, first_name, last_name, username, email, password, iv, cdate)
					VALUES (:user_group_id, :first_name, :last_name, :username, :email, :password, :iv, NOW())
				");
				
				$stmt->execute(array(
					':user_group_id' => $group,
					':first_name' => $name['first'],
					':last_name' => $name['last'],
					':username' => $username,
					':email' => $email,
					':password' => $pwd[0],
					':iv' => $pwd[1]
				));
				
				if($conn->commit()):
					goto('/user/overview');
				else:
					$this->registry->Error ("Sorry I could not register you due to a system error. Please try again later.", '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');
				endif;
			} catch (PDOException $e){
				$conn->rollBack();
				$this->registry->Error ($e->getMessage());
			}
		else:
			$this->registry->Error ('The email or username entered already has been registered with us. Please use a different one.', '<a href="'.$_SERVER['REQUEST_URI'].'">Try Again</a>');
		endif;
		
	else:
		
		// Output the form
		$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->get('admin_config.site.template'));
		
		$renderer->setFormTemplate('form');
		$renderer->setHeaderTemplate('header');
		$renderer->setElementTemplate('element');
		//$renderer->setGroupTemplate('group', $name);
		//$renderer->setElementTemplate('footer', 'submit');
		
		$form->accept($renderer);
			
		// output the form
		$this->content .= $renderer->toHtml();
	endif;
endif;
?>
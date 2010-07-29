<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id']) && $this->upid <= 3):
		
		$sql = "
			SELECT *
			FROM ".$this->registry->user."users
			NATURAL JOIN ".$this->registry->user."user_groups
			WHERE user_id=".$this->registry->params['id']."
		";
		
		$user = $this->registry->db->getRow($sql);
		
		$res = $this->registry->db->query("
			SELECT user_id
			FROM ".$this->registry->user."users
			NATURAL JOIN ".$this->registry->user."user_groups
			WHERE user_group='super administrator'
		");
		
		$num_su = count($res);
		
		// if we can edit this user or not!
		if (($this->upid == 2 && $user->user_group == 'super administrator') || ($this->upid == 3 && ($user->user_group == 'super administrator' || $user->user_group == 'administrator')) || ($this->upid == 3 && $user->user_group == 'manager')):
			$params['MESSAGE'] = 'You do not have permission to edit this user';
			$pass = false;
		else:
			$pass = true;
		endif;
		
		if ($pass):
			
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
	
			$form->addElement('password', 'password1', 'New password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
			$form->addElement('password', 'password2', 'Comfirm new password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
			
			if (($this->upid == 1 && $num_su == 1 && $user->user_group == 'super administrator') || ($_SESSION['user_id'] == $user->user_id)):
				$group_options['disabled'] = 'true';
			else:
				$group_options = null;
			endif;
	
			$s = $form->createElement('select', 'group', 'Group:', null, $group_options);
			$opts[0] = 'Select One';
			
			if ($this->upid > 1) unset($groups[0]);
			if ($this->upid > 2) unset($groups[1]);
	
			foreach ($groups as $group) {
				$opts[$group->user_group_id] = ucwords($group->user_group);
			}
	
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
			$form->addRule('password1', 'Enter a valid password (bewteen 8 & 12 characters long)', 'rangelength', array(8,12), 'server');
			$form->addRule('password1', 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');
	
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
				$update['first_name'] = ucwords($name['first']);
				$update['last_name'] = ucwords($name['last']);
				$update['username'] = $form->exportValue('username');
				$update['email'] = $form->exportValue('email');
				$password = $form->exportValue('password1');
				$update['user_group_id'] = $form->exportValue('group');
				
				if ($update['user_group_id'] == 0) $update['user_group_id'] = $user->user_group_id;
				
				if(!empty($password)):
					$user_config = new Config($registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
					// encrypt password.
				
					// get group id
					$ugid = $this->registry->db->query("
						SELECT user_group
						FROM ".$this->registry->user."user_groups
						WHERE user_group_id=:group
					", array(':group' => $update['user_group_id']));
					
					if ($ugid[0]->user_group == 'registered'):
						$key = array($user_config->get('key', 'cipher'), $this->get('config.server.web_url'));
					else:
						$key = $user_config->get('key', 'cipher');
					endif;
					
					$pwd = UthandoUser::encodePassword($password, $key);
					
					$update['password'] = $pwd[0];
					$update['iv'] = $pwd[1];
				endif;
				
				$result = $this->registry->db->update($update, $this->registry->user.'users', array('WHERE' => 'user_id='.$this->registry->params['id']), $quote=true);
				
				if (!$result):
					$this->registry->Error ('record not updated.');
				else:
					Uthando::go('/user/overview');
				endif;
			else:
				
				$form->setDefaults(array(
					'name' => array('first' => $user->first_name, 'last' => $user->last_name),
					'username' => $user->username,
					'email' => $user->email,
					'group' => $user->user_group_id
				));
				
				// Output the form
				$renderer = new UthandoForm(TEMPLATES . $this->get ('admin_config.site.template'));
		
				$renderer->setFormTemplate('form');
				$renderer->setHeaderTemplate('header');
				$renderer->setElementTemplate('element');
		
				$form->accept($renderer);
			
				// output the form
				$this->content .= $renderer->toHtml();
				
			endif;
		else:
			$menuBar['back']= '/user/overview';
			$params['TYPE'] = 'info';
			$params['MESSAGE'] = 'You do not have permission to edit this user';
		endif;
	else:
		$menuBar['back']= '/user/overview';
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = 'You do not have permission to edit this user';
	endif;
	
	if (!$pass):
		$params['CONTENT'] = $this->makeMessagebar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
endif;
?>
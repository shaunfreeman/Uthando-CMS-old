<?

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (!UthandoUser::authorize()) {
	
	$form = new HTML_QuickForm('login', 'post', '/user/register');
	
	$user_config = new Config($registry, array('path' => $this->registry->ini_dir.'/user/user.ini.php'));
	
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
	
	// Add form elements.
	// Grouped elements
	$name['first'] = &HTML_QuickForm::createElement('text', 'first', null, array('size' => 20, 'class' => 'inputbox'));
	$name['last'] = &HTML_QuickForm::createElement('text', 'last', null, array('size' => 30, 'class' => 'inputbox'));
	
	$form->addGroup($name, 'name', 'Name (first, last):', '&nbsp;');
	
	$form->addElement('text', 'email1', 'Enter your email address:', array('size' => 20, 'maxlength' => 100, 'class' => 'inputbox'));
	$form->addElement('text', 'email2', 'Comfirm your email address:', array('size' => 20, 'maxlength' => 100, 'class' => 'inputbox'));
	
	$form->addElement('password', 'password1', 'Set your password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
	$form->addElement('password', 'password2', 'Comfirm your password:', array('size' => 15, 'maxlength' => 12, 'class' => 'inputbox'));
	
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
	$form->addRule('email1', 'Please enter your email address', 'required');
	$form->addRule('email1', 'Enter a valid email address.', 'email', null, 'server');
	$form->addRule('email2', 'Please confirm your email address', 'required');
	$form->addRule('email2', 'Enter a valid email address.', 'email', null, 'server');
	// password rules
	$form->addRule('password1', 'Please enter your password', 'required');
	$form->addRule('password1', 'Enter a valid password (bewteen 8 & 12 characters long)', 'rangelength', array(8,12), 'server');
	$form->addRule('password1', 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');
	
	$form->addRule('password2', 'Please comfirm your password', 'required');
	$form->addRule('password2', 'Enter a valid password (bewteen 8 & 12 characters long)', 'rangelength', array(8,12), 'server');
	$form->addRule('password2', 'Enter a valid password (numbers, letters and ! £ $ % & / \ ( ) = ? + # - . , ; : _ only)', 'regex', '/^[a-zA-Z0-9!£$\%&\/\\\()=?+#-.,;:_]+$/', 'server');
	
	// compare rules
	$form->addRule(array('email1', 'email2'),'email addresses do not match','compare');
	$form->addRule(array('password1', 'password2'),'Passwords do not match','compare');
	
			
	if ($user_config->get('captcha_status', 'REGISTER') == 'on') {
		require_once('user/captcha/index.php');
	} else {
		
		if ($form->validate()) {
			
			require_once('user/validate/register.php');
		
		} else {
			
			$form->addElement('submit', null, 'Send', array('class' => 'button'));
			
			// Output the form
			$this->addContent($form->toHtml());
		}
	}
}
?>
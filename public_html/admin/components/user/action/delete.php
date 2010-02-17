<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$confirm = file_get_contents(__SITE_PATH.'/templates/' . $this->registry->template . '/html/message.html');
	
	if (isset($this->registry->params['id']) && $this->upid <= 3) {
		
		$sql = "
			SELECT *
			FROM {$this->registry->user}users
			NATURAL JOIN {$this->registry->user}user_groups
			WHERE user_id={$this->registry->params['id']}
		";
		
		$user = $this->registry->db->getRow($sql);
		
		$res = $this->registry->db->query("
			SELECT COUNT(user_id) AS num_rows
			FROM {$this->registry->user}users
			NATURAL JOIN {$this->registry->user}user_groups
			WHERE user_group='super administrator'
		");
		
		$num_su = $res->num_rows;
		
		// if we can delete this user or not!
		if ($_SESSION['user_id'] == $user->user_id) {
			$params['TYPE'] = 'info';
			$params['MESSAGE'] = 'You cannot delete yourself';
			$pass = false;
		} else if (($this->upid == 2 && $user->user_group == 'super administrator') || ($this->upid == 3 && ($user->user_group == 'super administrator' || $user->user_group == 'administrator')) || ($this->upid == 3 && $user->user_group == 'manager')) {
			$params['TYPE'] = 'info';
			$params['MESSAGE'] = 'You do not have permission to delete this user';
			$pass = false;
		} else if ($this->upid == 1 && $num_su == 1 && $user->user_group == 'super administrator') {
			$params['TYPE'] = 'info';
			$params['MESSAGE'] = 'You must have at least one super administrator';
			$pass = false;
		} else {
			$pass = true;
		}
		
		if (isset($this->registry->params['action']) == 'delete' && $pass) {
			
			$result = $this->registry->db->remove($this->registry->user.'users', 'user_id='.$this->registry->params['id']);
			
			// Always check that result is not an error
			if (!$result) {
				$this->registry->Error ("Could not delete user.");
			} else {
				goto('/user/overview');
			}
			
		} elseif ($pass) {
			
			$menuBar = array(
				'cancel' => '/user/overview',
				'delete' => '/user/delete/id-' . $this->registry->params['id'] . '/action-delete'
			);
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = 'Are you sure you want to delete this user';
			
		} else {
			$menuBar['back']= '/user/overview';
		}
		
	} else {
		$menuBar['back']= '/user/overview';
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = 'You do not have permission to delete this user';
	}
	
	$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
	$this->content .= $this->templateParser($confirm, $params, '<!--{', '}-->');
	
} else {
	header("Location:" . $this->registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
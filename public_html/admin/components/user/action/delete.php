<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	$confirm = file_get_contents(__SITE_PATH.'/templates/' . $this->registry->template . '/html/confirm.html');
	
	if (isset($this->registry->params['id']) && $this->upid <= 3) {
		
		$sql = "
			SELECT *
			FROM {$this->registry->user}users
			NATURAL JOIN {$this->registry->user}user_groups
			WHERE user_id={$this->registry->params['id']}
		";
		
		$user = $this->registry->db->getRow($sql);
		// check error!
		if (PEAR::isError($user)) {
			$this->registry->Error ($user->getMessage(), $user->getDebugInfo ());
		}
		
		$res = $this->registry->db->query("
			SELECT user_id
			FROM {$this->registry->user}users
			NATURAL JOIN {$this->registry->user}user_groups
			WHERE user_group='super administrator'
		");
		
		if (PEAR::isError($res)) {
			$this->registry->Error ($res->getMessage(), $res->getDebugInfo ());
		}
		
		$num_su = $res->numRows();
		
		// if we can delete this user or not!
		if ($_SESSION['user_id'] == $user->user_id) {
			$params['MESSAGE'] = 'You cannot delete yourself';
			$pass = false;
		} else if (($this->upid == 2 && $user->user_group == 'super administrator') || ($this->upid == 3 && ($user->user_group == 'super administrator' || $user->user_group == 'administrator')) || ($this->upid == 3 && $user->user_group == 'manager')) {
			$params['MESSAGE'] = 'You do not have permission to delete this user';
			$pass = false;
		} else if ($this->upid == 1 && $num_su == 1 && $user->user_group == 'super administrator') {
			$params['MESSAGE'] = 'You must have at least one super administrator';
			$pass = false;
		} else {
			$pass = true;
		}
		
		if (isset($this->registry->params['action']) == 'delete' && $pass) {
			
			$sql = "
				DELETE FROM {$this->registry->user}users
				WHERE user_id={$this->registry->params['id']}
			";
			
			$result = $this->registry->db->exec($sql);
			
			// Always check that result is not an error
			if (PEAR::isError($result)) {
				$this->registry->Error ($result->getMessage(), $result->getDebugInfo ());
			} else {
				goto('/user/overview');
			}
			
		} elseif ($pass) {
			
			$menuBar = array(
				'cancel' => '/user/overview',
				'delete' => '/user/delete/id-' . $this->registry->params['id'] . '/action-delete'
			);
			
			$params['MESSAGE'] = 'Are you sure you want to delete this user';
			
		} else {
			$menuBar['back']= '/user/overview';
		}
		
	} else {
		$menuBar['back']= '/user/overview';
			
		$params['MESSAGE'] = 'You do not have permission to delete this user';
	}
	
	$params['CONTENT'] = $this->makeToolbar($menuBar, 24);
	$this->content .= $this->templateParser($confirm, $params, '<!--{', '}-->');
	
} else {
	header("Location:" . $this->registry->config->get('web_url', 'SERVER'));
	exit();
}
?>
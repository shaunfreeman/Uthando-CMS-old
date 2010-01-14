<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()) {
	
	// Log out the user.
	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
	setcookie (session_name(), '', time()-300, '/', '', 0); // Destroy the cookie.
	header("Location: " . $this->registry->config->get('web_url', 'SERVER'));
	exit();
}

?>
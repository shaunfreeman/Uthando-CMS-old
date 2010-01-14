<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::authorize()) {
	
	// Log out the user.
	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
	setcookie (session_name(), '', time()-300, '/', '', 0); // Destroy the cookie.
	$this->deleteParameter('LOGIN_STATUS');
	$this->content .= "<p>You are now logged out</p>";
	$this->content .= "<script>window.location = '/';</script>";
}

?>
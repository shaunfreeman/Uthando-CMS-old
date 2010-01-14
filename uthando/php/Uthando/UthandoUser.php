<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UthandoUser
{
	private function __construct() {}

	private function __clone() {}

	public static function setUserInfo()
	{
		if (!$_SESSION['user_agent'] && !$_SESSION['remote_addr']):
			$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['remote_addr'] = $_SERVER['REMOTE_ADDR'];
		endif;
	}
	
	public static function checkUser()
	{
		if ($_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'] && $_SESSION['remote_addr'] == $_SERVER['REMOTE_ADDR']):
			return true;
		else:
			return false;
		endif;
	}
	
	public static function authorize()
	{
		if (isset($_SESSION['user_id']) && isset($_SESSION['user_group']) && self::checkUser()):
			return true;
		else:
			return false;
		endif;
	}

	public static function encodeKey($key)
	{
		if (is_array($key)):
			$server = str_replace('http://', '', $key[1]);
			$key = $key[0];
		else:
			$server = $_SERVER['SERVER_NAME'];
		endif;
		$key_length = strlen($key);
		$key = str_split($key, $key_length / 3);
		$key = $key[0] . $server. $key[1] . $_SERVER["SERVER_ADDR"] . $key[2];
		return $key;
	}
	
	public static function decodePassword($password, $key, $iv)
	{
		$cipher = new Cipher(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
		$key = self::encodeKey($key);
		return $cipher->decrypt($password, $key, $iv);
	}
	
	public static function encodePassword($password, $key)
	{
		$cipher = new Cipher(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
		$key = self::encodeKey($key);
		$pwd = $cipher->encrypt($password, $key);
		$iv = $cipher->getIV();
		return array($pwd, $iv);
	}
}

?>
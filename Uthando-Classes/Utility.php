<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Utility
{
	public static function removeSection($message, $type)
	{
		return preg_replace("/<!--".$type."_start-->(.*?)<!--".$type."_end-->/s", "", $message);
	}
	
	private static function encodeKey()
	{
		global $registry;
		$config = parse_ini_file($registry->ini_dir.'/user/user.ini.php', true);
		$key = $config['cipher']['key'];
		$key_length = strlen($key);
		$key = str_split($key, $key_length / 3);
		$key = $key[0] . $_SERVER['SERVER_NAME']. $key[1] . $_SERVER["SERVER_ADDR"] . $key[2];
		return $key;
	}
	
	public static function decodeString($str, $iv)
	{
		$cipher = new Security_Cipher(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
		$key = self::encodeKey();
		return $cipher->decrypt($str, $key, $iv);
	}
	
	public static function encodeString($str)
	{
		$cipher = new Security_Cipher(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
		$key = self::encodeKey();
		$str = $cipher->encrypt($str, $key);
		$iv = $cipher->getIV();
		return array($str, $iv);
	}
}

?>
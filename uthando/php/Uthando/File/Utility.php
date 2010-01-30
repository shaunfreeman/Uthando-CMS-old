<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

/* Stripped-down version of some Styx PHP Framework-Functionality bundled with this FileBrowser. Styx is located at: http://styx.og5.net */

class File_Utility {
	
	public static function endsWith($string, $look){
		return strrpos($string, $look)===strlen($string)-strlen($look);
	}
	
	public static function startsWith($string, $look){
		return strpos($string, $look)===0;
	}
	
	public static function pagetitle($data, $options = array()){
		static $regex;
		if(!$regex){
			$regex = array(
				explode(' ', 'Æ æ Œ œ ß Ü ü Ö ö Ä ä À Á Â Ã Ä Å &#260; &#258; Ç &#262; &#268; &#270; &#272; Ð È É Ê Ë &#280; &#282; &#286; Ì Í Î Ï &#304; &#321; &#317; &#313; Ñ &#323; &#327; Ò Ó Ô Õ Ö Ø &#336; &#340; &#344; Š &#346; &#350; &#356; &#354; Ù Ú Û Ü &#366; &#368; Ý Ž &#377; &#379; à á â ã ä å &#261; &#259; ç &#263; &#269; &#271; &#273; è é ê ë &#281; &#283; &#287; ì í î ï &#305; &#322; &#318; &#314; ñ &#324; &#328; ð ò ó ô õ ö ø &#337; &#341; &#345; &#347; š &#351; &#357; &#355; ù ú û ü &#367; &#369; ý ÿ ž &#378; &#380;'),
				explode(' ', 'Ae ae Oe oe ss Ue ue Oe oe Ae ae A A A A A A A A C C C D D D E E E E E E G I I I I I L L L N N N O O O O O O O R R S S S T T U U U U U U Y Z Z Z a a a a a a a a c c c d d e e e e e e g i i i i i l l l n n n o o o o o o o o r r s s s t t u u u u u u y y z z z'),
			);
			
			$regex[0][] = '"';
			$regex[0][] = "'";
		}
		
		$data = trim(substr(preg_replace('/(?:[^A-z0-9]|_|\^)+/i', '_', str_replace($regex[0], $regex[1], $data)), 0, 64), '_');
		return !empty($options) ? self::checkTitle($data, $options) : $data;
	}
	
	protected static function checkTitle($data, $options = array(), $i = 0){
		if(!is_array($options)) return $data;
		
		foreach($options as $content)
			if($content && strtolower($content)==strtolower($data.($i ? '_'.$i : '')))
				return self::checkTitle($data, $options, ++$i);
		
		return $data.($i ? '_'.$i : '');
	}
	
	public static function isBinary($str){
		$array = array(0, 255);
		for($i = 0; $i < strlen($str); $i++)
			if(in_array(ord($str[$i]), $array)) return true;
		
		return false;
	}
	
	public static function getPath(){
		static $path;
		return $path ? $path : $path = pathinfo(__FILE__, PATHINFO_DIRNAME);
	}
	
}

?>
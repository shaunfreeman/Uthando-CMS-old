<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class File_Upload
{
	public function mime($file, $options = array()){
		$file = realpath($file);
		$options = array_merge(array(
			'default' => null,
			'extension' => strtolower(pathinfo($file, PATHINFO_EXTENSION)),
		), $options);
		
		$mime = null;
		$ini = error_reporting(0);
		if (function_exists('finfo_open') && $f = finfo_open(FILEINFO_MIME, getenv('MAGIC'))){
			$mime = finfo_file($f, $file);
			finfo_close($f);
		}
		error_reporting($ini);
		
		if(!$mime && in_array($options['extension'], array('gif', 'jpg', 'jpeg', 'png'))){
			$image = getimagesize($file);
			if(!empty($image['mime']))
				$mime = $image['mime'];
		}
		
		if(!$mime && $options['default']) $mime = $options['default'];
		
		if((!$mime || $mime=='application/octet-stream') && $options['extension']){
			static $mimes;
			if(!$mimes) $mimes = parse_ini_file(pathinfo(__FILE__, PATHINFO_DIRNAME).'/MimeTypes.ini');
			
			if(!empty($mimes[$options['extension']])) return $mimes[$options['extension']];
		}
		
		return $mime;
	}
}

class UploadException extends Uthando_Exception {}

?>
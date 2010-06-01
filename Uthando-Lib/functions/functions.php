<?php

// Auto load classes.
function __autoload($class_name)
{
	$class_name = explode("_", $class_name);
	$class_path = null;
	foreach ($class_name as $key => $value) {
		$class_path .= '/'.$value;
	}
	$class_path = substr($class_path, 1);
	require ($class_path . '.php');
}

//class UthandoError extends  UthandoException {};

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
//set_error_handler("exception_error_handler");


function print_rr($value) {
	print "<pre style=\"background-color:white;color:black;\">";
	print_r($value);
	print "</pre>";
}

if(!function_exists('parse_ini_string')){
	function parse_ini_string($str, $ProcessSections=false){
		$lines  = explode("\n", $str);
		$return = Array();
		$inSect = false;
		foreach($lines as $line){
			$line = trim($line);
			if(!$line || $line[0] == "#" || $line[0] == ";")
				continue;
			if($line[0] == "[" && $endIdx = strpos($line, "]")){
				$inSect = substr($line, 1, $endIdx-1);
				continue;
			}
			if(!strpos($line, '=')) // (We don't use "=== false" because value 0 is not valid as well)
				continue;
		
			$tmp = explode("=", $line, 2);
			if($ProcessSections && $inSect)
				$return[$inSect][trim($tmp[0])] = ltrim($tmp[1]);
			else
				$return[trim($tmp[0])] = ltrim($tmp[1]);
		}
		return $return;
	}
}

// Function for escaping and trimming form data.
function escape_db_data ($data, $tags=true) {
	global $registry;
	if (ini_get('magic_quotes_gpc')) {
		$data = stripslashes($data);
	}
	if (!$tags) $data = strip_tags($data);
	return $registry->db->escape(trim($data));
}

function escape_data ($data, $tags=true) {
	if (ini_get('magic_quotes_gpc')) {
		$data = stripslashes($data);
	}
	if (!$tags) $data = strip_tags($data);
	return trim($data);
}

// Function for crating usernames.
function create_username ($username) { 
	$id = uniqid();
	$username = explode ("@", $username);
	$username = $username[0];
	if (strlen($username) > 8) {
		$username = substr ($username, 0, 8);
	} else {
		$username = $username;
	}
	return $username;
}

function find_files($dirname, $ext, $file_list = array()) {
	global $file_list;
    // Loop through the folder 
	$dir = dir($dirname); 
	while (false !== $entry = $dir->read()) { 
        // Skip pointers 
		if ($entry == '.' || $entry == '..') {
			continue;
		}
		
        // Deep find directories
		if (is_dir($dirname . DS . $entry)) {
			find_files($dirname . DS . $entry, $ext, $file_list);
		} else {
			foreach ($ext as $key => $value) {
				if (substr($entry,-$value) == $key) {
					$file_list[] = $dirname . DS . $entry;
				}
			}
		}
	}
  
    // Clean up
	$dir->close();
	
	return $file_list;
}

?>
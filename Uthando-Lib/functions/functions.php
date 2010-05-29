<?php

// Auto load classes.
function __autoload($class_name)
{
	$class_name = split("_", $class_name);
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
		if (is_dir($dirname . DIRECTORY_SEPARATOR . $entry)) {
			find_files($dirname . DIRECTORY_SEPARATOR . $entry, $ext, $file_list);
		} else {
			foreach ($ext as $key => $value) {
				if (substr($entry,-$value) == $key) {
					$file_list[] = $dirname . DIRECTORY_SEPARATOR . $entry;
				}
			}
		}
	}
  
    // Clean up
	$dir->close();
	
	return $file_list;
}

?>
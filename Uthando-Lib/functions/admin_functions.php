<?php

function copyr($source, $dest) { 
	// Simple copy for a file 
	if (is_file($source)) { 
		return copy($source, $dest); 
    } 
  
    // Make destination directory 
    if (!is_dir($dest)) { 
        mkdir($dest); 
    } 
  
    // Loop through the folder 
   	$dir = dir($source); 
    while (false !== $entry = $dir->read()) { 
        // Skip pointers 
        if ($entry == '.' || $entry == '..') { 
           	continue; 
        } 
  
        // Deep copy directories 
        if ($dest !== "$source/$entry") { 
            copyr("$source/$entry", "$dest/$entry"); 
        } 
    } 
  
    // Clean up 
    $dir->close(); 
    return true; 
} 
		
function rmdirr($dirname) { 
    // Sanity check 
    if (!file_exists($dirname)) { 
       	return false; 
    } 
  
    // Simple delete for a file 
    if (is_file($dirname) || is_link($dirname)) { 
       	return unlink($dirname); 
    } 
  
    // Loop through the folder 
    $dir = dir($dirname); 
    while (false !== $entry = $dir->read()) { 
        // Skip pointers 
        if ($entry == '.' || $entry == '..') { 
            continue; 
        } 
  
        // Recurse 
        rmdirr($dirname . DIRECTORY_SEPARATOR . $entry); 
    } 
  
    // Clean up 
    $dir->close(); 
    return rmdir($dirname); 
}

?>